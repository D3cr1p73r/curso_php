<?php
// MODELO::
// function buscaSolicitacoes($filter) {
//     require_once("src/config/database.php");
//     $sql = new Database;
//     $cSQL = "
//     ";
//     $result = $sql->runQuery($cSQL);
//     return $result; 
// };


function checaLogin($login) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT COUNT(*) AS CHK_LOGIN
               FROM WP_USUARIO US
              WHERE US.LOGIN = '{$login['user']}'
                AND US.SENHA = '{$login['password']}'
     ";
    $result = $sql->runQuery($cSQL);
    $result = $result[1];
    return $result;
    };

function validaUsrCadastro($user) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT COUNT(*)
               FROM FUNCIONARIO F
              WHERE 1 = 1
                AND F.AREA_COD_AREA = 634 /*CADASTRO*/
                AND F.USERNAME = $user
            ";
    $result = $sql->runQuery($cSQL);
    $result = $result[1];
    return $result;
    };
    
function preencheTipoMat() {
        require_once("src/config/database.php");
        $sql = new Database;
        $cSQL = "SELECT TM.COD_TIPO_MAT AS COD_TIPO
                        ,TM.DESCRICAO   AS DESC_TIPO
                   FROM TIPOS_MATERIAIS TM
                  ORDER BY TM.DESCRICAO  
                ";
        $result = $sql->runQuery($cSQL);
        return $result;
        };

function gravaSolicitacao($newData) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT NVL(MAX(CODIGO),0)+1 AS CODIGO FROM CAD_SOLICITACOES";
    $result = $sql->runQuery($cSQL);
    $codigo = $result[1];
    
    $newData['dtVigencia'] = date("d/m/Y", strtotime($newData['dtVigencia']));
    $cSQL = "INSERT INTO CAD_SOLICITACOES (CODIGO
                                            ,PRIORIDADE
                                            ,DT_VIGENCIA
                                            ,SOLICITANTE
                                            ,DESCRICAO_MAT
                                            ,TIPO_MAT
                                            ,FLG_MANIPULADO
                                            ,FORMA_AP_CODIGO
                                            ,COD_ANVISA
                                            ,REF_FABRICANTE
                                            ,TIPO_DEMANDA
                                            ,FLG_FRACIONA
                                            ,FLG_MOV_ESTOQUE
                                            ,FLG_MOV_SUB_EST
                                            ,CENTRO_DE_CUSTO
                                            ,COD_AGENDA_CCIR
                                            ,NOME_MEDICO
                                            ,FLG_ORCAMENTO
                                            ,FLG_AGENDAMENTO
                                            ,CLASSIF_CONTAB
                                            ,COD_GRUPO
                                            ,COD_SUB_GRUPO)
                                    VALUES(TO_NUMBER({$codigo['codigo']})
                                            ,TO_NUMBER({$newData['prioridade']})
                                            ,TO_DATE('{$newData['dtVigencia']}','DD/MM/RRRR')
                                            ,UPPER('{$_SESSION[user]}')
                                            ,'{$newData['descMat']}'
                                            ,'{$newData['tipoMat']}'
                                            ,'{$newData['manipulado']}'
                                            ,'{$newData['apresentacao']}'
                                            ,TO_NUMBER('{$newData['anvisa']}')
                                            ,'{$newData['refFabricante']}'
                                            ,'{$newData['tipoDemanda']}'
                                            ,'{$newData['fraciona']}'
                                            ,'{$newData['movEst']}'
                                            ,'{$newData['movSubEst']}'
                                            ,TO_NUMBER('{$newData['centroCusto']}')
                                            ,TO_NUMBER('{$newData['agendamento']}')
                                            ,'{$newData['medico']}'
                                            ,'{$newData['rdOrcamento']}'
                                            ,'{$newData['rdAgendamento']}'
                                            ,TO_NUMBER('{$newData['classCont']}')
                                            ,{$newData['classFin']}
                                            )";
    // echo $cSQL;         
    $sql->runDDL($cSQL);
    return $codigo['codigo'];
    };

    function gravaAnexos($newFiles,$codSolicitacao) {
        require_once("src/config/database.php");
        $sql = new Database;
            $pastaUpload = '../../anexos/solicitacao_cadastro/';
            foreach($newFiles as $file){
                if($file['error'] == 0){
                    // echo print_r($file)."<br>";
                    $nomeArquivo = "solic_".$codSolicitacao."_".$file['name'];
                    // echo "$nomeArquivo<br>";
                    $pathFile = "//192.168.10.27/anexos/solicitacao_cadastro/".$nomeArquivo;
                    $arquivo = $pastaUpload . $nomeArquivo;
                    $tmp = $file['tmp_name'];
                    if (!move_uploaded_file($tmp, $arquivo)) {
                        echo "<br>Erro no upload de arquivo!";
                    }else{
                        $cSQL ="SELECT NVL(MAX(CA.SEQ_ANEXO),0)+1 AS SEQ_ANEXO
                                FROM CAD_ANEXOS CA
                                WHERE CA.COD_SOLICITACAO = $codSolicitacao";
                        $result = $sql->runQuery($cSQL);
                        $result = $result[1];
                        $seqAnexo = $result['seq_anexo'];
                        $cSQL = "INSERT INTO CAD_ANEXOS(COD_SOLICITACAO,SEQ_ANEXO,NOME_ARQUIVO,PATH_ANEXO) 
                                 VALUES($codSolicitacao,$seqAnexo,'{$file['name']}','$pathFile')";
                        $sql->runDDL($cSQL);
                    }
                }
                // else{
                //     echo "Erro no arquivo ''{$file[name]}";
                // }
            }
    }

