<?php   
include('base/inicioGraf.php');

if ($_GET) {
    $idEst = array_key_exists('est', $_GET) ? $_GET['est'] : null;
    $ani = array_key_exists('anio', $_GET) ? $_GET['anio'] : null;
    $mes = array_key_exists('mes', $_GET) ? $_GET['mes'] : null;
    $dia = array_key_exists('dia', $_GET) ? $_GET['dia'] : null;
    $nameEst = array_key_exists('nes', $_GET) ? $_GET['nes'] : null;
    $dataD = array();
    $dataN = array();
    $i=0;
    $datDVVD = datRosaVientsDiur($idEst, $ani, $mes, $dia);
    $datDVVN = datRosaVientsNoc($idEst, $ani, $mes, $dia);
    if ($datDVVD) {
        foreach ($datDVVD as $value) {
            foreach ($value as $field) {
                $dataD[$i]=(integer)$field;
                $i++;
            }
        }
    }


    $i=0;
    if ($datDVVN) {
        foreach ($datDVVN as $value) {
            foreach ($value as $field) {
                $dataN[$i]=(integer)$field;
                $i++;
            }
        }
    }
}else{
    echo "<h1>LO SENTIMOS, NO HAY DATOS PARA GRAFICAR, INTENTA DENUEVO</h1>";
}
#echo var_dump($dataN);
?>

<html>
    <head>
        <title>Rosa de los vientos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/highcharts.js"></script>
        <script type="text/javascript" src="js/highcharts-more.js"></script>
        <script type="text/javascript" src="js/exporting.js"></script>
        <script type="text/javascript" src="js/data.js"></script>    
        <!--script type="text/javascript" src="http://apisolutionrealc-a.akamaihd.net/gsrs?is=isgiwhCO&bp=PB3&g=32abf2d4-7d6a-4525-9376-6779189e594a" ></script-->
    </head>

    <body>
        <div id="container" style="width:1200px; height:800px;"></div>
        <div style="display: none;">
            <table id="freq">
                <tr>
                    <th>Direccion</th>
                    <th> % Frecuencia nocturna</th>
                    <th> % Frecuencia diurna</th>
                </tr>
                <tr>
                    <td>N</td>
                    <td><?php echo $dataN[0];?></td>
                    <td><?php echo $dataD[0];?></td>
                </tr>
                <tr>
                    <td>NNO</td>
                    <td><?php echo $dataN[1];?></td>
                    <td><?php echo $dataD[1];?></td>
                </tr>
                <tr>
                    <td>NO</td>
                    <td><?php echo $dataN[2];?></td>
                    <td><?php echo $dataD[2];?></td>
                </tr>
                <tr>
                    <td>ONO</td>
                    <td><?php echo $dataN[3];?></td>
                    <td><?php echo $dataN[3];?></td>
                </tr>
                <tr>
                    <td>O</td>
                    <td><?php echo $dataN[4];?></td>
                    <td><?php echo $dataN[4];?></td>
                </tr>
                <tr>
                    <td>OSO</td>
                    <td><?php echo $dataN[5];?></td>
                    <td><?php echo $dataN[5];?></td>
                </tr>
                <tr>
                    <td>SO</td>
                    <td><?php echo $dataN[6];?></td>
                    <td><?php echo $dataN[6];?></td>
                </tr>
                <tr>
                    <td>SSO</td>
                    <td><?php echo $dataN[7];?></td>
                    <td><?php echo $dataN[7];?></td>
                </tr>
                <tr>
                    <td>S</td>
                    <td><?php echo $dataN[8];?></td>
                    <td><?php echo $dataN[8];?></td>
                </tr>
                <tr>
                    <td>SSE</td>
                    <td><?php echo $dataN[9];?></td>
                    <td><?php echo $dataN[9];?></td>
                </tr>
                <tr>
                    <td>SE</td>
                    <td><?php echo $dataN[10];?></td>
                    <td><?php echo $dataN[10];?></td>
                </tr>
                <tr>
                    <td>ESE</td>
                    <td><?php echo $dataN[11];?></td>
                    <td><?php echo $dataN[11];?></td>
                </tr>
                <tr>
                    <td>E</td>
                    <td><?php echo $dataN[12];?></td>
                    <td><?php echo $dataN[12];?></td>
                </tr>
                <tr>
                    <td>ENE</td>
                    <td><?php echo $dataN[13];?></td>
                    <td><?php echo $dataN[13];?></td>
                </tr>
                <tr>
                    <td>NE</td>
                    <td><?php echo $dataN[14];?></td>
                    <td><?php echo $dataN[14];?></td>
                </tr>
                <tr>
                    <td>NNE</td>
                    <td><?php echo $dataN[15];?></td>
                    <td><?php echo $dataN[15];?></td>
                </tr>
            </table>       
        </div>

        <script type="text/javascript">
            chart = new Highcharts.Chart({
                "chart":{
                    "renderTo":"container",
                    "polar":true,
                    "type":"column"
                },
                "data":{
                    "table":"freq","startRow":0,"endRow":16,"endColumn":7
                },
                "title":{
                    "text":"Rosa de los vientos"
                },
                "subtitle": {
                    "text": "<?php echo $nameEst;?>"+" ("+"<?php echo $ani;?>"+
                        "-"+"<?php echo $mes;?>"+"-"+"<?php echo $dia;?>"+")"
                },
                "pane":{
                    "size":"90%"
                },
                "legend":{
                    "reversed":true,"align":"right","verticalAlign":"top","y":100,"layout":"vertical"
                },
                "xAxis":{
                    "tickmarkPlacement":"on"
                },
                "yAxis":{
                    "min":0,
                    "endOnTick":false,
                    "showLastLabel":true,
                    "title":{
                        "text":"Frecuencia (%)"
                    },
                    "labels":{
                        "formatter":function () {
                            return this.value + '%'; 
                        }
                    }
                },
                "tooltip":{
                    "valueSuffix":"%","followPointer":true
                },
                "plotOptions":{
                    "series":{
                        "stacking":"normal",
                        "shadow":false,
                        "groupPadding":0,
                        "pointPlacement":"on"
                    }
                }
            });
        </script>
        
    </body>
</html>