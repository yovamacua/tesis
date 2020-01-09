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
      ->setTitle('REPORTE DE CAPACITACION')
      ->setDescription('Archivo generado por el Sistema de Campo Escuela para reportar la asistencia de una capacitación');

      $reporteCap = $documento->getActiveSheet();
      //configuracion de impresión 
      $reporteCap->getPageSetup()->setHorizontalCentered(true);
      $reporteCap->getPageSetup()->setScale(75);
      $reporteCap->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
      $reporteCap->getPageMargins()->setTop(1.3);
      $reporteCap->getPageMargins()->setRight(0.3);
      $reporteCap->getPageMargins()->setLeft(0.3);
      $reporteCap->getPageMargins()->setBottom(1.3); 

      $reporteCap->setTitle("Reporte de capacitación");


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
  $reporteCap->getStyle('B4')->applyFromArray($styleTitle);
  $reporteCap->getStyle('B5')->applyFromArray($styleTitle);
  $reporteCap->getStyle('B6')->applyFromArray($styleTitle);
  $reporteCap->getStyle('B7')->applyFromArray($styleTitle);
  $reporteCap->getStyle('B8')->applyFromArray($styleTitle);
  $reporteCap->getStyle('C4')->applyFromArray($styleTitle);
  $reporteCap->getStyle('C4')->getAlignment()->setHorizontal('left');
  $reporteCap->getStyle('C5')->applyFromArray($styleTitle);
  $reporteCap->getStyle('C6')->applyFromArray($styleTitle);
  $reporteCap->getStyle('C7')->applyFromArray($styleTitle);
  $reporteCap->getStyle('C8')->applyFromArray($styleTitle);

  $reporteCap->getStyle('A11')->applyFromArray($styleArray);
  $reporteCap->getStyle('B11')->applyFromArray($styleArray);
  $reporteCap->getStyle('C11')->applyFromArray($styleArray);
  $reporteCap->getStyle('D11')->applyFromArray($styleArray);

  //AGREGAMOS EL ANCHO DE LA COLUMNA
  $reporteCap->getColumnDimension('A')->setWidth(17);
  $reporteCap->getColumnDimension('B')->setWidth(25);
  $reporteCap->getColumnDimension('C')->setWidth(25);
  $reporteCap->getColumnDimension('D')->setWidth(25);

  //AGREGANDO EL TITUTLO DE LAS COLUMNAS
  $encabezado = ["CORRELATIVO", "NOMBRE", "APELLIDO", "DUI"];
  $reporteCap->fromArray($encabezado, null, 'A11');


   // TITULO DEL REPORTE
  $valor = "REPORTE DE CAPACITACION";
  $reporteCap->setCellValue('A2', $valor);
  $reporteCap->getStyle('A2')->applyFromArray($fontStyle);
  $reporteCap->mergeCells('A2:D2');

    // las consultas de los datos 
    $sql1 = "select cap.id_capacitacion, cap.fecha, cap.nombreGrupo, cap.cargo, cap.encargado, cap.id_usuario
              from capacitaciones cap where id_capacitacion=?";
            
    $sql1 = $bd->prepare($sql1, [PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL , ]);
            $sql1->bindValue(1, $_POST["id_capacitacion"]);
            $sql1->execute();

    $capacitacion  =  $sql1-> fetchObject ();
    $id_capacitacion = $capacitacion ->id_capacitacion;
    $fecha = $capacitacion ->fecha;
        $date_inicial = $fecha;
        $date = str_replace('-', '/', $date_inicial);
        $fecha_final = date("d/m/Y", strtotime($date));
    $nombreGrupo = $capacitacion ->nombreGrupo;
    $cargo = $capacitacion ->cargo;
    $encargado = $capacitacion ->encargado;

    $sql2 = "select dc.nombres, dc.apellidos, dc.dui from detallecapacitados dc where id_capacitacion=?";
            
    $sql2 = $bd->prepare($sql2, [PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL , ]);
            $sql2->bindValue(1, $_POST["id_capacitacion"]);
            $sql2->execute();
             
    $numeroDeFila = 12 ;
    $num = 1;
    
  while ( $capacitados  =  $sql2-> fetchObject ()) {
      # Obtener los datos de la base de datos
      $item = $num;
      $num = $num + 1;
      $nombres = $capacitados ->nombres;
      $apellidos = $capacitados ->apellidos;
      $dui = $capacitados ->dui;

      # Escribirlos en el documento
      $reporteCap -> setCellValueByColumnAndRow ( 1, $numeroDeFila, $item );
      $reporteCap -> setCellValueByColumnAndRow ( 2, $numeroDeFila, $nombres );
      $reporteCap -> setCellValueByColumnAndRow ( 3, $numeroDeFila, $apellidos );
      $reporteCap -> setCellValueByColumnAndRow ( 4, $numeroDeFila, $dui );
      $numeroDeFila ++ ;
      $item ++;
      $id=$numeroDeFila-1;

      // aplica formato a la celda con el contenido
      // la consulta de los datos
         
      $reporteCap->getStyle('A11:A'.$id)->applyFromArray($styleArray);
      $reporteCap->getStyle('B11:B'.$id)->applyFromArray($styleArray);
      $reporteCap->getStyle('C11:C'.$id)->applyFromArray($styleArray);
      $reporteCap->getStyle('D11:D'.$id)->applyFromArray($styleArray); 
  }

    // parte del titulo 
    $reporteCap->setCellValue('B4', "No. de capacitación:");
    $reporteCap->setCellValue('C4', $id_capacitacion);
    $reporteCap->setCellValue('B5', "Fecha:");
    $reporteCap->setCellValue('C5', $fecha_final);
    $reporteCap->setCellValue('B6', "Nombre del grupo:");
    $reporteCap->setCellValue('C6', $nombreGrupo);
    $reporteCap->setCellValue('B7', "Encargado:");
    $reporteCap->setCellValue('C7', $encargado);
    $reporteCap->setCellValue('B8', "Cargo:");
    $reporteCap->setCellValue('C8', $cargo);

    // Nombre del archivo descargado
    $archivogenerado = 'Reporte_Capacitación'.'.xlsx';
    $writer = new Xlsx($documento);
    # Le pasamos la ruta de guardado
    ob_end_clean();
    $writer->save($archivogenerado);

    header('Content-disposition: attachment; filename=' .$archivogenerado);
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    readfile($archivogenerado);
    unlink($archivogenerado);

   ?>
