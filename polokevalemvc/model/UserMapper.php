<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
 * Class UserMapper
 *
 * Database interface for User entities
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class UserMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }

  /**
   * Saves a User into the database
   * 
   * @param User $user The user to be saved
   * @throws PDOException if a database error occurs
   * @return void
   */      
  public function save($user) {
    $stmt = $this->db->prepare("INSERT INTO users (username, name_user, surname_user, dni, passwd, province) values (?,?,?,?,?,?)");
    $stmt->execute(array($user->getUsername(), $user->getNameUser(), $user->getSurnameUser(), $user->getDniUser(), $user->getPasswd(),$user->getProvinceUser()));
  }
  
  /**
   * Checks if a given username is already in the database
   * 
   * @param string $username the username to check
   * @return boolean true if the username exists, false otherwise
   */
  public function usernameExists($username) {
    $stmt = $this->db->prepare("SELECT count(username) FROM users where username=?");
    $stmt->execute(array($username));
    
    if ($stmt->fetchColumn() > 0) {   
      return true;
    } 
  }
  
  /**
   * Checks if a given pair of username/password exists in the database
   * 
   * @param string $username the username
   * @param string $passwd the password
   * @return boolean true the username/password exists, false otherwise.
   */
  public function isValidUser($username, $passwd) {
    $stmt = $this->db->prepare("SELECT count(username) FROM users where username=? and passwd=?");
    $stmt->execute(array($username, $passwd));
    
    if ($stmt->fetchColumn() > 0) {
      return true;        
    }
  }
}