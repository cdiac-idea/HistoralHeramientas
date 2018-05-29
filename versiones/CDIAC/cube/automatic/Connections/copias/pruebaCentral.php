		<?php

		require_once("conexiondwh.php");

		$columns = "SELECT estacion_sk,count(estacion_sk) as cantidad,min(fecha_sk) as fecha_min,max(fecha_sk) as fecha_max from fact_table group by estacion_sk order by estacion_sk";

		$e_columns = pg_query($columns);


		?>
		<table border=1>
		    
		    <tr>
		    <th>Estacion_sk</th>
		    <th>Estacion</th>
		    <th>Red</th>
		    <th>Cantidad</th>
		    <th>fecha Inicial</th>
		    <th>Hora Inicial</th>
		    <th>Fecha Final</th>
		    <th>Hora Final</th>
		    <th>Acumulado</th>
		  
		  </tr>

		<?php
			$acumulado = 0;
		while($f_columns = pg_fetch_array($e_columns)){
			
			$acumulado = $acumulado + $f_columns['cantidad'];

			$estacion_sk = $f_columns['estacion_sk'];

			$estacio = "SELECT estacion,red from station_dim where estacion_sk =  $estacion_sk";
			$e_estacion = pg_query($estacio);
			$f_estacion = pg_fetch_array($e_estacion);


			$fecha_sk_min = $f_columns['fecha_min'];
			$fecha_sk_max = $f_columns['fecha_max']; 
			
			$fecha_min = "SELECT fecha from date_dim where fecha_sk = $fecha_sk_min";
			$e_fecha_min = pg_query($fecha_min);
			$f_fecha_min = pg_fetch_array($e_fecha_min);

			$min_hora = "SELECT min(tiempo_sk) as min_tiempo from fact_table where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk_min";
			$e_min_hora = pg_query($min_hora);
			$f_min_hora = pg_fetch_array($e_min_hora);
			$v_min_hora = $f_min_hora['min_tiempo'];

			$tiempo_min = "SELECT tiempo from time_dim where tiempo_sk = $v_min_hora";
			$e_tiempo_min = pg_query($tiempo_min);
			$f_tiempo_min = pg_fetch_array($e_tiempo_min);



			$fecha_max = "SELECT fecha from date_dim where fecha_sk = $fecha_sk_max";
			$e_fecha_max = pg_query($fecha_max);
			$f_fecha_max = pg_fetch_array($e_fecha_max);

			$max_hora = "SELECT max(tiempo_sk) as max_tiempo from fact_table where estacion_sk = $estacion_sk and fecha_sk = $fecha_sk_max";
			$e_max_hora = pg_query($max_hora);
			$f_max_hora = pg_fetch_array($e_max_hora);
			$v_max_hora = $f_max_hora['max_tiempo'];

			$tiempo_max = "SELECT tiempo from time_dim where tiempo_sk = $v_max_hora";
			$e_tiempo_max = pg_query($tiempo_max);
			$f_tiempo_max = pg_fetch_array($e_tiempo_max);


		?>
		    
		    <tr>
		    <th><?php  echo number_format($estacion_sk, 0, '', '.');?></th>
		    <th><?php  echo($f_estacion['estacion']); ?></th>
		    <th><?php  echo($f_estacion['red']); ?></th>
		    <th><?php  echo number_format($f_columns['cantidad'], 0, '', '.'); ?></th>
		    <th><?php  echo($f_fecha_min['fecha']);?></th>
		   	<th><?php  echo($f_tiempo_min['tiempo']);?></th>
		    <th><?php  echo($f_fecha_max['fecha']);?></th>
		    <th><?php  echo($f_tiempo_max['tiempo']);?></th>
		    <th><?php  echo number_format($acumulado, 0, '', '.');?></th>
		  
		  </tr>

		<?php
		}
		?>