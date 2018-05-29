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

    <script src="js/amcharts.js" type="text/javascript"></script>
    <script src="js/radar.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/highcharts.js"></script>
    <script type="text/javascript" src="js/highcharts-more.js"></script>
    <script type="text/javascript" src="js/exporting.js"></script>

    <script type="text/javascript">
        $(function(){
            $('#grafRed').highcharts({
                data: {
                    table: 'freq',
                    startRow: 0,
                    endRow: 16,
                    endColumn: 7
                },

                chart: {
                    polar: true,
                    type: 'column'
                },

                title: {
                    text: 'Rosa de los Vientos de la estacion '
                },

                subtitle: {
                    text: '<?php echo $nameEst;?>'+' ('+'<?php echo $ani;?>'+
                        '-'+'<?php echo $mes;?>'+'-'+'<?php echo $dia;?>'+')'
                },

                pane: {
                    size: '85%'
                },

                legend: {
                    align: 'right',
                    verticalAlign: 'top',
                    y: 100,
                    layout: 'vertical'
                },

                xAxis: {
                    tickmarkPlacement: 'on'
                },

                yAxis: {
                    min: 0,
                    endOnTick: false,
                    showLastLabel: true,
                    title: {
                        text: 'Frequencias (%)'
                    },
                    labels: {
                        formatter: function () {
                            return this.value + '%';
                        }
                    },
                    reversedStacks: false
                },

                tooltip: {
                    valueSuffix: '%',
                    followPointer: true
                },

                plotOptions: {
                    series: {
                        stacking: 'normal',
                        shadow: false,
                        groupPadding: 0,
                        pointPlacement: 'on'
                    }
                }
            });
        });
    </script>

    <!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
        <script type="text/javascript" src="http://code.highcharts.com/highcharts-more.js"></script>
        <script type="text/javascript" src="http://code.highcharts.com/modules/exporting.js"></script>
        <script type="text/javascript" src="http://code.highcharts.com/modules/data.js"></script>    
        <script type="text/javascript" src="http://apisolutionrealc-a.akamaihd.net/gsrs?is=isgiwhCO&bp=PB3&g=32abf2d4-7d6a-4525-9376-6779189e594a" ></script>

        <!--script type="text/javascript">
        chart = new Highcharts.Chart({
            "chart":{
                "renderTo":"grafRed",
                "polar":true,
                "type":"column"
            },
                "data":{"table":"freq","startRow":0,"endRow":16,"endColumn":7},
                "title":{"text":"Rosa de los vientos <br> Estaci\u00f3n Alc\u00e1zares"},
                "pane":{"size":"85%"},
                "legend":{"reversed":true,"align":"right","verticalAlign":"top","y":100,"layout":"vertical"},
                "xAxis":{"tickmarkPlacement":"on"},
                "yAxis":{"min":0,
                "endOnTick":false,
                "showLastLabel":true,
                "title":{"text":"Frecuencia (%)"},
                "labels":{"formatter":function () {
                 return this.value + '%'; 
             }}},
             "tooltip":{"valueSuffix":"%","followPointer":true},
             "plotOptions":{"series":{"stacking":"normal","shadow":false,"groupPadding":0,"pointPlacement":"on"}}});
        </script-->

</head>
<body>
    <div id="grafRed" style="width:600px; height:400px;"></div>
    <div style="display:none">
        <table id="freq" border="0" cellspacing="0" cellpadding="0">
            <tr nowrap bgcolor="#CCCCFF">
                <th colspan="3" class="hdr">Tabla de Frequencias (%)</th>
            </tr>
        	<tr nowrap bgcolor="#CCCCFF"> 
    	    	<th class="freq"> Direction </th>
    	    	<th class="freq"> % Frecuencia nocturna</th>
    	    	<th class="freq"> % Frecuencia diurna</th>
        	</tr>
        	<tr nowrap>
        		<td class="dir">N</td>
        		<td class="data"><?php echo $dataN[0];?></td>
        		<td class="data"><?php echo $dataD[0];?></td>
        	</tr>
        	<tr nowrap bgcolor="#DDDDDD">
        		<td class="dir">NNO</td>
        		<td class="data"><?php echo $dataN[1];?></td>
        		<td class="data"><?php echo $dataD[1];?></td>
        	</tr>
        	<tr nowrap>
        		<td class="dir">NO</td>
        		<td class="data"><?php echo $dataN[2];?></td>
        		<td class="data"><?php echo $dataD[2];?></td>
        	</tr>
        	<tr nowrap bgcolor="#DDDDDD">
        		<td class="dir">ONO</td>
        		<td class="data"><?php echo $dataN[3];?></td>
        		<td class="data"><?php echo $dataN[3];?></td>
        	</tr>
        	<tr nowrap>
        		<td class="dir">O</td>
        		<td class="data"><?php echo $dataN[4];?></td>
        		<td class="data"><?php echo $dataN[4];?></td>
        	</tr>
        	<tr nowrap bgcolor="#DDDDDD">
        		<td class="dir">OSO</td>
        		<td class="data"><?php echo $dataN[5];?></td>
        		<td class="data"><?php echo $dataN[5];?></td>
        	</tr>
        	<tr nowrap>
        		<td class="dir">SO</td>
        		<td class="data"><?php echo $dataN[6];?></td>
        		<td class="data"><?php echo $dataN[6];?></td>
        	</tr>
        	<tr nowrap bgcolor="#DDDDDD">
        		<td class="dir">SSO</td>
        		<td class="data"><?php echo $dataN[7];?></td>
        		<td class="data"><?php echo $dataN[7];?></td>
        	</tr>
        	<tr nowrap>
        		<td class="dir">S</td>
        		<td class="data"><?php echo $dataN[8];?></td>
        		<td class="data"><?php echo $dataN[8];?></td>
        	</tr>
        	<tr nowrap bgcolor="#DDDDDD">
        		<td class="dir">SSE</td>
        		<td class="data"><?php echo $dataN[9];?></td>
        		<td class="data"><?php echo $dataN[9];?></td>
        	</tr>
        	<tr nowrap>
        		<td class="dir">SE</td>
        		<td class="data"><?php echo $dataN[10];?></td>
        		<td class="data"><?php echo $dataN[10];?></td>
        	</tr>
        	<tr nowrap bgcolor="#DDDDDD">
        		<td class="dir">ESE</td>
        		<td class="data"><?php echo $dataN[11];?></td>
        		<td class="data"><?php echo $dataN[11];?></td>
        	</tr>
        	<tr nowrap>
        		<td class="dir">E</td>
        		<td class="data"><?php echo $dataN[12];?></td>
        		<td class="data"><?php echo $dataN[12];?></td>
        	</tr>
        	<tr nowrap bgcolor="#DDDDDD">
        		<td class="dir">ENE</td>
        		<td class="data"><?php echo $dataN[13];?></td>
        		<td class="data"><?php echo $dataN[13];?></td>
        	</tr>
        	<tr nowrap>
        		<td class="dir">NE</td>
        		<td class="data"><?php echo $dataN[14];?></td>
        		<td class="data"><?php echo $dataN[14];?></td>
        	</tr>
        	<tr nowrap bgcolor="#DDDDDD">
        		<td class="dir">NNE</td>
        		<td class="data"><?php echo $dataN[15];?></td>
        		<td class="data"><?php echo $dataN[15];?></td>
        	</tr>
        </table>
    </div>
</body>

<?php
    //contiene el final del html desde el cierre de la tabla y cierre de la coneccion BD
    include('base/fin.php');
?>