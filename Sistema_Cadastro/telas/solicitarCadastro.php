<h4>Preencha o formul·rio de solicitaÁ„o:</h4>
<?php
  // echo $_SESSION['user'];
  require_once("recursos/functions/funcoes.php");
  // require_once("../../anexos/solicitacao_cadastro/anexos.php");
  // require_once("../../../anexos/solicitacao_cadastro/anexos.php");

  // print_r($_FILES);
  if($_FILES && $_FILES['anexo']) {
    // $pastaUpload = 'anexos/';
    $pastaUpload = '../../anexos/solicitacao_cadastro/';
    $nomeArquivo = "solic_".$return."_".$_FILES['anexo']['name'];
    $pathFile = "//192.168.10.27/anexos/solicitacao_cadastro/".$nomeArquivo;
    $arquivo = $pastaUpload . $nomeArquivo;
    $tmp = $_FILES['anexo']['tmp_name'];
    
    if (!move_uploaded_file($tmp, $arquivo)) {
      echo "<br>Erro no upload de arquivo!";
    }
    // ECHO "$pathFile<br>";
    // echo "<a href='$pathFile' target='_blank' > arquivo</a>";
  }
  
  if (isset($_POST['anvisa']))
  {
    if ( $_POST['anvisa'] != null){
      // ===gravar no banco =====
      $newData = $_POST;
      $newData['anexo'] = $pathFile;
      $return = gravaSolicitacao($newData);
      unset($_POST);
    }
  }
  ?>
<?php  if ($return != null):?>
  <div class="message">
    <a href='index.php?file=telas/acompanharSolicitacao.php'>
    SolicitaÁ„o <?=$return?> gravada. Clique para voltar ù consulta
  </a>
</div>
<?php endif ?>
<div class="form-style-3">
  <form action="#" method="POST" enctype="multipart/form-data">
  <fieldset><legend>Dados do Material</legend>
    <div class="row">
      <div class="col-2">
        <label for="descMat">
          <span>DescriÁ„o 
              <span class="required">*</span>
          </span>
              <input type="text" class="input-field" id="descMat" name="descMat"  value="" required/>
        </label>
      </div> 
      <div class="col-2">
        <label for="tipoMat"><span>Tipo</span>
          <select name="tipoMat" class="select-field">
            <option value="0">Baixa</option>
            <option value="1">Media</option>
            <option value="2">Alta</option>
          </select>
        </label>
      </div>
      <div class="col-2">
        <label for="refFabricante">
          <span>Referencia Fabricante 
              <span class="required">*</span>
          </span>
              <input type="text" class="input-field" id="refFabricante" name="refFabricante"  value="" required/>
        </label>
      </div> 
      <div class="col-2">
        <label for="anvisa">
          <span>ANVISA 
              <span class="required">*</span>
          </span>
              <input type="text" class="input-field" id="anvisa" name="anvisa"  value="" required/>
        </label>
      </div> 
      <div class="col-2">
        <label for="fornec">
          <span>Fornecedor(Codigo) 
            <span class="required">*</span>
          </span>
            <input type="text" class="input-field" name="fornec" id="fornec" value="" required/>
        </label>
      </div> 
      <div class="col-2">
        <label for="prioridade"><span>Prioridade</span>
          <select name="prioridade" class="select-field">
            <option value="0">Baixa</option>
            <option value="1">Media</option>
            <option value="2">Alta</option>
          </select>
        </label>
      </div>
    </div>
  <!-- </fieldset>
  <fieldset> -->
    <!-- <legend>Dados do Procedimento</legend> -->
    <span>Dados do Procedimento:</span>
    <div class="row">
      <div class="col-2">
        <label for="agendamento">
          <span>Agendamento: <span class="required">*</span> </span>
              <input type="text" class="input-field" id="agendamento" name="agendamento"
                  value="<?=  isset($_POST['agendamento']) ? $_POST['agendamento'] : ""; ?>" required/>
        </label>
      </div> 
      <div class="col-4">
        <label for="medico">
          <span>Nome do Mùdico: <span class="required">*</span> </span>
              <input type="text" class="input-field" id="medico" name="medico" value="<?=  isset($_POST['medico']) ? $_POST['medico'] : ""; ?>" />
        </label>
      </div> 
    <!-- </div> -->
      <div class="col-6">
        <label for="anexo">
          <span>Anexo</span>
           <input type="file" class="input-field" name="anexo"  id="anexo">
        </label>
      </div> 
    </div>
    <div class="col-12">
      <!-- <label><input type="submit" value="Gravar" /></label> -->
      <button>Enviar</button>
    </div>
  </fieldset>
  <!-- <fieldset><legend>Message</legend>
  <label for="field6"><span>Message <span class="required">*</span></span><textarea name="field6" class="textarea-field"></textarea></label>
  <label><span> </span><input type="submit" value="Gravar" /></label>
</fieldset> -->

</form>
</div>
