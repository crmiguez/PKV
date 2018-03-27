<?php
// file: model/ProductMapper.php
require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Product.php");

/**
 * Class ProductMapper
 *
 * Database interface for Product entities
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class ProductMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }

  /**
   * Retrieves all products
   * 
   * 
   *
   * @throws PDOException if a database error occurs
   * @return mixed Array of Product instances
   *
   *
   */  
  public function findAll() {   
    $stmt = $this->db->query("SELECT * FROM products, users WHERE users.username = products.author");    
    $products_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $products = array();
    
    foreach ($products_db as $product) {
      $author = new User($product["username"]);
      array_push($products, new Product($product["id_product"], $product["name_product"], $product["category_product"],  
										$product["content_product"], $product["price_product"], $product["photo_product"], 
										$product["visitsnumber"], $product["likesnumber"], $product["creationdate_product"], $author));
    }   

    return $products;
  }
  
  /**
   * Loads a Product from the database given its id
   * 
   *
   * @throws PDOException if a database error occurs
   * @return Product The Product instances. NULL 
   * if the Product is not found
   */    
  public function findById($productid){
    $stmt = $this->db->prepare("SELECT * FROM products WHERE id_product=?");
    $stmt->execute(array($productid));
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($product != null) {
      return new Product(
	$product["id_product"], 
	$product["name_product"], 
	$product["category_product"],  
	$product["content_product"], 
	$product["price_product"], 
	$product["photo_product"], 
	$product["visitsnumber"], 
	$product["likesnumber"], 
	$product["creationdate_product"],
	new User($product["author"]));
    } else {
      return NULL;
    }   
  }
  
  /**
   * Loads a Product from the database given the words from search form
   * 
   *
   * @throws PDOException if a database error occurs
   * @return Product The Product instances. 
   *
   */  
  
  public function findByWords($productwrd){
	$stmt = $this->db->prepare("SELECT * FROM products, users  WHERE users.username = products.author AND products.name_product LIKE ?");
    $stmt->execute(array("%".$productwrd."%"));
	//$stmt->debugDumpParams();
	$products_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $products = array();
    
    foreach ($products_db as $product) {
      $author = new User($product["username"]);
      array_push($products, new Product($product["id_product"], $product["name_product"], $product["category_product"],  
										$product["content_product"], $product["price_product"], $product["photo_product"], 
										$product["visitsnumber"], $product["likesnumber"], $product["creationdate_product"], $author));
    }   

    return $products;
  }
  /**
   * Loads a Product from the database given the author
   * 
   *
   * @throws PDOException if a database error occurs
   * @return Product The Product instances. 
   *
   */
  public function findByAuthor($productauth){
    $stmt = $this->db->prepare("SELECT * FROM products, users  WHERE users.username = products.author AND products.author=?");
    $stmt->execute(array($productauth));
	//$stmt->debugDumpParams();
	$products_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $products = array();
    
    foreach ($products_db as $product) {
      $author = new User($product["username"]);
      array_push($products, new Product($product["id_product"], $product["name_product"], $product["category_product"],  
										$product["content_product"], $product["price_product"], $product["photo_product"], 
										$product["visitsnumber"], $product["likesnumber"], $product["creationdate_product"], $author));
    }   

    return $products;
  }
  

  /**
   * Saves a Product into the database
   * 
   * @param Product $product The product to be saved
   * @throws PDOException if a database error occurs
   * @return int The new product id
   */    
  public function save(Product $product) {
    $stmt = $this->db->prepare("INSERT INTO products(name_product, category_product, content_product, 
													 price_product, photo_product, visitsnumber, likesnumber, 
													 creationdate_product, author) values (?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($product->getNameProduct(),$product->getCategoryProduct(),$product->getContentProduct(),$product->getPriceProduct(),
						 $product->getPhotoProduct(),$product->getVisitsProduct(),$product->getLikesProduct(),$product->getCreationDateProduct(),
						 $product->getAuthor()->getUsername()));
    return $this->db->lastInsertId();
  }

  /**
   * Updates a Product in the database
   * 
   * @param Product $product The product to be updated
   * @throws PDOException if a database error occurs
   * @return void
   */     
  public function update(Product $product) {
    $stmt = $this->db->prepare("UPDATE products set name_product=?, category_product=?, content_product=?, 
													 price_product=?, photo_product=?, 
													 visitsnumber=?, likesnumber=?, creationdate_product=?, author=? where id_product=?");
    $stmt->execute(array($product->getNameProduct(),$product->getCategoryProduct(),$product->getContentProduct(),$product->getPriceProduct(),
						 $product->getPhotoProduct(),$product->getVisitsProduct(),$product->getLikesProduct(),
						 $product->getCreationDateProduct(),$product->getAuthor()->getUsername(), 
						 $product->getIdProduct()));    
  }
  
  /**
   * Deletes a Product into the database
   * 
   * @param Product $product The product to be deleted
   * @throws PDOException if a database error occurs
   * @return void
   */   
  public function delete(Product $product) {
    $stmt = $this->db->prepare("DELETE from products WHERE id_product=?");
    $stmt->execute(array($product->getIdProduct()));    
  }
  
}
