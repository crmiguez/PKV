<?php
//file: controller/ProductsController.php

require_once(__DIR__."/../model/Product.php");
require_once(__DIR__."/../model/ProductMapper.php");
require_once(__DIR__."/../model/User.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class ProductsController
 * 
 * Controller to make a CRUDL of Product entities
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class ProductsController extends BaseController {
  
  /**
   * Reference to the ProductMapper to interact
   * with the database
   * 
   * @var ProductMapper
   */
  private $productMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->productMapper = new ProductMapper();          
  }
  
  /**
   * Action to list products
   * 
   * Loads all the posts from the database.
   * No HTTP parameters are needed.
   * 
   * The views are:
   * <ul>
   * <li>product/index (via include)</li>   
   * </ul>
   */
  public function index() {
    
	$products = $this->productMapper->findAll();
	
    // put the array containing Product object to the view
    $this->view->setVariable("products", $products);    
    
    // render the view (/view/products/index.php)
    $this->view->render("products", "index");
  }
  
  public function search(){
	  // obtain the data from the database
	 if (!isset($_GET["words"])) {
      throw new Exception("words is mandatory");
    }
	
    $productw = trim($_GET["words"]);
	
	$entero = 0;
	
	if (empty($productw)){
	  throw new Exception("Search not found");
	}else{
    
		// find the Product object in the database
		$productsB = $this->productMapper->findByWords($productw);
		//print_r($productsB);
		//die();
		if ($productsB == NULL) {
		  throw new Exception("no such product with words: ".$productw);
		}
	}
	// put the array containing Product object to the view
    $this->view->setVariable("products", $productsB);    
    
    // render the view (/view/products/search.php)
    $this->view->render("products", "search");
  }
  
  public function myproducts() {
	//comprobar si hay algun usuario, sino, lanzar una excepcion de seguridad
	 if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Seeing products requires login");
    }
	
	// obtain the data from the database
		$products = $this->productMapper->findByAuthor($this->currentUser->getUsername());
		
		//print_r($products);
		//die();
		
		// put the array containing Product object to the view
		$this->view->setVariable("products", $products);    
		
		// render the view (/view/products/myproducts.php)
		$this->view->render("products", "myproducts");
  }
  
  /**
   * Action to view a given product
   * 
   * 
   */
  public function view(){
    if (!isset($_GET["id"])) {
      throw new Exception("id is mandatory");
    }
	
    $productid = $_GET["id"];
    
    // find the Product object in the database
    $product = $this->productMapper->findById($productid);
    $product->setVisitsProduct($product->getVisitsProduct()+1);
	$this->productMapper->update($product);
    if ($product == NULL) {
      throw new Exception("no such product with id: ".$productid);
    }
	
	if (isset($_POST["like"])) {
		 $product->setLikesProduct($product->getLikesProduct()+1);
		 $this->productMapper->update($product);
	}
    
    // put the Product object to the view
    $this->view->setVariable("product", $product);
	
    
    // render the view (/view/products/view.php)
    $this->view->render("products", "view");
    
  }
  
  /**
   * Action to add a new product
   * 
   *
   * @throws Exception if no user is in session
   * @return void
   */
  public function add() {
    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Adding products requires login");
    }
    
    $product = new Product();
    
    if (isset($_POST["submit"])) { // reaching via HTTP Post...
      
      // populate the Product object with data form the form
      $product->setNameProduct($_POST["nameproduct"]);
      $product->setCategoryProduct($_POST["categoryproduct"]);
	  $product->setContentProduct($_POST["contentproduct"]);
      $product->setPriceProduct($_POST["priceproduct"]);
	  $product->setVisitsProduct("0");
	  $product->setLikesProduct("0");
	  $product->setCreationDateProduct($_POST["creationdateproduct"]);
      
      // The user of the Product is the currentUser (user in session)
      $product->setAuthor($this->currentUser);
	  
		 //comprobamos si ha ocurrido un error.
		if (!isset($_FILES["photoproduct"]["error"])){
			echo "ha ocurrido un error";
			print_r($_FILES);
			die();
		} else if ($_FILES['photoproduct']['type'] != "") {
			//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
			//y que el tamanho del archivo no exceda los 500kb
			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
			$limite_kb = 500;

			if (in_array($_FILES['photoproduct']['type'], $permitidos) && $_FILES['photoproduct']['size'] <= $limite_kb * 1024){
				//esta es la ruta donde copiaremos la imagen
				//recuerden que deben crear un directorio con este mismo nombre
				//en el mismo lugar donde se encuentra el archivo subir.php
				//die($_FILES['photoproduct']['name']);
				$nombreImagen = pathinfo($_FILES['photoproduct']['name']);
				$nnombre = md5(rand().time()).".".$nombreImagen['extension'];  

				$ruta = __DIR__."/../images/img_products/" . $nnombre;
				//die($nnombre);
				$product->setPhotoProduct($nnombre);
				//die($ruta);
				//comprobamos si este archivo existe para no volverlo a copiar.
				//pero si quieren pueden obviar esto si no es necesario.
				//o pueden darle otro nombre para que no sobreescriba el actual.
				if (!file_exists($ruta)){
					//aqui movemos el archivo desde la ruta temporal a nuestra ruta
					//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
					//almacenara true o false
					$resultado = @move_uploaded_file($_FILES["photoproduct"]["tmp_name"], $ruta);
					if ($resultado){
						echo "el archivo ha sido movido exitosamente";
					} else {
						echo "ocurrio un error al mover el archivo.";
					}
				} else {
					echo $_FILES['photoproduct']['name'] . ", este archivo existe";
					die();
				}
			} else {
				echo "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
				die();
			}
		}		 
      try {
	// validate Product object
	$product->checkIsValidForCreate(); // if it fails, ValidationException
	
	// save the Product object into the database
	$this->productMapper->save($product);
	
	// POST-REDIRECT-GET
	// Everything OK, we will redirect the user to the list of posts
	// We want to see a message after redirection, so we establish
	// a "flash" message (which is simply a Session variable) to be
	// get in the view after redirection.
	$this->view->setFlash(sprintf(i18n("Product \"%s\" successfully added."),$product ->getNameProduct()));
	
	// perform the redirection. More or less: 
	// header("Location: index.php?controller=products&action=index")
	// die();
	$this->view->redirect("products", "index");
	
      }catch(ValidationException $ex) {      
	// Get the errors array inside the exepction...
	$errors = $ex->getErrors();	
	// And put it to the view as "errors" variable
	$this->view->setVariable("errors", $errors);
      }
    }
    
    // Put the Product object visible to the view
    $this->view->setVariable("product", $product);    
    
    // render the view (/view/products/add.php)
    $this->view->render("products", "add");
    
  }
  
  /**
   * Action to edit a product
   * 
   *
   */  
  public function edit() {
    if (!isset($_REQUEST["id"])) {
      throw new Exception("A product id is mandatory");
    }
    
    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Editing products requires login");
    }
    
    // Get the Post object from the database
    $productid = $_REQUEST["id"];
    $product = $this->productMapper->findById($productid);
    
    // Does the post exist?
    if ($product == NULL) {
      throw new Exception("no such product with id: ".$productid);
    }
    
    // Check if the Product author is the currentUser (in Session)
    if ($product->getAuthor() != $this->currentUser) {
      throw new Exception("logged user is not the author of the product id ".$productid);
    }
    
    if (isset($_POST["submit"])) { // reaching via HTTP Post...  
    
      // populate the Product object with data form the form
      $product->setNameProduct($_POST["nameproduct"]);
      $product->setCategoryProduct($_POST["categoryproduct"]);
	  $product->setContentProduct($_POST["contentproduct"]);
      $product->setPriceProduct($_POST["priceproduct"]);
	  $product->setVisitsProduct($_POST["visits"]);
	  $product->setLikesProduct($_POST["likes"]);
	  $product->setCreationDateProduct($_POST["creationdateproduct"]);
    
	  	  //comprobamos si ha ocurrido un error.
		if (!isset($_FILES["photoproduct"]["error"])){
			echo "ha ocurrido un error";
			print_r($_FILES);
			die();
		} else if ($_FILES['photoproduct']['type'] != "") {
			//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
			//y que el tamanho del archivo no exceda los 500kb
			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
			$limite_kb = 500;

			if (in_array($_FILES['photoproduct']['type'], $permitidos) && $_FILES['photoproduct']['size'] <= $limite_kb * 1024){
				//esta es la ruta donde copiaremos la imagen
				//recuerden que deben crear un directorio con este mismo nombre
				//en el mismo lugar donde se encuentra el archivo subir.php
				//die($_FILES['photoproduct']['name']);
				$nombreImagen = pathinfo($_FILES['photoproduct']['name']);
				$nnombre = md5(rand().time()).".".$nombreImagen['extension'];  

				$ruta = __DIR__."/../images/img_products/" . $nnombre;
				//die($nnombre);
				$product->setPhotoProduct($nnombre);
				//die($ruta);
				//comprobamos si este archivo existe para no volverlo a copiar.
				//pero si quieren pueden obviar esto si no es necesario.
				//o pueden darle otro nombre para que no sobreescriba el actual.
				if (!file_exists($ruta)){
					//aqui movemos el archivo desde la ruta temporal a nuestra ruta
					//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
					//almacenara true o false
					$resultado = @move_uploaded_file($_FILES["photoproduct"]["tmp_name"], $ruta);
					if ($resultado){
						echo "el archivo ha sido movido exitosamente";
					} else {
						echo "ocurrio un error al mover el archivo.";
					}
				} else {
					echo $_FILES['photoproduct']['name'] . ", este archivo existe";
					die();
				}
			} else {
				echo "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
				die();
			}
		}		 
      try {
	// validate Product object
	$product->checkIsValidForUpdate(); // if it fails, ValidationException
	
	// update the Post object in the database
	$this->productMapper->update($product);
	
	// POST-REDIRECT-GET
	// Everything OK, we will redirect the user to the list of posts
	// We want to see a message after redirection, so we establish
	// a "flash" message (which is simply a Session variable) to be
	// get in the view after redirection.
	$this->view->setFlash(sprintf(i18n("Product \"%s\" successfully updated."),$product ->getNameProduct()));
	
	// perform the redirection. More or less: 
	// header("Location: index.php?controller=posts&action=index")
	// die();
	$this->view->redirect("products", "index");	
	
      }catch(ValidationException $ex) {
	// Get the errors array inside the exepction...
	$errors = $ex->getErrors();
	// And put it to the view as "errors" variable
	$this->view->setVariable("errors", $errors);
      }
    }
    
    // Put the Product object visible to the view
    $this->view->setVariable("product", $product);
    
    // render the view (/view/products/edit.php)
    $this->view->render("products", "edit");    
  }
  
  /**
   * Action to delete a product
   * 
   * 
   */    
  public function delete() {  
    if (!isset($_POST["id"])) {
      throw new Exception("id is mandatory");
    }
    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Editing products requires login");
    }
    
     // Get the Post object from the database
    $productid = $_REQUEST["id"];
    $product = $this->productMapper->findById($productid);
    
    // Does the post exist?
    if ($product == NULL) {
      throw new Exception("no such product with id: ".$postid);
    }  
    
    // Check if the Product author is the currentUser (in Session)
    if ($product->getAuthor() != $this->currentUser) {
      throw new Exception("Product author is not the logged user");
    }
    
    // Delete the Post object from the database
    $this->productMapper->delete($product);
    
    // POST-REDIRECT-GET
    // Everything OK, we will redirect the user to the list of posts
    // We want to see a message after redirection, so we establish
    // a "flash" message (which is simply a Session variable) to be
    // get in the view after redirection.
    $this->view->setFlash(sprintf(i18n("Product \"%s\" successfully deleted."),$product ->getNameProduct()));
    
    // perform the redirection. More or less: 
    // header("Location: index.php?controller=products&action=index")
    // die();
    $this->view->redirect("products", "index");
    
  }  
}
