
	<script language="javascript" type="text/javascript">
    
 $(document).ready(function(){
        $("#red").change(function(){
           $("#estacion").load("<?php echo base_url(); ?>index.php/administrar_variables/estacion_select/"+$("#red").val())
              $("#variable").load("<?php echo base_url(); ?>index.php/administrar_variables/variables_select/"+$("#red".val(),"#estacion".val()))
        });
    });


</script>


  <section id="main" class="column">
        
    <h4 class="alert_info">Administar Controles</h4>
        
                <article class="module width_full">
      <form method="post" action="editar_controles_view.php" enctype="multipart/form-data" id="testform">
        Seleccione RED: <select name="red" id="red">
        <option value="">Seleccione la Red</option>
   
   
        
        <?php foreach ($var_redes as $rede){ ?>   
        
        <option value="<?php echo $rede->red?>" ><?php echo $rede->red?></option>

        <?php }?>

  </select>
<br>
      Seleccione Estacion: <select name="estacion" id="estacion">
          <option value="">Seleccione una Estación </option>
    </select>
<br>   
      Seleccione Variable:<select name="variable" id="variable">
      <option value="">Seleccione Variable</option>
       <?php foreach ($var_redes as $rede){ ?>   
        
        <option value="<?php echo $rede->red?>" ><?php echo $rede->red?></option>
        
        <?php }?>
      
       
<br>
</select>    
    <div id="ju"></div>
    
    <br>
    
  
    <input type="submit" value="modificar">
    
    
  </form>
        </section>
</article>  
