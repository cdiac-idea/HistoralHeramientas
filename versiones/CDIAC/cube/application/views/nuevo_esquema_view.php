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
    <h4 class="alert_info">Bienvenido a OLAP-IDEA, para crear cubos, en la opción esquemas encontrara la manera de hacerlo.</h4>
    <div class="clear"></div>
    <form name="form1" method="post" action="<?php echo base_url() ?>index.php/esquema/imp/" enctype="multipart/form-data" id="form1">

        <article class="module width_full">
            <header><h3>Constructor de esquemas</h3></header>
            <div class="module_content">             


                <table border="0" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Medidas selecionadas</th>
                            <th>Hechos seleccionados</th>
                            <th>Dimensiones Seleccionadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>  
                                <select name="box2View[]" id="box2View" multiple="multiple" style="">
                                </select>
                            </td>
                            <td>
                                <select name="box4View[]" id="box4View" multiple="multiple" style="">
                                </select> 
                            </td>
                            <td>
                                <select name="box6View[]" id="box6View" multiple="multiple" style="">
                                
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>



            </div><!-- end of .tab_container -->



            <footer>
                <div class="submit_link">

                    <input type="submit" value="Guardar Esquema" class="alt_btn">

                </div>
                <div class="submit_link2">

                    <input type="button" id="allTo1" value="Quitar medidas" class="alt_btn">
                    <input type="button" id="allTo3" value="Quitar hechos" class="alt_btn">
                    <input type="button" id="allTo5" value="Quitar Dimensiones" class="alt_btn">

                </div>
            </footer>
        </article><!-- end of post new article -->


        <article class="module width_quarter">
            <header><h3>Medidas</h3></header>
            <div class="module_content">   

                <select id="box1View" multiple="multiple" style="width: 100%; background-color: white;">
                    <option value="sum">Suma</option>
                    <option value="avg">Promedio</option>
                    <option value="max">Maximo</option>
                    <option value="min">Minimo</option>
                    <option value="count">Cantidad</option>

                </select><br/>


            </div><!-- end of .tab_container -->



            <footer>
                <div class="submit_link">

                    <input type="button" id="to2"  value="Añadir" class="alt_btn">
                    <input type="button" id="allTo2" value="Añadir todo" class="alt_btn">

                </div>
            </footer>
        </article><!-- end of post new article -->

        <article class="module width_quarter">
            <header><h3>Hechos</h3></header>
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
            <header><h3>Dimensiones</h3></header>
            <div class="module_content">   
                <select id="box5View" multiple="multiple" style="width: 100%; background-color: white;">
                    <option value="ano">Año</option>
                    <option value="mes">Mes</option>
                    <option value="dia">Día</option>
                    <option value="diasemana">Día de la semana</option>
                    <option value="semanaaño">Semana del año</option>
                    <option value="trimestre">Trimestre</option>
                    <option value="semestre">Semestre</option>
                    <option value="lustro">Lustro</option>
                    <option value="nombremes">Nombre mes</option>
                    <option value="nombredia">Nombre día</option>
                    <option value="horas">Horas</option>
                    <option value="minutos">Minutos</option>
                    <option value="segundos">Segundos</option>
                    <option value="jornada">Jornada</option>
                    <option value="estacion">Estacion</option>
                    <option value="red">Red</option>
                    <option value="tipologia">Tipologia</option>
                    <option value="municipio">Municipio</option>
                    <option value="ubicacion">Ubicacion</option>
                     <option value="latitud">Latitud</option>
                    <option value="longitud">Longitud</option>
                    <option value="altitud">Altitud</option>
                    <option value="propietario">Propietario</option>
                    <option value="inicio_funcionamiento">Inicio funcionamiento</option>
                     <option value="observacion">Observacion</option>
                </select><br/>




            </div><!-- end of .tab_container -->



            <footer>
                <div class="submit_link">

                    <input type="button" value="Añadir" id="to6" class="alt_btn">
                    <input type="button" value="Añadir todo" id="allTo6" class="alt_btn">

                </div>
            </footer>
        </article><!-- end of post new article -->



    </form>

</section>
