<?php
set_time_limit(0);

require_once("../../config/conexion.php");
/*==========================================*/
$dbhost = DBHOST; // Databade host
$dbuser = DBUSER; // Databade username
$dbpass = DBPASS; // Databade password
$dbname = DBNAME; // Databade name

/*=======================================*/
function tableDump($link,$table_name)
{
	$query = $link -> prepare("SHOW CREATE TABLE $table_name");
	$query -> execute();
	$create_table = $query ->fetchAll();
	$ct = $create_table[0][1].";\n\n\n";
	$query = $link -> prepare("SELECT * FROM $table_name");
	$query -> execute();
	$column = $query  -> columnCount();
	$table = $ct; $x = "";
	foreach ($query as $key)
	{
		for ($i=0; $i < $column; $i++)
		{
			$x.= "\"$key[$i]\"";
			if($i<$column-1){$x.= ",";}
		}
		$table.="INSERT INTO {$table_name} VALUES({$x});\n";
		$x ="";

	}
	return $table."\n\n\n";
}
try {$link = new PDO("mysql:host={$dbhost};charset=utf8;dbname={$dbname};charset=utf8",$dbuser,$dbpass);}
catch(PDOException $e){echo '<span style="color: red">ERROR: ' . $e->getMessage()."</span>\n"; exit();}
$result = $link -> prepare('SHOW TABLES');
$result -> execute();
$num_table = $result -> rowCount();
$dump = " ";
foreach ($result as $row){
	$dump.=tableDump($link,$row[0]);
	}

$filename = "Respaldo_".date('Y_m_d_H_i_s').".sql";

$fo = fopen("$filename", 'w');
if(fwrite($fo, $dump))
{
	echo '<span style="color: green">'."Base Datos Guardada Como $filename </span><br>"."\n";

	fclose($fo);
}

else {echo "<span style=\"color: green\">Error al guardar</span>"."\n"; fclose($fo);}

header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename=' . $filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filename));
ob_clean();
flush();
readfile($filename);
exec('rm ' . $filename);
unlink($filename);

$redireccion = Conectar::ruta()."vistas/respaldo.php?msj=1";?>
<script type="text/javascript">
alert("Debe seleccionar una cuenta primero")
self.location = '<?php echo $redireccion; ?>'
</script>
