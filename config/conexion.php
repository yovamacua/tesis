<?php


define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','campoescuela');

//****************************************
//Conexion usando clase
//****************************************
 session_start();

if(isset($_SESSION["id_usuario"])){
	$fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));

    //comparamos el tiempo transcurrido
    // minutos por segundos 60 minutos x 60 segundos = 3600
     if($tiempo_transcurrido >= 3600) {
     //si pasaron 10 minutos o más
      session_destroy(); // destruyo la sesión
      header("Location:".Conectar::ruta()."vistas/index.php");
       exit();
    }else {
    $_SESSION["ultimoAcceso"] = $ahora;
   }
}


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
