<?php
require_once "../../config/conexion.php";
 if (!isset($_SESSION['id_usuario'])) { ?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
    }

$conectar = new Conectar();
$conectar = $conectar->conexion();

$page_id        = $_POST["page_id_array"];
$tiempo_inicial = microtime(true);

for ($i = 0; $i < count($page_id); $i++) {
    $sql = "UPDATE entrada SET Orden = '" . $i . "' WHERE id_entrada = '" . $page_id[$i] . "'";
    $sql = $conectar->prepare($sql);
    $sql->execute();
}
$tiempo_final = microtime(true);
$tiempo       = $tiempo_final - $tiempo_inicial;

echo $tiempo;

//echo 'Cambio realizado';
