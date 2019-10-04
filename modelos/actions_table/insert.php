<?php
require_once("../../config/conexion.php");
$conectar = new Conectar();
$conectar =  $conectar->conexion();

$iden = $_GET['valor'];

if(isset( $_POST["ActGeneral"], $_POST["ActEspecifica"],$_POST["Responsable"],$_POST["Academico"], $_POST["Tecnico"], $_POST["Financiero"],  $_POST["Infraestructura"], $_POST["Infraestructura"],$_POST["Logro"], $_POST["Inicio"], $_POST["Fin"]))
{
 $ActGeneral = $_POST["ActGeneral"];
 $ActEspecifica = $_POST["ActEspecifica"];
 $Responsable = $_POST["Responsable"];
 $Academico = $_POST["Academico"];
 $Tecnico = $_POST["Tecnico"];
 $Financiero = $_POST["Financiero"];
 $Infraestructura = $_POST["Infraestructura"];
 $Logro = $_POST["Logro"];
 $Inicio = $_POST["Inicio"];
 $Fin = $_POST["Fin"];

//validando campos vacios  o con espacio
if($ActGeneral ==''){$ActGeneral = '&nbsp;';}
if($ActEspecifica ==''){$ActEspecifica = '&nbsp;';}
if($Responsable == ''){$Responsable = '&nbsp;';}
if($Academico ==''){$Academico = '&nbsp;';}
if($Tecnico == ''){$Tecnico = '&nbsp;';}
if($Financiero ==''){$Financiero = '&nbsp;';}
if($Infraestructura ==''){$Infraestructura = '&nbsp;';}
if($Logro == ''){$Logro = '&nbsp;';}
if($Inicio ==''){$Inicio = '&nbsp;';}
if($Fin == ''){$Fin = '&nbsp;';}
//fin validación


/**** start recuperando ultimo id */
$special = "SELECT * FROM entrada ORDER by id_entrada DESC LIMIT 1";
$special=$conectar->prepare($special);
$special->execute();
$contenido = $special->fetchAll(PDO::FETCH_ASSOC);


foreach ($contenido as $row) {
  $final =  $row['id_entrada']."<br>";
 	}
 	if (empty($final)) {
 		$finalizando = 1;
 	}else{
 		$finalizando = intval($final)+1;
 	}

/*** end recuperando ultimo id ***/

$sql="INSERT INTO entrada(id_cuenta, ActGeneral, ActEspecifica, Responsable, Academico, Tecnico, Financiero, Infraestructura, Logro, Inicio, Fin, Orden)
VALUES('$iden', '$ActGeneral', '$ActEspecifica', '$Responsable', '$Academico', '$Tecnico',
 '$Financiero','$Infraestructura','$Logro','$Inicio','$Fin','$finalizando')";
$sql=$conectar->prepare($sql);
$sql->execute();

$query1 = "SELECT SUM(Financiero) FROM entrada WHERE id_cuenta ='".$iden."'";
$statement1 = $conectar->prepare($query1);
$statement1->execute();

$result1 = $statement1->fetchAll();

foreach ($result1 as $row) {
  $sumado =  $row['SUM(Financiero)'];
 	}
echo '<span class="sumaview">Total: '.number_format($sumado, 2).'</span><span class="loghide"> - Informacion Guardada</span>';

}

?>
