<?php
	
	class assets {
	
		static function setForm($action,$args){
			$form = "<form action='{$action}' method='POST' class='formAjx'>";
			
			foreach($args as $value){
				$form .= $this->getFormElement($value);
			}
			
			$form .= "</form>";
			return $form;
		}
		
		private function getFormElement($args){
			switch($args[0]){
				case "select" : return $this->select($args); break;
				case "textarea" : return $this->textarea($args); break;
				case "datalist" : return $this->datalist($args); break;
				case "keygen" : return $this->keygen($args); break;
				case "output" : return $this->output($args); break;
				default : return $this->input($args);
			}
		}
		
		private function select($args){
			$options = "<option></option>";
			$atributos = "";
			$class = $args[4];
			foreach($args[2] $value=>$tag){
				$options .= "<option value='{$value}'>{$tag}</option>";
			}
			foreach($args[3] $key=>$value){
				$atributos .= "{$key}='{$value}'";
			}			
			$id = str_replace(array("[","]"),"_",$args[1]);			
			return "<select name='{$args[1]}' id='{$id}' {$atributos} class='{$class}'>{$options}</select>";
		}
		
		private function textarea($args){
			$value = $args[2];
			$class = $args[4];
			$atributos = "";
			foreach($args[3] $key=>$value){
				$atributos .= "{$key}='{$value}'";
			}
			return "<textarea name='{$args[1]}' id='{$id}' {$atributos} class='{$class}'>{$value}</textarea>";
		}
	}

?>