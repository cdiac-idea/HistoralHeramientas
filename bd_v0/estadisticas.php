<?php	
	//inicio de html y parte del menu ademas de funciones con las consultas sql
	include('base/inicio.php');
?>
</ul></td></tr>
<!--tr><td><center><table border = 1>
	<tr><td class="label">Seleccione la Estacion:</td>
		<td class="input">
			<select name="idEstacion" id="idEstacion" onchange="obtenerEstadistica();">
				<option>Seleccione</option> 
				<?php
					/*if (getEstacion() != null) {
						foreach (getEstacion() as $value) {
							echo "<option value='".$value["id"]."'>".$value["nombre"]."</option>";
						}
					}else{
						echo "<option>NO HAY VALORES</option>";
					}*/
				?>
			</select>
	</td></tr><br><br>
</table></center></td></tr>
<tr id="cabeza"></tr-->
<tr><td><center><h1>EN CONSTRUCCION...</h1>
<?php
	//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
	include('base/fin.php');
?>