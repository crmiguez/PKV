<?php 
 //file: view/chats/room.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $chat = $view->getVariable("chat");
 $currentuser = $view->getVariable("currentusername"); 
 $newmessagetext = $view->getVariable("messagetext");  
 $errors = $view->getVariable("errors");
 
 $view->setVariable("title", "PKV: Polo Ke Vale | Chat Room");
 
?><h1><?= i18n("Chat")?></h1>
<section id="maincontent" class="col-md-12">
	<div class="row">
		<article class="product col-md-4 col-xs-1">
			<p class="product_image"><img src="./images/img_products/<?=$chat->getProductChat()->getPhotoProduct()?>"  class="img-responsive"></p>
			<p class="product_price"><strong><?=$chat->getProductChat()->getPriceProduct()?><?=i18n(" Euros ")?></strong></p>
			<p class="product_title"><strong><a href="index.php?controller=products&amp;action=view&amp;id=<?= $chat->getProductChat()->getIdProduct() ?>"><strong><?=$chat->getProductChat()->getNameProduct() ?></strong></a></p>
		</article>
	</div>
    <h2><?= i18n("Messages at the moment ").":" ?></h2>    
    
    <?php foreach($chat->getMessageTexts() as $messagetxs): ?>
	
	<?php if ($messagetxs->getTypeMessageText() == '1'): ?>
			<div class="row">
									<p><?= sprintf(i18n("%s sent..."), $chat->getProductChat()->getAuthor()->getUsername()) ?> </p>
									<div class="message_response col-xs-4 ">
										<p class="message_response_text"><?= $messagetxs->getMessageTextContent(); ?></p>
										<p class="message_date_response"><?= $messagetxs->getDateMessageText(); ?></p>
									</div>
			</div>
	<?php else: ?>
						<div class="row">
										<p><?= sprintf(i18n("%s sent..."), $chat->getRequesterChat()->getUsername()) ?> </p>
										<div class="message_request col-xs-4 col-sm-push-2">
											<p class="message_request_text"><?= $messagetxs->getMessageTextContent(); ?></p>
											<p class="message_date_request"><?= $messagetxs->getDateMessageText(); ?></p>
										</div>
						</div>
	<?php endif ?>
    <?php endforeach; ?>
	<div class="row">
				<br>
				<br>
				<br>
		</div>
    <?php if (isset($currentuser) ): ?>    
    <div class="row">
				<div id="chattext" class="product col-md-6">
					  <form id="chatform" method="POST" action="index.php?controller=messagetexts&amp;action=add" class="row">
						<input type="hidden" name="requester" value="<?= $chat->getRequesterChat()->getUsername() ?>" >
						<input type="hidden" name="idchat" value="<?= $chat->getIdChat() ?>" >
						<?= isset($errors["content"])?$errors["content"]:"" ?><br>
						<input type="textarea" name="content" id="chatbox" class="col-xs-10" placeholder="Escribe tu texto..."> 						
						<button type="submit" name="sendmessage" class="btn col-xs-1"><img src="images/menu_icons/enviartextPKV.png" ></button>
					  </form>
				</div>
	</div>
    <?php endif ?>
</section>