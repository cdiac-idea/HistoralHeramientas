<?php   

include('base/inicioGraf.php');

if ($_GET) {
    $idEst = array_key_exists('est', $_GET) ? $_GET['est'] : null;
    $ani = array_key_exists('anio', $_GET) ? $_GET['anio'] : null;
    $ani2 = array_key_exists('anio2', $_GET) ? $_GET['anio2'] : null;
    $mes = array_key_exists('mes', $_GET) ? $_GET['mes'] : 0;
    $origen = array_key_exists('origen', $_GET) ? $_GET['origen'] : null;
    $dia = 0;
    $nameEst = array_key_exists('nes', $_GET) ? $_GET['nes'] : null;
    $dataD = array();
    $dataN = array();
    $i=0;
    if ($origen!=null) {
        $datDVVD = datRosaVientsDiurMes($idEst, $ani, $mes);
        $datDVVN = datRosaVientsNocMes($idEst, $ani, $mes);
    }else{
        $datDVVD = datRosaVientsDiur($idEst, $ani, $ani2, $mes, $dia);
        $datDVVN = datRosaVientsNoc($idEst, $ani, $ani2, $mes, $dia);
    }
    #echo var_dump($datDVVD);
    #echo "<br><br><br><br><br>";
    #echo var_dump($datDVVN);
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

    #echo var_dump($dataD);
    $idVariable = 5;
    $nombreVar='Velocidad del Viento';
    $unidadMedida='(m/s)';
    #$tituloGraf = $nombreVar.' '.$ani;
    $tituloGraf = $nombreVar.' ';
    if ($ani2!=null) {
        $tituloGraf .= $ani.' - '.$ani2;
    }else{
        $tituloGraf .= $ani;
    }
    $serie = $nombreVar." VS ";
    $data = array();
    if ($dia==null && $mes!=null) {
        $tituloGraf .= '-'.$mes;
        $serie .= "Dias";
        $dia=0;
    }elseif ($dia==null && $mes==null) {
        $serie .= "Meses";
        $mes=0;
        $dia=0;
    }else{
        $serie .= "Tiempo";
        $tituloGraf .= '-'.$mes;
    }
    
    $tituloGraf .= ' '.$nameEst;
    /*$datosEst = getTiempoDato($idVariable, $idEst, $ani, $ani2, $mes, 0);
    if($origen=="mes"){
        $datosEst = getTiempoDatoMes($idVariable, $idEst, $ani, $ani2);
    }*/
    #echo var_dump($datosEst);
    if($origen=="mes"){
        $datosEst = getTiempoDatoMes($idVariable, $idEst, $ani, $ani2, $mes, $dia);
    }elseif ($origen=="anio") {
        $datosEst = getTiempoDatoAnual($idVariable, $idEst, $ani, $ani2, 0, $dia);
    }else{
        $datosEst = getTiempoDato($idVariable, $idEst, $ani, $ani2, $mes, $dia);
    }



    if ( $datosEst) {
        foreach ( $datosEst as $value) {
            if ($origen=="anio") {
                $data["id"][] = $value["año"];
            }else{
                if ($value["dia"]!=null) {
                    $fechaId = $value["dia"];
                }
                if ($value["mes"]!=null) {
                    $fechaId = $value["mes"];
                }
                if ($value["año"]!=null) {
                    $fechaId .= "-".$value["año"];
                }
                $data["id"][] = $fechaId;
            }
            $data["maxima"][] = (float)$value["maxima"];
            $data["media"][] = (float)$value["media"];
        }
        $tam = count($data["id"]);
    }
    

    $fecha='';
    if($mes>0){
        $fecha .= ' - '.$mes;
    }
    $fecha .= ' - '.$ani;



        

    

    $periodoTiempo;
    if ($ani!=null && $mes==null && $dia==null) {
        $periodoTiempo = ' el mes número ';
    }elseif ($mes!=null && $dia==null) {
        $periodoTiempo = ' el mes número '.$mes.' y día ';
    }
    if ($origen=="anio") {
        $periodoTiempo = ' el año ';

    }

}else {
    echo "<h1>LO SENTIMOS, NO HAY DATOS PARA GRAFICAR, INTENTA DENUEVO</h1>";
}

  
?>

    <script src="js/amcharts.js" type="text/javascript"></script>
    <script src="js/radar.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/highcharts.js"></script>
    <script type="text/javascript" src="js/highcharts-more.js"></script>
    <script type="text/javascript" src="js/exporting.js"></script>
    
    <!--script type="text/javascript">

        $(function () {
            $('#grafRed').highcharts({
                chart: {
                    polar: true,
                    type: 'bar'
                },
                title: {
                    text: 'Rosa de los Vientos de la estacion '+
                            '<?php /*echo $nameEst;?>'+' ('+'<?php echo $ani;?>'+'-'+'<?php echo $ani2;?>'+
                            '-'+'<?php echo $mes;?>'+')',
                },
                pane: {
                    size: '80%'
                },
                xAxis: {
                    categories: ["N", "NNO", "NO", "ONO", "O", "OSO", "SO", "SSO", "S",
                                 "SSE", "SE", "ESE", "E", "ENE", "NE", "NNE"],
                    tickmarkPlacement: 'on',
                    lineWidth: 0
                },
                yAxis: {
                    gridLineInterpolation: 'polygon',
                    lineWidth: 0,
                    min: 0
                },
                tooltip: {
                    shared: true,
                    pointFormat: '<b><span style="color:{series.color}">{series.name}: </b> {point.y:,.0f}<br/>'
                },
                legend: {
                    align: 'right',
                    verticalAlign: 'top',
                    y: 70,
                    layout: 'vertical'
                },
                series: [{
                    name: 'Dirección del viento predominante Diurna (6:00 am- 6:00 pm)',
                    shadow: true,
                    data: <?php echo json_encode($dataD); ?>,
                    pointPlacement: 'on'
                }, {
                    name: 'Dirección del viento predominante Nocturna (6:00 pm- 6:00 am)',
                    data: <?php echo json_encode($dataN); */?>,
                    pointPlacement: 'on'
                }]

            });
        });
    </script-->
    <script type="text/javascript">
        var variable = "<?php echo $nombreVar; ?>";
        var titulo = "<?php echo $tituloGraf; ?>";
        var mesAnio = "<?php echo $fecha ?>";
        var typeGrafica;
        var punteada = "";
        var serie = "<?php echo $serie ?>";
        typeGrafica= 'spline';//'scatter';
        var punteada = 'longdash';
        var intervalo = "<?php echo $tam/4; ?>";
        var unidad = "<?php echo $unidadMedida ?>";
        var serieTiempo = "<?php echo $periodoTiempo ?>";
    </script>
    <script type="text/javascript">
        $(function () {
            var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'regEtacion'
                    },
                    title: {
                        text: titulo
                    },
                    subtitle: {
                        text: serie
                    },
                    xAxis: {
                            // Le pasamos los datos que irán en el eje de las 'X' en JSON
                            title: {
                                text: "TIEMPO"
                            },
                            categories: <?php echo json_encode( $data["id"]) ?>,
                            minTickInterval: intervalo
                        },
                    yAxis: {
                        title: {
                            text: variable + ' '+ unidad
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                            'En' + serieTiempo + this.x +' se tuvo  una ' + variable +
                             ' ' + ' de: '+ this.y + ' ' + unidad;
                        }
                    },
                    series: [
                        {
                            type: typeGrafica,
                            name: 'Velocidad Maxima',
                            dashStyle: punteada,
                            data: <?php echo json_encode($data["maxima"]) ?> ,
                            marker: {
                                lineWidth: 1,
                                lineColor: Highcharts.getOptions().colors[1],
                                fillColor: 'white'
                            }
                        },
                        {
                            type: typeGrafica,
                            name: 'Velocidad Media',
                            dashStyle: punteada,
                            data: <?php echo json_encode($data["media"]) ?> ,
                            marker: {
                                lineWidth: 1,
                                lineColor: Highcharts.getOptions().colors[1],
                                fillColor: 'white'
                            }
                        }
                    ]
                });
            });
        });
</script>

</head>

<body>
    <!--div id="grafRed" style="width:1600px; height:1000px;"></div-->
    <br><br>
    <div id="regEtacion" style="width:1200px; height:500px; margin: 20px;"></div>
</body>

<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/fin.php');
?>
