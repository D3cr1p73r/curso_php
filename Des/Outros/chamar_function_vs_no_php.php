<?php
require("../../../lib/php/gera_relatorio.php");
require("../../../lib/bd/bd_hosp.php");
require("../../../lib/php/graficos.php");

$relatorio = new GeraRelatorio;

$data_inicio = "'".$_GET['data_inicio']."'";
$data_fim = "'".$_GET['data_fim']."'";
$tipo_paciente = "'".$_GET['tipo_paciente']."'";

$cSQL_Fech = "
SELECT DATA_MINIMA_FECHAMENTO
       ,DATA_MAXIMA_FECHAMENTO
       
  FROM (SELECT CONVENIO
              ,1 QTDE_ALTA
              ,TO_DATE('14' || '/' ||
                       TO_CHAR(ADD_MONTHS(TRUNC(DATA_FINAL), +1), 'mm/rrrr')
                      ,'dd/mm/rrrr') DATA_MAXIMA_FECHAMENTO
              ,ADD_MONTHS(TO_DATE('14' || '/' ||
                                  TO_CHAR(ADD_MONTHS(TRUNC(DATA_FINAL), +1)
                                         ,'mm/rrrr')
                                 ,'dd/mm/rrrr')
                         ,-1) + 1 DATA_MINIMA_FECHAMENTO
              ,U.DESCRICAO DESC_CONVENIO
              ,R.NUM_CC
              ,R.DT_ALTACLI DATA_ALTA
              ,R.DT_FECHAMENTO DATA_FECHAMENTO
              ,DATMOV DATA_AGENDADA_FECHAMENTO
              ,DATA_INICIAL DATA_INICIAL_CORTE
              ,DATA_FINAL DATA_FINAL_CORTE
          FROM CONTA_CORRENTE R
              ,CONV_GRUPO_CONVENIO P
              ,CONV_GRUPO U
              ,(SELECT COD_CONVENIO CONVENIO
                     ,DATMOV
                     ,ANTERIOR     DATA_INICIAL
                     ,DATA_CORTE   DATA_FINAL
                 FROM (SELECT DISTINCT K.COD_GRUPO COD_CONVENIO
                                      ,N.DATMOV
                                      ,LAG(N.DATA_CORTE) OVER(ORDER BY N.CONVENIO_COD_CONVENIO, N.DATA_CORTE) + 1 ANTERIOR
                                      ,N.DATA_CORTE
                         FROM FAT_CALCON          N
                             ,CONV_GRUPO_CONVENIO K
                        WHERE N.DATMOV >=
                              ADD_MONTHS(TO_DATE($data_inicio), -1)
                          AND N.DATMOV < TO_DATE($data_fim) + 1
                          AND K.COD_CONVENIO = N.CONVENIO_COD_CONVENIO
                          AND N.STATUS_ENTREGA = 0)
                WHERE DATMOV >= TO_DATE($data_inicio)
                  AND DATMOV < TO_DATE($data_fim) + 1)
         WHERE R.DT_ALTACLI >= DATA_INICIAL
           AND R.DT_ALTACLI < DATA_FINAL + 1
           AND R.COD_CONVENIO = P.COD_CONVENIO
           AND R.TIPO_PACIENTE IN (1, 4)
           AND R.TIPO_PACIENTE LIKE DECODE($tipo_paciente
                                          ,'INTERNO'
                                          ,'1'
                                          ,'AMBULATORIO'
                                          ,'4'
                                          ,'EMERGENCIA'
                                          ,'3'
                                          ,'LABORATORIO'
                                          ,'2')
           AND DECODE(P.COD_GRUPO, 123, 2, P.COD_GRUPO) = CONVENIO
           AND U.COD_GRUPO = P.COD_GRUPO
        UNION ALL
        SELECT CONVENIO
              ,1 QTDE_ALTA
              ,TO_DATE('14' || '/' ||
                       TO_CHAR(ADD_MONTHS(TRUNC(DATA_FINAL), +1), 'mm/rrrr')
                      ,'dd/mm/rrrr') DATA_MAXIMA_FECHAMENTO
              ,ADD_MONTHS(TO_DATE('14' || '/' ||
                                  TO_CHAR(ADD_MONTHS(TRUNC(DATA_FINAL), +1)
                                         ,'mm/rrrr')
                                 ,'dd/mm/rrrr')
                         ,-1) + 1 DATA_MINIMA_FECHAMENTO
              ,U.DESCRICAO DESC_CONVENIO
              ,R.NUM_CC
              ,R.DT_ALTACLI DATA_ALTA
              ,R.DT_FECHAMENTO DATA_FECHAMENTO
              ,DATMOV DATA_AGENDADA_FECHAMENTO
              ,DATA_INICIAL DATA_INICIAL_CORTE
              ,DATA_FINAL DATA_FINAL_CORTE
          FROM CONTA_CORRENTE R
              ,CONV_GRUPO_CONVENIO P
              ,CONV_GRUPO U
              ,(SELECT COD_CONVENIO CONVENIO
                     ,DATMOV
                     ,ANTERIOR     DATA_INICIAL
                     ,DATA_CORTE   DATA_FINAL
                 FROM (SELECT DISTINCT K.COD_GRUPO COD_CONVENIO
                                      ,N.DATMOV
                                      ,LAG(N.DATA_CORTE) OVER(ORDER BY N.CONVENIO_COD_CONVENIO, N.DATA_CORTE) + 1 ANTERIOR
                                      ,N.DATA_CORTE
                         FROM FAT_CALCON          N
                             ,CONV_GRUPO_CONVENIO K
                        WHERE N.DATMOV >=
                              ADD_MONTHS(TO_DATE($data_inicio), -1)
                          AND N.DATMOV < TO_DATE($data_fim) + 1
                          AND K.COD_CONVENIO = N.CONVENIO_COD_CONVENIO
                          AND N.STATUS_ENTREGA = 0)
                WHERE DATMOV >= TO_DATE($data_inicio)
                  AND DATMOV < TO_DATE($data_fim) + 1)
         WHERE R.DT_CHEGADA_RECEPCAO >= DATA_INICIAL
           AND R.DT_CHEGADA_RECEPCAO < DATA_FINAL + 1
           AND R.TIPO_PACIENTE LIKE DECODE($tipo_paciente
                                          ,'INTERNO'
                                          ,'1'
                                          ,'AMBULATORIO'
                                          ,'4'
                                          ,'EMERGENCIA'
                                          ,'3'
                                          ,'LABORATORIO'
                                          ,'2')
           AND R.TIPO_PACIENTE IN (3, 2, 5)
           AND R.COD_CONVENIO = P.COD_CONVENIO
           AND DECODE(P.COD_GRUPO, 123, 2, P.COD_GRUPO) = CONVENIO
           AND U.COD_GRUPO = P.COD_GRUPO)
 GROUP BY DATA_MINIMA_FECHAMENTO
         ,DATA_MAXIMA_FECHAMENTO
 ORDER BY DATA_MINIMA_FECHAMENTO         