function buscaSolicitacao($codigo) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT SO.CODIGO
                    ,SO.STATUS
                    ,DECODE(SO.PRIORIDADE, 1, 'Baixa', 2, 'Média', 3, 'Alta') AS PRIORIDADE
                    ,TO_CHAR(SO.DT_VIGENCIA, 'DD/MM/RRRR') AS DT_VIGENCIA
                    ,SO.SOLICITANTE
                    ,SO.DT_SOLICITACAO
                    ,SO.DESCRICAO_MAT
                    ,TM.DESCRICAO AS TIPO_MAT
                    ,DECODE(SO.FLG_MANIPULADO,'S','SIM','N','NÃO') AS MANIPULADO
                    ,SO.FORMA_AP_CODIGO
                    ,FAP.DESCRICAO AS FORMA_AP
                    ,SO.COD_ANVISA
                    ,SO.REF_FABRICANTE
                    ,DECODE(SO.TIPO_DEMANDA,1,'CONSUMO'
                                        ,2,'COMPRA'
                                        ,3,'CONSIGNACAO'
                                        ,4,'CONSIGNACAO-ESTOQUE') AS TIPO_DEMANDA
                    ,DECODE(SO.FLG_FRACIONA,'S','SIM','N','NÃO') AS FRACIONA
                    ,DECODE(SO.FLG_MOV_ESTOQUE,'S','SIM','N','NÃO') AS MOV_EST
                    ,DECODE(SO.FLG_MOV_SUB_EST,'S','SIM','N','NÃO') AS MOV_SUB_EST
                    ,SO.CENTRO_DE_CUSTO AS COD_CENTRO_CUSTO
                    ,AR.DESCRICAO_AREA AS CENTRO_CUSTO
                    ,SO.COD_AGENDA_CCIR
                    ,SO.NOME_MEDICO
                    ,SO.FLG_ORCAMENTO
                    ,SO.FLG_AGENDAMENTO
                    ,SO.CLASSIF_CONTAB
                    ,CTB.DESCRICAO AS CLASS_CONT
                    ,SGC.DESCRICAO AS CLASS_FIN_DESC
                    ,SO.COD_GRUPO
                    ,SO.COD_SUB_GRUPO
                FROM CAD_SOLICITACOES SO
                    ,TIPOS_MATERIAIS TM
                    ,FORMA_APRESENTACAO FAP
                    ,AREAS      AR
                    ,CTB_CTACTB         CTB
                    ,SUBGRUPO_COBRANCA  SGC
                WHERE 1 = 1
                AND SO.TIPO_MAT = TM.COD_TIPO_MAT(+)
                AND SO.FORMA_AP_CODIGO = FAP.CODIGO(+)
                AND SO.CENTRO_DE_CUSTO = AR.COD_AREA(+)
                AND SO.COD_GRUPO = SGC.COD_GRUPO(+)
                AND SO.CLASSIF_CONTAB = CTB.COD_CONTA(+)
                AND SO.COD_SUB_GRUPO = SGC.COD_SGRUPO(+)
                AND SO.CODIGO =  $codigo
    ";
    $resultQuery = $sql->runQuery($cSQL);
    $result = $resultQuery[1];
    return $result; 
};

