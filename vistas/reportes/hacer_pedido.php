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
      ->setTitle('SOLICITUD O REQUERIMIENTO DE OBRA BIEN O SERVICIO')
      ->setDescription('Archivo generado por el Sistema de Campo Escuela para hacer pedido de insumos');

      $hacer_pedido = $documento->getActiveSheet();
      //configuracion de impresión 
      $hacer_pedido->getPageSetup()->setHorizontalCentered(true);
      $hacer_pedido->getPageSetup()->setScale(75);
      $hacer_pedido->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
      $hacer_pedido->getPageMargins()->setTop(1.3);
      $hacer_pedido->getPageMargins()->setRight(0.3);
      $hacer_pedido->getPageMargins()->setLeft(0.3);
      $hacer_pedido->getPageMargins()->setBottom(1.3); 

      $hacer_pedido->setTitle("Pedido de Insumos");


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
  $hacer_pedido->getStyle('A4')->applyFromArray($styleTitle);
  $hacer_pedido->getStyle('A5')->applyFromArray($styleTitle);
  $hacer_pedido->getStyle('A6')->applyFromArray($styleTitle);
  $hacer_pedido->getStyle('A7')->applyFromArray($styleTitle);
  $hacer_pedido->getStyle('A8')->applyFromArray($styleTitle);
  $hacer_pedido->getStyle('A9')->applyFromArray($styleTitle);
  $hacer_pedido->getStyle('A10')->applyFromArray($styleTitle);

  $hacer_pedido->getStyle('A14')->applyFromArray($styleArray);
  $hacer_pedido->getStyle('B14')->applyFromArray($styleArray);
  $hacer_pedido->getStyle('C14')->applyFromArray($styleArray);
  $hacer_pedido->getStyle('D14')->applyFromArray($styleArray);
  $hacer_pedido->getStyle('E14')->applyFromArray($styleArray);
   
  //AGREGAMOS EL ANCHO DE LA COLUMNA
  $hacer_pedido->getColumnDimension('A')->setWidth(25);
  $hacer_pedido->getColumnDimension('B')->setWidth(25);
  $hacer_pedido->getColumnDimension('C')->setWidth(25);
  $hacer_pedido->getColumnDimension('D')->setWidth(30);
  $hacer_pedido->getColumnDimension('E')->setWidth(25);

  //AGREGANDO EL TITUTLO DE LAS COLUMNAS
  $encabezado = ["ITEM","CANTIDAD", "UNIDAD DE MEDIDA","OBRA, BIEN O SERVICIO SOLICITADO","ESPECIFICACIONES"];
  $hacer_pedido->fromArray($encabezado, null, 'A14');


   // TITULO DEL REPORTE
  $valor = "SOLICITUD O REQUERIMIENTO DE OBRA BIEN O SERVICIO";
  $hacer_pedido->setCellValue('A2', $valor);
  $hacer_pedido->getStyle('A2')->applyFromArray($fontStyle);
  $hacer_pedido->mergeCells('A2:E2');

    $fecha1 = $_POST["fecha"];

    // la consulta de los datos 
    $sql = "select dp.cantidad, uni.nombre, dp.nombreInsumo, dp.descripcion from detallepedidos dp inner join unidad uni on dp.id_uni = uni.idunidad where id_pedido=?";
            
    $sql = $bd->prepare($sql, [PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL , ]);
            $sql->bindValue(1, $_POST["id_pedido"]);
            $sql->execute();
             
    $numeroDeFila = 15 ;
    $num = 1;
    

  while ( $pedido  =  $sql-> fetchObject ()) {
      # Obtener los datos de la base de datos
      $item = $num;
      $num = $num + 1;
      $cantidad = $pedido ->cantidad;
      $unidadMedida = $pedido ->nombre;
      $nombreInsumo = $pedido ->nombreInsumo;
      $descripcion = $pedido ->descripcion;

      # Escribirlos en el documento
      $hacer_pedido -> setCellValueByColumnAndRow ( 1, $numeroDeFila , $item );
      $hacer_pedido -> setCellValueByColumnAndRow ( 2, $numeroDeFila , $cantidad );
      $hacer_pedido -> setCellValueByColumnAndRow ( 3, $numeroDeFila , $unidadMedida );
      $hacer_pedido -> setCellValueByColumnAndRow ( 4, $numeroDeFila , $nombreInsumo );
      $hacer_pedido -> setCellValueByColumnAndRow ( 5, $numeroDeFila , $descripcion );
      $numeroDeFila ++ ;
      $item ++;
      $id=$numeroDeFila-1;
      // aplica formato a la celda con el contenido
      // la consulta de los datos
         

      $hacer_pedido->getStyle('A14:A'.$id)->applyFromArray($styleArray);
      $hacer_pedido->getStyle('B14:B'.$id)->applyFromArray($styleArray);
      $hacer_pedido->getStyle('C14:C'.$id)->applyFromArray($styleArray);
      $hacer_pedido->getStyle('D14:D'.$id)->applyFromArray($styleArray); 
      $hacer_pedido->getStyle('E14:E'.$id)->applyFromArray($styleArray); 
  }

    // parte del titulo 
    //$hacer_pedido->getStyle('A4:B5')->applyFromArray($fontStyle);
    $hacer_pedido->setCellValue('A4', "FECHA:");
    $hacer_pedido->setCellValue('B4', $fecha1);
    $hacer_pedido->setCellValue('A5', "NOMBRE DEL SOLICITANTE:");
    $hacer_pedido->setCellValue('B5', $_SESSION["nombre"]);
    $hacer_pedido->setCellValue('A6', "CARGO:");
    $hacer_pedido->setCellValue('B6', "ADMINISTRADOR/RA DEL CAMPO ESCUELA");
    $hacer_pedido->setCellValue('A7', "DEPENDENCIA:");
    $hacer_pedido->setCellValue('B7', " ");
    $hacer_pedido->setCellValue('A8', "NOMBRE DE AUTORIZANTE:");
    $hacer_pedido->setCellValue('B8', "BLANCA MARIBEL SOLANO DE SOSA");
    $hacer_pedido->setCellValue('A9', "CARGO:");
    $hacer_pedido->setCellValue('B9', "ALCALDEZA MUNICIPAL");
    $hacer_pedido->setCellValue('A10', "DEPENDENCIA:");
    $hacer_pedido->setCellValue('B10', "CONCEJO MUNICIPAL");
    $hacer_pedido->setCellValue('D5', "FIRMA DEL SOLICITANTE:");
    $hacer_pedido->setCellValue('F5', " ");
    $hacer_pedido->setCellValue('D8', "FIRMA DEL AUTORIZANTE:");
    $hacer_pedido->setCellValue('F8', " ");
    $hacer_pedido->setCellValue('A11', "JUSTIFICACION DE LA SOLICITUD:");
    $hacer_pedido->setCellValue('B12', " ");

    $hacer_pedido->mergeCells('B4:E4');
    $hacer_pedido->mergeCells('B5:C5');
    $hacer_pedido->mergeCells('B6:C6');
    $hacer_pedido->mergeCells('B7:C7');
    $hacer_pedido->mergeCells('B8:C8');
    $hacer_pedido->mergeCells('B9:C9');
    $hacer_pedido->mergeCells('B10:C10');
    $hacer_pedido->mergeCells('D5:D7');
    $hacer_pedido->mergeCells('D8:D10');
    $hacer_pedido->mergeCells('E5:E7');
    $hacer_pedido->mergeCells('E8:E10');
    $hacer_pedido->mergeCells('A11:E11');
    $hacer_pedido->mergeCells('A12:E12');
    
    $hacer_pedido->getStyle('B4:E4')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('B5:C5')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('B6:C6')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('B7:C7')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('B8:C8')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('D5:D7')->applyFromArray($styleArray);
    $hacer_pedido->getStyle('D8:D10')->applyFromArray($styleArray);
    $hacer_pedido->getStyle('D5:D7')->getAlignment()->setVertical('center');
    $hacer_pedido->getStyle('D8:D10')->getAlignment()->setVertical('center');
    $hacer_pedido->getStyle('B9:C9')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('B10:C10')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('D5:D7')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('D8:D10')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('E5:E7')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('E8:E10')->applyFromArray($styleTitle);
    $hacer_pedido->getStyle('A11:E11')->applyFromArray($styleArray);
    $hacer_pedido->getStyle('A12:E12')->applyFromArray($styleTitle);


    // Nombre del archivo descargado
    $archivogenerado = 'PedidoInsumos'.'.xlsx';
    $writer = new Xlsx($documento);
    # Le pasamos la ruta de guardado
    ob_end_clean();
    $writer->save($archivogenerado);

    header('Content-disposition: attachment; filename=' .$archivogenerado);
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    readfile($archivogenerado);
    unlink($archivogenerado);

   ?>
