<?php
#incluye conecion
require_once "../../config/conexion.php";

#valida que exista session
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

#instancia y creación de objeto conexión
$conectar = new Conectar();
$conectar = $conectar->conexion();

$iden = $_GET['valor'];

#eliminar registro
if (isset($_POST["id"])) {
    $sql = "DELETE FROM entrada WHERE id_entrada = '" . $_POST["id"] . "'";
    $sql = $conectar->prepare($sql);
    $sql->execute();

#calculo de sumatoria
    $query1     = "SELECT SUM(Financiero) FROM entrada WHERE id_cuenta ='" . $iden . "'";
    $statement1 = $conectar->prepare($query1);
    $statement1->execute();

    $result1 = $statement1->fetchAll();

    foreach ($result1 as $row) {
        $final = $row['SUM(Financiero)'];
    }

    echo '<span class="sumaview">Total: ' . number_format($final, 2) . '</span> <span class="loghide">- Informacion Eliminada</span>';

}
