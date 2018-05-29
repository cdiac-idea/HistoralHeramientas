<?php

class Medida extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('medidas_model');
    }
    
    public function index(){
               
       
        $content = array(
                'title' => 'Medidas',
                'main' => 'medidas_view',
                'var_redes' => $this->medidas_model->lista_redes(),
            
                'page' => 'Esquema'
            );
            $this->load->view('include/main_template', $content);
        
        }

        public function estacion_select($id)
        {
            $id = urldecode($id);
            $datos['estacion']=
            $this->medidas_model->lista_estaciones($id);
            $this->load->view('opc_estacion',$datos);
        }
        
        
        function consultar()
	{
            $red=  $this->input->get('red');
            $estacion=  $this->input->get('estacion');        
            $estacion_sk=$this->medidas_model->buscar_estacion($red,$estacion);

            
            echo "<table width='436' border='2'>
  <tr>
    <td colspan='5' aling='center'>Estación: ". $estacion. "</td>
  </tr>
  <tr>
    <td width='381'>Medidas </td>
    <td width='10'>Promedio</td>
    <td width='9'>Valor Máximo</td>
    <td width='8'>Valor Mínimo</td>
    <td width='15'>Sumatoria</td>
    <td width='15'>Desviación Estándar</td>    
    <td width='15'>Moda</td>
    <td width='15'>Media</td>
    <td width='15'>Mediana</td>
    <td width='15'>Varianza</td>
    <td width='15'>Asimetría</td>
    <td width='15'>Curtosis</td>
    <td width='15'>Valores Nulos</td>
    <td width='15'>Valores Distintos</td>
    
  </tr>
  <tr>
    <td>precipitacion</td>";
            $medida="precipitacion";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
   <td>temperatura</td>";
            $medida="temperatura";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>temperatura_max</td>";
    $medida="temperatura_max";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>temperatura_min</td>";
    $medida="temperatura_min";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>temperatura_med</td>";
    $medida="temperatura_med";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>brillo</td>";
    $medida="brillo";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>humedad_relativa</td>";
    $medida="humedad_relativa";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>nivel</td>";
    $medida="nivel";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>caudal</td>";
    $medida="caudal";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>velocidad_viento</td>";
    $medida="velocidad_viento";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>direccion_viento</td>";
    $medida="direccion_viento";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>presion_barometrica</td>";
    $medida="presion_barometrica";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>evapotranspiracion</td>";
    $medida="evapotranspiracion";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
  <tr>
    <td>radiacion_solar</td>";
    $medida="radiacion_solar";
            $promedio=$this->medidas_model->promedio($estacion_sk, $medida);
            $minimo=$this->medidas_model->minimo($estacion_sk, $medida);
            $maximo=$this->medidas_model->maximo($estacion_sk, $medida);
            $suma=$this->medidas_model->suma($estacion_sk, $medida);
            echo"
    <td>".number_format($promedio[0][$medida],4,',','.')."</td>
    <td>".number_format($minimo[0][$medida],4,',','.')."</td>
    <td>".number_format($maximo[0][$medida],4,',','.')."</td>
    <td>".number_format($suma[0][$medida],4,',','.')."</td>
  </tr>
</table>

";
               
            
            

	}
        
 }


?>