";
//Sql dados:
$cSQL_Data ="
SELECT
  F_ACENTO(DESC_CONVENIO)
  ,CTA_FECHADAS_ACIMA_PERIODO
  ,DATA_MINIMA_FECHAMENTO
  ,DATA_MAXIMA_FECHAMENTO
FROM
(
  SELECT DESC_CONVENIO
        ,MAX(DATA_AGENDADA_FECHAMENTO) DATA_AGENDADA_FECHAMENTO
        ,MIN(DATA_INICIAL_CORTE) DATA_INICIAL_CORTE
        ,MAX(DATA_FINAL_CORTE) DATA_FINAL_CORTE
        ,DATA_MINIMA_FECHAMENTO
        ,DATA_MAXIMA_FECHAMENTO
        ,SUM(QTDE_ALTA) QTDE_ALTA
        ,SUM(CTA_FECHADAS_PERIODO) CTA_FECHADAS_PERIODO
        ,((SUM(CTA_FECHADAS_PERIODO) * 100) / SUM(QTDE_ALTA)) PER_FECH_PERIODO
        ,SUM(CTA_FECHADAS_ACIMA_PERIODO) CTA_FECHADAS_ACIMA_PERIODO
        ,((SUM(CTA_FECHADAS_ACIMA_PERIODO) * 100) / SUM(QTDE_ALTA)) PER_FECH_ACIMA_PERIODO
        ,SUM(CONTAS_ABERTAS) CONTAS_ABERTAS
        ,((SUM(CONTAS_ABERTAS) * 100) / SUM(QTDE_ALTA)) PER_ABERTAS
    FROM (SELECT DESC_CONVENIO
                ,DATA_AGENDADA_FECHAMENTO
                ,DATA_INICIAL_CORTE
                ,DATA_FINAL_CORTE
                ,DATA_MINIMA_FECHAMENTO
                ,DATA_MAXIMA_FECHAMENTO
                ,SUM(QTDE_ALTA) QTDE_ALTA
                ,SUM(CTA_FECHADAS_PERIODO + CTA_FECHADAS_ANTES_PERIODO) CTA_FECHADAS_PERIODO
                ,SUM(CTA_FECHADAS_ACIMA_PERIODO) CTA_FECHADAS_ACIMA_PERIODO
                ,SUM(CONTAS_ABERTAS) CONTAS_ABERTAS
            FROM (SELECT CONVENIO
                        ,DESC_CONVENIO
                        ,DATA_AGENDADA_FECHAMENTO
                        ,DATA_MINIMA_FECHAMENTO
                        ,DATA_MAXIMA_FECHAMENTO
                        ,DATA_ALTA
                        ,DATA_FECHAMENTO
                        ,DATA_INICIAL_CORTE
                        ,DATA_FINAL_CORTE
                        ,SUM(QTDE_ALTA) QTDE_ALTA
                        ,SUM(CONTAS_FECHADAS_PERIODO) CTA_FECHADAS_PERIODO
                        ,SUM(CTA_FECHADAS_ANTES_PERIODO) CTA_FECHADAS_ANTES_PERIODO
                        ,SUM(CTA_FECHADAS_ACIMA_PERIODO) CTA_FECHADAS_ACIMA_PERIODO
                        ,SUM(META_FECH_DENTRO_PERIODO) META_FECH_DENTRO_PERIODO
                        ,SUM(META_FECH_CONTAS_ANTERIOR) META_FECH_CONTAS_ANTERIOR
                        ,SUM(META_FECH_CONTAS_POSTERIOR) META_FECH_CONTAS_POSTERIOR
                        ,SUM(CONTAS_ABERTAS) CONTAS_ABERTAS
                    FROM (SELECT CONVENIO
                                ,QTDE_ALTA
                                ,DATA_MINIMA_FECHAMENTO
                                ,DATA_MAXIMA_FECHAMENTO
                                ,DESC_CONVENIO
                                ,NUM_CC
                                ,DATA_ALTA
                                ,DATA_FECHAMENTO
                                ,DATA_AGENDADA_FECHAMENTO
                                ,DATA_INICIAL_CORTE
                                ,DATA_FINAL_CORTE
                                ,CASE
                                   WHEN DATA_FECHAMENTO BETWEEN
                                        DATA_MINIMA_FECHAMENTO AND
                                        DATA_MAXIMA_FECHAMENTO THEN
                                    1
                                   ELSE
                                    0
                                 END CONTAS_FECHADAS_PERIODO
                                ,CASE
                                   WHEN DATA_FECHAMENTO < DATA_MINIMA_FECHAMENTO THEN
                                    1
                                   ELSE
                                    0
                                 END CTA_FECHADAS_ANTES_PERIODO
                                ,CASE
                                   WHEN DATA_FECHAMENTO > DATA_MAXIMA_FECHAMENTO THEN
                                    1
                                   ELSE
                                    0
                                 END CTA_FECHADAS_ACIMA_PERIODO
                                ,CASE
                                   WHEN DATA_FECHAMENTO =
                                        DATA_AGENDADA_FECHAMENTO THEN
                                    1
                                   ELSE
                                    0
                                 END META_FECH_DENTRO_PERIODO
                                ,CASE
                                   WHEN DATA_FECHAMENTO <
                                        DATA_AGENDADA_FECHAMENTO THEN
                                    1
                                   ELSE
                                    0
                                 END META_FECH_CONTAS_ANTERIOR
                                ,CASE
                                   WHEN DATA_FECHAMENTO >
                                        DATA_AGENDADA_FECHAMENTO THEN
                                    1
                                   ELSE
                                    0
                                 END META_FECH_CONTAS_POSTERIOR
                                ,CASE
                                   WHEN DATA_FECHAMENTO IS NULL THEN
                                    1
                                   ELSE
                                    0
                                 END CONTAS_ABERTAS
                            FROM (SELECT CONVENIO
                                        ,1 QTDE_ALTA
                                        ,TO_DATE('14' || '/' ||
                                                 TO_CHAR(ADD_MONTHS(TRUNC(DATA_FINAL)
                                                                   ,+1)
                                                        ,'mm/rrrr')
                                                ,'dd/mm/rrrr') DATA_MAXIMA_FECHAMENTO
                                        ,ADD_MONTHS(TO_DATE('14' || '/' ||
                                                            TO_CHAR(ADD_MONTHS(TRUNC(DATA_FINAL)
                                                                              ,+1)
                                                                   ,'mm/rrrr')
                                                           ,'dd/mm/rrrr')
                                                   ,-1) + 1 DATA_MINIMA_FECHAMENTO
                                        ,U.DESCRICAO DESC_CONVENIO
                                        ,R.NUM_CC
                                        ,R.DT_ALTACLI DATA_ALTA
                                        ,R.DT_FECHAMENTO DATA_FECHAMENTO
                                        ,DATMOV DATA_AGENDADA_FECHAMENTO
                                        ,DATA_INICIAL DATA_INICIAL_CORTE
                                        ,DATA_FINAL DATA_FINAL_CORTE
                                    FROM CONTA_CORRENTE R
                                        ,CONV_GRUPO_CONVENIO P
                                        ,CONV_GRUPO U
                                        ,(SELECT COD_CONVENIO CONVENIO
                                               ,DATMOV
                                               ,ANTERIOR     DATA_INICIAL
                                               ,DATA_CORTE   DATA_FINAL
                                           FROM (SELECT DISTINCT K.COD_GRUPO COD_CONVENIO
                                                                ,N.DATMOV
                                                                ,LAG(N.DATA_CORTE) OVER(ORDER BY N.CONVENIO_COD_CONVENIO, N.DATA_CORTE) + 1 ANTERIOR
                                                                ,N.DATA_CORTE
                                                   FROM FAT_CALCON          N
                                                       ,CONV_GRUPO_CONVENIO K
                                                  WHERE N.DATMOV >=
                                                        ADD_MONTHS(TO_DATE($data_inicio)
                                                                  ,-1)
                                                    AND N.DATMOV <
                                                        TO_DATE($data_fim) + 1
                                                    AND K.COD_CONVENIO =
                                                        N.CONVENIO_COD_CONVENIO
                                                    AND N.STATUS_ENTREGA = 0)
                                          WHERE DATMOV >=
                                                TO_DATE($data_inicio)
                                            AND DATMOV <
                                                TO_DATE($data_fim) + 1)
                                   WHERE R.DT_ALTACLI >= DATA_INICIAL
                                     AND R.DT_ALTACLI < DATA_FINAL + 1
                                     AND R.COD_CONVENIO = P.COD_CONVENIO
                                     AND R.TIPO_PACIENTE IN (1, 4)
                                     AND R.TIPO_PACIENTE LIKE
                                         DECODE($tipo_paciente
                                               ,'INTERNO'
                                               ,'1'
                                               ,'AMBULATORIO'
                                               ,'4'
                                               ,'EMERGENCIA'
                                               ,'3'
                                               ,'LABORATORIO'
                                               ,'2')
                                     AND DECODE(P.COD_GRUPO, 123, 2, P.COD_GRUPO) =
                                         CONVENIO
                                     AND U.COD_GRUPO = P.COD_GRUPO
                                  UNION ALL -- EMERGENCIA / LABORATORIO
                                  SELECT CONVENIO
                                        ,1 QTDE_ALTA
                                        ,TO_DATE('14' || '/' ||
                                                 TO_CHAR(ADD_MONTHS(TRUNC(DATA_FINAL)
                                                                   ,+1)
                                                        ,'mm/rrrr')
                                                ,'dd/mm/rrrr') DATA_MAXIMA_FECHAMENTO
                                        ,ADD_MONTHS(TO_DATE('14' || '/' ||
                                                            TO_CHAR(ADD_MONTHS(TRUNC(DATA_FINAL)
                                                                              ,+1)
                                                                   ,'mm/rrrr')
                                                           ,'dd/mm/rrrr')
                                                   ,-1) + 1 DATA_MINIMA_FECHAMENTO
                                        ,U.DESCRICAO DESC_CONVENIO
                                        ,R.NUM_CC
                                        ,R.DT_ALTACLI DATA_ALTA
                                        ,R.DT_FECHAMENTO DATA_FECHAMENTO
                                        ,DATMOV DATA_AGENDADA_FECHAMENTO
                                        ,DATA_INICIAL DATA_INICIAL_CORTE
                                        ,DATA_FINAL DATA_FINAL_CORTE
                                    FROM CONTA_CORRENTE R
                                        ,CONV_GRUPO_CONVENIO P
                                        ,CONV_GRUPO U
                                        ,(SELECT COD_CONVENIO CONVENIO
                                               ,DATMOV
                                               ,ANTERIOR     DATA_INICIAL
                                               ,DATA_CORTE   DATA_FINAL
                                           FROM (SELECT DISTINCT K.COD_GRUPO COD_CONVENIO
                                                                ,N.DATMOV
                                                                ,LAG(N.DATA_CORTE) OVER(ORDER BY N.CONVENIO_COD_CONVENIO, N.DATA_CORTE) + 1 ANTERIOR
                                                                ,N.DATA_CORTE
                                                   FROM FAT_CALCON          N
                                                       ,CONV_GRUPO_CONVENIO K
                                                  WHERE N.DATMOV >=
                                                        ADD_MONTHS(TO_DATE($data_inicio)
                                                                  ,-1)
                                                    AND N.DATMOV <
                                                        TO_DATE($data_fim) + 1
                                                    AND K.COD_CONVENIO =
                                                        N.CONVENIO_COD_CONVENIO
                                                    AND N.STATUS_ENTREGA = 0)
                                          WHERE DATMOV >=
                                                TO_DATE($data_inicio)
                                            AND DATMOV <
                                                TO_DATE($data_fim) + 1)
                                   WHERE R.DT_CHEGADA_RECEPCAO >= DATA_INICIAL
                                     AND R.DT_CHEGADA_RECEPCAO < DATA_FINAL + 1
                                     AND R.TIPO_PACIENTE LIKE
                                         DECODE($tipo_paciente
                                               ,'INTERNO'
                                               ,'1'
                                               ,'AMBULATORIO'
                                               ,'4'
                                               ,'EMERGENCIA'
                                               ,'3'
                                               ,'LABORATORIO'
                                               ,'2')
                                     AND R.TIPO_PACIENTE IN (3, 2, 5)
                                     AND R.COD_CONVENIO = P.COD_CONVENIO
                                     AND DECODE(P.COD_GRUPO, 123, 2, P.COD_GRUPO) = CONVENIO
                                     AND U.COD_GRUPO = P.COD_GRUPO))
                   GROUP BY CONVENIO
                           ,DESC_CONVENIO
                           ,DATA_AGENDADA_FECHAMENTO
                           ,DATA_MINIMA_FECHAMENTO
                           ,DATA_MAXIMA_FECHAMENTO
                           ,DATA_ALTA
                           ,DATA_FECHAMENTO
                           ,DATA_INICIAL_CORTE
                           ,DATA_FINAL_CORTE)
           GROUP BY DESC_CONVENIO
                   ,DATA_AGENDADA_FECHAMENTO
                   ,DATA_INICIAL_CORTE
                   ,DATA_FINAL_CORTE
                   ,DATA_MINIMA_FECHAMENTO
                   ,DATA_MAXIMA_FECHAMENTO)
   GROUP BY DESC_CONVENIO
           ,DATA_MINIMA_FECHAMENTO
           ,DATA_MAXIMA_FECHAMENTO
   ORDER BY 
            DATA_AGENDADA_FECHAMENTO
            ,DESC_CONVENIO
)
WHERE 1 = 1        
--AND DESC_CONVENIO NOT LIKE 'AMIL INTERNAC%'    
ORDER BY DATA_MINIMA_FECHAMENTO
         ,CTA_FECHADAS_ACIMA_PERIODO
         ,DESC_CONVENIO
