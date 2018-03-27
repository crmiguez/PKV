<?php
// file: model/MessageTextMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/MessageText.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Chat.php");

/**
 * Class MessageTextMapper
 *
 * Database interface for MessageText entities
 * 
 * @author crmiguez <crmiguez@esei.uvigo.es>
 */
class MessageTextMapper {
 
  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  /**
   * Saves a messagetext
   * 
   * @param MessageText $messagetext The messagetext to save
   * @throws PDOException if a database error occurs
   * @return int The new messagetext id
   */
  public function save(MessageText $messagetext) {
    $stmt = $this->db->prepare("INSERT INTO messagetexts(id_chat, id_messagetext, messagetext_text, messagetext_date, type_message) values (?,?,?,?,?)");
    $stmt->execute(array($messagetext->getIdChatMessageText()->getIdChat(),$messagetext->getIdMessageText(),
						 $messagetext->getMessageTextContent(),$messagetext->getDateMessageText(),$messagetext->getTypeMessageText()));    
    return $this->db->lastInsertId();
  }
}
