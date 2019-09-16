<?php


/* $servername="localhost";
$username="root";
$password="admin12-";
// conexion a la base de datos
try {

	$conn = new PDO("mysql:host=$servername;dbname=proyecto_tesis",$username,$password);
	// Establace el modo error en la excepcion
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	echo("CONEXION EXITOSA");
} catch (PDOException $e) {
	echo "conexion fallida" . $e->getMessage();
}
// cerrar la conexion
$conn =null; */


//****************************************
//Conexion usando clase
//****************************************
session_start();
class Conectar {
 	protected $dbh;
 	public function conexion(){
	try {
    //conexion a la bd

$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=campoescuela;charset=utf8","root","");
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
?>
