<!-- <h4>Gerenciar Solicitações:</h4> -->
<?php 
    if ($_GET['cod']) :
        require_once("src/functions/funcoes.php");
        $solic = buscaSolicitacao($_GET['cod']);
        $anexos = buscaAnexo($_GET['cod']);
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
                                    Alteração realizada
                                </a>
                        </div>";
            }
        }
        // print_r($anexos);
?>
<div class="form-style-3">
 <!-- =======INICIO FORM======    -->
<form action="#" method="POST">
  <fieldset>
    <legend>Solicitação <?=$_GET['cod'] ?></legend>
    <!-- ============================================= -->
    <div class="row"> <!-- row -->
           <!-- =========================VIGENCIA  -->
        <div class="col-2">
            <label for="vigencia">
                <span>Vigencia</span>
                <input type="text" class="input-field" id="vigencia" name="vigencia"  value="<?= $solic['dt_vigencia'] ?> " required disabled/>
            </label>
        </div> 
           <!-- =========================PRIORIDADE  -->
        <div class="col-1">
            <label for="prioridade">
                <span>Prioridade</span>
                <input type="text" class="input-field" id="prioridade" name="prioridade"  value="<?= $solic['prioridade'] ?> " required disabled/>
            </label>
        </div> 
      <!-- ======DESCRIÇÃO============= -->
        <div class="col-4">
            <label for="descMat">
                <span>Descrição </span>
                <input type="text" class="input-field" id="descMat" name="descMat"  value="<?= $solic['descricao_mat'] ?> " required disabled/>
          </label>
        </div> 
      <!-- ======TIPO MATERIAL============= -->
        <div class="col-3">
            <label for="tipoMat">
                <span>Tipo Material </span>
                <input type="text" class="input-field" id="tipoMat" name="tipoMat"  value="<?= $solic['tipo_mat'] ?> " required disabled/>
          </label>
        </div> 
        <!-- ================ACAO============== -->
        <div class="col-2">
          <?php if($solic['status'] != 2): ?>
            <label for="acao"><span>Ação</span>
                <select name="acao" class="select-field">
                    <?php if($solic['status'] != 1){echo "<option value='I'>Iniciar</option>";} ?>
                    <option value='F'>Finalizar</option>
                    <!-- fazer essa validao pelo codigo da rea -->
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
    </div> <!-- row -->
    <!-- <hr> -->

    <!-- ====================Dados do Material======================= -->
    <div id="matData">
      <div  <?php if($solic['flg_orcamento'] == 'S'){echo "class='d-none'";} else{echo "class='row'";}?> >
             <!-- ======MANIPULADO============= -->
        <div class="col-1">
            <label for="manipulado">
                <span>Manipulado </span>
                <input type="text" class="input-field" id="manipulado" name="manipulado"  value="<?= $solic['manipulado'] ?> " required disabled/>
          </label>
        </div> 

      <!-- ================================APRESENTACAO -->
        <div class="col-3">
            <label for="apresentacao">
                <span>Forma Apresentacao </span>
                <input type="text" class="input-field" id="apresentacao" name="apresentacao"  value="<?= $solic['FORMA_AP'] ?> " required disabled/>
          </label>
        </div> 
    <!-- ===========================ANVISA -->
        <div class="col-2">
            <label for="anvisa">
                <span>Anvisa</span>
                <input type="text" class="input-field" id="anvisa" name="anvisa"  value="<?= $solic['FORMA_AP'] ?> " required disabled/>
          </label>
        </div> 
    <!-- ===========================REF FABRICANTE -->
        <div class="col-2">
            <label for="refFabricante">
                <span>Ref. Fabricante </span>
                <input type="text" class="input-field" id="refFabricante" name="refFabricante"  value="<?= $solic['ref_fabricante'] ?> " required disabled/>
          </label>
        </div> 
        <!-- ======================TIPO DEMANDA -->
        <div class="col-2">
            <label for="tipoDemanda">
                <span>Tipo de Demanda </span>
                <input type="text" class="input-field" id="tipoDemanda" name="tipoDemanda"  value="<?= $solic['tipo_demanda'] ?> " required disabled/>
            </label>
        </div> 
        <!-- ===========================FRACIONADO -->
        <div class="col-1">
            <label for="fraciona">
                <span>Fraciona</span>
                <input type="text" class="input-field" id="fraciona" name="fraciona"  value="<?= $solic['fraciona'] ?> " required disabled/>
            </label>
        </div> 
        <!-- ===========================MOVIMENTA ESTOQUE -->
        <div class="col-1">
            <label for="movEst">
                <span>Mov. Est.</span>
                <input type="text" class="input-field" id="movEst" name="movEst"  value="<?= $solic['mov_est'] ?> " required disabled/>
            </label>
        </div> 
            
            <!-- ===========================MOVIMENTA SUB-ESTOQUE -->
        <div class="col-2">
            <label for="movSubEst">
                <span>Mov. Sub. Est.</span>
                <input type="text" class="input-field" id="movSubEst" name="movSubEst"  value="<?= $solic['mov_sub_est'] ?> " required disabled/>
            </label>
        </div> 
        <!-- ================Centro de custo -->
        <div class="col-2">
            <label for="centroCusto">
                <span>Centro de Custo</span>
                <input type="text" class="input-field" id="centroCusto" name="centroCusto"  value="<?= $solic['centro_custo'] ?> " required disabled/>
            </label>
        </div> 
        <!-- ========================CLASSIF CONTABIL -->
        <div class="col-3">
            <label for="classCont">
                <span>Classificação Contabil</span>
                <input type="text" class="input-field" id="classCont" name="classCont"  value="<?= $solic['class_cont'] ?> " required disabled/>
            </label>
        </div> 
        <!-- ========================CLASS FIN -->
        <div class="col-3">
            <label for="classFin">
                <span>Sub Grupo Receita/Despesa</span>
                <input type="text" class="input-field" id="classFin" name="classFin"  value="<?= $solic['class_fin_desc'] ?> " required disabled/>
            </label>
        </div> 
      </div><!-- Fim row -->
    </div>
  <!-- <hr id="hrMat"> -->
