<?php 
 //file: view/users/register.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $user = $view->getVariable("user");
 $view->setVariable("title", "Register");
?>
<h1><?= i18n("Register")?></h1>
<form id="registerform" action="index.php?controller=users&amp;action=register" method="POST">
      <?= i18n("Username")?>: <input type="text" name="username" 
			value="<?= $user->getUsername() ?>">
      <?= isset($errors["username"])?$errors["username"]:"" ?><br>
	  
	  <?= i18n("Name")?>: <input type="text" name="nameuser" value="">
	   <?= isset($errors["nameuser"])?$errors["nameuser"]:"" ?><br>
	   
	  <?= i18n("Surname")?>: <input type="text" name="surnameuser" value="">
	   <?= isset($errors["surnameuser"])?$errors["surnameuser"]:"" ?><br>
	   
	  <?= i18n("DNI")?>: <input type="text" name="dniuser" value="">
	   <?= isset($errors["dniuser"])?$errors["dniuser"]:"" ?><br>
      
      <?= i18n("Password")?>: <input type="password" name="passwd" 
			value="">
      <?= isset($errors["passwd"])?$errors["passwd"]:"" ?><br>
	  
	  <?= i18n("Province")?>: <input type="text" name="province" value="">
	   <?= isset($errors["province"])?$errors["province"]:"" ?><br>
      
      <input type="submit" value="<?= i18n("Register")?>">
</form>
