<?php
 
  require_once("../../config/conexion.php");

  if(isset($_SESSION["id_usuario"]))
        
    # Conexion base de datos
  $bd = new Conectar();
  $bd =  $bd->conexion();

  require_once "vendor/autoload.php";

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

  $documento = new Spreadsheet();
  $documento
      ->getProperties()
      ->setCreator("Campo Escuela")
      ->setLastModifiedBy('Campo Escuela')
      ->setTitle('REPORTE DE GASTOS')
      ->setDescription('Archivo generado por el Sistema de Campo Escuela para reportar las gastos mensuales');

      $reporteGastos = $documento->getActiveSheet();
      //configuracion de impresión 
      $reporteGastos->getPageSetup()->setHorizontalCentered(true);
      $reporteGastos->getPageSetup()->setScale(75);
      $reporteGastos->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
      $reporteGastos->getPageMargins()->setTop(1.3);
      $reporteGastos->getPageMargins()->setRight(0.3);
      $reporteGastos->getPageMargins()->setLeft(0.3);
      $reporteGastos->getPageMargins()->setBottom(1.3); 

      $reporteGastos->setTitle("Reporte de donaciones");


  $styleTitle = [
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
      'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
      ],
  ];
  $fontStyle = [
      'font' => [
          'size' => 16,
           'bold' => true,
      ],
      'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
  ];


  //APLICAMOS ESTILO A LAS CELDAS
  $reporteGastos->getStyle('A4')->applyFromArray($styleTitle);
  $reporteGastos->getStyle('A5')->applyFromArray($styleTitle);
  $reporteGastos->getStyle('B4')->applyFromArray($styleTitle);
  $reporteGastos->getStyle('B5')->applyFromArray($styleTitle);
  $reporteGastos->getStyle('B5')->getAlignment()->setHorizontal('left');

  $reporteGastos->getStyle('A8')->applyFromArray($styleArray);
  $reporteGastos->getStyle('B8')->applyFromArray($styleArray);
  $reporteGastos->getStyle('C8')->applyFromArray($styleArray);
  $reporteGastos->getStyle('F5')->applyFromArray($styleArray);
  $reporteGastos->getStyle('G5')->applyFromArray($styleArray);

  //AGREGAMOS EL ANCHO DE LA COLUMNA
  $reporteGastos->getColumnDimension('A')->setWidth(15);
  $reporteGastos->getColumnDimension('B')->setWidth(40);
  $reporteGastos->getColumnDimension('C')->setWidth(20);
  $reporteGastos->getColumnDimension('F')->setWidth(15);
  $reporteGastos->getColumnDimension('G')->setWidth(10);

  //AGREGANDO EL TITUTLO DE LAS COLUMNAS
  $encabezado = ["FECHA", "DESCRIPCION", "GASTO"];
  $reporteGastos->fromArray($encabezado, null, 'A8');

  $encabezado1 = ["MES", "TOTAL"];
  $reporteGastos->fromArray($encabezado1, null, 'F5');


   // TITULO DEL REPORTE
  $valor = "REPORTE DE GASTOS";
  $reporteGastos->setCellValue('A2', $valor);
  $reporteGastos->getStyle('A2')->applyFromArray($fontStyle);
  $reporteGastos->mergeCells('A2:I2');

  	$anio = $_POST["year"];
  	
    // las consultas de los datos 
    $sql = "select g.id_gasto, YEAR(fecha) as anio, MONTHname(fecha) as mes, g.fecha, g.descripcion, g.precio, u.usuario from gastos g inner join usuarios u on g.id_usuario = u.id_usuario where YEAR(fecha)=?;";
            
    $sql = $bd->prepare($sql, [PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL , ]);
            $sql->bindValue(1, $anio);
            $sql->execute();

    $sql1 = "select YEAR(fecha) as anio, SUM(precio) as gasto
      from gastos where YEAR(fecha)=? group by YEAR(fecha) desc;";
            
    $sql1 = $bd->prepare($sql1, [PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL , ]);
            $sql1->bindValue(1, $anio);
            $sql1->execute();

    $total_gasto  =  $sql1-> fetchObject ();
    $total_anio = $total_gasto ->gasto;

    $sql2 = "select YEAR(fecha) as anio, MONTH(fecha) as mes, SUM(precio) as total_mes
      from gastos where YEAR(fecha)=? group by anio asc, mes asc;";
            
    $sql2 = $bd->prepare($sql2, [PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL , ]);
            $sql2->bindValue(1, $anio);
            $sql2->execute();

    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $numfil = 6;
    $dolar = "$"; 

    while ( $mes_gasto  =  $sql2-> fetchObject ()){
      $total_mes = $mes_gasto ->total_mes;
      $mes_num = $mes_gasto ->mes;

      //recorro el array y lo imprimo
      foreach($mes_gasto as $row){
      	$mes = $meses[date($mes_num, strtotime($row["mes"]))-1];
      }

      # Escribirlos en el documento
      $reporteGastos -> setCellValueByColumnAndRow ( 6, $numfil, $mes);
      $reporteGastos -> setCellValueByColumnAndRow ( 7, $numfil, $dolar.$total_mes);
      $numfil ++ ;
      $id1 = $numfil-1;

      // aplica formato a la celda con el contenido
      // la consulta de los datos
         
      $reporteGastos->getStyle('F6:F'.$id1)->applyFromArray($styleArray);
      $reporteGastos->getStyle('G6:G'.$id1)->applyFromArray($styleArray);
    }
     
    $numeroDeFila = 9 ;

  while ( $gastos  =  $sql-> fetchObject ()) {
      # Obtener los datos de la base de datos

  	  $fecha = $gastos ->fecha;
         $date_inicial = $fecha;
         $date = str_replace('-', '/', $date_inicial);
         $fecha_final = date("d/m/Y", strtotime($date));
      $descripcion = $gastos ->descripcion;
      $precio = $gastos ->precio;

      # Escribirlos en el documento
      $reporteGastos -> setCellValueByColumnAndRow ( 1, $numeroDeFila, $fecha_final);
      $reporteGastos -> setCellValueByColumnAndRow ( 2, $numeroDeFila, $descripcion);
      $reporteGastos -> setCellValueByColumnAndRow ( 3, $numeroDeFila, $dolar.$precio);
      $numeroDeFila ++ ;
      $id = $numeroDeFila-1;

      // aplica formato a la celda con el contenido
      // la consulta de los datos
         
      $reporteGastos->getStyle('A8:A'.$id)->applyFromArray($styleArray);
      $reporteGastos->getStyle('B8:B'.$id)->applyFromArray($styleArray);
      $reporteGastos->getStyle('C8:C'.$id)->applyFromArray($styleArray);
  }

    // parte del titulo 
    $reporteGastos->setCellValue('A4', "Autor:");
    $reporteGastos->setCellValue('B4', $_SESSION["nombre"]);
    $reporteGastos->setCellValue('A5', "Año:");
    $reporteGastos->setCellValue('B5', $anio);
    $reporteGastos->setCellValue('C4', "Total gasto del ".$anio);
    $reporteGastos->setCellValue('D4', $dolar.$total_anio);
    $reporteGastos->setCellValue('A7', "LISTADO DE GASTOS MENSUALES");
    $reporteGastos->setCellValue('F4', "TOTAL POR MES DEL ".$anio);

    $reporteGastos->mergeCells('C4:C5');
    $reporteGastos->mergeCells('D4:D5');
    $reporteGastos->mergeCells('A7:C7');
    $reporteGastos->mergeCells('F4:G4');

    $reporteGastos->getStyle('C4:C5')->applyFromArray($styleArray);
    $reporteGastos->getStyle('C4:C5')->getAlignment()->setVertical('center');
    $reporteGastos->getStyle('D4:D5')->applyFromArray($styleArray);
    $reporteGastos->getStyle('D4:D5')->getAlignment()->setVertical('center');
    $reporteGastos->getStyle('A7:C7')->applyFromArray($styleArray);
    $reporteGastos->getStyle('A7:C7')->getAlignment()->setVertical('center');
    $reporteGastos->getStyle('F4:G4')->applyFromArray($styleArray);
    $reporteGastos->getStyle('F4:G4')->getAlignment()->setVertical('center');

    // Nombre del archivo descargado
    $archivogenerado = 'Reporte_Gasto'.'.xlsx';
    $writer = new Xlsx($documento);
    # Le pasamos la ruta de guardado
    ob_end_clean();
    $writer->save($archivogenerado);

    header('Content-disposition: attachment; filename=' .$archivogenerado);
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    readfile($archivogenerado);
    unlink($archivogenerado);

   ?>