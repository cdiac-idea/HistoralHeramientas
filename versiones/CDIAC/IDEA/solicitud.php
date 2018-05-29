<?php
    include('head.php');
?>

<p id= 'p-inicio' align='justify'>
	Si usted requiere de la información almacenada en el sistema de información, es necesario diligenciar el siguiente formulario<br><br><br>
	<font ></font>

	<form name="frmContacto" method="post" action="sendbymail.php">
		<table width="500px">
		<tr>
		<td>
		<label for="first_name">Nombre: *</label>
		</td>
		<td>
		<input type="text" name="first_name" maxlength="50" size="25">
		</td>
		</tr>
		<tr>
		<td valign="top">
		<label for="last_name">Apellido: *</label>
		</td>
		<td>
		<input type="text" name="last_name" maxlength="50" size="25">
		</td>
		</tr>
		<tr>
		<td>
		<label for="email">Dirección de E-mail: *</label>
		</td>
		<td>
		<input type="text" name="email" maxlength="80" size="35">
		</td>
		</tr>
		<tr>
		<td>
		<label for="telephone">Número de teléfono:</label>
		</td>
		<td>
		<input type="text" name="telephone" maxlength="25" size="15">
		</td>
		</tr>
		<tr>
		<td>
		<label for="comments">Comentarios: *</label>
		</td>
		<td>
		<textarea name="comments" maxlength="500" cols="30" rows="5"></textarea>
		</td>
		</tr>
		<tr>
		<td colspan="2" style="text-align:right">
		<input type="submit" value="Enviar">
		</td>
		</tr>
		</table>
	</form>
</p>


<?php
    include('pie.php');
?>