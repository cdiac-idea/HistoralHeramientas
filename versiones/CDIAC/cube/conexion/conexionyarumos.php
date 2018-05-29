<?php

#Se establece la conexión con el servidor remoto

$pg_servidor = @pg_connect ("user = postgres password=%froac$ port=5432 dbname=bodegaVariablesAmbientales host=froac.manizales.unal.edu.co");

pg_set_client_encoding($pg_servidor, "UNICODE");

?>