
<script language="javascript" type="text/javascript">

    $(document).ready(function() {
        $("#red").change(function() {
            $("#estacion").load("<?php echo base_url(); ?>index.php/migrar/estacion_select/" + $("#red").val())
        });
    });


</script>


<section id="main" class="column">

    <h4 class="alert_info">Carga de Archivos.</h4>

    <article class="module width_full">
        <form >
            Seleccione RED: <select name="red" id="red">
                <option value="">Seleccione la Red</option>
                <?php
                foreach ($var_redes as $rede) {
                    ?>

                    <option value="<?php echo $rede->red ?>" ><?php echo $rede->red ?></option>
                <?php } ?>
            </select>
            <br>


            Seleccione Estacion: 
            <select name="estacion" id="estacion">
                <option value="">Seleccione una Estación </option>
            </select>



            <div id="ju"></div>

            <br>


            <input type="button" id="consultartabla" value="Consultar">

        </form>
        <br>
        <div style="display: none;" id="tabladatos">

        </div>
</section>
</article>
<script>
    $("#consultartabla").click(function() {

        var tabla = $.ajax({
            url: "<?php echo base_url() ?>index.php/medida/consultar/",
            data: {estacion: $("#estacion").val(), red: $("#red").val()},
            dataType: "html"
        });

        $("#tabladatos").show('slow', function() {
            tabla.done(function(msg) {
                $("#tabladatos").html(msg);
            });
        });
//        $("#consultartabla").append(tabla);



    });
</script>
