<script src="https://kit.fontawesome.com/25fe18b66a.js" crossorigin="anonymous"></script>
<meta charset="windows-1252">
<h4>Acompanhar Solicitações:</h4>
<?php
// require_once("recursos/db/db_teste_ha.php");
require_once("src/functions/funcoes.php");
$filter['status'] = 99;
$filter['prioridade'] = 99;
if(isset($_POST['status']) == 1){
    $filter['status'] = $_POST['status'];
}else{
    $filter['status'] = 99;
}

if(isset($_POST['prioridade'])){
    $filter['prioridade'] = $_POST['prioridade'];
}else{
    $filter['prioridade'] = 99;
}

$solicitacoes = buscaSolicitacoes($filter);
?>
<div class='row'>
    <div class='col-11'>
        <table id='table'>
            <tr>
                <th>Cod.</th>
                <th>Status</th>
                <th>Prioridade</th>
                <th>Solicitante</th>
                <th>Data Solicitacao</th>
                <th>Ações</th>
            </tr>             
        <?php 
            // for ($i = 1; $i <= count($numero); $i++){
            if(isset($solicitacoes)){   
                foreach($solicitacoes as $solic){
                echo  "<tr>
                            <td>{$solic['codigo']     }  </td>
                            <td>{$solic['status']     }  </td>
                            <td>{$solic['prioridade'] }  </td>
                            <td>{$solic['solicitante']}  </td>
                            <td>{$solic['dt_solicitacao']}  </td>
                            <td>
                                <a class='tooltip' href='index.php?file=telas/gerenciarSolicitacao.php&cod={$solic['codigo']}&tipo=acom'>
                                <i class='fas fa-cog'></i>
                                    <span class='tooltiptext'>Gerenciar</span>
                                </a>
                            </td>
                       </tr>";
                }}
                // }
        ?>
        </table>
    </div>
    <br>
    <div class='col-1 sticky border-round form-style-3'>
        <form action="#" method="post">
            Filtros:
            <div>
            <label for="status">
                <span>Status:</span>
                <select id="status" name="status">
                        <option value="99">Todas</option>
                        <option value="0">Solicitadas</option>
                        <option value="1">Em Análise</option>
                        <option value="2">Finalizadas</option>
                        <option value="3">Pendente</option>
                </select>
            </label>
            <label for="prioridade">  
            <span>Prioridade:</span>   
                <select id="prioridade" name="prioridade">
                    <option value="99">Todas</option>
                    <option value="0">Baixa</option>
                    <option value="1">Média</option>
                    <option value="2">Alta</option>
                </select>
            </label>
            </div>
            <div>
                <input style="width: 100%;" type="submit" value="Filtrar">
            </div>
        </form>
    </div>
</div>

