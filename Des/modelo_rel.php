<!doctype html>
<html lang="en">
  <head>
  <style>
  @page /*para não mostrar o cabeçalho do navegador ao imprimir*/
    {
        size: auto;   /* auto is the initial value */
        margin: 5mm;  /* this affects the margin in the printer settings */
    }
	p {
	  border-top-style: solid;
	  border-width: 1px 0px 0px 0px;
	}
  </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>RHCCI039</title>
	<link rel="stylesheet" href="recursos/icons/fontawesome5/css/all.css">
	<link rel="stylesheet" href="recursos/icons/fontawesome5/css/fontawesome.min.css">
  </head>
  <body border="black" >
  </br>
	<div class="container">
		   <div class="row justify-content-md-center">
				<div class="col col-lg-2 justify-content-md-left">
				<img  style="width:70%" src="recursos/img/logo_austa_hospital_30X30.gif">
				  <!-- 1 of 3 -->
				</div>
				<div class="col col-lg-9" >
					<div style="font-size:12px; text-align : center;">
						</br>
						<h5><u>COMUNICAÇÃO DE UTILIZAÇÃO DE ÓRTESE, PRÓTESE E MATERIAIS ESPECIAIS</u></br>
						<u >UNIDADES DE INTERNACAO</u></h5>
						
					</div>
				</div>
				<div class="col col-lg-1 " style="font-size:12px; text-align : right;">
				  </br>
				  RHCCI039</br>
				  HOSPPRD </br>
				  <?= date('d/m/Y H:i:s'); ?>
				</div>
		  </div>
		</div>
	</br>
    <nav class="container">
		<!-- <div class="row justify-content-md-center"> -->
		<div class="row justify-content-md-center">
		    <div class="col col-lg-9" >
				Nome do Paciente
			</div>
			<div class="col col-lg-1" >
				Guia
			</div>
			<div class="col col-lg-1" >
				Conta
			</div>
			<div class="col col-lg-1" >
				Data
			</div>
		</div>
		<!---->
		<div class="row justify-content-md-center">
		    <div class="col col-lg-6" >
				Procedimento
			</div>
			<div class="col col-lg-3" >
				Convênio
			</div>
			<div class="col col-lg-3" >
				Médico
			</div>
		</div>
		<!---->
		<div class="row justify-content-md-center">
		    <div class="col col-lg-10" >
				Material
			</div>
			<div class="col col-lg-2" >
				Qtde
			</div>
		</div>
		<!---->
		<div class="row justify-content-md-center" >
			<div class="col col-8" style="border : solid; text-align : center;" >
				<div>
					<i class="far fa-square"></i>&nbsp;RX pós operatório realizado
					&nbsp;&nbsp;
					<i class="far fa-square"></i>&nbsp;Etiqueta Anexa
					&nbsp;&nbsp;
					<i class="far fa-square"></i>&nbsp;Dispensa emissão de etiqueta
				</div>
			</div>
		</div>
		</br>
		<div class="row justify-content-md-left" style="text-align : left; font-size:12px;">
			<div class="col col-lg-8" >
			<b><i>*No uso de materiais não autorizados, solicitar justificativa do cirurgião.</i></b>
			</div>
		</div>
		<!---->
		</br>
		<div class="row justify-content-md-left">
			<div class="col col-lg-1" style="text-align : left;" >
			Obs:
			</div>
			<div class="col col-lg-11" style="text-align : left;" >			
			<!--conteudo obs -->
			</div>
		</div>
		<!---->
		</br>
		<div class="row justify-content-md-left">
			<div class="col col-lg-6" style="text-align : center;margin-bottom: 100px;" >
				<p></p>
				Circulante
			</div>
			<div class="col col-lg-6" style="text-align : center;" >
				<p></p>
				Enfermeiro(a)
			</div>
			<div class="col col-lg-6" style="text-align : center;" >
				<p></p>
				Instrumentador(a)
			</div>
			<div class="col col-lg-6" style="text-align : center;" >
				<p></p>
				Cirurgião
			</div>
		</div>
	</nav>
		
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>