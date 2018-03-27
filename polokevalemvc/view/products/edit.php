<?php 
 //file: view/posts/edit.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $product = $view->getVariable("product");
 $errors = $view->getVariable("errors");
 
 $view->setVariable("title", "Edit Product");
 
?><h1><?= i18n("Modify Product") ?></h1>
<form class="formproduct" action="index.php?controller=products&amp;action=edit" method="POST" enctype="multipart/form-data">
      <?= i18n("Name") ?>: <input type="text" name="nameproduct" 
		    value="<?= isset($_POST["nameproduct"])?$_POST["nameproduct"]:$product->getNameProduct() ?>">
      <?= isset($errors["nameproduct"])?$errors["nameproduct"]:"" ?><br>
	  
	  <?= i18n("Category") ?>: <input type="text" name="categoryproduct" 
			     value="<?= isset($_POST["categoryproduct"])?$_POST["categoryproduct"]:$product->getCategoryProduct() ?>">
	    <?= isset($errors["categoryproduct"])?$errors["categoryproduct"]:"" ?><br>
      
      <?= i18n("Content of product") ?>: <br>
      <textarea name="contentproduct" rows="4" cols="50"><?= 
	isset($_POST["contentproduct"])?
	      htmlentities($_POST["contentproduct"]):
	      htmlentities($product->getContentProduct())
      ?></textarea>	    
      <?= isset($errors["contentproduct"])?$errors["contentproduct"]:"" ?><br>
	  
	  <?= i18n("Price (Euros)") ?>: <input type="text" name="priceproduct" 
			     value="<?= isset($_POST["priceproduct"])?$_POST["priceproduct"]:$product->getPriceProduct() ?>">
	    <?= isset($errors["priceproduct"])?$errors["priceproduct"]:"" ?><br>
	    
		<?= i18n("Change photo") ?>: <input type="file" name="photoproduct" 
			     value="<?= isset($_POST["photoproduct"])?$_POST["photoproduct"]:$product->getPhotoProduct() ?>">
	    <?= isset($errors["photoproduct"])?$errors["photoproduct"]:"" ?><br>
		
		<input type="hidden" name="creationdateproduct"
			     value="<?= date("Y/n/d") ?>">
	    <?= isset($errors["creationdateproduct"])?$errors["creationdateproduct"]:"" ?><br>
		
		<input type="hidden" name="visits" value="<?= $product->getVisitsProduct() ?>">
		
		<input type="hidden" name="likes" value="<?= $product->getLikesProduct() ?>">
		
      <input type="hidden" name="id" value="<?= $product->getIdProduct() ?>">
	  
      <input type="submit" name="submit" value="<?= i18n("Modify Product") ?>">
</form>
    