function buscaAnexo($codigo) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "  SELECT SEQ_ANEXO
                     ,NOME_ARQUIVO
                     ,PATH_ANEXO
                FROM CAD_ANEXOS
            WHERE COD_SOLICITACAO = $codigo
     ";
    $result = $sql->runQuery($cSQL);
    return $result; 
};


function buscaSolicitacoes($filter) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT CODIGO
                    ,DECODE(STATUS,0,'Solicitado'
                                  ,1,'Analise'
                                  ,2,'Finalizado'
                                  ,3,'Pendente' ) AS STATUS
                    ,DECODE(PRIORIDADE ,0,'Baixa'
                                       ,1,'Média'
                                       ,2,'Alta') AS PRIORIDADE
                    ,SOLICITANTE
                    ,TO_CHAR(DT_SOLICITACAO,'DD/MM/RRRR HH24:MI:SS') AS DT_SOLICITACAO
                FROM CAD_SOLICITACOES
                WHERE 1 = 1
                AND STATUS = DECODE({$filter['status']},99,STATUS,{$filter['status']})
                AND PRIORIDADE = DECODE({$filter['prioridade']},99,PRIORIDADE,{$filter['prioridade']})        
                ORDER BY CODIGO DESC
    ";
    $result = $sql->runQuery($cSQL);
    return $result; 
};
function buscaSolicitacoesPend($user) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT CAS.CODIGO
                    ,CAS.ANVISA
                    ,CAS.COD_AGENDA_CCIR
                    ,DECODE(CAS.STATUS,0,'Solicitado'
                                  ,1,'Analise'
                                  ,2,'Finalizado'
                                  ,3,'Pendente' ) AS STATUS
                    ,DECODE(CAS.PRIORIDADE ,0,'Baixa'
                                       ,1,'Mdia'
                                       ,2,'Alta') AS PRIORIDADE
                    ,TO_CHAR(CAS.DT_SOLIC, 'DD/MM/RRRR HH24:MI:SS') AS DT_SOLIC
                FROM CAD_SOLICITACOES CAS
                WHERE 1 = 1
                AND (CAS.USUARIO = '$user'
                     OR EXISTS(
                                SELECT 1
                                  FROM FUNCIONARIO F
                                 WHERE 1 = 1
                                   AND F.AREA_COD_AREA = 634 /*CADASTRO*/
                                   AND F.USERNAME = '$user'
                               )
                    )    
                ORDER BY CODIGO DESC
    ";
    $result = $sql->runQuery($cSQL);
    return $result; 
};

function buscaHistObs($codigo) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "
    SELECT TO_CHAR(CSC.DT_CONTROLE, 'DD/MM/RRRR HH24:MI:SS') AS DATA
            ,CSC.USUARIO 
            ,CSC.OBSERVACAO AS OBS
      FROM CAD_SOLICITACOES_CONTROLE CSC
     WHERE CSC.COD_SOLICITACAO = $codigo
       AND CSC.OBSERVACAO IS NOT NULL
     ORDER BY CSC.DT_CONTROLE DESC
    ";
    $result = $sql->runQuery($cSQL);
    return $result;
};

