<script src="<?php echo base_url() ?>lib/listbox/jquery.dualListBox-1.3.min.js" language="javascript" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
    $(function() {
       $.configureBoxes({
            useFilters: false,
            useCounters: false,
            
        });
        $.configureBoxes({
            box1View: 'box3View',
            box1Storage: 'box3Storage',
            box1Filter: 'box3Filter',
            box1Clear: 'box3Clear',
            box2View: 'box4View',
            box2Storage: 'box4Storage',
            box2Filter: 'box4Filter',
            box2Clear: 'box4Clear',
            to1: 'to3',
            to2: 'to4',
            allTo1: 'allTo3',
            allTo2: 'allTo4',
            
        });
        $.configureBoxes({
            box1View: 'box5View',
            box1Storage: 'box5Storage',
            box1Filter: 'box5Filter',
            box1Clear: 'box5Clear',
            box2View: 'box6View',
            box2Storage: 'box6Storage',
            box2Filter: 'box6Filter',
            box2Clear: 'box6Clear',
            to1: 'to5',
            to2: 'to6',
            allTo1: 'allTo5',
            allTo2: 'allTo6'
        });
    });
</script>




<section id="main" class="columns">
    <h4 class="alert_info">Crear Nueva Estación.</h4>
    <div class="clear"></div>
    <article class="module width_full">
    <form name="nueva_estacion" method="post" action="<?php echo base_url() ?>index.php/nueva_estacion/guardar" enctype="multipart/form-data" id="nueva_estacion">

    <table width="786" border="0">
       <tr>
         <td width="139">Seleccione RED:</td>
         <td width="177"><select name="red" id="red">
           <option value="">Seleccione la Red</option>
           <?php
        foreach ($var_redes as $rede){
            ?>
           <option value="<?php echo $rede->red?>" ><?php echo $rede->red?></option>
           <?php }?>
         </select></td>
         <td width="27">&nbsp;</td>
         <td width="217">Ubicación: </td>
         <td width="204"><input type="text" name="ubicacion" id="ubicacion" /></td>
       </tr>
       <tr>
         <td>Nombre Estación: </td>
         <td><input type="text" name="nombre_estacion" id="nombre_estacion" /></td>
         <td>&nbsp;</td>
         <td>Latitud:</td>
         <td><input type="text" name="latitud" id="latitud" /></td>
       </tr>
       <tr>
         <td> Seleccione Tipología:</td>
         <td><select name="tipologia" id="tipologia">
           <option value="">Seleccione la Tipología</option>
           <?php
        foreach ($var_tipologia as $tipologia){
            ?>
           <option value="<?php echo $tipologia->tipologia?>" ><?php echo $tipologia->tipologia?></option>
           <?php }?>
         </select></td>
         <td>&nbsp;</td>
         <td>Longitud:</td>
         <td><input type="text" name="longitud" id="longitud" /></td>
       </tr>
       <tr>
         <td>Seleccione Municipio:</td>
         <td><select name="municipio" id="municipio">
           <option value="">Seleccione el Municipio</option>
           <?php
        foreach ($var_municipio as $municipio){
            ?>
           <option value="<?php echo $municipio->municipio?>" ><?php echo $municipio->municipio?></option>
           <?php }?>
         </select></td>
         <td>&nbsp;</td>
         <td>Altitud:</td>
         <td><input type="text" name="altitud" id="altitud" /></td>
       </tr>
       <tr>
         <td>Propietario: </td>
         <td><input type="text" name="propietario" id="propietario" /></td>
         <td>&nbsp;</td>
         <td>Fecha de inicio de funcionamiento:</td>
         <td><input type="text" name="inicio_funcionamiento" id="inicio_funcionamiento" /></td>
       </tr>
       <tr>
         <td>Observaciones: </td>
         <td colspan="4"><textarea name="observaciones" id="observaciones" cols="60" rows="3"></textarea></td>
       </tr>
     </table>  
        <article class="module width_quarter">
            <header><h3>Medidas</h3></header>
            <div class="module_content">   
                <select id="box3View" multiple="multiple" style="width: 100%; background-color: white;">
                    <option value="precipitacion">Precipitación</option>
                    <option value="temperatura">Temperatura</option>
                    <option value="temperatura_max">Temperatura maxima</option>
                    <option value="temperatura_min">Temperatura minima</option>
                    <option value="temperatura_med">Temperatura media</option>
                    <option value="brillo">Brillo</option>
                    <option value="humedad_relativa">Humedad Relativa</option>
                    <option value="nivel">Nivel</option>
                    <option value="caudal">Caudal</option>
                    <option value="velocidad_viento">Velocidad del viento</option>
                    <option value="direccion_viento">Direccion del viento</option>
                    <option value="presion_barometrica">Presion barometrica</option>
                    <option value="evapotranspiracion">Evapotranspiración</option>
                    <option value="radiacion_solar">Radiacion solar</option>
                </select><br/>
                <span id="box3Counter" class="countLabel"></span>
                <select id="box3Storage">
                </select>



            </div><!-- end of .tab_container -->



            <footer>
                <div class="submit_link">

                    <input type="button" value="Añadir" id="to4" class="alt_btn">
                    <input type="button" value="Añadir todo" id="allTo4" class="alt_btn">
                </div>
            </footer>
        </article><!-- end of post new article -->

        
        <article class="module width_quarter">
            <header><h3>Seleccione las medidas</h3></header>
            <div class="module_content">             

                <table border="0" style="width: 50%">
                    <thead>
                        <tr>
                           <th>Medidas seleccionadas</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="boxmedidas[]" id="box4View" multiple="multiple" style="">
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                            </div><!-- end of .tab_container -->
            <footer>
                <div class="submit_link">
                    <input type="submit" value="Guardar" class="alt_btn">
                </div>
                <div class="submit_link2">

                    
                    <input type="button" id="allTo3" value="Quitar medidas" class="alt_btn">
                    

                </div>
            </footer>
          </article>
        

       
    </form>

</section>
