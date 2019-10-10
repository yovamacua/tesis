<?php
require_once("../../config/conexion.php");
require_once "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset( $_GET['selector'])) {
       $selector = $_GET['selector'];

# Nuestra base de datos
function obtenerBD(){
    try {
        $conexion = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
        $conexion->query("set names utf8;");
        $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $conexion;
    } catch (Exception $e) {
        exit("Error obteniendo BD: " . $e->getMessage());
        return null;
    }
}


 
# Obtener base de datos
$bd = obtenerBD();
$documento = new Spreadsheet();
$documento
    ->getProperties()
    ->setCreator("Campo Escuela")
    ->setLastModifiedBy('Campo Escuela')
    ->setTitle('Archivo De Partida/Cuenta')
    ->setDescription('Archivo generado por el Sistema de Campo Escuela para consulta la información de una cuenta');

# Ahora los cuentas
# Como ya hay una hoja por defecto, la obtenemos, no la creamos
$hojaDeCuentas = $documento->getActiveSheet();
$hojaDeCuentas->getStyle('A1:J1')->getAlignment()->setHorizontal('center');
$hojaDeCuentas->mergeCells('A1:J1');
$hojaDeCuentas->setTitle("Cuenta");
//$hojaDeCuentas->getRowDimension()->setRowHeight(100);
$hojaDeCuentas->getDefaultColumnDimension()->setWidth(30);
$hojaDeCuentas->getStyle('A7:J8')->getAlignment()->setHorizontal('center');
$hojaDeCuentas->getStyle('A3:J100')->getAlignment()->setVertical('top');
$hojaDeCuentas->getStyle('A1')->getFont()->setSize(15);
$hojaDeCuentas->getStyle('A7:J7')->getFont()->setSize(13);
$hojaDeCuentas->getStyle('A8:J8')->getFont()->setSize(13);

$hojaDeCuentas->getStyle('A7:J8')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('F1F1F1F1');

