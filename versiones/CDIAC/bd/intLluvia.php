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
    $datDVVD = datIntLluv($idEst, $ani, $mes, $dia);
    if ($datDVVD) {
        foreach ($datDVVD as $value) {
            foreach ($value as $field) {
                $dataD[$i]=(integer)$field;
                $i++;
            }
        }
    }
}else {
    echo "<h1>LO SENTIMOS, NO HAY DATOS PARA GRAFICAR, INTENTA DENUEVO</h1>";
}

  
?>

<script type="text/javascript" src="js/highcharts.js"></script>
<script type="text/javascript">
    var arraystation = <?php echo json_encode($data["nombre"]); ?>;

    function get_station(id){
        return arraystation[id];
    }
</script>
<script type="text/javascript">
    $(function () {
        var chart;
        var n
        $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'regEtacion'
                },
                title: {
                    text: 'Resumen de registros por estaciones'
                },
                subtitle: {
                    text: 'Numero de registros VS Estaciones'
                },
                xAxis: {
                    // Le pasamos los datos que irán en el eje de las 'X' en JSON
                    categories: <?php echo json_encode( $dataD) ?>
                },
                yAxis: {
                    title: {
                        text: 'Numero Registros (Millones)'
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: function() {
                        //var station = get_station(this.x-1);
                        return '<b>'+ this.series.name +'</b><br/>'+
                            'La estacion ' + this.x + ' tiene '+ this.y +' registros';
                    }
                },
                series: [{
                    type: 'spline',
                    name: 'Resgistros VS Estacion',
                    data: <?php echo json_encode($dataD) ?> ,
                    marker: {
                        lineWidth: 1,
                        lineColor: Highcharts.getOptions().colors[1],
                        fillColor: 'white'
                    }
                }]
            });
        });
    });
</script>

</head>

<body>

    <div id="grafRed" style="width:1200px; height:800px;"></div>
</body>

<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/fin.php');
?>
