<?php
require_once("../../config/conexion.php");
$conectar = new Conectar();
$conectar =  $conectar->conexion();

$page_id = $_POST["page_id_array"];

for($i=0; $i<count($page_id); $i++)
{
$sql = "UPDATE entrada SET Orden = '".$i."' WHERE id_entrada = '".$page_id[$i]."'";
$sql = $conectar->prepare($sql);
$sql->execute();
}
//echo 'Cambio realizado';
?>
