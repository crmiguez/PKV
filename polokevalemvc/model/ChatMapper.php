<?php
// file: model/ChatMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Chat.php");
require_once(__DIR__."/../model/Product.php");
require_once(__DIR__."/../model/MessageText.php");

/**
 * Class ChatMapper
 *
 * Database interface for Chat entities
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class ChatMapper {
 
  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
 
  /**
   * Retrieves all chats
   * 
   * Note: Message texts are not added to the Chat instances
   *
   * @throws PDOException if a database error occurs
   * @return mixed Array of Chat instances (without messagetexts)
   */  
  
   public function findAllChats() {   
    $stmt = $this->db->query("SELECT * FROM chats, products WHERE chats.id_product=products.id_product AND chats.finished = '0' ");    
    $chats_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    $chats = array();
	
    foreach ($chats_db as $chattable) {
      $requester = new User($chattable["id_requester"]);
	  $author = new User($chattable["author"]);
	  $product= new Product($chattable["id_product"], $chattable["name_product"], $chattable["category_product"],  
										$chattable["content_product"], $chattable["price_product"], $chattable["photo_product"], 
										$chattable["visitsnumber"], $chattable["likesnumber"], $chattable["creationdate_product"], $author);
      array_push($chats, new Chat($chattable["id_chat"],$product, $requester, $chattable["creationdate_chat"],$chattable["finished"]));
    }   

    return $chats;
  }
  /**
   * Loads a chat id string from the database given the id of product and requester
   * 
   *
   * @throws PDOException if a database error occurs
   * @return string of chat id. NULL 
   * if the id does not exists
   */   
  public function findChatById($productid, User $requester){
    $stmt = $this->db->prepare("SELECT id_chat FROM chats WHERE id_product=? AND id_requester=?");
    $stmt->execute(array($productid, $requester->getUsername()));
    $chatid = $stmt->fetch(PDO::FETCH_ASSOC);
    if($chatid != null) {
      return $chatid["id_chat"];
    } else {
      return NULL;
    }   
  }
  
  /**
   * Loads a Chat from the database given its id
   * 
   * Note: Message Texts are not added to the Post
   *
   * @throws PDOException if a database error occurs
   * @return Post The Post instances (without comments). NULL 
   * if the Chat is not found
   */  
  
   public function findById($chatid){
    $stmt = $this->db->prepare("SELECT * FROM chats, products WHERE chats.id_product=products.id_product AND chats.id_chat= ?");
    $stmt->execute(array($chatid));
    $chat = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($chat != null) {
	  $requester = new User($chat["id_requester"]);
	  $author = new User($chat["author"]);
      $product = new Product($chat["id_product"], $chat["name_product"], 
							 $chat["category_product"],$chat["content_product"], 
							 $chat["price_product"], $chat["photo_product"], 
							 $chat["visitsnumber"], $chat["likesnumber"], $chat["creationdate_product"], $author);
	return new Chat($chat["id_chat"],$product, $requester, $chat["creationdate_chat"],$chat["finished"]);
    } else {
      return NULL;
    }   
  }
  
  /**
   * Loads a Chat from the database given its id
   * 
   * It includes all the messagetexts
   *
   * @throws PDOException if a database error occurs
   * @return Chat The Chat instances (with messagetexts). NULL 
   * if the Chat is not found
   */      
   
  public function findByIdWithMessageTexts($chatid){
	$stmt = $this->db->prepare("SELECT
	P.id_product as 'product.id',
	P.name_product as 'product.name',
	P.category_product as 'product.category',
	P.content_product as 'product.content',
	P.price_product as 'product.price',
	P.photo_product as 'product.photo',
	P.visitsnumber as 'product.visits',
	P.likesnumber as 'product.likes',
	P.creationdate_product as 'product.creationdate',
	P.author as 'product.author',
	C.id_chat as 'chat.id', 
	C.id_product as 'chat.id_product',
	C.id_requester as 'chat.requester', 
	C.creationdate_chat as 'chat.creationdate',
	C.finished as 'chat.finished',
	M.id_chat as 'messagetext.id_chat', 	
	M.id_messagetext as 'messagetext.id', 
	M.messagetext_text as 'messagetext.text', 
	M.messagetext_date as 'messagetext.date',
	M.type_message as 'messagetext.type'
	
	FROM products P, chats C LEFT OUTER JOIN messagetexts M
	ON C.id_chat = M.id_chat
	WHERE C.id_product=P.id_product AND C.id_chat=? 
	ORDER BY M.messagetext_date");
    
    $stmt->execute(array($chatid));
    $chat_wt_messages= $stmt->fetchAll(PDO::FETCH_ASSOC);
    
	//$stmt->debugDumpParams();
	
    if (sizeof($chat_wt_messages) > 0) {
	  $author = new User($chat_wt_messages[0]["product.author"]);
	  $product = new Product($chat_wt_messages[0]["product.id"], 
		       $chat_wt_messages[0]["product.name"], 
		       $chat_wt_messages[0]["product.category"],
			   $chat_wt_messages[0]["product.content"],
			   $chat_wt_messages[0]["product.price"],
			   $chat_wt_messages[0]["product.photo"],
			   $chat_wt_messages[0]["product.visits"],
			   $chat_wt_messages[0]["product.likes"],
			   $chat_wt_messages[0]["product.creationdate"], $author);
	  $requester = new User($chat_wt_messages[0]["chat.requester"]);
      $chatmess = new Chat($chat_wt_messages[0]["chat.id"],$product, $requester, 
					   $chat_wt_messages[0]["chat.creationdate"],
					   $chat_wt_messages[0]["chat.finished"]);
      $messages_array = array();
      if ($chat_wt_messages[0]["messagetext.id"]!=null) {
        foreach ($chat_wt_messages as $messaget){
          $messaget = new MessageText($chatmess, $messaget["messagetext.id"],
                                  $messaget["messagetext.text"],
								  $messaget["messagetext.date"],
								  $messaget["messagetext.type"]);
          array_push($messages_array, $messaget);
        }
      }
      $chatmess->setMessageTexts($messages_array);
      
      return $chatmess;
    }else {
      return NULL;
    }
  }
  
  /**
   * Saves a chat
   * 
   * @param Chat $chat The chat to save
   * @throws PDOException if a database error occurs
   * @return int The new chat id
   */
  public function save(Chat $chat) {
    $stmt = $this->db->prepare("INSERT INTO chats(id_product, id_requester, creationdate_chat, finished) values (?,?,?,?)");
    $stmt->execute(array($chat->getProductChat()->getIdProduct(), $chat->getRequesterChat()->getUsername(), $chat->getCreationDateChat(), 
						 $chat->getFinishedChat()));    
    return $this->db->lastInsertId();
  }
  /**
   * Updates a Chat in the database with the attribute finished
   * NOTE: If finished is equal to 1 the chat does not be displayed
   * 
   * @param  Chat $chat The chat to be updated
   * @throws PDOException if a database error occurs
   * @return void
   */     
  public function updatefinished(Chat $chat) {
    $stmt = $this->db->prepare("UPDATE chats set finished='1' where id_chat=?");
    $stmt->execute(array($chat->getIdChat()));    
  }

}
