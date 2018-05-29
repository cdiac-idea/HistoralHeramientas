<?php   
    $visible='true';
    //inicio de html y parte del menu ademas de funciones con las consultas sql
    include('base/inicio.php');
?>
<h4 class="alert_info">Generación de Indicadores de Clima</h4><br>
<center>
<form action = "generarIndicador.php" method = "post" onsubmit = "return validacion()" target="_blank">
    <table border = 1>
        <tr>
            <td class="label">Seleccione la Estación:</td>
            <td class="input">
                <select name="idEstacion" id="idEstacion" onchange="obtener();">
                    <option>Seleccione</option> 
                    <?php            
                        if (getEstacionClima($visible) != null) {
                            foreach (getEstacionClima($visible) as $value) {
                                echo "<option value='".$value["id"]."'>".$value["nombre"]." - ".$value["municipio"]."</option>";
                            }
                        }else{
                            echo "<option>NO HAY VALORES</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Seleccione un Año o un <br>rango de Años:</td>
            <td class="input">
                <select name="idAno1" id="idAno1" onchange="obtenerMes('consultarVariablesIndicador');"><option>Seleccione</option></select>
                <br>
                <select name="idAno2" id="idAno2" onchange="obtenerMes('consultarVariablesIndicador');"><option>Seleccione</option></select>
            </td>
        </tr>
        <tr>
            <td class = "laber">Seleccione el tipo de indicador <br>a generar:</td>
            <td class = "medidas">                      
                <div id="listVar">
                    Seleccione una estación y un parámetro de fechas
                </div>
            </td>   
        </tr>
        <tr>
            <td class = "laber">Elija el periodo que desea ver <br>de los datos</td>
            <td class = "input">
                <input type='checkbox' name='idAnual' id='idAnual' value='1'/>Año<br>
                <input type='checkbox' name='idMensu' id='idMensu' value='2'/>Mes<br>
                <input type='checkbox' name='idDiari' id='idDiari' value='3'/>Dia<br>
            </td>
        </tr>
        <tr >
            <td colspan = 2 class = "menuConsulta">
                <br>
                <input id="boton" name = "consultar" type = "submit" value = "Generar Indicador"/>
                <input id="boton" name = "reiniciarCons" type = "reset" value = "Reiniciar Condiciones"/>
                <br>
            </td>
        </tr>
    </table>
<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('../bd/base/fin.php');
?>
