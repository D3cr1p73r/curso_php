<!-- <h4>Preencha o formulário de solicitação:</h4> -->
<?php
  unset($_SESSION['tela']);   
  unset($_SESSION['cod_sol']);
  // print_r($_FILES);
  // unset($_POST);
  require_once("src/functions/funcoes.php");
  setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8');
  $tipoMat = preencheTipoMat();
  $classCont = buscaClassifCont();
  $classFin = buscaClassifFin();


  // print_r($_POST);
  if (isset($_POST['dtVigencia']) && $_POST['dtVigencia'] != '' && $_POST['salvo'] != 1)
  {
      // ===gravar no banco =====
      $newData = $_POST;
      $codSolicitacao = gravaSolicitacao($newData);
      if($_FILES && $_FILES['anexo']){
        gravaAnexos($_FILES,$codSolicitacao);
      }
      header("LOCATION:index.php?file=telas/solicitarCadastro.php");
      $_SESSION['tela'] = 'solicitar';
      $_SESSION['cod_sol'] = $codSolicitacao;

      // unset($_POST);
      // unset($_FILES);
      // unset($newData);
      // print_r($_POST);

      // echo "<br>";
      // print_r($newData);
  }


  ?>
<div class="form-style-3">
  <!-- Inicio Form -->
  <form action="#" name="solicitacao" method="POST" enctype="multipart/form-data">
  <fieldset><legend>Dados do Material</legend>
    <div class="row"> <!-- row -->
      <div class="col-2 border font_size_small"> <!-- col -->
        <label>Possui orçamento?</label>
        <div class="custom-control-inline">
          <label for="rdOrcSim">Sim</label>
          <input type="radio" name="rdOrcamento" value="S">
        </div>
        <div class="custom-control-inline">
          <label for="rdOrcNao">Não</label>
          <input type="radio" name="rdOrcamento" value="N" checked = "checked" >
        </div>
      </div> <!-- col -->
      <div class="col-2 border font_size_small"> <!-- col -->
        <label>Possui agendamento?</label>
        <div class="custom-control-inline">
          <label for="rdAgeSim">Sim</label>
          <input type="radio" name="rdAgendamento" value="S" checked = "checked">
        </div>
        <div class="custom-control-inline">
          <label for="rdAgeNao">Não</label>
          <input type="radio" name="rdAgendamento" value="N"  >
        </div>
      </div> <!-- col -->
           <!-- =========================VIGENCIA  -->
           <div class="col-2">
        <label for="">
            <span>Data de Vigência: 
              <span class="required">*</span> 
            </span>
            <input type="date" class="input-field" id="dtVigencia" name="dtVigencia" required />
          </label>
        </div> 
      <div class="col-2">
        <label for="prioridade"><span>Prioridade</span>
        <select name="prioridade" class="select-field">
          <option value="1">Baixa</option>
          <option value="2">Media</option>
          <option value="3">Alta</option>
        </select>
        </label>
      </div>
    </div> <!-- row -->
    <hr>

    <!-- ====================Dados do Material======================= -->
    <div id="matData">
      <div class="row" >
        <!-- ======DESCRIÇÃO============= -->
        <div class="col-4">
          <label for="descMat">
            <span>Descrição 
              <span class="required">*</span>
            </span>
            <input type="text" class="input-field" id="descMat" name="descMat"  value="" required/>
          </label>
        </div> 
        <!-- ========================TIPO -->
        <div class="col-3">
          <label for="tipoMat"><span>Tipo
            <span class="required">*</span>
          </span> 
          <select name="tipoMat" id="tipoMat" class="select-field" data-live-search="true">
            <?php foreach($tipoMat as $tipo) 
                    echo "<option data-fam='{$tipo['cod_tipo']}' value={$tipo['cod_tipo']}>{$tipo['desc_tipo']}</option>";
                    echo "<option data-fam='0' value='0' selected><i>Selecione</i></option>";
            ?>
            </select>
          </label>
        </div>
        <!-- ===========================MANIPULADO -->
        <div class="col-1" >
          <label for="manipulado"><span>Manipulado<span class="required">*</span></span>
          <select name="manipulado" id="manipulado" class="select-field" style="background-color:#EEEEEE;"
                  data-live-search="true" disabled required>
            <option value='NULL' selected >...</option>
            <option value="'N'">Não</option>
            <option value="'S'">Sim</option>
          </select>
        </label>
      </div>
      <!-- ================================APRESENTACAO -->
      <div class="col-2" id="divApresentacao" >
        <label for="apresentacao"><span>Forma Apresentacao<span class="required">*</span></span>
        <input type="text" class="input-field" name="apresentacao" id="apresentacao" 
              style="background-color:#EEEEEE;" disabled required/>
      </label>
    </div>
    <!-- ===========================ANVISA -->
    <div class="col-2" id="divAnvisa">
      <label for="anvisa">
        <span>ANVISA 
          <span id="spanAnvisa" class="required">*</span>
        </span>
        <input type="text" class="input-field" id="anvisa" name="anvisa"  value=""/>
      </label>
      <div style="display: inline-flex;">
        <input type="checkbox" id="chkAnvisa" name="chkAnvisa" onclick="fChkAnv()">
        <span style="font-size: 12px;margin-top: 3px;">Não se aplica</span>
      </div>
    </div>
    <!-- </div> -->
    <!-- <div class="row" > -->
      <div class="col-3">
        <label for="refFabricante">
          <span>Referencia do Fabricante 
            <span class="required">*</span>
          </span>
          <input type="text" class="input-field" id="refFabricante" name="refFabricante"  value=""/>
        </label>
      </div> 
      <!-- ======================TIPO DEMANDA -->
      <div class="col-2">
        <label for="tipoDemanda">
          <span>Tipo de Demanda
            <span class="required">*</span>
          </span>
          <select name="tipoDemanda" id="tipoDemanda" class="select-field" style="background-color:#EEEEEE;"
                  data-live-search="true" disabled required>
            <option value='' selected >...</option>
            <option value='1'>Consumo</option>
            <option value='2'>Compra</option>
            <option value='3'>Consignação</option>
            <option value='4'>Consignação/Estoque</option>
          </select>
        </label>
      </div> 
      <!-- ===========================FRACIONADO -->
        <div class="col-1" >
          <label for="fraciona"><span>Fraciona<span class="required">*</span></span>
            <select name="fraciona" id="fraciona" class="select-field" data-live-search="true"
                      style="background-color:#EEEEEE;" data-live-search="true" disabled required>
              <option value='' selected >...</option>
              <option value='N'>Não</option>
              <option value='S'>Sim</option>
            </select>
          </label>
        </div>
      <!-- ===========================MOVIMENTA ESTOQUE -->
        <div class="col-2" id="divMovEst" >
          <label for="movEst"><span>Movimenta Estoque<span class="required">*</span></span>
            <select name="movEst" id="movEst" class="select-field" data-live-search="true">
              <option value='N'>Não</option>
              <option value='S' selected>Sim</option>
            </select>
          </label>
        </div>
      <!-- ===========================MOVIMENTA SUB-ESTOQUE -->
        <div class="col-2" id="divMovSubEst" >
          <label for="movSubEst"><span>Mov. Sub-Estoque<span class="required">*</span></span>
            <select name="movSubEst" id="movSubEst" class="select-field" data-live-search="true">
              <option value='N'>Não</option>
              <option value='S' selected>Sim</option>
            </select>
          </label>
        </div>
        <!-- ================Centro de custo -->
        <div class="col-2">
        <label for="centroCusto">
          <span>Centro de Custo
            <span class="required">*</span>
          </span>
          <input type="text" class="input-field" id="centroCusto" name=""  value=""/>
        </label>
      </div> 
       <!-- ========================CLASSIF CONTABIL -->
       <div class="col-3">
          <label for="classCont"><span>Classificação Contabil
            <span class="required">*</span>
          </span> 
          <select name="classCont" id="classCont" class="select-field" data-live-search="true">
            <?php foreach($classCont as $cont) 
                    echo "<option data-fam='{$cont['cod_conta']}' value={$cont['cod_conta']}>{$cont['descricao']}</option>";
                    echo "<option data-fam='' value='' selected><i>Selecione</i></option>";
            ?>
            </select>
          </label>
        </div>
       <!-- ========================CLASS FIN -->
       <div class="col-3">
          <label for="classFin"><span>Sub Grupo Receita/Despesa
            <span class="required">*</span>
          </span> 
          <select name="classFin" id="classFin" class="select-field" data-live-search="true">
            <?php foreach($classFin as $fin) 
                    echo "<option data-fam='{$fin['gp_sgp']}' value={$fin['gp_sgp']}>{$fin['descricao']}</option>";
                    echo "<option data-fam='' value='null,null' selected><i>Selecione</i></option>";
            ?>
            </select>
          </label>
        </div>
  </div><!-- Fim row -->
