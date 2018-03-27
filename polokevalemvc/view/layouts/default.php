<?php
 //file: view/layouts/default.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 
?><!DOCTYPE html>
<html>
  <html>
  <head>
  <title><?= $view->getVariable("title", "no title") ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-3.3.7/dist/css/bootstrap-theme.min.css" rel="stylesheet">
	
		<!-- CSS Products -->
	<link href="css/products.css" rel="stylesheet">

	
	<!-- PKV Icon -->
	<link rel="shortcut icon" href="favicon.ico">
	
	<!-- Scripts Ir Arriba -->
	<script src="js/jquery-latest.js"></script>
	<script src="js/arriba.js"></script>
    <?= $view->getFragment("css") ?>
    <?= $view->getFragment("javascript") ?>
  </head>
  <body>    
    <main>
      <div id="flash">
	<?= $view->popFlash() ?>
      </div>   
    </main>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-sm-push-9">
			<div class="language">
			<?php
					include(__DIR__."/language_select_element.php");
				?>
			</div>
		
		  <div class="logo" class="col-sm-3 col-sm-push-9"><a href="index.php?controller=products&amp;action=index"><img src="images/logoPKV.png" class="img-responsive"></img></a></div>
            <div class="sidebar-nav">
              <div class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <span class="visible-xs navbar-brand"></span>
                </div>
                <div class="navbar-collapse collapse sidebar-navbar-collapse">
                  <ul class="nav navbar-nav">	
				  <?php if (isset($currentuser)): ?> 				  
						<li><?= sprintf(i18n(" Hello %s "), $currentuser) ?></li>
							<li>
							<a 	href="index.php?controller=users&amp;action=logout">(Logout)</a>
							</li>
				 <?php else: ?>
					  <li><?= sprintf(i18n("You must be logged")) ?></li>
						<li>
						<a href="index.php?controller=users&amp;action=login"><?= i18n("Login") ?></a></li>
						</li>
				<?php endif ?>
				<?php if (isset($currentuser)): ?> 
                    <li><a href="#"><img src="images/menu_icons/perfilPKV.png" ></img><?= i18n(" My Profile ") ?></a></li>
                    <li class="active"><a href="index.php?controller=products&amp;action=index"><img src="images/menu_icons/buscselecPKV.png" ></img><?= i18n(" Search Product ") ?></a></li>
					 <li><a href="index.php?controller=chats&amp;action=index"><img src="images/menu_icons/chatPKV.png" ></img><?= i18n(" Chat ") ?></a></li>
                    <li><a href="index.php?controller=products&amp;action=add"><img src="images/menu_icons/addPKV.png" ></img><?= i18n(" Add Product ") ?></a></li>
					<li><a href="index.php?controller=products&amp;action=myproducts"><img src="images/menu_icons/misproductPKV.png" ></img><?= i18n(" My Products ") ?></a></li>
					<li><a href="#"><img src="images/menu_icons/infoPKV.png" ></img><?= i18n(" More Info ") ?></a></li>
                    <!-- <li><a href="#">Reviews <span class="badge">1,118</span></a></li> -->
                  </ul>
				<?php endif ?>
                </div><!--/.nav-collapse -->
              </div>
            </div>
          </div>
		   <!--Aquí se muestra el contenido del producto a buscar-->
          <div class="col-sm-9 col-sm-pull-3">
			  <div class="row">
					<div id="query" class="col-sm-5">
						<h2><strong><?= i18n("By Words") ?></strong></h2>
						  <form id="queryform" method="GET" action="index.php">
							<input type="hidden" name="controller" value="products">
							<input type="hidden" name="action" value="search">
							<input type="text" name="words" id="querybox" placeholder="Busca tu producto">
						  </form>
					</div>
			 </div>
				 <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
		   </div>
    </div><!-- /.container -->
	  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="css/bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
  </body>
</html>