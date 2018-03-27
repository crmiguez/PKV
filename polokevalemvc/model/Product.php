<?php
// file: model/Product.php

require_once(__DIR__."/../core/ValidationException.php");

/**
 * Class Post
 * 
 * Represents a Post in the Web App. A Product was written by an
 * specific User (author)
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class Product {
	
	

  /**
   * MAIN ATTRIBUTES
   */
  private $idproduct;
  
  private $nameproduct;
     
  private $categoryproduct;
  
  private $contentproduct;
  
  private $priceproduct;
  
  private $photoproduct;
  
  private $visits;
  
  private $likes;
  
  private $creationdateproduct;
   
  private $author;
  
  /**
   * The constructor
   * 
   * 
   */  
  public function __construct($idproduct=NULL, $nameproduct=NULL, $categoryproduct=NULL, $contentproduct=NULL, $priceproduct=NULL, 
							  $photoproduct=NULL, $visits=NULL, $likes=NULL, $creationdateproduct=NULL, User $author=NULL) {
    $this->idproduct = $idproduct;
    $this->nameproduct = $nameproduct;
    $this->categoryproduct = $categoryproduct;
	$this->contentproduct = $contentproduct;
	$this->priceproduct = $priceproduct;
	$this->photoproduct = $photoproduct;
	$this->visits = $visits;
	$this->likes = $likes;
	$this->creationdateproduct = $creationdateproduct;
    $this->author = $author;
    
  }

  /**
   * Gets the id of this post
   * 
   * @return string The id of this post
   */     
  public function getIdProduct() {
    return $this->idproduct;
  }
  
  /**
   * Gets the name of this product
   * 
   * @return string The name of this product
   */     
  public function getNameProduct() {
    return $this->nameproduct;
  }
  
  /**
   * Sets the name of this product
   * 
   * @param string $nameproduct the name of this product
   * @return void
   */    
  public function setNameProduct($nameproduct) {
    $this->nameproduct = $nameproduct;
  }
  
   public function getCategoryProduct() {
    return $this->categoryproduct;
  }
  
   public function setCategoryProduct($categoryproduct) {
    $this->categoryproduct = $categoryproduct;
  }
  
   public function getContentProduct() {
    return $this->contentproduct;
  }
  
   public function setContentProduct($contentproduct) {
    $this->contentproduct = $contentproduct;
  }
  
   public function getPriceProduct() {
    return $this->priceproduct;
  }
  
   public function setPriceProduct($priceproduct) {
    $this->priceproduct = $priceproduct;
  }
  
  public function getPhotoProduct() {
    return $this->photoproduct;
  }
  
   public function setPhotoProduct($photoproduct) {
    $this->photoproduct = $photoproduct;
  }
   public function getVisitsProduct() {
    return $this->visits;
  }
  
   public function setVisitsProduct($visits) {
    $this->visits = $visits;
  }
  
   public function getLikesProduct() {
    return $this->likes;
  }
  
   public function setLikesProduct($likes) {
    $this->likes = $likes;
  }
  
   public function getCreationDateProduct() {
    return $this->creationdateproduct;
  }
  
   public function setCreationDateProduct($creationdateproduct) {
    $this->creationdateproduct = $creationdateproduct;
  }

  /**
   * Gets the author of this product
   * 
   * @return User The author of this product
   */    
  public function getAuthor() {
    return $this->author;
  }
  
  /**
   * Sets the author of this product
   * 
   * @param User $author the author of this product
   * @return void
   */    
  public function setAuthor(User $author) {
    $this->author = $author;
  }
  /**
   * Checks if the current instance is valid
   * for being updated in the database.
   * 
   * @throws ValidationException if the instance is
   * not valid
   * 
   * @return void
   */    
  public function checkIsValidForCreate() {
      $errors = array();
      if (strlen(trim($this->nameproduct)) == 0 ) {
	$errors["nameproduct"] = "title is mandatory";
      }
      if (strlen(trim($this->contentproduct)) == 0 ) {
	$errors["contentproduct"] = "contentproduct is mandatory";
      }
	  if (strlen(trim($this->contentproduct)) > 400 ) {
	$errors["contentproduct"] = "contentproduct is not valid. Only 400 characters";
      }
	  if ($this->priceproduct == NULL ) {
	$errors["priceproduct"] = "priceproduct is mandatory";
      }
      if ($this->author == NULL ) {
	$errors["author"] = "author is mandatory";
      }
      
      if (sizeof($errors) > 0){
	throw new ValidationException($errors, "product is not valid");
      }
  }

  /**
   * Checks if the current instance is valid
   * for being updated in the database.
   * 
   * @throws ValidationException if the instance is
   * not valid
   * 
   * @return void
   */
  public function checkIsValidForUpdate() {
    $errors = array();
    
    if (!isset($this->idproduct)) {      
      $errors["idproduct"] = "idproduct is mandatory";
    }
    
    try{
      $this->checkIsValidForCreate();
    }catch(ValidationException $ex) {
      foreach ($ex->getErrors() as $key=>$error) {
	$errors[$key] = $error;
      }
    }    
    if (sizeof($errors) > 0) {
      throw new ValidationException($errors, "product is not valid");
    }
  }
}
