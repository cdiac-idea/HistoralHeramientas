<?php
/**/
session_start();

$mensaje = "";
require_once("../configuracion/clsBD.php");
$objDatos = new clsDatos();
if($_POST){
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    if($user == null || $pass == null){
        $mensaje = "El usuario y la clave son obligatorios";
    } else {
        $sql = "SELECT id_usuario, nombre, apellido
                FROM usuario u 
                WHERE u.nombre_usuario='$user' AND u.contrasenia=MD5('$pass')";
        $datos_desordenados = $objDatos->hacerConsulta($sql);
        $arreglo_datos = $objDatos->generarArreglo($datos_desordenados);
        $usuario = $arreglo_datos[0];
        $nombUsuario= $arreglo_datos[1]." ".$arreglo_datos[2];
        if($usuario > 0) {
            $sql = "SELECT id_rol_usu FROM usuario u WHERE u.id_usuario=".$usuario;
            $datos_desordenados = $objDatos->hacerConsulta($sql);
            $arreglo_datos = $objDatos->generarArreglo($datos_desordenados);
            $perfil = $arreglo_datos[0]; 
            $_SESSION['idUsu']=$usuario;
            $_SESSION['nombreUsuario']= $nombUsuario;
            $_SESSION['perfil']=$perfil;
            header("Location: menu.php");//?usuario=$usuario&perfil=$perfil");
        } else {
            $mensaje = "Usuario o clave invalidos";  
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SISTEMA DE CONSULTAS</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--LINK REL=StyleSheet HREF="css/estilo.css" TYPE="text/css" MEDIA=screen-->
    <header id="header">
        <hgroup>            
            <h2 class="section_title">SISTEMA DE CONSULTAS DE VARIABLES AMBIENTALES</h2>
        </hgroup>
    </header>
    <link rel="stylesheet" type="text/css" href="css/style/admin/css/layout.css" media="screen" />
    
    <style type="text/css">
        #corp {
            position: absolute;
            top:  8px;
            left: 900px;
        }
        #fondo {
            position: absolute;
            top:  0px;
            left: 885px;
        }
    </style>
</head>
<body>
    <section id="secondary_bar">
        <h1 id="bienvenida">Bienvenido al Sistema de Consultas </h1>
    </section>
    

    <aside id="sidebar" class="">
        <br><br><br><br><br><br><br>
       <div id="fondo">
            <!--a  href="http://www.corpocaldas.gov.co/" target="_blank"><img src="images/logo_Corpocaldass.png" width=27%></a-->
            <img src="images/fondo.PNG" width=33%>
        </div>
        <div id="corp">
            <a  href="http://www.corpocaldas.gov.co/" target="_blank"><img src="images/logo_Corpocaldass.png" width=27%></a>
            <!--img src="images/fondo.PNG" width=27%-->
        </div>
        <footer id="pie">
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <hr />
            <p><strong>IDEA -- GAIA</strong></p>
        </footer>
    </aside>
    <center>
        <form method="post" action="index.php">
            <br><br><br>
                <label id="titulo">Ingrese su Nombre de <br>usuario y contraseña</label><br><br>
                <label id="nombre">Usuario</label><br><input type="text" id="user" name="user" /><br><br>
                <label id="nombre">Contraseña</label><br><input type="password" id="pass" name="pass"/><br>
                <label id="mensaj"><?php echo $mensaje; ?></label>
                <br><br>
                <input type="submit" value="Enviar"/>
        </form>
    </center>
</body>
</html>
<?php
    $objDatos->cerrarConexion();
?>