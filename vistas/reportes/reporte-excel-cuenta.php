<?php
require_once("../../config/conexion.php");
require_once "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset( $_GET['selector'])) {
       $selector = $_GET['selector'];
       $selector2 = $_GET['selector2'];

# Conexion base de datos
$bd = new Conectar();
$bd =  $bd->conexion();

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
$hojaDeCuentas->getStyle('A8:J9')->getAlignment()->setHorizontal('center');
$hojaDeCuentas->getStyle('A3:J100')->getAlignment()->setVertical('top');
$hojaDeCuentas->getStyle('A1')->getFont()->setSize(15);
$hojaDeCuentas->getStyle('A7:J7')->getFont()->setSize(13);
$hojaDeCuentas->getStyle('A8:J8')->getFont()->setSize(13);

$hojaDeCuentas->getStyle('A8:J9')->getFill()
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

$hojaDeCuentas->getStyle('A8:J8')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('B9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('C9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('D9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('E9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('F9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('G9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('H9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('I9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('J9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('C8:C9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('J8:J9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('H8:I9')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('C8:C9')->getAlignment()->setVertical('center');
$hojaDeCuentas->getStyle('J8:J9')->getAlignment()->setVertical('center');

$encabezado = ["FUNCIONAMIENTO DE OFICINA DE AGRONEGOCIOS"];
$hojaDeCuentas->fromArray($encabezado, null, 'A1');


$encabezado = ["Actividades", "","Responsable", "Recurso","","","","Plazo","","Indicador de Logro"];
$hojaDeCuentas->fromArray($encabezado, null, 'A8');
$hojaDeCuentas->mergeCells('A8:B8');
$hojaDeCuentas->mergeCells('C8:C9');
$hojaDeCuentas->mergeCells('D8:G8');
$hojaDeCuentas->mergeCells('J8:J9');
$hojaDeCuentas->mergeCells('H8:I8');


# Escribir encabezado
$encabezado = ["Generales", "Especificas", "Responsable", "Académico", "Técnico","Financiero ($)", "Infraestructura", "Inicio", "Fin", "Indicadores de Logro"];
# El último argumento es por defecto A1 pero lo pongo para que se explique mejor
$hojaDeCuentas->fromArray($encabezado, null, 'A9');

$consulta1 = "SELECT * from entrada WHERE id_cuenta = '".$selector."'";
$sentencia1 = $bd->prepare($consulta1);
$sentencia1->execute();
$result1 = $sentencia1->fetchAll();

if (count($result1) > 0) {

# Obtener cuentas de BD
$consulta = "SELECT p.nombrepartida, p.anio, c.nombrecuenta, c.objetivo, c.estrategia, e.ActGeneral, e.ActEspecifica, e.Responsable, e.Academico, e.Tecnico, e.Financiero, e.Infraestructura, e.Logro ,e.Inicio, e.Fin from partidas p INNER JOIN cuentas c on p.id_partida = '".$selector2."' AND  c.id_cuenta  = '".$selector."'  INNER JOIN entrada e on c.id_cuenta = e.id_cuenta ORDER BY e.Orden";
$sentencia = $bd->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();


# Comenzamos en la 9 porque la 1-8 es del encabezado
$numeroDeFila = 10;
$total = 0;
while ($cuenta = $sentencia->fetchObject()) {

# encabezado
    $nombrepartida = $cuenta->nombrepartida;
    $nombrecuenta = $cuenta->nombrecuenta;
    $objetivo = $cuenta->objetivo;
    $estrategia = $cuenta->estrategia;
    $anio = $cuenta->anio;

    $nombrepartida = str_replace("<br>", " ", $nombrepartida);
    $nombrepartida = str_replace("<div>", "", $nombrepartida);
    $nombrepartida = str_replace("</div>", "", $nombrepartida);
    $nombrecuenta = str_replace("<br>", " ", $nombrecuenta);
    $nombrecuenta = str_replace("<div>", "", $nombrecuenta);
    $nombrecuenta = str_replace("</div>", "", $nombrecuenta);
    $objetivo = str_replace("<br>", " ", $objetivo);
    $objetivo = str_replace("<div>", "", $objetivo);
    $objetivo = str_replace("</div>", "", $objetivo);
    $estrategia = str_replace("<br>", " ", $estrategia);
    $estrategia = str_replace("<div>", "", $estrategia);
    $estrategia = str_replace("</div>", "", $estrategia);

    # Obtener los datos de la base de datos
    if($cuenta->ActGeneral  == '&nbsp;'){$cuenta->ActGeneral = '';}
    $ActGeneral = $cuenta->ActGeneral;

    $ActGeneral = str_replace("<br>", " ", $ActGeneral);
    $ActGeneral = str_replace("<div>", "", $ActGeneral);
    $ActGeneral = str_replace("</div>", "", $ActGeneral);

    if($cuenta->ActEspecifica  == '&nbsp;'){$cuenta->ActEspecifica = '';}
    $ActEspecifica = $cuenta->ActEspecifica;

    $ActEspecifica = str_replace("<br>", " ", $ActEspecifica);
    $ActEspecifica = str_replace("<div>", "", $ActEspecifica);
    $ActEspecifica = str_replace("</div>", "", $ActEspecifica);

    if($cuenta->Responsable  == '&nbsp;'){$cuenta->Responsable = '';}
    $Responsable = $cuenta->Responsable;

    $Responsable = str_replace("<br>", " ", $Responsable);
    $Responsable = str_replace("<div>", "", $Responsable);
    $Responsable = str_replace("</div>", "", $Responsable);

    if($cuenta->Academico  == '&nbsp;'){$cuenta->Academico = '';}
    $Academico = $cuenta->Academico;

    $Academico = str_replace("<br>", " ", $Academico);
    $Academico = str_replace("<div>", "", $Academico);
    $Academico = str_replace("</div>", "", $Academico);
    
    if($cuenta->Tecnico  == '&nbsp;'){$cuenta->Tecnico = '';}
    $Tecnico = $cuenta->Tecnico;

    $Tecnico = str_replace("<br>", " ", $Tecnico);
    $Tecnico = str_replace("<div>", "", $Tecnico);
    $Tecnico = str_replace("</div>", "", $Tecnico);

    if($cuenta->Financiero  == '&nbsp;'){$cuenta->Financiero = '';}
    $Financiero = $cuenta->Financiero;

    $Financiero = str_replace("<br>", " ", $Financiero);
    $Financiero = str_replace("<div>", "", $Financiero);
    $Financiero = str_replace("</div>", "", $Financiero);

    if($cuenta->Infraestructura  == '&nbsp;'){$cuenta->Infraestructura = '';}
    $Infraestructura = $cuenta->Infraestructura;

    $Infraestructura = str_replace("<br>", " ", $Infraestructura);
    $Infraestructura = str_replace("<div>", "", $Infraestructura);
    $Infraestructura = str_replace("</div>", "", $Infraestructura);

    if($cuenta->Logro  == '&nbsp;'){$cuenta->Logro = '';}
    $Logro = $cuenta->Logro;

    $Logro = str_replace("<br>", " ", $Logro);
    $Logro = str_replace("<div>", "", $Logro);
    $Logro = str_replace("</div>", "", $Logro);
    
    if($cuenta->Inicio  == '&nbsp;'){$cuenta->Inicio = '';}
    $Inicio = $cuenta->Inicio;

    $Inicio = str_replace("<br>", " ", $Inicio);
    $Inicio = str_replace("<div>", "", $Inicio);
    $Inicio = str_replace("</div>", "", $Inicio);

    if($cuenta->Fin  == '&nbsp;'){$cuenta->Fin = '';}
    $Fin = $cuenta->Fin;

    $Fin = str_replace("<br>", " ", $Fin);
    $Fin = str_replace("<div>", "", $Fin);
    $Fin = str_replace("</div>", "", $Fin);

    # Escribirlos en el documento
    $hojaDeCuentas->setCellValueByColumnAndRow(1, $numeroDeFila, $ActGeneral);
    $hojaDeCuentas->setCellValueByColumnAndRow(2, $numeroDeFila, $ActEspecifica);
    $hojaDeCuentas->setCellValueByColumnAndRow(3, $numeroDeFila, $Responsable);
    $hojaDeCuentas->setCellValueByColumnAndRow(4, $numeroDeFila, $Academico);
    $hojaDeCuentas->setCellValueByColumnAndRow(5, $numeroDeFila, $Tecnico);
    $hojaDeCuentas->setCellValueByColumnAndRow(6, $numeroDeFila, $Financiero);
    $hojaDeCuentas->setCellValueByColumnAndRow(7, $numeroDeFila, $Infraestructura);
    $hojaDeCuentas->setCellValueByColumnAndRow(8, $numeroDeFila, $Logro);
    $hojaDeCuentas->setCellValueByColumnAndRow(9, $numeroDeFila, $Inicio);
    $hojaDeCuentas->setCellValueByColumnAndRow(10, $numeroDeFila, $Fin);

    $total = $total+$Financiero;

    $numeroDeFila++;
}
$hojaDeCuentas->mergeCells('B2:J2');
$hojaDeCuentas->mergeCells('B3:J3');
$hojaDeCuentas->mergeCells('B4:J4');
$hojaDeCuentas->mergeCells('B5:J5');
$hojaDeCuentas->mergeCells('B6:J6');
$hojaDeCuentas->mergeCells('B7:J7');

$hojaDeCuentas->getStyle('A2')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A3')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A4')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A5')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A6')->applyFromArray($styleArray);
$hojaDeCuentas->getStyle('A7')->applyFromArray($styleArray);

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

$hojaDeCuentas->setCellValue('A4', "Año");
$hojaDeCuentas->setCellValue('B4', $anio);

$hojaDeCuentas->setCellValue('A5', "Objetivo");
$hojaDeCuentas->setCellValue('B5', $objetivo);

$hojaDeCuentas->setCellValue('A6', "Estrategia");
$hojaDeCuentas->setCellValue('B6', $estrategia);

$hojaDeCuentas->setCellValue('A7', "Total de Partida");
$hojaDeCuentas->setCellValue('B7', $total);

$hojaDeCuentas->getStyle('B7')->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
$hojaDeCuentas->getStyle('B7')->getAlignment()->setHorizontal('left');
$hojaDeCuentas->getStyle('B4')->getAlignment()->setHorizontal('left');
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
    echo "Esta cuenta no posee información";
}

 }else{
	 $redireccion = Conectar::ruta()."vistas";?>
      <script type="text/javascript">
       self.location = '<?php echo $redireccion; ?>'
       </script>
<?php }
