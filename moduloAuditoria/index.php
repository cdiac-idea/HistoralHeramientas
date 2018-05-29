<?php 
include('soporte/funciones.php'); 
$mensaje = "";
if($_POST){
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    $mensaje = validarUsuario($user, $pass);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
    <form method="post" action="index.php">
        <div id="titulo_index"></div>
        <div>
            Usuario <input type="text" id="user" name="user" />
            Clave <input type="password" id="pass" name="pass"/>
            <div><?php echo $mensaje; ?></div>
            <input type="submit" />
        </div>
    </form>
</body>
</html>