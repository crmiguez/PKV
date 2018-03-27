<?php
//file: /controller/MessageTextsController.php

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Chat.php");
require_once(__DIR__."/../model/Product.php");
require_once(__DIR__."/../model/MessageText.php");

require_once(__DIR__."/../model/ChatMapper.php");
require_once(__DIR__."/../model/MessageTextMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class MessageTextsController
 * 
 * Controller for messagetexts related use cases.
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class MessageTextsController extends BaseController {
  
  /**
   * Reference to the MessageTextMapper to interact
   * with the database
   * 
   * @var 
   */
  private $messagetextmapper;
  
  /**
   * Reference to the ChatMapper to interact
   * with the database
   * 
   * @var 
   */
  private $chatmapper;
  
  
  public function __construct() {
    parent::__construct();
    
    $this->messagetextmapper = new MessageTextMapper();
    $this->chatmapper = new ChatMapper();
	$this->view->setLayout('chat');
  }
  
  /**
   * Action to adds a messagetext to a chat
   *
   * This method should only be called via HTTP POST.
   *
   * The user of the messagetext is taken from the {@link BaseController::currentUser}
   * property.
   * 
   *
   * @return void
   */
  public function add() {
    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Adding messagetexts requires login");
    }
    
    if (isset($_POST["idchat"])) { // reaching via HTTP Post...
      
      // Get the Post object from the database
      $chatid = $_POST["idchat"];
      $chat = $this->chatmapper->findById($chatid);
      
      // Does the post exist?      
      if ($chat == NULL) {
			throw new Exception("no such chat with idchat: ".$chatid);
	  }	
	   //Exception if the user in session are not the participant of the chat
	  if (isset($this->currentUser) && !($this->currentUser->getUsername() == $chat->getRequesterChat()->getUsername()) && 
									 !($this->currentUser->getUsername() == $chat->getProductChat()->getAuthor()->getUsername())){
			throw new Exception("You are not a participant in this chat. Chat forbidden!!!");
	}
      
      // Create and populate the MessageText object
      $messagetext = new MessageText();
	  $messagetext->setIdChatMessageText($chat);
	  //I generate a number random in order to insert the messages
	  $randomnumber=mt_rand();
	  $messagetext->setIdMessageText($randomnumber);
      $messagetext->setMessageTextContent($_POST["content"]);
	  //If the current user is a requester, then put a zero value
	  $numbertypemessage='1';
	  if(isset($this->currentUser) && ($this->currentUser->getUsername() == $chat->getRequesterChat()->getUsername())){
		 $numbertypemessage='0';
		 $messagetext->setTypeMessageText($numbertypemessage);
	  }
	  if (isset($this->currentUser) && ($this->currentUser->getUsername() == $chat->getProductChat()->getAuthor()->getUsername())) {
		 $messagetext->setTypeMessageText($numbertypemessage); 
	  }
	  //The message texts are sort by its date
      $messagetext->setDateMessageText(date("Y/n/d H:i:s"));
      
      try {
      
	// validate MessageText object
	$messagetext->checkIsValidForCreate(); // if it fails, ValidationException
	
	// save the MessageText object into the database
	$this->messagetextmapper->save($messagetext);
	
	// POST-REDIRECT-GET
	// Everything OK, we will redirect the user to the list of posts
	// We want to see a message after redirection, so we establish
	// a "flash" message (which is simply a Session variable) to be
	// get in the view after redirection.
	$this->view->setFlash("Message Text of \"".$this->currentUser->getUsername()."\" successfully added.");
	
	// perform the redirection. More or less: 
	// header("Location: index.php?controller=chats&action=room,&productid=$productid&requester=$requester")
	// die();
	$this->view->redirect("chats", "room", "productid=".$chat->getProductChat()->getIdProduct()."&requester=".$chat->getRequesterChat()->getUsername());
      }catch(ValidationException $ex) {
	$errors = $ex->getErrors();
	
	// Go back to the form to show errors.
	// However, the form is not in a single page (messagetexts/add)
	// It is in the Chat Room page.
	// We will save errors as a "flash" variable (third parameter true)
	// and redirect the user to the referring page
	// (the View chat page)	
	$this->view->setVariable("messagetext", $messagetext, true);
	$this->view->setVariable("errors", $errors, true);
	
	$this->view->redirect("chats", "room", "productid=".$chat->getProductChat()->getIdProduct()."&requester=".$chat->getRequesterChat()->getUsername());
      }
    } else {
      throw new Exception("No such chat idchat");
    }
  }  
}