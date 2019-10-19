<?php
require_once "../../config/conexion.php";
$conectar = new Conectar();
$conectar = $conectar->conexion();
$iden     = $_GET['valor'];

$query = "SELECT * FROM entrada WHERE id_cuenta = " . $iden . "";

$buscar = $_POST["search"]["value"];

if ($buscar != '') {
    $query .= ' and ActGeneral LIKE "%' . $buscar . '%"
 OR ActEspecifica LIKE "%' . $buscar . '%"
 OR Responsable LIKE "%' . $buscar . '%"
 OR Academico LIKE "%' . $buscar . '%"
 OR Tecnico LIKE "%' . $buscar . '%"
 OR Financiero LIKE "%' . $buscar . '%"
 OR Infraestructura LIKE "%' . $buscar . '%"
 OR Logro LIKE "%' . $buscar . '%"
 OR Inicio LIKE "%' . $buscar . '%"
 OR Fin LIKE "%' . $buscar . '%" ';
}

$query .= ' ORDER BY Orden';

$data   = array();
$result = $query;

$filas = $conectar->query($result);
foreach ($filas as $fila) {
    $sub_array = array();

    $sub_array[] = '<div class="mvdown" id="' . $fila["id_entrada"] . '" data-id="' . $fila["id_entrada"] . '"><div class="handle"></div></div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 100)" ondblclick="this.contentEditable=true;" class="update" data-id="' . $fila["id_entrada"] . '" data-column="ActGeneral">' . $fila["ActGeneral"] . '</div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 100)" ondblclick="this.contentEditable=true;" class="update" data-id="' . $fila["id_entrada"] . '" data-column="ActEspecifica">' . $fila["ActEspecifica"] . '</div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 100)"  ondblclick="this.contentEditable=true;" class="update" data-id="' . $fila["id_entrada"] . '" data-column="Responsable">' . $fila["Responsable"] . '</div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 100)"  ondblclick="this.contentEditable=true;" class="update" data-id="' . $fila["id_entrada"] . '" data-column="Academico">' . $fila["Academico"] . '</div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 100)"  ondblclick="this.contentEditable=true;" class="update" data-id="' . $fila["id_entrada"] . '" data-column="Tecnico">' . $fila["Tecnico"] . '</div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 9) && restrictAlphabets(event);" ondblclick="this.contentEditable=true;"  class="update" data-id="' . $fila["id_entrada"] . '" data-column="Financiero">' . $fila["Financiero"] . '</div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 100)"  ondblclick="this.contentEditable=true;" class="update" data-id="' . $fila["id_entrada"] . '" data-column="Infraestructura">' . $fila["Infraestructura"] . '</div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 100)"  ondblclick="this.contentEditable=true;" class="update" data-id="' . $fila["id_entrada"] . '" data-column="Inicio">' . $fila["Inicio"] . '</div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 10)"  ondblclick="this.contentEditable=true;" class="update" data-id="' . $fila["id_entrada"] . '" data-column="Fin">' . $fila["Fin"] . '</div>';

    $sub_array[] = '<div onkeypress="return (this.innerText.length <= 10)"  ondblclick="this.contentEditable=true;" class="update" data-id="' . $fila["id_entrada"] . '" data-column="Logro">' . $fila["Logro"] . '</div>';

    $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete hint--left" aria-label="Eliminar Registro" id="' . $fila["id_entrada"] . '"><i style="font-size: 18px;" class="fa fa-trash"></i></button>';

    $data[] = $sub_array;
}

$output = array("data" => $data);
echo json_encode($output);
