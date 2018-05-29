
<script language="javascript" type="text/javascript">
    
 $(document).ready(function(){
        $("#red").change(function(){
           $("#estacion").load("<?php echo base_url(); ?>index.php/migrar/estacion_select/"+$("#red").val())
        });
	});


</script>


	<section id="main" class="column">
		
		<h4 class="alert_info">Carga de Archivos.</h4>
		
                <article class="module width_full">
<form method="post" action="<?php echo base_url()?>index.php/migrar/do_upload" enctype="multipart/form-data" id="testform">
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
    
    <input type="file" name="archivo" value="" id="archivo" />
    <input type="submit" value="subir">
    
    
  </form>
        </section>
</article>	