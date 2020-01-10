<link rel='stylesheet' href='../recursos/css/style.css'>
<br>Acompanhar solicitações?
<div class='row'>
    <div class='col-10'>
        <table id='table'>
            <tr>
                <th>Codigo</th>
                <th>Agendamento</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>ANVISA</th>
                <th>Solicitante</th>
                <th>Data Solicitacao</th>
                <th>Status</th>
                <th>Status</th>
                <th>Prioridade</th>
                <th>Ações</th>
            </tr>             
        <?php for ($i = 1; $i <= 100; $i++){
                echo  "<tr>
                            <td>$i</td>
                            <td>$i</td>
                            <td>$i</td>
                            <td>$i</td>
                            <td>$i</td>
                            <td>$i</td>
                            <td>".date("d/m/Y")."</td>
                            <td>Solicitado</td>
                            <td>$i</td>
                            <td>ACD</td>
                        </tr>";
                }
        ?>
        </table>
    </div>
    <br>
    <div class='col-2 sticky border-round'>
        <form action="#">
            Filtros:
            <br>
            <select id="filtors" name="filtros">
                <option value="Todas">Todas</option>
                <option value="Solicitadas">Solicitadas</option>
                <option value="EmAnalise">Em Análise</option>
                <option value="Finalizadas">Finalizadas</option>
            </select>
  
            <input type="submit" value="Filtrar">
        </form>
    </div>
</div>
    