<?php
	$funcao = $_REQUEST['funcao'];
	$args   = $_REQUEST['args'];
	
	eval($funcao($args));
	
	//Funcoes
	function ajaxSimples($args){
		$er = '/^http:\/\//';
		$conteudo = "";
		
		if(preg_match($er,$args['url'])){
			$conteudo = implode('',file($args['url']));			
		}else{
			$conteudo = implode('',file('../'.$args['url']));
		}
		echo '<article class="draggable" id="'.$args['id'].'">	
				<div class="combo_botoes_view">
					<div class="min" data-paiid="'.$args['id'].'">Min</div>
					<!-- div class="max">Max</div -->
					<div class="ext" data-paiid="'.$args['id'].'">Ext</div>
				</div>				
				<div class="conteudo">
					'.$conteudo.'
				</div>
			</article>';
		
		die();
	}
	
	function template($url){
		list($class, $args) = explode("/",$url);
		$args = explode(":",$args);
		$metodo = $args[0];
		$param = array();
		if(isset($args[1])){
			$param = explode(";",$args[1]);
		}
		$path = "../controle/".strtolower($class).".class.php";
		if(!file_exists($path)){
			setMenssagem(array(
				"msg"=>"Classe {$class} não encontrada.",
				"status"=>"erro"
			));
		}
		require_once($path);			
		$obj = new $class();
		if(method_exists($obj,$metodo)){
			$obj->$metodo($param);
		}
	}
	
	function setMenssagem($array=''){
		if(is_array($array)){
			echo "<div class='".$array['status']."'><pre>"; print_r($array['msg']); echo "</pre></div>";
			die();
		}
	}
	 
?>