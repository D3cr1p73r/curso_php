<?php
    require("graficos.php");

    #$nCount = 1;

    #$tipo = array(1=>"ALTA", 2=>"MEDIA", 3=>"MODERADA", 4=>"BAIXA");
    #$valor = array();


    #$grafico1[1]['titulo'] = "t";#$tipo[1];
    #$grafico1[2]['titulo'] = "x";#$tipo[2];
    #$grafico1[3]['titulo'] = "c";#$tipo[3];
    #$grafico1[4]['titulo'] = "v";#$tipo[4];

    /*Armazenando os totais de cada tipo no vetor para o gráfico 1*/
    #$valor[1] = 10;#+= $valores[$nCount]['valores'] = 25;#OCIResult($oRS,2);
    #$valor[2] = 50;# += $valores[$nCount]['valores'] = 25;#OCIResult($oRS,3);
    #$valor[3] = 20; #+= $valores[$nCount]['valores'] = 25;#OCIResult($oRS,4);
    #$valor[4] = 20;#+= $valores[$nCount]['valores'] = 25;#OCIResult($oRS,5);

    #$grafico1[1]['valores'] = 10;#$valor[1];
    #$grafico1[2]['valores'] = 50;#$valor[2];
    #$grafico1[3]['valores'] = 20;#$valor[3];
    #$grafico1[4]['valores'] = 20;#$valor[4];

    #$grafico1[1]['color'] = "'#FF0000'"; /*Vermelho*/
    #$grafico1[2]['color'] = "'#FFFF00'"; /*Amarelo*/
    #$grafico1[3]['color'] = "'#0000FF'"; /*Azul*/
    #$grafico1[4]['color'] = "'#04B404'"; /*Verde*/

    #echo $grafico1[1]['color'];

    #echo "<script>";
     #   echo PizzaPersonalizado("container1","2019",$grafico1);
    #echo "</script>";
    
?>


<script type="text/javascript">
    $(function() {
        $('#container1').highcharts({
            chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares in January, 2018'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Chrome',
            y: 61.41,
            sliced: true,
            selected: true
        }, {
            name: 'Internet Explorer',
            y: 11.84
        }, {
            name: 'Firefox',
            y: 10.85
        }, {
            name: 'Edge',
            y: 4.67
        }, {
            name: 'Safari',
            y: 4.18
        }, {
            name: 'Other',
            y: 7.05
        }]
    }]
});
</script>