</div>
  <hr id="hrMat">
<!-- ===================Dados do Agendamento============== -->
    <div class="row" id="ageData">
      <div class="col-2">
        <label for="agendamento">
          <span>Agendamento: 
            <span class="required" id="spanAgend" name="spanAgend">*</span>
            </span>
            <input type="text" class="input-field" id="agendamento" name="agendamento"
            value="<?=  isset($_POST['agendamento']) ? $_POST['agendamento'] : ""; ?>" required/>
          </label>
        </div> 
        <div class="col-4">
          <label for="medico">
            <span>Nome do Médico: 
              <span class="required">*</span> 
            </span>
            <input type="text" class="input-field" id="medico" name="medico" 
                    value="<?=  isset($_POST['medico']) ? $_POST['medico'] : ""; ?>" required />
          </label>
        </div> 
      </div>
      <hr id="hrAge">
      <!-- ===================Dados do Agendamento============== -->
      <!-- ==================================ANEXO  -->
    <div class="row">
      <div class="col-8">
        <span style="color: black;font-weight: bold;font-size: 13px;">Anexo 
          <span id='span_anexo' class="required d-none">*</span>
        </span>
      <label for="anexo">
        <div class="custom-control-inline">
          <input type="file" class="input-field" name="anexo"  id="anexo">
          <a href="#" class='abtn' style="vertical-align: sub;"  id="btnAdicionaEmail" >
              <i class="fas fa-plus"></i>
          </a>
        </div>
      </label>
      <div id="imendaHTMLanexo"></div>
     </div>
     <!-- ------botao -->
      <div class="col-12">
          <button>Enviar</button>
      </div>
      </div>
  </div>
