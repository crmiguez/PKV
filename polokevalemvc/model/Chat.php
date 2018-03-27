<?php
// file: model/Chat.php

require_once(__DIR__."/../core/ValidationException.php");

/**
 * Class Chat
 * 
 * Represents a chat in the web app
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class Chat {
  /**
   * 
   * MAIN ATTRIBUTES
   */
  private $idchat;  
  
  private $productchat;
  
  private $requester;
  
  private $creationdatechat;
  
  private $finished;
  
   private $textmessages;
  
  /**
   * The constructor
   * 
   * 
   */
  public function __construct($idchat=NULL, Product $productchat=NULL, User $requester=NULL, $creationdatechat=NULL, $finished=NULL, 
							  array $textmessages=NULL) {
    $this->idchat = $idchat;
    $this->productchat = $productchat;    
    $this->requester = $requester;
    $this->creationdatechat = $creationdatechat;
	$this->finished = $finished;
	$this->textmessages = $textmessages;
  }
  
  /**
   * Gets the id of this chat
   * 
   * @return string The id of this chat
   */
  public function getIdChat(){
    return $this->idchat;
  }

  /**
   * Gets the product of this chat
   * 
   * @return Product The product of this chat
   */  
  public function getProductChat() {
    return $this->productchat;
  }

  /**
   * Sets the product of this chat
   * 
   * @param Product The product of this chat
   * @return void
   */
  public function setProductChat(Product $productchat) {
    $this->productchat = $productchat;
  }
  
  public function getRequesterChat() {
    return $this->requester;
  }
  
   public function setRequesterChat(User $requester) {
    $this->requester = $requester;
  }
  
   public function getCreationDateChat() {
    return $this->creationdatechat;
  }
  
   public function setCreationDateChat($creationdatechat) {
    $this->creationdatechat = $creationdatechat;
  }
  
  public function getFinishedChat() {
    return $this->finished;
  }
  
   public function setFinishedChat($finished) {
    $this->finished = $finished;
  }
  
  
  /**
   * Gets the list of messagetexts of this chat
   * 
   * @return mixed The list of messagetext of this chat
   */  
  public function getMessageTexts() {
    return $this->textmessages;
  }
  
  /**
   * Sets the messagetexts of the chat
   * 
   * @param mixed $textmessages the messagetexts list of this chat
   * @return void
   */  
  public function setMessageTexts(array $textmessages) {
    $this->textmessages = $textmessages;
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
      if ($this->requester == NULL ) {
	$errors["requester"] = "requester is mandatory";	
      }
      if ($this->productchat == NULL ) {
	$errors["productchat"] = "productchat is mandatory";	
      }
      if ($this->creationdatechat == NULL ) {
	$errors["creationdatechat"] = "creationdatechat is mandatory";	
      }
      if (sizeof($errors) > 0){
	throw new ValidationException($errors, "chat is not valid");
      }
  }
}
