<?php 
 //file: view/posts/add.php
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 
 $product = $view->getVariable("product");
 $errors = $view->getVariable("errors");
 
 $view->setVariable("title", "Add Product");
 
?><h1><?= i18n("Create product")?></h1>
      <form class="formproduct" action="index.php?controller=products&amp;action=add" method="POST" enctype="multipart/form-data">
	    <?= i18n("Name") ?>: <input type="text" name="nameproduct" 
			     value="<?= $product->getNameProduct() ?>">
	    <?= isset($errors["nameproduct"])?$errors["nameproduct"]:"" ?><br>
		
		<?= i18n("Category") ?>: <input type="text" name="categoryproduct" 
			     value="">
	    <?= isset($errors["categoryproduct"])?$errors["categoryproduct"]:"" ?><br>
		
	    <?= i18n("Content of product") ?>: <br>
	    <textarea name="contentproduct" rows="4" cols="50"></textarea>
	    <?= isset($errors["contentproduct"])?$errors["contentproduct"]:"" ?><br>
		
		<?= i18n("Price (Euros)") ?>: <input type="text" name="priceproduct" 
			     value="">
	    <?= isset($errors["priceproduct"])?$errors["priceproduct"]:"" ?><br>
	    
		<?= i18n("Add photo") ?>: <input type="file" name="photoproduct" 
			     value="">
	    <?= isset($errors["photoproduct"])?$errors["photoproduct"]:"" ?><br>
		
		<input type="hidden" name="creationdateproduct"
			     value="<?= date("Y/n/d") ?>">
	    <?= isset($errors["creationdateproduct"])?$errors["creationdateproduct"]:"" ?><br>
		
		
	    <input type="submit" name="submit" value="<?=i18n("send") ?>">
      </form>
