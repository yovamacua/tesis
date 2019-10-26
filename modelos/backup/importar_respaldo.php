<?php
#incluir conexion
require_once "../../config/conexion.php";

#valida que exista la session
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

// funcion para limpiar el script
function limpiarCadena($valor)
{
    $valor = addslashes($valor);
    $valor = str_ireplace("<script>", "", $valor);
    $valor = str_ireplace("</script>", "", $valor);
    $valor = str_ireplace("SELECT * FROM", "", $valor);
    $valor = str_ireplace("DELETE FROM", "", $valor);
    $valor = str_ireplace("UPDATE", "", $valor);
    $valor = str_ireplace("INSERT INTO", "", $valor);
    $valor = str_ireplace("DROP TABLE", "", $valor);
    $valor = str_ireplace("TRUNCATE TABLE", "", $valor);
    $valor = str_ireplace("--", "", $valor);
    $valor = str_ireplace("^", "", $valor);
    $valor = str_ireplace("[", "", $valor);
    $valor = str_ireplace("]", "", $valor);
    $valor = str_ireplace("\\", "", $valor);
    $valor = str_ireplace("=", "", $valor);
    return $valor;
}

//variables de conexion
$servername = DBHOST; // Databade host
$username   = DBUSER; // Databade username
$password   = DBPASS; // Databade password
$db         = DBNAME; // Databade name
if (isset($_POST["Import"])) {

    $con = mysqli_connect($servername, $username, $password, $db);
    $con->set_charset("utf8");
//nombre de la carpeta
    $carpeta = "backup/";
//abrir directorio
    opendir($carpeta);
//carpeta destino más nombre del archivo
    $destino = $carpeta . $_FILES['archivo']['name'];
//copiando el archivo
    copy($_FILES['archivo']['tmp_name'], $destino);
    $restorePoint = limpiarCadena($destino);
    $sql          = explode(";", file_get_contents($restorePoint));

    $totalErrors = 0;
    set_time_limit(0);
    $con->query("SET FOREIGN_KEY_CHECKS=0");
    for ($i = 0; $i < (count($sql) - 1); $i++) {
        if ($con->query($sql[$i] . ";")) {} else { $totalErrors++;}
    }
    $con->query("SET FOREIGN_KEY_CHECKS=1");
    $con->close();
    unlink($destino);

} else {echo "No valido";}
$redireccion = Conectar::ruta() . "vistas/respaldo.php?msj=1";?>
<script type="text/javascript">
self.location = '<?php echo $redireccion; ?>'
</script>
