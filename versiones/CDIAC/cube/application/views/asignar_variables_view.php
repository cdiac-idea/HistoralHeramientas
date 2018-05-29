<script language="javascript" type="text/javascript">
    
 $(document).ready(function(){
        $("#red").change(function(){
           $("#estacion").load("asignar_variables/estacion_select/"+$("#red").val())
        });
    });


</script>

    <section id="main" class="column">
        
        <h4 class="alert_info">Asignar Variables.</h4>
        
                <article class="module width_full">
<form name="cargar_archivo_frm" method="post" action="../admin/asignar_variable/index.php" enctype="multipart/form-data" id="testform">
    <br>
    Seleccione RED: <select name="red" id="red">
        <option value="">Seleccione la Red</option>
<?php



        foreach ($var_redes as $rede){
            ?>
        
          <option value="<?php echo $rede->red?>" ><?php echo $rede->red?></option>
        <?php }?>
</select>
    <br>


    Seleccione Estación: <select name="estacion" id="estacion">
        <option value="">Seleccione una Estación </option>
</select>
    
    
    
    <div id="ju"></div>
    
    <br>
    
   
    <input type="submit" value="Aceptar">
    
   
  </form>
        </section>
</article>  

<script>

</script>

