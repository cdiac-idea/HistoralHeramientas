<?php

//este controlador es el que permite cargar un archivo excel, con los datos que 
//se leen desde las estaciones
//se debe acceder a la tabla variables, donde estan los filtros que se deben hacer, antes de insertar los datos en la BD
//En la tabla variables, esta el valor máximo y minimo permitido y la diferencia con el valor anterior
//estos filtros solo son informativos... entrega la fila en excel que esta malo, y que variable y por que filtro falló 
// 
header('Content-Type: text/html; charset=UTF-8');
echo "<br> Se ha filtrado con éxito";


?>