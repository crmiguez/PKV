<?php 
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $products = $view->getVariable("products");
 $currentuser = $view->getVariable("currentusername");
 
 $view->setVariable("title", "PKV: Polo Que Vale | Mis Productos");
 
?><h1><?=i18n(" My Products ")?></h1>

<div class="row" id="pagecontent">
<?php if (isset($currentuser)): ?>
      <a href="index.php?controller=products&amp;action=add"><?= i18n("Create product") ?></a>
    <?php endif; ?>
	<section id="maincontent" class="col-md-12">
		<div class="row">
		
			<table id="tablemain" class="table_products">
			  <tr>
			<th><?= i18n("Name")?></th><th><?= i18n("Actions")?></th>
			  </tr>
			
			<?php foreach ($products as $product): ?>
				<tr>	    
				  <td>
						<p class="product_image_table"><img src="./images/img_products/<?=$product->getPhotoProduct()?>"  class="img-responsive"></img></span></p>
						<p class="product_price_table"><strong><?=$product->getPriceProduct()?><?=i18n(" Euros ")?></strong></span></p>
				  </td>
				  <td>
				  <p class="product_title_table"><a href="index.php?controller=products&amp;action=view&amp;id=<?= $product->getIdProduct() ?>"><strong><?=$product->getNameProduct()?></strong></a></p>
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
				  
				  <?php endif; ?>

				  </td>
				</tr>    
			<?php endforeach; ?>
			</table> 
		</div>
		</section>
    </div>
</div>