$styleArray = [
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
                'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
                'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
                'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$hojaDeCuentas->getStyle('A7:J7')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('B8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('C8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('D8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('E8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('F8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('G8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('H8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('I8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('J8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('C7:C8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('J7:J8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('H7:I8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('C7:C8')->getAlignment()->setVertical('center');
$hojaDeCuentas->getStyle('J7:J8')->getAlignment()->setVertical('center');

$encabezado = ["FUNCIONAMIENTO DE OFICINA DE AGRONEGOCIOS"];
$hojaDeCuentas->fromArray($encabezado, null, 'A1');

/*foreach (range('A','J') as $col) {
  $hojaDeCuentas->getColumnDimension($col)->setAutoSize(true);  
} */

$encabezado = ["Actividades", "","Responsable", "Recurso","","","","Plazo","","Indicador de Logro"];
$hojaDeCuentas->fromArray($encabezado, null, 'A7');
$hojaDeCuentas->mergeCells('A7:B7');
$hojaDeCuentas->mergeCells('C7:C8');
$hojaDeCuentas->mergeCells('D7:G7');
$hojaDeCuentas->mergeCells('J7:J8');
$hojaDeCuentas->mergeCells('H7:I7');


# Escribir encabezado
$encabezado = ["Generales", "Especificas", "Responsable", "Académico", "Técnico","Financiero ($)", "Infraestructura", "Inicio", "Fin", "Indicadores de Logro"];
# El último argumento es por defecto A1 pero lo pongo para que se explique mejor
$hojaDeCuentas->fromArray($encabezado, null, 'A8');


# Obtener cuentas de BD
$consulta = "SELECT p.nombrepartida, c.nombrecuenta, c.objetivo, c.estrategia, e.ActGeneral, e.ActEspecifica, e.Responsable, e.Academico, e.Tecnico, e.Financiero, e.Infraestructura, e.Logro ,e.Inicio, e.Fin from partidas p INNER JOIN cuentas c on p.id_partida = '".$selector."' AND  c.id_partida  = '".$selector."'  INNER JOIN entrada e on c.id_cuenta = e.id_cuenta ORDER BY e.Orden";
$sentencia = $bd->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();


# Comenzamos en la 9 porque la 1-8 es del encabezado
$numeroDeFila = 9;
$total = 0;
while ($cuenta = $sentencia->fetchObject()) {

# encabezado
    $nombrepartida = $cuenta->nombrepartida;
    $nombrecuenta = $cuenta->nombrecuenta;
    $objetivo = $cuenta->objetivo;
    $estrategia = $cuenta->estrategia;

    # Obtener los datos de la base de datos
    if($cuenta->ActGeneral  == '&nbsp;'){$cuenta->ActGeneral = '';}
    $ActGeneral = $cuenta->ActGeneral;

    if($cuenta->ActEspecifica  == '&nbsp;'){$cuenta->ActEspecifica = '';}
    $ActEspecifica = $cuenta->ActEspecifica;

    if($cuenta->Responsable  == '&nbsp;'){$cuenta->Responsable = '';}
    $Responsable = $cuenta->Responsable;

    if($cuenta->Academico  == '&nbsp;'){$cuenta->Academico = '';}
    $Academico = $cuenta->Academico;
    
    if($cuenta->Tecnico  == '&nbsp;'){$cuenta->Tecnico = '';}
    $Tecnico = $cuenta->Tecnico;

    if($cuenta->Financiero  == '&nbsp;'){$cuenta->Financiero = '';}
    $Financiero = $cuenta->Financiero;

    if($cuenta->Infraestructura  == '&nbsp;'){$cuenta->Infraestructura = '';}
    $Infraestructura = $cuenta->Infraestructura;

    if($cuenta->Logro  == '&nbsp;'){$cuenta->Logro = '';}
    $Logro = $cuenta->Logro;
    
    if($cuenta->Inicio  == '&nbsp;'){$cuenta->Inicio = '';}
    $Inicio = $cuenta->Inicio;

    if($cuenta->Fin  == '&nbsp;'){$cuenta->Fin = '';}
    $Fin = $cuenta->Fin;

    # Escribirlos en el documento
    $hojaDeCuentas->setCellValueByColumnAndRow(1, $numeroDeFila, $ActGeneral);
    $hojaDeCuentas->setCellValueByColumnAndRow(2, $numeroDeFila, $ActEspecifica);
    $hojaDeCuentas->setCellValueByColumnAndRow(3, $numeroDeFila, $Responsable);
    $hojaDeCuentas->setCellValueByColumnAndRow(4, $numeroDeFila, $Academico);
    $hojaDeCuentas->setCellValueByColumnAndRow(5, $numeroDeFila, $Tecnico);
    $hojaDeCuentas->setCellValueByColumnAndRow(6, $numeroDeFila, $Financiero);
    $hojaDeCuentas->setCellValueByColumnAndRow(7, $numeroDeFila, $Infraestructura);
    $hojaDeCuentas->setCellValueByColumnAndRow(8, $numeroDeFila, $Inicio);
    $hojaDeCuentas->setCellValueByColumnAndRow(9, $numeroDeFila, $Fin);
    $hojaDeCuentas->setCellValueByColumnAndRow(10, $numeroDeFila, $Logro);

    $total = $total+$Financiero;

    $numeroDeFila++;
}
$hojaDeCuentas->mergeCells('B2:J2');
$hojaDeCuentas->mergeCells('B3:J3');
$hojaDeCuentas->mergeCells('B4:J4');
$hojaDeCuentas->mergeCells('B5:J5');
$hojaDeCuentas->mergeCells('B6:J6');


$hojaDeCuentas->getStyle('A2')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A3')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A4')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A5')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A6')->applyFromArray($styleArray);

$hojaDeCuentas->getStyle('B2:J2')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('B3:J3')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('B4:J4')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('B5:J5')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('B6:J6')->applyFromArray($styleArray);

$hojaDeCuentas->getStyle('A2:J2')->getFont()->setSize(13);
$hojaDeCuentas->getStyle('A3:J3')->getFont()->setSize(13);
$hojaDeCuentas->getStyle('A4:J4')->getFont()->setSize(13);
$hojaDeCuentas->getStyle('A5:J5')->getFont()->setSize(13);
$hojaDeCuentas->getStyle('A6:J6')->getFont()->setSize(13);


$hojaDeCuentas->setCellValue('A2', "Nombre de partida ");
$hojaDeCuentas->setCellValue('B2', $nombrepartida);

$hojaDeCuentas->setCellValue('A3', "Nombre de cuenta");
$hojaDeCuentas->setCellValue('B3', $nombrecuenta);

$hojaDeCuentas->setCellValue('A4', "Objetivo");
$hojaDeCuentas->setCellValue('B4', $objetivo);

$hojaDeCuentas->setCellValue('A5', "Estrategia");
$hojaDeCuentas->setCellValue('B5', $estrategia);

$hojaDeCuentas->setCellValue('A6', "Total de Partida");
$hojaDeCuentas->setCellValue('B6', $total);

$hojaDeCuentas->getStyle('B6')->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
$hojaDeCuentas->getStyle('B6')->getAlignment()->setHorizontal('left');
$hojaDeCuentas->getStyle('F9:F100')->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

$archivogenerado = $nombrepartida.'-'.$nombrecuenta.'.xlsx';

# Crear un "escritor"
$writer = new Xlsx($documento);
# Le pasamos la ruta de guardado
$writer->save($archivogenerado);

header('Content-disposition: attachment; filename=' .$archivogenerado);
header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
readfile($archivogenerado);
unlink($archivogenerado);
 }else{
	 $redireccion = Conectar::ruta()."vistas";?>
      <script type="text/javascript">
       self.location = '<?php echo $redireccion; ?>'
       </script>
<?php }
