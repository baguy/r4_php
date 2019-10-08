<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	  <style type="text/css">
			.resultado{
			  font-size: 12px !important;
			}

			td,th{
			  font-family: sans-serif !important;
			}

			table{
				width:100% !important;
			}

			th{
				text-align:left;
			}

			.fixed{
				position: fixed;
				bottom: 200px;
			}
	  </style>
	</head>

	<body>

		<header id="header" class="header col-xs-12">
	    <div class="row">
		    <div class="col-xs-2">

					<center>
						<img src="{{ base_path() }}/assets/img/brasao.png" alt="Prefeitura de Caraguatatuba">
					</center>

		    </div>

		    <div class="col-xs-8">
					<center>
		        <div class="col-xs-12 print-line"><b>PREFEITURA MUNICIPAL DA ESTÂNCIA BALNEÁRIA DE CARAGUATATUBA</b></div>
		        <div class="col-xs-12 print-line"><b>SECRETARIA MUNICIPAL DE SAÚDE</b></div>
		        <div class="col-xs-12 print-line"><small>LABORATÓRIO DE SAÚDE PÚBLICA DE CARAGUATATUBA</small></div>
		        <div class="col-xs-12 print-line"><small>Av. Maranhão, nº421 - Jardim Primavera</small></div>
					</center>
		    </div>
	    </div>

			<hr>

		</header>

	  @yield('MAIN')

	</body>

</html>