</fieldset>
<!-- fim Form -->
</form>
</div>

<script src="https://kit.fontawesome.com/25fe18b66a.js" crossorigin="anonymous"></script>
<script src="src/js/jquery-3.4.1.min.js"></script>

<script type="text/javascript">
  var orc = document.solicitacao.rdOrcamento;
  var age = document.solicitacao.rdAgendamento;
  var flgOrc = null;
  
  // Radio Orçamento
  orc[0].addEventListener('change', function() 
  {
    $("#matData").addClass("d-none");
    $("#hrMat").addClass("d-none");
    $("#span_anexo").removeClass("d-none");
    document.getElementById("anexo").required = true;
    $("#matData").prop("disabled", true);
    $("#descMat").prop("disabled",true);
    $("#tipoMat").prop("disabled",true);
    $("#manipulado").prop("disabled",true);
    $("#apresentacao").prop("disabled",true);
    $("#anvisa").prop("disabled",true);
    $("#refFabricante").prop("disabled",true);
    $("#tipoDemanda").prop("disabled",true);
    $("#fraciona").prop("disabled",true);
    $("#movEst").prop("disabled",true);
    $("#tipoDemanda").prop("disabled",true);
    
  });
  orc[1].addEventListener('change', function() 
  {
    $("#matData").removeClass("d-none");
    $("#hrMat").removeClass("d-none");
    $("#span_anexo").addClass("d-none");
    document.getElementById("anexo").required = false;
    $("#matData").prop("disabled", false);
    $("#matData").setAttr("required");
    $("#descMat").prop("disabled",false);
    $("#descMat").setAttr("required");
    $("#tipoMat").prop("disabled",false);
    $("#manipulado").prop("disabled",false);
    $("#apresentacao").prop("disabled",false);
    $("#anvisa").prop("disabled",false);
    $("#refFabricante").prop("disabled",false);
    $("#tipoDemanda").prop("disabled",false);
    $("#fraciona").prop("disabled",false);
    $("#movEst").prop("disabled",false);
    $("#tipoDemanda").prop("disabled",false);
  });
  // fim radio orçamento
  // Radio Agendamento
  age[0].addEventListener('change', function() 
  {
    $("#ageData").removeClass("d-none");
    $("#hrAge").addClass("d-none");
    $("#span_anexo").removeClass("d-none");
    document.getElementById("anexo").required = true;
    document.getElementById("agendamento").required = true;
    document.getElementById("medico").required = true;
  });
  age[1].addEventListener('change', function() 
  {
    $("#ageData").addClass("d-none");
    $("#hrAge").addClass("d-none");
    document.getElementById("anexo").required = false;
    document.getElementById("agendamento").required = false;
    document.getElementById("medico").required = false;
  });
    
  function fChkAnv() {
    var checkBox = document.getElementById("chkAnvisa");
    var anv = document.getElementById("anvisa");
    if (checkBox.checked == true){
      anv.disabled = true;
      anv.style.backgroundColor = "#EEEEEE";
      $("#spanAnvisa").addClass("d-none");
      $("#manipulado").val("null");
    } 
    else {
      anv.disabled = false;
      anv.style.backgroundColor = "white";
      $("#spanAnvisa").removeClass("d-none");
    }
  }
  //fim chk Anvisa

  // fim radio Agendamento


    $('#tipoMat').on('change', function(event) {
        /*Pega o valor do option do select*/
        var tipoMat = $(this).closest('select').find('option:selected').data('tipo');
        var value = $(this).val();
        var manip = document.getElementById("manipulado");
        var formAp = document.getElementById("apresentacao");
        var tpDem = document.getElementById("tipoDemanda");
        var frac = document.getElementById("fraciona");

        //manipulado------------------------------
        if(value == 2){ 
          manip.style.backgroundColor = "white";
          $("#manipulado").removeAttr("disabled");
        }
        else{
          $("#manipulado").prop("disabled", true);
          manip.style.backgroundColor = "#EEEEEE";
          $("#manipulado").val("");
        }//---------------------------------------

        //apresentacao-----------------------------
        if((value == 2)||(value == 62)||(value == 42)){
          formAp.style.backgroundColor = "white";
          $("#apresentacao").removeAttr("disabled");
        }
        else{
          $("#apresentacao").prop("disabled", true);
          formAp.style.backgroundColor = "#EEEEEE";
          $("#apresentacao").val("");
        }//-----------------------------------------

        //tipoDemanda-------------------------------
        if((value == 42)||(value == 82)){ 
          tpDem.style.backgroundColor = "white";
          $("#tipoDemanda").removeAttr("disabled");
        }
        else{
          $("#tipoDemanda").prop("disabled", true);
          tpDem.style.backgroundColor = "#EEEEEE";
          $("#tipoDemanda").val("");
        }//-----------------------------------------

        //fraciona----------------------------------
        if((value == 2)||(value == 62)){ 
          frac.style.backgroundColor = "white";
          $("#fraciona").removeAttr("disabled");
        }
        else{
          $("#fraciona").prop("disabled", true);
          frac.style.backgroundColor = "#EEEEEE";
          $("#fraciona").val("");
        }//-----------------------------------------

    });

</script>
<!-- Script para adicionar mais campos de anexo -->
<script type="text/javascript">
	 var idContador = 0;
  	function exclui(id){
    var campo = $("#"+id.id);
		campo.hide(200);
	}
	$( document ).ready(function() {
		$("#btnAdicionaEmail").click(function(e){
			e.preventDefault();
			var tipoCampo = "anexo";
			adicionaCampo(tipoCampo);
		})
		function adicionaCampo(tipo){
      // idContador = 1;
      idContador++;
			var idCampo = "field"+idContador;
			var idForm = "form"+idContador;
      var html = "";
      html += "<div class='row'>"
        html += "<div class='custom-control-inline' id='"+idForm+"'>";
          html += "<label for='"+idCampo+"'>";
			    html += "<input type='file' id='"+idCampo+"' name='"+idCampo+"' class='input-field'/>";
			    html += "</label>";
          html +=	"<button onclick='exclui("+idForm+")' type='button'><i class='far fa-trash-alt'></i></button>";
			  html += "</div>";
			html += "</div>";
			$("#imendaHTML"+tipo).append(html);
		}
  });
  
	</script>
