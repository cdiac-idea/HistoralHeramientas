<?php
    require_once("../configuracion/clsBD.php");
    $objDatos = new clsDatos();
    $objDatos->cerrarConexion();
    #session_destroy();
?>