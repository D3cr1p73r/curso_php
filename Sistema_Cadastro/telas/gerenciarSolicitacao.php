<h4>Gerenciar SolicitaÁıes:</h4>
<?php 
    if ($_GET['cod']) :
        require_once("recursos/functions/funcoes.php");
        $solic = buscaSolicitacao($_GET['cod']);
        $obsHist = buscaHistObs($_GET['cod']);
        if (count($_POST) > 0){
            $newData = $_POST;
            if($newData['acao'] != 'S'){
                // echo "Alter Status<br>";
            }
            // print_r($_POST);
            // unset($_POST);
            if ($newData['anvisa'] != $solic['anvisa'] 
                || 
                $newData['fornecedor'] != $solic['fornecedor'] 
                || 
                $newData['prioridade'] != $solic['prioridade'] 
                || 
                $newData['observacoes'] != $solic['observacoes'] 
                ||
                $newData['acao'] != 'S'
                )
            { 
                $upd['codigo'] = $_GET['cod'];
                if ((isset($newData['anvisa']) == 1 ) and ($newData['anvisa'] != $solic['anvisa'])){
                    $upd['anvisa'] = $newData['anvisa'];
                }else{
                    $upd['anvisa'] = $solic['anvisa'];
                }

                if ((isset($newData['fornecedor']) == 1 ) and ($newData['fornecedor'] != $solic['fornecedor'])){
                    $upd['fornecedor'] = $newData['fornecedor'];
                }else{
                    $upd['fornecedor'] = $solic['fornecedor'];
                }
                
                if ((isset($newData['prioridade']) == 1 ) and ($newData['prioridade'] != $solic['prioridade'])){
                    $upd['prioridade'] = $newData['prioridade'];
                }else{
                    $upd['prioridade'] = $solic['prioridade'];
                }
                
                if ((isset($newData['observacoes']) == 1 ) 
                     and ($newData['observacoes'] != $solic['observacoes'])
                     and trim($newData['observacoes']) != null){
                    $upd['observacoes'] = $newData['observacoes'];
                }else{
                    $upd['observacoes'] = $solic['observacoes'];
                }

                $upd['acao'] = $newData['acao'];
                $upd['usuario'] = $_SESSION['user'];
                // echo "Update!!<br>";
            //  echo "Solic: ".print_r($solic);
                // echo "<br>";
                // print_r($upd);
                // echo $hein;
                alteraSolicitacao($upd);
                echo "<div class='message'>
                                <a href='index.php?file=telas/acompanharSolicitacao.php'>    
                                    Alteraùùo realizada
                                </a>
                        </div>";
            }
        }
        
?>
<div class="form-style-3">
<form action="#" method="POST" >
  <fieldset><legend>SolicitaÁ„o <?=$_GET['cod'] ?></legend>
    <div class="row">
      <div class="col-2">
        <label for="anvisa">
          <span>ANVISA </span>
              <?php if($solic['usuario'] == $_SESSION['user']) : ?>
              <input type="text" class="input-field" id="anvisa" name="anvisa"  
                    value="<?= isset($_POST['anvisa']) ? $_POST['anvisa'] : $solic['anvisa']?>" required/>
              <?php else : ?>
                <div class="blockedField">
                    <?= $solic['anvisa'] ?>
                </div>
              <?php endif ?>
        </label>
      </div> 
      <div class="col-4">
        <label for="fornecedor">
          <span>Fornecedor 
          </span>
            <?php if($solic['usuario'] == $_SESSION['user']) : ?>
                <input type="text" class="input-field" name="fornecedor" 
                    value="<?= isset($_POST['fornecedor']) ? $_POST['fornecedor'] : $solic['fornecedor'] ?>" required/>
            <?php else : ?>
                <div class="blockedField">
                    <?= $solic['fornecedor'] ?>
                </div>
            <?php endif ?>
        </label>
      </div> 
      <div class="col-2">
        <label for="solicitante">
          <span>Solicitante 
          </span>
                <div class="blockedField">
                    <?= $solic['usuario'] ?>
                </div>
        </label>
      </div> 
      <div class="col-2">
        <label for="prioridade"><span>Prioridade</span>
            <?php if($solic['usuario'] == $_SESSION['user']) : ?>
                <select name="prioridade" class="select-field">
                    <option value="0" <?php if(isset($_POST['prioridade']) == 0){if($solic['prioridade'] == 0){echo 'selected';}}else{if($_POST['prioridade'] == 0){echo 'selected';}}?> >Baixa</option>
                    <option value="1" <?php if(isset($_POST['prioridade']) == 0){if($solic['prioridade'] == 1){echo 'selected';}}else{if($_POST['prioridade'] == 1){echo 'selected';}} ?> >Media</option>
                    <option value="2" <?php if(isset($_POST['prioridade']) == 0){if($solic['prioridade'] == 2){echo 'selected';}}else{if($_POST['prioridade'] == 2){echo 'selected';}} ?> >Alta</option>
                </select>
            <?php else : ?>
                <div class="blockedField">
                    <?= $solic['prioridade_desc'] ?>
                </div>
            <?php endif ?>   
        </label>
      </div>
      <div class="col-2">
          <?php if($solic['status'] != 2): ?>
            <label for="acao"><span>Aùùo</span>
            <select name="acao" class="select-field">
                <?php if($solic['status'] != 1){echo "<option value='I'>Iniciar</option>";} ?>
                <option value='F'>Finalizar</option>
                <!-- fazer essa validaùùo pelo codigo da ùrea -->
                <?php
                    if($_GET['tipo']=='acom'){
                        echo "<option value='D'>Devolver</option>";
                    }elseif($_GET['tipo']=='pend'){
                        echo "<option value='R'>Reencaminhar</option>";
                    }
                    ?>
                <option value="S" selected><i>Selecione</i></option>
            </select>
            </label>
            <?php else : ?> 
                <label for="Status">
                    <span>Status </span>
                    <div class="blockedField">
                            Finalizado
                     </div>
                </label>
            <?php endif ?> 
      </div>
      <?php if($solic['anexo']) : ?>
        <div class="col-1">
            <label for="anexo">
            <span>Anexo 
                <?php 
                    echo "<a href='{$solic['anexo']}' target='_blank'>
                                <img class='icon_m' src='src/img/anexo.png'>
                        </a>"
                ?>
            </label>
        </div> 
      <?php endif?>
      <div class="col-12"> 
        <label for="observacoes">
            <span>Observaùùes:</span>
            <textarea name="observacoes" class="textarea-field"><?php if($_POST['observacoes'] != null){ echo $_POST['observacoes'];} ?></textarea>
        </label>
        <input type="submit" value="Gravar" />
      </div>
      <div class="col-12"> 
        <label for="obsHistorico">
            <span>Observaùùes - Histùrico:</span>
            <div class="blockedField_div">
                    <?php if(count($obsHist) > 0){
                        foreach($obsHist as $obs){
                                // print_r( $obs);
                                echo "{$obs[data]} - 
                                      <span class='required'>{$obs[usuario]}:</span>
                                      <span class='green'>{$obs[obs]}</span><br>";
                        }}
                    ?>
            </div>
        </label>
       </div>
    </fieldset>
</form>
</div>
    <?php else:
    echo "<div class='message'>
                <a href='index.php?file=telas/acompanharSolicitacao.php'>    
                    Selecione uma solicitaùùo na tela de Acompanhamento
                </a>
          </div>";
    endif
?>
