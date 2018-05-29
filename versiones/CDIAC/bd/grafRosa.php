<?php   

    include('base/inicioGraf.php');

        if ($_GET) {
            $idEst = array_key_exists('est', $_GET) ? $_GET['est'] : null;
            $ani = array_key_exists('anio', $_GET) ? $_GET['anio'] : null;
            $ani2 = array_key_exists('anio2', $_GET) ? $_GET['anio2'] : null;
            $origen = array_key_exists('origen', $_GET) ? $_GET['origen'] : null;
            $nameEst = array_key_exists('nes', $_GET) ? $_GET['nes'] : null;
            $dataD = array();
            $dataN = array();
            $i=0;
            $datDVVD = datRosaVientsDiurDia($idEst, $ani, $ani2);
            $datDVVN = datRosaVientsNocDia($idEst, $ani, $ani2);
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
            $idVariable = 5;
            $nombreVar='Velocidad del Viento';
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
            $datosEst = getTiempoDatoDia($idVariable, $idEst, $ani, $ani2, $mes, $dia);

            if ( $datosEst) {
                foreach ( $datosEst as $value) {
                    if ($value["dia"]!=null) {
                        $fechaId = $value["dia"];
                    }
                    if ($value["mes"]!=null) {
                        $fechaId .= "-".$value["mes"];
                    }
                    if ($value["año"]!=null) {
                        $fechaId .= "-".$value["año"];
                    }
                    if ($value["tiempo"]!=null) {
                        $fechaId .= " : ".$value["tiempo"];
                    }
                    $data["id"][] = $fechaId;
                    $data["dato"][] = (float)$value["dato"];
                }
            }
            $fecha='';
            if($mes>0){
                $fecha .= ' - '.$mes;
            }
            $fecha .= ' - '.$ani;
        }else {
            echo "<h1>LO SENTIMOS, NO HAY DATOS PARA GRAFICAR, INTENTA DENUEVO</h1>";
        }

?>

    <script type="text/javascript" src="js/amcharts.js"></script>
    <script type="text/javascript" src="js/radar.js"></script>
    <script type="text/javascript" src="js/highcharts.js"></script>
    <script type="text/javascript" src="js/highcharts-more.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>

    <script type="text/javascript" src="js/exporting.js"></script>

    
    <script type="text/javascript">
        $(function () {
            $('#grafRed').highcharts({
                chart: {
                    polar: true,
                    type: 'bar'
                },
                title: {
                    text: 'Rosa de los Vientos de la estacion '+
                            '<?php echo $nameEst;?>'+' ('+'<?php echo $ani;?>'+
                            '-'+'<?php echo $ani2;?>'+')',
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
                    data: <?php echo json_encode($dataN); ?>,
                    pointPlacement: 'on'
                }]

            });
        });
    </script>
    <script type="text/javascript">
        var variable = "<?php echo $nombreVar; ?>";
        var titulo = "<?php echo $tituloGraf; ?>";
        var mesAnio = "<?php echo $fecha ?>";
        var typeGrafica;
        var punteada = "";
        var serie = "<?php echo $serie ?>";
        typeGrafica= 'spline';
        var punteada = 'longdash';
    </script>
    <script type="text/javascript">
        $(function () {
            $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', 
                function (data) {
                // Create the chart
                $('#container').highcharts(
                    'StockChart', {
                    rangeSelector : {
                        selected : 1
                    },
                    title : {
                        text : 'AAPL Stock Price'
                    },
                    series : [{
                        name : 'AAPL',
                        data : data/*[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,
                                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,
                                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,
                                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,
                                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,
                                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,
                                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]*/
                    }]
                });
            });
        });
    </script>
</head>

<body>
    <br><br>
    <script src="js/highstock.js"></script>
    <script src="js/exporting.js"></script>
    <div id="regEtacion" style="height: 400px; min-width: 310px"></div>
</body>

<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/fin.php');
?>
