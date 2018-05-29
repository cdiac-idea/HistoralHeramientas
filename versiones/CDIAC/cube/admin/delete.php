<?php
require_once("class/class.php");
$tra=new Trabajo();
$tra->delete($_GET["id"]);
?>