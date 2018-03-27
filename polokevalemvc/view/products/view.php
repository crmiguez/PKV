<?php 
 //file: view/posts/view.php
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $product = $view->getVariable("product");
 $currentuser = $view->getVariable("currentusername");  
 $errors = $view->getVariable("errors");
 
 $view->setVariable("title", "View Product");
 
?><h1><?= i18n("Product").": ".htmlentities($product->getNameProduct()) ?></h1>
    <em><?= sprintf(i18n("by %s"),$product->getAuthor()->getUsername()) ?></em>
	<article class="productdepth col-md-12">
	<div class="row">
		<p>
			<p class="product_imagedepth"><img src="./images/img_products/<?=$product->getPhotoProduct()?>"  class="img-responsive"></img></span></p>
			<p class="product_pricedepth"><strong><?=$product->getPriceProduct()?><?=i18n(" Euros ")?></strong></span></p>
			<h2><?=i18n(" Description ")?>:</h2>
			<p class="product_contentdepth"><span><?=$product->getContentProduct()?></span></p>
		</p>
		<?php
		//show actions ONLY for the author of the product (if logged)
		
		if (isset($currentuser) && $currentuser == $product->getAuthor()->getUsername()): ?>
		
		  <?php 
		  // 'Delete Button': show it as a link, but do POST in order to preserve
		  // the good semantic of HTTP
		  ?>
		  <form 		    
		    method="POST" 
		    action="index.php?controller=products&amp;action=delete" 
		    id="delete_product_<?= $product->getIdProduct(); ?>"
		    style="display: inline" 
		    >
		  
		    <input type="hidden" name="id" value="<?= $product->getIdProduct() ?>">
		  
		    <a href="#" 
		      onclick="
		      if (confirm('<?= i18n("Are you sure?")?>')) {
			    document.getElementById('delete_product_<?= $product->getIdProduct() ?>').submit() 
		      }"
		    ><?= i18n("Delete") ?></a>
		  
		  </form>
		  
		  &nbsp;
		  
		  <?php 
		  // 'Edit Button'
		  ?>		  
		  <a href="index.php?controller=products&amp;action=edit&amp;id=<?= $product->getIdProduct() ?>"><?= i18n("Edit product") ?></a>
	</div>
		  <?php endif; ?>
	</article>
	
<?php 
		  // 'Visits'
		  ?>
		  <?php if (isset($currentuser)): ?>
				  <h3><?= i18n("Visits") ?>:<strong><?=$product->getVisitsProduct()?></strong></h3>
		  <?php endif; ?>	
				
	<?php 
		  // 'Likes Button'
		  ?>
		  <?php if (isset($currentuser) && !($currentuser == $product->getAuthor()->getUsername())): ?>
				  <h3><?= i18n("Likes") ?>:<strong><?=$product->getLikesProduct()?></strong></h3>
				  <form method="POST" action="index.php?controller=products&amp;action=view&amp;id=<?= $product->getIdProduct() ?>">
					<input type="submit" name="like" value="<?=i18n("Love this!")?>">
				  </form>
		  <?php endif; ?>
    
    <?php if (isset($currentuser) && !($currentuser == $product->getAuthor()->getUsername())): ?>
    <h3><?= i18n("Let's chat!") ?></h3>
	<form method="POST" action="index.php?controller=chats&amp;action=room&amp;productid=<?= $product->getIdProduct() ?>&amp;requester=<?= $currentuser ?>">
		<input type="hidden" name="creationdatechat"
			     value="<?= date("Y/n/d H:i:s") ?>">
	    <?= isset($errors["creationdatechat"])?$errors["creationdatechat"]:"" ?><br>
	 <input type="submit" name="chat" value="<?=i18n("do chat") ?>">
    </form>
    
    <?php endif ?>
				<br>
					<br>