<?php
 //file: view/layouts/default.php
 
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 
?><!DOCTYPE html>
<html>
  <head>
  <title><?= $view->getVariable("title", "PKV: Polo Ke Vale | Chat Room") ?></title>
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
	<!-- CSS Chat -->
	<link href="css/chat.css" rel="stylesheet">
	
    <?= $view->getFragment("css") ?>
    <?= $view->getFragment("javascript") ?>
  </head>
  <body>    
    <main>
	 <br>
      <div id="flash">
	<?= $view->popFlash() ?>
      </div> 
	 <br>
	 <br>
				  <div class="language">
					<?php
							include(__DIR__."/language_select_element.php");
						?>
					</div>
					<div class="usercurrent">
						<ul id="usercurrent">
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
					</ul>
					</div>
    </main>
	<div class="container">
		<div class="row">
          <div class="col-sm-3 col-sm-push-9">
				 <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
						  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex6-collapse">
							<span class="sr-only">Desplegar navegación</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						  </button>
						  <div class="logo"><a href="index.php?controller=products&amp;action=index"><img src="images/chatroomlogoPKV.png" class="img-responsive"></a></div>
						</div>

						<!-- Collect the nav links, forms, and other content for toggling -->
						<div id="navbar" class="collapse navbar-collapse navbar-ex6-collapse">
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
							<li><a href="index.php?controller=chats&amp;action=index"><img src="images/menu_icons/salirchatPKV.png" ></img></a></li>
							<li class="active"><a href="#"><img src="images/menu_icons/chatroom2PKV.png" ></a></li>
							<li><a href="#"><img src="images/menu_icons/personachatPKV.png" ></a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/menu_icons/opcionesPKV.png" ><b class="caret"></b></a>
									<ul class="dropdown-menu">
									  <li><a href="#">Ubicación</a></li>
									  <li><a href="#">Imagen</a></li>
									  <li><a href="#">Documento</a></li>
									  <li class="divider"></li>
									  <li class="dropdown-header">He decidido...</li>
									  <li><a href="#">Adquirir</a></li>
									  <li><a href="#">Rechazar</a></li>
									</ul>
							</li>
						  </ul>
						</div><!-- /.navbar-collapse -->
				</nav>
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