";

//   echo $cSQL_Fech;
$oRS = OCIParse($oConBD, $cSQL_Fech);
OCIExecute($oRS);
$cont = 1;
while (OCIFetch($oRS)) {
    $dtMinFech[$cont] = OCIResult($oRS, 1);
    $dtMaxFech[$cont] = OCIResult($oRS, 2);
    $cont++;
}
OCIFreeStatement($oRS);


$oRS = OCIParse($oConBD, $cSQL_Data);
OCIExecute($oRS);
$cont = 1;
while (OCIFetch($oRS)) {
    $descConv[$cont]   = OCIResult($oRS, 1);
    $qtdeContas[$cont] = OCIResult($oRS, 2);
    $dtMinFechData[$cont] = OCIResult($oRS, 3);
    $dtMaxFechData[$cont] = OCIResult($oRS, 4);    
    $cont++;
}
OCIFreeStatement($oRS);


echo '<br>';
echo '<br>';
echo '<br>';
for ($i = 1; $i <= count($dtMaxFech); $i++) {
    echo "<div class='row'>";
        echo "<div class='col-md-12 mt-4 pb-3'>";
            echo "<span><i class='fas fa-chart-area'></i>&nbsp;Fechamento:&nbsp;";
            echo $dtMinFech[$i].' a '.$dtMaxFech[$i];  
            echo "</span><hr>";
        echo "</div>";
    echo "</div>";
    for ($s = 1; $s <= count($descConv); $s++) {
        if  ($dtMinFechData[$s] == $dtMinFech[$i] && $dtMaxFechData[$s] == $dtMaxFech[$i]){
            $v_param[$s] = "{name: '".$descConv[$s]."',y: ".$qtdeContas[$s]."}";
        }

    } 
    $impl = implode(",",$v_param);
    var_dump($dados);
    echo "<script>$(document).ready(function() {grafico('grafico$i','teste$i',$impl);}); </script>";
    echo "<div class='row'>";
    echo "<div class='col-md-12' id='grafico$i'></div>";
    echo "</div>";
    echo  $impl;

    //$teste = "'".implode("','",$usuario)."'";
   } 
