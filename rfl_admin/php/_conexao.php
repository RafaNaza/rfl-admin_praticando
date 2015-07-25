<?php
	class conexao {
		
		private $con;
		private $query;
		
		public function __construct($host, $user, $pass){
			try{
				$this->con = mysql_connect($host, $user, $pass);
				if(!$this->con) throw new Exception(mysql_error());			
			}catch(Exception $e){
				$this->setError($e->getMessage());
			}			
		}
		
		public function selectdb($base){
			try{
				if(!mysql_select_db($base,$this->con))throw new Exception(mysql_error());	
			}catch(Exception $e){
				$this->setError($e->getMessage());
			}
		}
		
		public function query($sql){
			try{
				$this->query = mysql_query($sql);
				if(!$this->query)throw new Exception(mysql_error());
			}catch(Exception $e){
				$this->setError($e->getMessage());
			}
		}
		
		public function fetchArray(){
			try{
				return mysql_fetch_array($this->query);
			}catch(Exception $e){
				$this->setError(mysql_error());
			}
		}
		public function fetchObject(){
			try{
				return mysql_fetch_object($this->query);
			}catch(Exception $e){
				$this->setError(mysql_error());
			}
		}
		
		public function close(){
			mysql_close($this->con);
		}
		
		public function setError($msg){
			echo '<div style="background-color:#c48080;color:#FFF;text-align:left"><pre>' ; print_r( $msg ) ; echo '</pre></div>' ;
			die();
		}
	}
?>