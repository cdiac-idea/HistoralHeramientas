<?php
    //inicio de html y parte del menu ademas de funciones con las consultas sql
include('base/inicio.php');
?>
<h4 class="alert_info">Generacion de Indicadores de Aire</h4><br>
<center>
    <br><br><br>
    <p>Los datos utilizados para realizar el calculo de los indicadores, <br>son datos que se encuentran en <br>condición estandar.</p>
    <br><br><br>
    <form action = "generarIndicadorAire.php" method = "post" target="_blank" onsubmit = "return validacion()">
        <table border = 1>
            <tr>
                <td class="label">Seleccione una variable:
                </td>
                <td class="input">
                    <select clase="aire" name="idVariable" id="idVariable" onchange="obtenerEstacion();">
                        <option>Seleccione</option> 
                        <?php            
                        if (getEstacionVar() != null) {
                            foreach (getEstacionVar() as $value) {
                                echo "<option value='".$value["id"]."'>ICA ".$value["nombre"]."</option>";
                            }
                        }else{
                            echo "<option>NO HAY VALORES</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">Seleccione la Estacion:
                </td>
                <td class="input">
                    <select  clase="aire" name="idEstacion" id="idEstacion" onchange="obtener('aire');"><option>Seleccione</option></select>
                </td>
            </tr>
            <tr>
                <td class="label">Seleccione una fecha o un <br>rango de fechas:
                </td>
                <td class="input">
                    <table >
                        <tr>
                            <td>
                                <center>
                                    <label id="fecha"><b>Año</b></label>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select class="fecha" name="idAno1" id="idAno1"><option>Seleccione</option></select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select class="fecha" name="idAno2" id="idAno2"><option>Seleccione</option></select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr >
                <td colspan = 2 class = "menuConsulta">
                    <br>
                	<input id="boton" name = "consultar" type = "submit" value = "Generar Indicador"/>
                    <input id="boton" name = "reiniciarCons" type = "reset" value = "Reiniciar Consulta"/>
                    <br>
                </td>
            </tr>
        </table>
<?php
//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
include('base/fin.php');
?>