<?php

	class conexao {
		private $con;
		private $query;
		public function __construct($host, $user, $pass, $base=''){			
			$this->con = new mysqli($host,$user,$pass,$base);
			if(mysqli_connect_errno()){
				$this->setError("Falha na conex&atilde;o!<br />".mysqli_connect_error());
			}
		}
		
		public function query($sql){
			if(!$this->con->query($sql)){
				$this->setError("Erro na query <br />`{$sql}`<br />".$this->con->error);
			}
		}
		
		public function fetch_object(){			
			return mysqli_fetch_object($this->query);
		}
		
		public function selectdb($base){
			if(!mysqli_select_db($this->con,$base)){$this->setError("Banco de Dados desconhecido `{$base}`.<br />".mysqli_error($this->con));die();}
		}
		
		public function salvar($obj=''){
			if(!is_object($obj)){
				$this->setError("Erro ao tentar salvar. Nenhum objeto válido informado.");
			}
			
			$return = false;
			if($obj->id>0){
				$return = $this->atualiza($obj);
			}
			else {
				$return = $this->insere($obj);
			}

			return $return;
		}
		
		public function insere($obj){
			$return = false;

			$sql = ' INSERT INTO ' . get_class($obj) ;
			$campos = array() ;

			// se existir o campo de data de cadastro na tabela, preenche com a data/hora do momento
			if(property_exists(get_class($obj),'data_cadastro')){
				$this->data_cadastro = bd_now();
			}

			//var_dump($this);
			foreach ( get_class_vars(get_class($obj)) as $var_name => $var_value ){
				if( $var_name != 'id'
					&& isset($obj->$var_name) ){
					$campos[1][] = "`{$var_name}`" ;
					if ( $obj->$var_name === "null" ){
						$campos[2][] = "null";
					}
					else{
						$campos[2][] = "'".($obj->$var_name)."'";
					}
				}
			}

			$sql = $sql . "(" . join(",",$campos[1]) . ") VALUES (". join(",",$campos[2]) .")";
			$return = (query($sql));
			$obj->id = mysql_insert_id();
			return ($return);
		}

		public function atualiza($obj){
			$sql = ' UPDATE ' . get_class($obj) . ' SET ' ;
			$campos = array() ;

			foreach ( get_class_vars(get_class($obj)) as $var_name => $var_value ){
				if( $var_name != "id"
					&& isset($obj->$var_name) ){
					$campos[] = "`{$var_name}`" . " = '".($obj->$var_name)."'"  ;
				}
			}
			$sql = $sql . join(',',$campos) . ' WHERE id = ' . $obj->id  ;
			return (query($sql));
		}

		public function exclui($obj){
			foreach ( $this->get_related_objects() as $obj ){
				$obj->exclui();
			}
			return query('DELETE FROM ' . $this->get_table_name() . ' WHERE id = ' . $this->id ) ;
		}
		
		public function setError($msg){
			echo "<div style='width:100%;background:#dc8181;color:#FFF;text-align:left;padding:3px 0 3px 5px;font-size:14px;'><pre>"; print_r($msg); echo "</pre></div>";
			die();
		}
	
	}

?>