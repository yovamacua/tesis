<?php


define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','admin12-');
define('DBNAME','campoescuela');

//****************************************
//Conexion usando clase
//****************************************
 session_start();
class Conectar {
 	protected $dbh;
 	public function conexion(){
	try {
    //conexion a la bd
 			$conectar = $this->dbh = new PDO("mysql:host=".DBHOST.";charset=utf8;dbname=".DBNAME, DBUSER, DBPASS);
 			return $conectar;

 		} catch (Exception $e) {
      //mensaje de error si no conectar
 			print "¡Error!: " . $e->getMessage() . "<br/>";
      die();
 		}
} //cierre de llave de la function conexion()

    // funcion para evitar problemas de tilde ( o carateres latinos)
	public function set_names(){
 	   return $this->dbh->query("SET NAMES 'utf8'");
		 }

     //funcion para colocar la ruta del proyecto
		 public function ruta(){
		 	return "http://localhost/tesis/";
		 }
	}//cierre de llave conectar
