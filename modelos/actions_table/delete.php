<?php
require_once("../../config/conexion.php");
$conectar = new Conectar();
$conectar =  $conectar->conexion();

$iden = $_GET['valor'];

if(isset($_POST["id"]))
{
$sql="DELETE FROM entrada WHERE id_entrada = '".$_POST["id"]."'";
$sql=$conectar->prepare($sql);
$sql->execute();

$query1 = "SELECT SUM(Financiero) FROM entrada WHERE id_cuenta ='".$iden."'";
$statement1 = $conectar->prepare($query1);
$statement1->execute();

$result1 = $statement1->fetchAll();

foreach ($result1 as $row) {
  $final =  $row['SUM(Financiero)'];
 	}

echo '<span class="sumaview">Total: '.number_format($final, 2).'</span> - Informacion Eliminada';

}

?>