<!-- ===================Dados do Agendamento============== -->
    <div  <?php if($solic['flg_agendamento'] == 'N'){echo "class='d-none'";} else{echo "class='row'";}?>>
        <!-- ==============AGENDAMENTO========= -->
        <div class="col-2">
            <label for="agendamento">
                <span>Agendamento:</span>
                <input type="text" class="input-field" id="agendamento" name="agendamento"  value="<?= $solic['cod_agenda_ccir'] ?> " required disabled/>
            </label>
        </div> 
        <!-- =============MEDICO====== -->
        <div class="col-4">
            <label for="medico">
                <span>Nome do Médico:</span>
                <input type="text" class="input-field" id="medico" name="medico"  value="<?= $solic['nome_medico'] ?> " required disabled/>
            </label>
        </div> 
      <!-- </div> -->
     
    </div>
    <hr <?php if($solic['flg_agendamento'] == 'N'){echo "class='d-none'";} else{echo "class='d-block'";}?>>
    <div class="row">
        <div class="col-12">
            <span style="color: black;font-weight: bold;font-size: 13px;">Anexos</span>
        </div>
        <?php 
        if(isset($anexos)==1){
            foreach($anexos as $anexo){
                echo "<div class='col-6 '>
                        <div class='anexo'>
                        <a href='{$anexo['path_anexo']}' target='_blank'>{$anexo['nome_arquivo']}</a>
                        </div>
                </div>";
            } 
        }else{
            echo "<div class='col-6 '>
                    <span style='color:red;font-size: 13px;'>Nenhum anexo inserido.</span>
                  </div>";
        }
        ?>

    </div>


      <!-- =================================================================================================== -->
      <div class="col-12"> 
        <label for="observacoes">
            <span>Observações:</span>
            <textarea name="observacoes" class="textarea-field"><?php if($_POST['observacoes'] != null){ echo $_POST['observacoes'];} ?></textarea>
        </label>
        <input type="submit" value="Gravar" />
      </div>
      <div class="col-12"> 
        <label for="obsHistorico">
            <span>Observações - Histórico:</span>
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
                Selecione uma solicitação na tela de Acompanhamento
            </a>
        </div>";
endif
?>
