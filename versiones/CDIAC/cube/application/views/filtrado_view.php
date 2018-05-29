<!doctype html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> 	<html lang="en"> <!--<![endif]-->
<head>

	<!-- General Metas -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	<!-- Force Latest IE rendering engine -->
	<title>ENHORABUENA</title>
	<!--<a href="../filtros/generarReporte.php" >Generar Reporte</a>-->
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
<body></br></br>     
            <center>
            	<h1>
		<p class="forgot"> <a href=""> <font size='5'> ENHORABUENA<BR>Los Datos han sido filtrados con exito</font></a></p>
		</h1>
			'<form name="volver" method="post" action="../index.php/migrar" enctype="multipart/form-data" id="vuelta">
    
    <input type="submit" value="volver">


    
   
  </form>
  <form name="Generar Reporte de Correccion" method="post" action="../filtros/generarReporteCorreccion.php" enctype="multipart/form-data" id="vuelta">
    
    <input type="submit" value="Generar Reporte de Correccion">    
    
  </form>

  <form name="Generar Reporte de Errores" method="post" action="../filtros/generarReporteErrores.php" enctype="multipart/form-data" id="vuelta">
    
    <input type="submit" value="Generar Reporte de Errores y Correcciones">    
    
  </form>
</center>

	</div><!-- container -->

	<!-- JS  -->

<!-- End Document -->
</body>
</html>