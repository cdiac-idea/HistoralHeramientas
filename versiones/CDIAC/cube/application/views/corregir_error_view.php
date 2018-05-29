
<script>
    // just for the demos, avoids form submit
    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });
    $(".myform").validate({
        rules: {
            field: {
                required: true,
                range: [13, 23]
            }
        }
    });



</script>

<section id="main" class="columns">
    <h4 class="alert_info">Corrección de errores de archivo.</h4>
    <div class="clear"></div>
    <article class="module width_full">
        <form name="errores" method="post" action="<?php echo base_url() ?>index.php/nueva_estacion/guardar" enctype="multipart/form-data" id="nueva_estacion">
            <table>
                <?php
                $i = 0;

                foreach ($errores as $row) {
                    ?>
                    <tr>
                        <td>
                            <label for="<?php echo $row['columna'] . $i ?>"><?php echo "Estación " . $row['estacion'] . " Fila " . $row['fila'] . " Columna " . $row['columna'] ?></label>
                        </td>
                        <td>
                            <input style="border-radius: 4px; margin-left: 2px; width: 200px;" type="text" placeholder="dato entre <?php echo $row['minimo'] . " y " . $row['maximo']; ?>" id="<?php echo $row['fila'] . $i ?>">
                        </td>
                    </tr>

                    <script>
                        $("#<?php echo $row['fila'] . $i ?>").focusout(function(){
                            var i = $("#<?php echo $row['fila'] . $i ?>").val();
                            if((i<<?php echo $row['minimo']?>)||(i><?php echo $row['maximo']?>)){
                                alert("Por el dato debe estar dentro del rango");
                                $("#<?php echo $row['fila'] . $i ?>").focus();
                            }
                        });
                    </script>
                    <?php $i++;
                }
                ?>
            </table> 



            <input type="reset" value="Cancelar"/>
            <input type="submit" value="Corregir y subir">

        </form>

</section>

