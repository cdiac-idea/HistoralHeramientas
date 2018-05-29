<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
<title>Administrar Variables</title>
</head>
<body>
    <article align="center"> 
      <table width="50%" border="0">
        <tr>
          <td><select name="seleccion_uno" id="seleccion_uno" input name="option" type="radio" value="loc" >
            <option value = "0" id="0"> seleccione una opcion</option>
            <option value = "1"> crear un nuevo filtro</option>
            <option value = "2"> editar un filtro</option>
            
            <?php $bandera = seleccion_uno;?>
          
          </select</td>
        </tr>
        <tr>
          <td><?php 
          if($bandera == 0){
            echo "seleccione una opcion para inicar el proceso";
          }
          else{
           if($bandera == 1) {
            $this->load->view('formularios/formulario_uno');
            }
          else{
             if($bandera == 2) { 
            $this->load->view('formularios/formulario_uno');
            } 
            }
          }
          ;?>


          </td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td></td>
        </tr>
      </table>
    </article>
</body>
</html>
