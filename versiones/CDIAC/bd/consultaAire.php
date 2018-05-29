<?php
    //inicio de html y parte del menu ademas de funciones con las consultas sql
include('base/inicio.php');
?>
<h4 class="alert_info">Consultas a la Bodega de datos de Aire</h4><br>
<center>
    <form action = "consultasBodega.php" method = "post" onsubmit = "return validacion()">
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
                                echo "<option value='".$value["id"]."'>".$value["nombre"]."</option>";
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
                            <td>
                                <center>
                                    <label id="fecha"><b>Mes</b></label>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <label id="fecha"><b>Dia</b></label><br>
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select class="fecha" name="idAno1" id="idAno1" onchange="obtenerMes('consultarFactTable', 'aire');"><option>Seleccione</option></select>
                            </td>
                            <td>
                                <select class="fecha" name="idMes1" id="idMes1" onchange="obtenerDia('consultarFactTable', 'aire');"><option>Seleccione</option></select>
                            </td>
                            <td>
                                <select class="fecha" name="idDia1" id="idDia1"><option>Seleccione</option></select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select class="fecha" name="idAno2" id="idAno2" onchange="obtenerMes('consultarFactTable', 'aire');"><option>Seleccione</option></select>
                            </td>
                            <td>
                                <select class="fecha" name="idMes2" id="idMes2" onchange="obtenerDia('consultarFactTable', 'aire');"><option>Seleccione</option></select>
                            </td>
                            <td>
                                <select class="fecha" name="idDia2" id="idDia2"><option>Seleccione</option></select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--tr>
                <td class = "laber">Seleccione las variables <br>a ver:</td>
                <td class = "medidas">                      
                    <div id="listVar">
                        Seleccione una estacion y un rango de fechas
                    </div>
                </td>   
            </tr-->
            <tr >
                <td colspan = 2 class = "menuConsulta">
                    <br>
                    <input id="boton" name = "consultar" type = "submit" value = "Consultar"/>
                    <input id="boton" name = "reiniciarCons" type = "reset" value = "Reiniciar Consulta"/>
                    <br>
                </td>
            </tr>
        </table>
<?php
//contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
include('base/fin.php');
?>