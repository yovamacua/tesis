<?php
#incluye conexion
require_once "../../config/conexion.php";

#valida que exista sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

#objeto de tipo conexion
$conectar = new Conectar();
$conectar = $conectar->conexion();

$iden = $_GET['valor'];

#proceso de inserción de información
if (isset($_POST["ActGeneral"], $_POST["ActEspecifica"], $_POST["Responsable"], $_POST["Academico"], $_POST["Tecnico"], $_POST["Financiero"], $_POST["Infraestructura"], $_POST["Infraestructura"], $_POST["Logro"], $_POST["Inicio"], $_POST["Fin"])) {
    $ActGeneral      = substr($_POST["ActGeneral"], 0, 100);
    $ActEspecifica   = substr($_POST["ActEspecifica"], 0, 100);
    $Responsable     = substr($_POST["Responsable"], 0, 50);
    $Academico       = substr($_POST["Academico"], 0, 50);
    $Tecnico         = substr($_POST["Tecnico"], 0, 50);
    $Financiero      = $_POST["Financiero"];
    $Infraestructura = substr($_POST["Infraestructura"], 0, 150);
    $Logro           = substr($_POST["Logro"], 0, 200);
    $Inicio          = substr($_POST["Inicio"], 0, 15);
    $Fin             = substr($_POST["Fin"], 0, 15);

//validando campos vacios  o con espacio
    if ($ActGeneral == '') {$ActGeneral = '&nbsp;';}
    if ($ActEspecifica == '') {$ActEspecifica = '&nbsp;';}
    if ($Responsable == '') {$Responsable = '&nbsp;';}
    if ($Academico == '') {$Academico = '&nbsp;';}
    if ($Tecnico == '') {$Tecnico = '&nbsp;';}
    if ($Financiero == '') {$Financiero = '&nbsp;';}
    if ($Infraestructura == '') {$Infraestructura = '&nbsp;';}
    if ($Logro == '') {$Logro = '&nbsp;';}
    if ($Inicio == '') {$Inicio = '&nbsp;';}
    if ($Fin == '') {$Fin = '&nbsp;';}
//fin validación

/**** start recuperando ultimo id */
    $special = "SELECT * FROM entrada ORDER by id_entrada DESC LIMIT 1";
    $special = $conectar->prepare($special);
    $special->execute();
    $contenido = $special->fetchAll(PDO::FETCH_ASSOC);

    foreach ($contenido as $row) {
        $final = $row['id_entrada'] . "<br>";
    }
    if (empty($final)) {
        $finalizando = 1;
    } else {
        $finalizando = intval($final) + 1;
    }

/*** end recuperando ultimo id ***/

    $sql = "INSERT INTO entrada(id_cuenta, ActGeneral, ActEspecifica, Responsable, Academico, Tecnico, Financiero, Infraestructura, Logro, Inicio, Fin, Orden)
VALUES('$iden', '$ActGeneral', '$ActEspecifica', '$Responsable', '$Academico', '$Tecnico', '$Financiero', '$Infraestructura', '$Logro', '$Inicio', '$Fin', '$finalizando')";
    $sql = $conectar->prepare($sql);
    $sql->execute();

#sumatoria de valores
    $query1     = "SELECT SUM(Financiero) FROM entrada WHERE id_cuenta ='" . $iden . "'";
    $statement1 = $conectar->prepare($query1);
    $statement1->execute();

    $result1 = $statement1->fetchAll();

    foreach ($result1 as $row) {
        $sumado = $row['SUM(Financiero)'];
    }
    echo '<span class="sumaview">Total: ' . number_format($sumado, 2) . '</span><span class="loghide"> - Informacion Guardada</span>';

}