function buscaClassifCont() {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT COD_CONTA
                    ,DESCRICAO
             FROM CTB_CTACTB
             ORDER BY COD_CONTA
            ";
    $result = $sql->runQuery($cSQL);
    return $result; 
};
function buscaClassContNull() {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT CSO.CODIGO
                    ,CSO.DESCRICAO_MAT
                    ,CSO.TIPO_MAT
                    ,CSO.SOLICITANTE
                FROM CAD_SOLICITACOES CSO
                WHERE CSO.CLASSIF_CONTAB IS NULL
                AND CSO.FLG_ORCAMENTO = 'N'
                AND CSO.FLG_AGENDAMENTO = 'N'
            ";
    $result = $sql->runQuery($cSQL);
    return $result; 
};

function buscaClassifFin() {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT DESCRICAO
                    ,TO_CHAR(COD_GRUPO||','||COD_SGRUPO) AS GP_SGP
                    ,SUBSTR(LISTA.LISTA_GRUPO_COBRANCA(COD_GRUPO), 1, 40) NOME_GRUPO
                FROM SUBGRUPO_COBRANCA
                ORDER BY DESCRICAO
            ";
    $result = $sql->runQuery($cSQL);
    // print_r($result);
    return $result; 
};
function buscaClassifFinNull($filter) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT CSO.CODIGO
                    ,CSO.DESCRICAO_MAT
                    ,CSO.TIPO_MAT
                    ,CSO.SOLICITANTE
                FROM CAD_SOLICITACOES CSO
                WHERE CSO.COD_GRUPO IS NULL
                AND CSO.FLG_ORCAMENTO = 'N'
                AND CSO.FLG_AGENDAMENTO = 'N'
            ";
    $result = $sql->runQuery($cSQL);
    return $result; 
};

function alteraSolicitacao($p_upd) {
     require_once("src/config/database.php");
     $sql = new Database;

    switch ($p_upd['acao']) {
        case 'I':
            $newStatus = 1;//anlise
        break;
        case 'F':
            $newStatus = 2;//finalizado
        break;
        case 'D':
            $newStatus = 3;//pendente
        break;
        case 'R':
            $newStatus = 0;//solicitado
        break;
        case 'S':
            $newStatus = 99;//manter anterior
        break;
    }
    $cSQL = "UPDATE CAD_SOLICITACOES
                SET ANVISA          = '{$p_upd['anvisa']}'
                    ,FORNECEDOR     = {$p_upd['fornecedor']}
                    ,STATUS         = DECODE($newStatus,99,STATUS,$newStatus)
                    ,PRIORIDADE     = {$p_upd['prioridade']}
                WHERE CODIGO        = {$p_upd['codigo']}
    ";
    $sql->runDDL($cSQL);
    $cSQL = "SELECT NVL(MAX(CSC.SEQUENCIA), 0) + 1 AS SEQUENCIA
               FROM CAD_SOLICITACOES_CONTROLE CSC
              WHERE CSC.COD_SOLICITACAO = {$p_upd['codigo']}
            ";
    $result = $sql->runQuery($cSQL);
    $seq = $result[1];
    if ($p_upd['observacoes'] == null){
        if($newStatus == 2){
            $obs = "'Finalizado.'";
        }else{
            $obs = 'null';
        }
    }else{
        $obs = 'null';
    }
    $cSQL2 = "INSERT INTO CAD_SOLICITACOES_CONTROLE(COD_SOLICITACAO,SEQUENCIA,STATUS,OBSERVACAO,USUARIO)
                                            VALUES({$p_upd['codigo']}
                                                  ,{$seq['sequencia']}
                                                  ,$newStatus
                                                  ,$obs
                                                  ,'{$p_upd['usuario']}')
            ";
    $sql->runDDL($cSQL2);

};
 
