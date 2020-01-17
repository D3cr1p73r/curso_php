<?php
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
    
function preencheForm($login) {
        require_once("src/config/database.php");
        $sql = new Database;
        $cSQL = "SELECT FM.FAM_MAT_COD_FAMILIA AS COD_FAMILIA
                       ,FMM.DESCRICAO          AS DESC_FAMILIA
                  FROM FAMILIAS_MATERIAIS FM
                      ,FAMILIAS_MATERIAIS FMM
                 WHERE FM.FAM_MAT_COD_FAMILIA = FMM.COD_FAMILIA
              GROUP BY FM.FAM_MAT_COD_FAMILIA
                      ,FMM.DESCRICAO
              ORDER BY FMM.DESCRICAO  
                ";
        $result = $sql->runQuery($cSQL);
        $result = $result[1];
        return $result;
        };





function gravaSolicitacao($newData) {
    require_once("src/config/database.php");
    // echo "<br><br>Func<br>";
    // print_r($newData);
    $sql = new Database;
    $cSQL = "SELECT NVL(MAX(CODIGO),0)+1 AS CODIGO FROM CAD_SOLICITACOES";
    $result = $sql->runQuery($cSQL);
    $codigo = $result[1];
    $cSQL = "INSERT INTO CAD_SOLICITACOES(CODIGO,ANVISA,FORNECEDOR,COD_AGENDA_CCIR,NOME_MEDICO,ANEXO,PRIORIDADE,USUARIO)
             VALUES(TO_NUMBER({$codigo['codigo']})
                    ,'{$newData['anvisa']}'
                    ,{$newData['fornec']}
                    ,{$newData['agendamento']}
                    ,UPPER('{$newData['medico']}')
                    ,'{$newData['anexo']}'
                    ,TO_NUMBER({$newData['prioridade']})
                    ,UPPER('{$_SESSION[user]}'))";
    // echo          
    $sql->runDDL($cSQL);
    return$codigo['codigo'];
    };

function buscaSolicitacao($codigo) {
    require_once("recursos/db/db_teste_ha.php");
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "
            SELECT CODIGO
                   ,ANVISA
                   ,FORNECEDOR
                   ,PRIORIDADE PRIORIDADE
                   ,DECODE(PRIORIDADE, 0,'Baixa'
                                      ,1,'M�dia'
                                       ,2,'Alta') AS PRIORIDADE_DESC
                   ,STATUS
                   ,ANEXO
                   ,USUARIO
                FROM CAD_SOLICITACOES
                WHERE 1 = 1
            AND CODIGO = $codigo
    ";
    $resultQuery = $sql->runQuery($cSQL);
    $result = $resultQuery[1];
    return $result; 
};

function buscaSolicitacoes($filter) {
    require_once("src/config/database.php");
    $sql = new Database;
    $cSQL = "SELECT CODIGO
                    ,ANVISA
                    ,COD_AGENDA_CCIR
                    ,DECODE(STATUS,0,'Solicitado'
                                  ,1,'Analise'
                                  ,2,'Finalizado'
                                  ,3,'Pendente' ) AS STATUS
                    ,DECODE(PRIORIDADE ,0,'Baixa'
                                       ,1,'M�dia'
                                       ,2,'Alta') AS PRIORIDADE
                    ,USUARIO
                    ,TO_CHAR(DT_SOLIC, 'DD/MM/RRRR HH24:MI:SS') AS DT_SOLIC
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
                                       ,1,'M�dia'
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

function alteraSolicitacao($p_upd) {
     require_once("src/config/database.php");
     $sql = new Database;

    switch ($p_upd['acao']) {
        case 'I':
            $newStatus = 1;//an�lise
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
 