<?php
#incluir conexion
require_once "../../config/conexion.php";

#verifica que exista sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

#objeto de tipo conexion
$conectar = new Conectar();
$conectar = $conectar->conexion();

#captura de parametos
$page_id        = $_POST["page_id_array"];
$tiempo_inicial = microtime(true);

#proceso de reordenamiento
for ($i = 0; $i < count($page_id); $i++) {
    $sql = "UPDATE entrada SET Orden = '" . $i . "' WHERE id_entrada = '" . $page_id[$i] . "'";
    $sql = $conectar->prepare($sql);
    $sql->execute();
}
$tiempo_final = microtime(true);
$tiempo       = $tiempo_final - $tiempo_inicial;

echo $tiempo;

//echo 'Cambio realizado';
