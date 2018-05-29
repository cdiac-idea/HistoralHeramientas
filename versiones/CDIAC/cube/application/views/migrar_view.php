
<script language="javascript" type="text/javascript">
    
 $(document).ready(function(){
   
        $("#red").change(function(){
           $("#estacion").load("<?php echo base_url(); ?>index.php/migrar/estacion_select/"+$("#red").val())
        });
	});


</script>


	<section id="main" class="column">
		
		<h4 class="alert_info">Filtrar archivos de clima</h4>
		
                <article class="module width_full">
<form name="cargar_archivo_frm" method="post" action="../filtros/traductor.php" enctype="multipart/form-data" id="testform">
    <br>
    Seleccione Red: <select name="red" id="red">
        <option value="">Seleccione la Red</option>
<?php
        foreach ($var_redes as $rede){
            ?>
        
          <option value="<?php echo $rede->red?>" ><?php echo $rede->red?></option>
        <?php }?>
</select>
    <br>


    Seleccione Estacion: <select name="estacion" id="estacion">
        <option value="">Seleccione una Estación </option>
       

</select>
    
    
    
    <div id="ju"></div>
    
    <br>
    
    <input type="file" name="archivo" value="" id="archivo" />
    <input type="submit" value="Subir">
    
    
  </form>
        </section>
</article>	

<script>

</script>