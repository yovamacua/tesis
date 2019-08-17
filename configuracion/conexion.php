<?php
$servername="localhost";
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
$conn =null;
?>