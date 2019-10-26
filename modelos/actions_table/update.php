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

#creación de nuevo objeto
$conectar = new Conectar();
$conectar = $conectar->conexion();

$iden = $_GET['valor'];
if (isset($_POST["id"])) {
    $value = $_POST["value"];
    if ($value == '') {
        $value = '&nbsp;';
    }
#actualización de parametro
    $sql = "UPDATE entrada SET " . $_POST["column_name"] . "='" . $value . "' WHERE id_entrada = '" . $_POST["id"] . "'";

    $sql = $conectar->prepare($sql);
    $sql->execute();

#sumatoria de valores
    $query1     = "SELECT SUM(Financiero) FROM entrada WHERE id_cuenta ='" . $iden . "'";
    $statement1 = $conectar->prepare($query1);
    $statement1->execute();

    $result1 = $statement1->fetchAll();

    foreach ($result1 as $row) {
        $final = $row['SUM(Financiero)'];
    }
    echo '<span class="sumaview">Total: ' . number_format($final, 2) . '</span><span class="loghide"> - Informacion Actualizada</span>';
}
