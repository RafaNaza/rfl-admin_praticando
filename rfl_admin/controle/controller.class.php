<?php
	include "Template.class.php";

	class controller {
		
		private function tmpBox($conteudo,$id){
			echo '<article class="xdraggable zIndexBack" id="'.$id.'">	
				<div class="combo_botoes_view">
					<div class="min" data-paiid="'.$id.'">Esconder</div>
					<!-- div class="max">Max</div -->
					<div class="ext" data-paiid="'.$id.'">Fechar</div>
				</div>				
				<div class="conteudo">
					'.$conteudo.'
				</div>
			</article>';
		
			die();
		}
		
		public function demostracao($args=array()){
			$temp = new Template('../templates/demostracao.htm');			
			$this->tmpBox( $temp->getContent(),$args[0]);
		}
		
		public function demostracao2($args=array()){
			$temp = new Template('../templates/demostracao2.htm');
			$this->tmpBox( $temp->getContent(),$args[0]);
		}
	}
?>