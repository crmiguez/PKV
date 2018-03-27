<?php 
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $chats = $view->getVariable("chats");
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "Chats");
 
?>
<h1><?=i18n("Chats")?></h1>
<div class="row" id="pagecontent">
	<section id="maincontent" class="col-md-12">
			<div class="row">
		<table id="tablemain" class="table_chats">
			  <tr>
			<th><?= i18n("Product")?></th><th><?= i18n("Author")?></th><th><?= i18n("Requester")?></th>
			  </tr>
			
			<?php foreach ($chats as $chat): ?>
				<tr>	    
				  <td>
					<p class="product_image_table"><img src="./images/img_products/<?=$chat->getProductChat()->getPhotoProduct()?>"  class="img-responsive"></img></span></p>
					<p class="product_price_table"><strong><?=$chat->getProductChat()->getPriceProduct()?><?=i18n(" Euros ")?></strong></span></p>
					<p class="product_title_table"><a href="index.php?controller=products&amp;action=view&amp;id=<?= $chat->getProductChat()->getIdProduct() ?>"><strong><?=$chat->getProductChat()->getNameProduct()?></strong></a></p>
					 <a href="index.php?controller=chats&amp;action=room&amp;productid=<?= $chat->getProductChat()->getIdProduct() ?>&amp;requester=<?=$chat->getRequesterChat()->getUsername()?>"><?= i18n("do chat")?></a>
				<?php
				//show actions ONLY for the author of the product (if logged)
				//IMPORTANT: The owner of the product is the only who finalizes the chat
				if (isset($currentuser) && $currentuser == $chat->getProductChat()->getAuthor()->getUsername()): ?>
						
						  <?php 
						  // 'Delete Button': show it as a link, but do POST in order to preserve
						  // the good semantic of HTTP
						  ?>
						  <form 		    
							method="POST" 
							action="index.php?controller=chats&amp;action=updatefinished" 
							id="finish_chat_<?= $chat->getIdChat(); ?>"
							style="display: inline" 
							>
						  
							<input type="hidden" name="id" value="<?= $chat->getIdChat() ?>">
						  
							<a href="#" 
							  onclick="
							  if (confirm('<?= i18n("Are you sure?")?>')) {
								document.getElementById('finish_chat_<?= $chat->getIdChat() ?>').submit() 
							  }"
							><?= i18n("Finish chat") ?></a>
						  
						  </form>
						  
						  &nbsp;
		  
				<?php endif; ?>
				  </td>
				  <td>
				<?= $chat->getProductChat()->getAuthor()->getUsername() ?>
				  </td> 
				  <td>
				  <?= $chat->getRequesterChat()->getUsername() ?>
				  </td>
				</tr>    
			<?php endforeach; ?>
			</table> 
		</div>
	</section>
	<br>
	<br>
</div>
	
    
