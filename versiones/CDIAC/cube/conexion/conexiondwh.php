<?php

$pg_servidor = @pg_connect ("user = postgres password=%froac$ port=5432 dbname=idea_dwh_db_pruebascube host=froac.manizales.unal.edu.co");

pg_set_client_encoding($pg_servidor, "UNICODE");

?>