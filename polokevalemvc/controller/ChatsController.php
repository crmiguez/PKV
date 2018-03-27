<?php
//file: /controller/ChatController.php

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Product.php");
require_once(__DIR__."/../model/Chat.php");
require_once(__DIR__."/../model/MessageText.php");

require_once(__DIR__."/../model/ProductMapper.php");
require_once(__DIR__."/../model/ChatMapper.php");
require_once(__DIR__."/../model/MessageTextMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class ChatController
 * 
 * Controller for chats and messagetexts related use cases.
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class ChatsController extends BaseController {
  
  /**
   * Reference to the ChatMapper to interact
   * with the database
   * 
   * @var CommentMapper
   */
  private $chatMapper;
  
  /**
   * Reference to the ProductMapper to interact
   * with the database
   * 
   * @var PostMapper
   */
  private $productMapper; 
  
  /**
   * Reference to the MessageTextMapper to interact
   * with the database
   * 
   * @var PostMapper
   */

  private $textmessageMapper;    
  
  public function __construct() {
    parent::__construct();
    
    $this->chatMapper = new ChatMapper();
    $this->productMapper = new ProductMapper();
	$this->textMessagemapper = new MessageTextMapper();
	$this->view->setLayout('chat');
  }
  public function index() {
	  //The list of chat it is ONLY for registered users!!
	  if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Going to a chat requires login");
    }
	  // obtain the data from the database
    $chats = $this->chatMapper->findAllChats();
	
    // put the array containing Chat object to the view
    $this->view->setVariable("chats", $chats);    
    
    // render the view (/view/chats/index.php)
    $this->view->render("chats", "index");
	  
  }
  
  public function room() {
	  if (!isset($_GET["productid"]) && !isset($_GET["requester"])) {
      throw new Exception("productid and requester are mandatories");
    }
	
	if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Going to a chat requires login");
    }
	
    $productid = $_GET["productid"];
	$requesterid = $_GET["requester"];
	
	$product = $this->productMapper->findById($productid);
	$requester = new User($requesterid);
	
	//Exception if the user in session are not the participant of the chat
	if (isset($this->currentUser) && !($this->currentUser->getUsername() == $requesterid) && !($this->currentUser->getUsername() == $product->getAuthor()->getUsername())){
		throw new Exception("You are not a participant in this chat. Chat forbidden!!!");
	}
	
    // find the Chat object in the database
	$chatid = $this->chatMapper->findChatById($productid, $requester);
	if ($chatid == NULL) {
			 $chat = new Chat();
			 if (isset($_POST["chat"])) { // reaching via HTTP Post...
				$chat->setProductChat($product);
				$chat->setRequesterChat($requester);
				$chat->setCreationDateChat(date("Y/n/d"));
				$chat->setFinishedChat('0');
				
				try {
					// validate Chat object
					$chat->checkIsValidForCreate(); // if it fails, ValidationException
					
					// save the Post object into the database
					$this->chatMapper->save($chat);
					
					
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Chat \"%s\" successfully added."),$chat ->getProductChat()->getNameProduct()));
					
					// perform the redirection. More or less: 
					// header("Location: index.php?controller=chats&action=room")
					// die();
					$this->view->redirect("chats", "room", "productid=$productid&requester=$requesterid");
					
					  }catch(ValidationException $ex) {      
					// Get the errors array inside the exepction...
					$errors = $ex->getErrors();	
					// And put it to the view as "errors" variable
					$this->view->setVariable("errors", $errors);
					  }
			 }
      
	} else  if (isset($_POST["chat"])){
		$this->view->redirect("chats", "room", "productid=$productid&requester=$requesterid");
	}
			$chatidnew = $this->chatMapper->findChatById($productid, $requester);
			$chat = $this->chatMapper->findByIdWithMessageTexts($chatidnew);
				
				if ($chat == NULL) {
				  throw new Exception("no such chat with idchat: ".$chatidnew);
				}
			
			// put the Chat object to the view
			$this->view->setVariable("chat", $chat);
			
			// check if message text is already on the view (for example as flash variable)
			// if not, put an empty MessageText for the view
			$messagetext = $this->view->getVariable("messagetext"); 
			$this->view->setVariable("messagetext", ($messagetext==NULL)?new MessageText():$messagetext);
			
			// render the view (/view/chats/room.php)
			$this->view->render("chats", "room");
  }

  /*
  */
  public function updatefinished() {
	  if (!isset($_POST["id"])) {
      throw new Exception("id is mandatory");
    }
    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Editing posts requires login");
    }
    
     // Get the Chat object from the database
    $chatid = $_REQUEST["id"];
    $chat = $this->chatMapper->findById($chatid);
    
    // Does the chat exist?
    if ($chat == NULL) {
      throw new Exception("no such post with id: ".$postid);
    }  
    
    // Check if the Product author is the currentUser (in Session)
    if ($chat->getProductChat()->getAuthor() != $this->currentUser) {
      throw new Exception("Product author is not the logged user");
    }
    
    // Delete the Chat object from the database
    $this->chatMapper->updatefinished($chat);
    
    // POST-REDIRECT-GET
    // Everything OK, we will redirect the user to the list of posts
    // We want to see a message after redirection, so we establish
    // a "flash" message (which is simply a Session variable) to be
    // get in the view after redirection.
    $this->view->setFlash(sprintf(i18n("Chat \"%s\" successfully deleted."), $chat ->getProductChat()->getNameProduct()));
    
    // perform the redirection. More or less: 
    // header("Location: index.php?controller=chats&action=index")
    // die();
    $this->view->redirect("chats", "index");
	  
  }
  
  }

