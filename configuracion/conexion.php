<?php

class Conectar {
protected $dbh;
protected function conexion(){
 		try {
		$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=campoescuela","root","");
		     return $conectar;
 		} catch (Exception $e) {
 			print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
 		}
} //cierre de llave de la function conexion()


		 public function set_names(){
		 return $this->dbh->query("SET NAMES 'utf8'");
		 }


		 public function ruta(){
		 	return "http://localhost/tesis/";
		 }
}//cierre de llave conectar

?>