?>

<script type="text/javascript">
    function grafico(v_idDiv,v_titulo,v_dados) {
        //window.alert(v_dados);
        $('#'+v_idDiv).highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: v_titulo
            },
            tooltip: {
                pointFormat: 'Contas.:<b>{point.y:.1f}</b><br>Porcent.: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Contas',
                colorByPoint: true,
                data: 
                [ 
                    //<? echo $impl ?>
                    v_dados
                   // {name: 'CABESP',y: 0},{name: 'CASSI',y: 0},{name: 'S. BRADES. - EMPRESA',y: 0},{name: 'SUL AMERICA INDIVIDUAL',y: 0},{name: 'UNINTER SAUDE UNINFANCIA',y: 0},{name: 'AMIL INTERNAC "PLANOS BASICOS"',y: 1},{name: 'ASSEFAZ',y: 1},{name: 'CESP',y: 1},{name: 'FUNCEF / PAMS',y: 1},{name: 'NOTRE DAME',y: 1},{name: 'SUL AMERICA EMPRESA',y: 1},{name: 'AUSTACLINICAS',y: 104},{name: 'CASSI',y: 0},{name: 'PARTICULAR',y: 0},{name: 'S. BRADES. - EMPRESA',y: 0},{name: 'SUL AMERICA EMPRESA',y: 0},{name: 'AMIL INTERNAC "PLANOS BASICOS"',y: 1},{name: 'FUNCEF / PAMS',y: 1},{name: 'PETROBRAS PETROLEO',y: 1},{name: 'AUSTACLINICAS',y: 5},{name: 'UNIMED',y: 22}
                ]
            }]
        });
    }

</script>
