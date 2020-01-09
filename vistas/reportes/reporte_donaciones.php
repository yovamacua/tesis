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
      ->setTitle('REPORTE DE DONACIONES')
      ->setDescription('Archivo generado por el Sistema de Campo Escuela para reportar las donaciones mensuales');

      $reporteDon = $documento->getActiveSheet();
      //configuracion de impresión 
      $reporteDon->getPageSetup()->setHorizontalCentered(true);
      $reporteDon->getPageSetup()->setScale(75);
      $reporteDon->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
      $reporteDon->getPageMargins()->setTop(1.3);
      $reporteDon->getPageMargins()->setRight(0.3);
      $reporteDon->getPageMargins()->setLeft(0.3);
      $reporteDon->getPageMargins()->setBottom(1.3); 

      $reporteDon->setTitle("Reporte de donaciones");


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
  $reporteDon->getStyle('A4')->applyFromArray($styleTitle);
  $reporteDon->getStyle('A5')->applyFromArray($styleTitle);
  $reporteDon->getStyle('B4')->applyFromArray($styleTitle);
  $reporteDon->getStyle('B5')->applyFromArray($styleTitle);
  $reporteDon->getStyle('B5')->getAlignment()->setHorizontal('left');

  $reporteDon->getStyle('A8')->applyFromArray($styleArray);
  $reporteDon->getStyle('B8')->applyFromArray($styleArray);
  $reporteDon->getStyle('C8')->applyFromArray($styleArray);
  $reporteDon->getStyle('D8')->applyFromArray($styleArray);
  $reporteDon->getStyle('E8')->applyFromArray($styleArray);
  $reporteDon->getStyle('F8')->applyFromArray($styleArray);
  $reporteDon->getStyle('H5')->applyFromArray($styleArray);
  $reporteDon->getStyle('I5')->applyFromArray($styleArray);

  //AGREGAMOS EL ANCHO DE LA COLUMNA
  $reporteDon->getColumnDimension('A')->setWidth(15);
  $reporteDon->getColumnDimension('B')->setWidth(25);
  $reporteDon->getColumnDimension('C')->setWidth(30);
  $reporteDon->getColumnDimension('D')->setWidth(10);
  $reporteDon->getColumnDimension('E')->setWidth(10);
  $reporteDon->getColumnDimension('F')->setWidth(10);
  $reporteDon->getColumnDimension('H')->setWidth(15);
  $reporteDon->getColumnDimension('I')->setWidth(10);

  //AGREGANDO EL TITUTLO DE LAS COLUMNAS
  $encabezado = ["FECHA", "DONANTE", "DESCRIPCION", "CANTIDAD", "VALOR C/U", "TOTAL"];
  $reporteDon->fromArray($encabezado, null, 'A8');

  $encabezado1 = ["MES", "TOTAL"];
  $reporteDon->fromArray($encabezado1, null, 'H5');


   // TITULO DEL REPORTE
  $valor = "REPORTE DE DONACIONES";
  $reporteDon->setCellValue('A2', $valor);
  $reporteDon->getStyle('A2')->applyFromArray($fontStyle);
  $reporteDon->mergeCells('A2:I2');

  	$anio = $_POST["year"];
  	
    // las consultas de los datos 
    $sql = "select d.id_donacion, YEAR(fecha) as anio, MONTHname(fecha) as mes, d.fecha, d.donante, d.descripcion, d.cantidad, d.precio, (d.cantidad*d.precio) as total, u.usuario 
		from donaciones d inner join usuarios u on d.id_usuario = u.id_usuario
		where YEAR(fecha)=?;";
            
    $sql = $bd->prepare($sql, [PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL , ]);
            $sql->bindValue(1, $anio);
            $sql->execute();

    $sql1 = "select YEAR(fecha) as anio, SUM(cantidad*precio) as total
			from donaciones where YEAR(fecha)=? group by YEAR(fecha) desc;";
            
    $sql1 = $bd->prepare($sql1, [PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL , ]);
            $sql1->bindValue(1, $anio);
            $sql1->execute();

    $total_dona  =  $sql1-> fetchObject ();
    $total_anio = $total_dona ->total;

    $sql2 = "select YEAR(fecha) as anio, MONTH(fecha) as mes, SUM(cantidad*precio) as total_mes
			from donaciones where YEAR(fecha)=? group by anio asc, mes asc;";
            
    $sql2 = $bd->prepare($sql2, [PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL , ]);
            $sql2->bindValue(1, $anio);
            $sql2->execute();

    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    $numfil = 6;
    $dolar = "$"; 

    while ( $mes_dona  =  $sql2-> fetchObject ()){
      $total_mes = $mes_dona ->total_mes;
      $mes_num = $mes_dona ->mes;

      //recorro el array y lo imprimo
      foreach($mes_dona as $row){
      	$mes = $meses[date($mes_num, strtotime($row["mes"]))-1];
      }

      # Escribirlos en el documento
      $reporteDon -> setCellValueByColumnAndRow ( 8, $numfil, $mes);
      $reporteDon -> setCellValueByColumnAndRow ( 9, $numfil, $dolar.$total_mes);
      $numfil ++ ;
      $id1 = $numfil-1;

      // aplica formato a la celda con el contenido
      // la consulta de los datos
         
      $reporteDon->getStyle('H6:H'.$id1)->applyFromArray($styleArray);
      $reporteDon->getStyle('I6:I'.$id1)->applyFromArray($styleArray);
    }
     
    $numeroDeFila = 9 ;

  while ( $donaciones  =  $sql-> fetchObject ()) {
      # Obtener los datos de la base de datos

  	  $fecha = $donaciones ->fecha;
         $date_inicial = $fecha;
         $date = str_replace('-', '/', $date_inicial);
         $fecha_final = date("d/m/Y", strtotime($date));
      $donante = $donaciones ->donante;
      $descripcion = $donaciones ->descripcion;
      $cantidad = $donaciones ->cantidad;
      $precio = $donaciones ->precio;
      $total = $donaciones ->total;

      # Escribirlos en el documento
      $reporteDon -> setCellValueByColumnAndRow ( 1, $numeroDeFila, $fecha_final);
      $reporteDon -> setCellValueByColumnAndRow ( 2, $numeroDeFila, $donante);
      $reporteDon -> setCellValueByColumnAndRow ( 3, $numeroDeFila, $descripcion);
      $reporteDon -> setCellValueByColumnAndRow ( 4, $numeroDeFila, $cantidad);
      $reporteDon -> setCellValueByColumnAndRow ( 5, $numeroDeFila, $dolar.$precio);
      $reporteDon -> setCellValueByColumnAndRow ( 6, $numeroDeFila, $dolar.$total);
      $numeroDeFila ++ ;
      $id = $numeroDeFila-1;

      // aplica formato a la celda con el contenido
      // la consulta de los datos
         
      $reporteDon->getStyle('A8:A'.$id)->applyFromArray($styleArray);
      $reporteDon->getStyle('B8:B'.$id)->applyFromArray($styleArray);
      $reporteDon->getStyle('C8:C'.$id)->applyFromArray($styleArray);
      $reporteDon->getStyle('D8:D'.$id)->applyFromArray($styleArray);
      $reporteDon->getStyle('E8:E'.$id)->applyFromArray($styleArray); 
      $reporteDon->getStyle('F8:F'.$id)->applyFromArray($styleArray); 
  }

    // parte del titulo 
    $reporteDon->setCellValue('A4', "Autor:");
    $reporteDon->setCellValue('B4', $_SESSION["nombre"]);
    $reporteDon->setCellValue('A5', "Año:");
    $reporteDon->setCellValue('B5', $anio);
    $reporteDon->setCellValue('C4', "Total donación del ".$anio);
    $reporteDon->setCellValue('D4', $dolar.$total_anio);
    $reporteDon->setCellValue('A7', "LISTADO DE DONACIONES MENSUALES");
    $reporteDon->setCellValue('H4', "TOTAL POR MES DEL ".$anio);

    $reporteDon->mergeCells('C4:C5');
    $reporteDon->mergeCells('D4:D5');
    $reporteDon->mergeCells('A7:F7');
    $reporteDon->mergeCells('H4:I4');

    $reporteDon->getStyle('C4:C5')->applyFromArray($styleArray);
    $reporteDon->getStyle('C4:C5')->getAlignment()->setVertical('center');
    $reporteDon->getStyle('D4:D5')->applyFromArray($styleArray);
    $reporteDon->getStyle('D4:D5')->getAlignment()->setVertical('center');
    $reporteDon->getStyle('A7:F7')->applyFromArray($styleArray);
    $reporteDon->getStyle('A7:F7')->getAlignment()->setVertical('center');
    $reporteDon->getStyle('H4:I4')->applyFromArray($styleArray);
    $reporteDon->getStyle('H4:I4')->getAlignment()->setVertical('center');

    // Nombre del archivo descargado
    $archivogenerado = 'Reporte_Donacion'.'.xlsx';
    $writer = new Xlsx($documento);
    # Le pasamos la ruta de guardado
    ob_end_clean();
    $writer->save($archivogenerado);

    header('Content-disposition: attachment; filename=' .$archivogenerado);
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    readfile($archivogenerado);
    unlink($archivogenerado);

   ?>
