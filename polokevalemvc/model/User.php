<?php
// file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");

/**
 * Class User
 * 
 * Represents a User in the Web App
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class User {

  /**
   * The user name of the user
   * @var string
   */
  private $username;
  
  private $nameofuser;
  
  private $surnameuser;
  
  private $dniuser;

  /**
   * The password of the user
   * @var string
   */
  private $passwd;
  
  private $province;
  
  /**
   * The constructor
   * 
   *
   *
   */
  public function __construct($username=NULL, $nameofuser=NULL, $surnameuser=NULL, $dniuser=NULL, $passwd=NULL, $province=NULL) {
    $this->username = $username;
    $this->nameofuser = $nameofuser;
    $this->surnameuser = $surnameuser;
    $this->dniuser = $dniuser;
    $this->passwd = $passwd;
	$this->province = $province;
  }

  /**
   * Gets the username of this user
   * 
   * @return string The username of this user
   */  
  public function getUsername() {
    return $this->username;
  }

  /**
   * Sets the username of this user
   * 
   * @param string $username The username of this user
   * @return void
   */  
  public function setUsername($username) {
    $this->username = $username;
  }
  
  public function getNameUser() {
    return $this->nameofuser;
  }
  
   public function setNameUser($nameofuser) {
    $this->nameofuser = $nameofuser;
  }
  
   public function getSurnameUser() {
    return $this->surnameuser;
  }
  
   public function setSurnameUser($surnameuser) {
    $this->surnameuser = $surnameuser;
  }
  
   public function getDniUser() {
    return $this->dniuser ;
  }
  
   public function setDniUser($dniuser) {
    $this->dniuser = $dniuser;
  }
  
  /**
   * Gets the password of this user
   * 
   * @return string The password of this user
   */  
  public function getPasswd() {
    return $this->passwd;
  }  
  /**
   * Sets the password of this user
   * 
   * @param string $passwd The password of this user
   * @return void
   */    
  public function setPassword($passwd) {
    $this->passwd = $passwd;
  }
  
  public function getProvinceUser() {
    return $this->province;
  }
  
   public function setProvinceUser($province) {
    $this->province = $province;
  }
  
  /**
   * Checks if the current user instance is valid
   * for being registered in the database
   * 
   * @throws ValidationException if the instance is
   * not valid
   * 
   * @return void
   */  
  public function checkIsValidForRegister() {
      $errors = array();
      if (strlen($this->username) < 6) {
	$errors["username"] = "Username must be at least 6 characters length";
	
      }
      if (strlen($this->passwd) < 7) {
	$errors["passwd"] = "Password must be at least 7 characters length";	
      }
	  if ($this->nameofuser == NULL ) {
	$errors["nameofuser"] = "nameofuser is mandatory";	
      }
	  if ($this->dniuser == NULL ) {
	$errors["dniuser"] = "dniuser is mandatory";	
      }
      if (sizeof($errors)>0){
	throw new ValidationException($errors, "user is not valid");
      }
  } 
}