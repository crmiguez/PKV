<?php
// file: model/MessageText.php

require_once(__DIR__."/../core/ValidationException.php");

/**
 * Class MessageText
 * 
 * Represents a MessageText in the chat.
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class MessageText {
/**
   * 
   * MAIN ATTRIBUTES
   */
  private $idchat;
  
  private $idmessagetext;  
  
  private $messagetextcontent;
  
  private $datemessagetext;
  
  private $typemessagetext;
  
  /**
   * The constructor
   * 
   * 
   */
  public function __construct(Chat $idchat=NULL, $idmessagetext=NULL, $messagetextcontent=NULL, $datemessagetext=NULL, $typemessagetext=NULL) {
    $this->idchat = $idchat;
    $this->idmessagetext = $idmessagetext;    
    $this->messagetextcontent = $messagetextcontent;
    $this->datemessagetext = $datemessagetext;
	$this->typemessagetext = $typemessagetext;
  }
  
  /**
   * Gets the id chat of this messagetext
   * 
   * @return string The id chat of this messagetext 
   */
  public function getIdChatMessageText(){
    return $this->idchat;
  }
  
  public function setIdChatMessageText(Chat $idchat){
    return $this->idchat = $idchat;
  }
  /**
   * Gets the id messagetext of this MessageText
   * 
   * @return string The id messagetext of this MessageText
   */
  public function getIdMessageText(){
    return $this->idmessagetext;
  }
  
  public function setIdMessageText($idmessagetext){
    return $this->idmessagetext = $idmessagetext;
  }

  public function getMessageTextContent() {
    return $this->messagetextcontent;
  }

  public function setMessageTextContent($messagetextcontent) {
    $this->messagetextcontent = $messagetextcontent;
  }
  
   public function getDateMessageText() {
    return $this->datemessagetext;
  }
  
   public function setDateMessageText($datemessagetext) {
    $this->datemessagetext = $datemessagetext;
  }
  
  public function getTypeMessageText() {
    return $this->typemessagetext;
  }
  
   public function setTypeMessageText($typemessagetext) {
    $this->typemessagetext = $typemessagetext;
  }
  
  
  /**
   * Checks if the current instance is valid
   * for being inserted in the database.
   * 
   * @throws ValidationException if the instance is
   * not valid
   * 
   * @return void
   */  
  public function checkIsValidForCreate() {
      $errors = array();
      if ($this->idchat == NULL ) {
	$errors["idchat"] = "idchat is mandatory";	
      }
      if ($this->idmessagetext == NULL ) {
	$errors["idmessagetext"] = "idmessagetext is mandatory";	
      }
      if ($this->datemessagetext == NULL ) {
	$errors["datemessagetext"] = "datemessagetext is mandatory";	
      }
	  if ($this->typemessagetext == NULL ) {
	$errors["typemessagetext"] = "typemessagetext is mandatory";	
      }
      if (sizeof($errors) > 0){
	throw new ValidationException($errors, "messagetext is not valid");
      }
  }
}
