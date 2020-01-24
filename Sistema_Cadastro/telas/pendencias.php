<h4>Pendencias</h4>
<?php   
require_once("src/functions/funcoes.php");
$solicitacoes = buscaSolicitacoesPend($_SESSION['user']);
?>
<div class='row'>
    <div class='col-11'>
        <table id='table'>
            <tr>
                <th>Cod.</th>
                <th>Anvisa</th>
                <th>Agendamento</th>
                <th>Status</th>
                <th>Prioridade</th>
                <th>Data Solicitacao</th>
                <th>Ações</th>
            </tr>             
        <?php 
            // for ($i = 1; $i <= count($numero); $i++){
            if ($solicitacoes){                
                foreach($solicitacoes as $solic){
                echo  "<tr>
                            <td>{$solic['codigo']     }  </td>
                            <td>{$solic['anvisa']     }  </td>
                            <td>{$solic['cod_agenda_ccir']}  </td>
                            <td>{$solic['status']     }  </td>
                            <td>{$solic['prioridade'] }  </td>
                            <td>{$solic['dt_solic']}  </td>
                            <td>
                            <a class='tooltip' href='index.php?file=telas/gerenciarSolicitacao.php&cod={$solic['codigo']}&tipo=acom'>
                                <img class='icon' src='src/img/lupa.png'>
                                <span class='tooltiptext'>Gerenciar</span>
                            </a>
                        </td>
                       </tr>";
                }
            }
        ?>
        </table>
    </div>
</div>