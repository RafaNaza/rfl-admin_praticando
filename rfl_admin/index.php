<?php 
	error_reporting(0);
 ?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>RFL - ADMIN</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable = no, initial-scale=1">		
		<meta name="author" content="Rafa Nazario">
		
		<link rel="icon" href="favicon.png" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="css/estilos.css" />
		<link rel="stylesheet"type="text/css"  href="css/nanoscroller.css" />
		
		<script src="js/jquery-1.11.1.min.js"></script>
	
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/jquery.ui.touch-punch.js"></script>
		<script src="js/jquery.form.js"></script>
		
	</head>
	<body>
		<!-- header>Bem Vindo<p></p></header -->
		
		<div id="workspace"></div>
		
		<div class="menu hide nano" id="sidebarMenu">
			<span class="nano-content">
				<a href="controller/demostracao:demo" class="item_menu" data-id="demo" data-iniciais="DEM">Demonstra&ccedil;&atilde;o</a>
				<a href="controller/demostracao2:demo2" class="item_menu" data-id="demo2" data-iniciais="DEMO-2">Sistema</a>
			</span>
		</div>
		
		<div class="botao_menu" id="botao_menu" data-nclass="show" data-vclass="hide"></div>
		
		<footer>
			<!-- div class="botao_menu" data-nclass="show" data-vclass="hide"></div -->
			<!-- Barra de Tarefas -->
			
			<table>
				<tr>
					<td>
						<div class="barra_de_tarefas"></div>
					</td>
					<td style="min-width:100px;">| <a href="#">Usuário</a></td>
				</tr>
			</table>
		</footer>	
	</body>
	
	<script src="js/controlador.js"></script>
	<script type="text/javascript" src="js/jquery.nanoscroller.js"></script>
	
	<script>
		$(document).ready(function(){
			$(".nano").nanoScroller();
		});
	</script>
</html>