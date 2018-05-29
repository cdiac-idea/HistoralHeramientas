<!doctype html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> 	<html lang="en"> <!--<![endif]-->
<head>

	<!-- General Metas -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	<!-- Force Latest IE rendering engine -->
	<title>Iniciar Sesión</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
	
	<!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url()?>style/login/css/base.css">
	<link rel="stylesheet" href="<?php echo base_url()?>style/login/css/skeleton.css">
	<link rel="stylesheet" href="<?php echo base_url()?>style/login/css/layout.css">
	
</head>
<body>

	



	<!-- Primary Page Layout -->

	<div class="container">
         
                
  
		<div class="form-bg">
			   <?php
			   error_reporting(E_ERROR | E_WARNING | E_PARSE);
     $spe = $_GET["spe"];
     if ($spe == 1) {
     	?>
     
      <strong><font color="#FFFFFF" size="4"><p align="center">Datos Incorrectos</p></font></strong>
     	<?php

     }
     else{
     echo "<br><br>";
 }
     ?>
<form action="../cube/filtros/control.php"  method="POST" enctype="multipart/form-data">
				<h2>Inicio de Sesión</h2>
                                <p><input type="text" placeholder="Nombre de usuario" name="username"></p>
                                <p><input type="password" placeholder="Contraseña" name="password"></p>
				<label for="remember">
				  <input type="checkbox" id="remember" value="remember" />
				  <span>Recordarme</span>
				</label>
				<button type="submit"></button>
			</form>
			<p class="forgot"> <a href=""> No recuerda su contraseña?</a></p>

		</div>
                       
            
	


	</div><!-- container -->

	<!-- JS  -->

<!-- End Document -->
</body>
</html>