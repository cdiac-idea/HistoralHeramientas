<?php 
require_once("../cube/conexion/conexion.php");
?>
<!doctype html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> 	<html lang="en"> <!--<![endif]-->
<head>

	<!-- General Metas -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	<!-- Force Latest IE rendering engine -->
	<title>ERROR :(</title>
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
		<p class="forgot"> <a href=""> <font size='5'> LO LAMENTAMOS<BR> No es posible terminar el proceso ya que no se reconoce algunas de las columnas del archivo a filtrar, <BR> asegurese de que el encabezado de cada columna contenga algunas de las siguientes referencias,<br> sea el nombre de la variable normal o como el valor que sugiere la columna derecha:
</p>

<?php
	$variables = "SELECT distinct (variables) from variables ";
	$e_variables = pg_query($variables);

	 
?>
<ul>
	<center>
<table border="0">

<?php
while ($f_variables  = pg_fetch_array($e_variables)) {
		$variablesN = $f_variables['variables'];
				
		$variable_excel = "SELECT distinct (variable_excel) from variables where variables = '$variablesN'";
		$e_variables_excel = pg_query($variable_excel);
		$f_var_excel = pg_fetch_array($e_variables_excel);
	?>

  <tbody><tr><td><?php echo($variablesN);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><?php echo($f_var_excel['variable_excel']);?></td></tr>


</tbody>

		
<?php
}
?>
</table></div>
</center>
</ul>

</font>
</a>
		
		</h1>
			'<form name="volver" method="post" action="../index.php/migrar" enctype="multipart/form-data" id="vuelta">
    
    <input type="submit" value="volver">
</center>

    
    
  </form>


	</div><!-- container -->

	<!-- JS  -->

<!-- End Document -->
</body>
</html>