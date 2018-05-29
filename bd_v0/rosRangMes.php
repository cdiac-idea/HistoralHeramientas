<?php   
    include('base/inicioGraf.php');
    if ($_GET) {
        $idVariable = 5;
        $ani = array_key_exists('anio', $_GET) ? $_GET['anio'] : null;
        $ani2 = array_key_exists('anio2', $_GET) ? $_GET['anio2'] : null;
        $idEst = array_key_exists('est', $_GET) ? $_GET['est'] : null;
        $nameEst = array_key_exists('nes', $_GET) ? $_GET['nes'] : null;
        
        $dataD = array();
        $dataN = array();

        $datDVVD = datRosaVientsDiurRangMes($idEst, $ani, $ani2);
        $datDVVN = datRosaVientsNocRangMes($idEst, $ani, $ani2);

        $i=0;
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

        $nombreVar='Velocidad del Viento';
        $tituloGraf = $nombreVar.' '.$ani.' - '.$ani2.' '.$nameEst;
        $serie = $nombreVar." VS Tiempo";
        $data = array();

        $datosEst = velVientoRangoMes($idVariable, $idEst, $ani, $ani2);


        if ($datosEst) {
            foreach ( $datosEst as $value) {
                $data["id"][] = $value["dia"]."/".$value["mes"]."/".$value["año"];
                $data["maxima"][] = (float)$value["maxima"];
                $data["media"][] = (float)$value["media"];
            }
            
            $tam = count($data["id"]);
            $tam=$tam/($tam/10);
        }
    }else {
        echo "<h1>LO SENTIMOS, NO HAY DATOS PARA GRAFICAR, INTENTA DENUEVO</h1>";
    }
?>

    <script type="text/javascript" src="js/amcharts.js"></script>
    <script type="text/javascript" src="js/radar.js"></script>
    <script type="text/javascript" src="js/highcharts.js"></script>
    <script type="text/javascript" src="js/highcharts-more.js"></script>
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
                            '<?php echo $nameEst;?>'+' ('+'<?php echo $ani;?>'+'-'+'<?php echo $ani2;?>'+')',
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
                    name: 'Las Dirección del viento Maximas predominantes Diurna (6:00 am- 6:00 pm)',
                    shadow: true,
                    data: <?php echo json_encode($dataD); ?>,
                    pointPlacement: 'on'
                }, {
                    name: 'Las Dirección del viento Maximas predominantes Nocturna (6:00 pm- 6:00 am)',
                    data: <?php echo json_encode($dataN); ?>,
                    pointPlacement: 'on'
                }]
            });
        });
    </script>
    <script type="text/javascript">
        var variable = "<?php echo $nombreVar.' (°C)'; ?>";
        var titulo = "<?php echo $tituloGraf; ?>";
        var typeGrafica;
        var punteada = "";
        var serie = "<?php echo $serie ?>";
        var intervalo = "<?php echo $tam; ?>";
        typeGrafica= 'spline';//'scatter';
        var punteada = 'longdash';
    </script>
    <script type="text/javascript">
        $(function () {
            $('#regEtacion').highcharts({
                chart: {
                    type: 'spline',
                    resetZoom: 'Reset zoom',
                    resetZoomTitle: 'Reset zoom à 1:1',
                    zoomType: 'x',
                    alignTicks: false
                },
                title: {
                    text: titulo,
                    style: {
                        fontSize: "28px"
                    }
                },
                subtitle: {
                    text: serie,
                    style: {
                        fontSize: "18px"
                    }
                },
                xAxis: {
                    // Le pasamos los datos que irán en el eje de las 'X' en JSON
                    title: {
                        text: "TIEMPO",
                        style: {
                            fontSize: "18px"
                        }
                    },
                    labels : { 
                        y : 20, 
                        rotation: -90 
                    },
                    categories: <?php echo json_encode( $data["id"]) ?>,
                    minTickInterval: intervalo
                },
                yAxis: {
                    title: {
                        text: variable,
                        style: {
                            fontSize: "18px"
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        'En la fecha ' + this.x +' se tuvo  una ' + variable + 
                        ' ' + this.series.name + ' de: '+ this.y + ' (°C)';
                    }
                },
                navigator: {
                    enabled: true
                },
                scrollBar:{
                    enabled: true
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
    </script>
</head>

<body>
    <div id="grafRed" style="width:1200px; height:800px;"></div>
    <br><br>
    <div id="regEtacion" style="width:1200px; height:500px; margin: 20px;"></div>
</body>

<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/fin.php');
?>
