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
  $hacer_pedido->getStyle('C14')->applyFromArray($styleArray);
  $hacer_pedido->getStyle('D14')->applyFromArray($styleArray);
  $hacer_pedido->getStyle('E14')->applyFromArray($styleArray);
  $hacer_pedido->getStyle('F14')->applyFromArray($styleArray);
  $hacer_pedido->getStyle('G14')->applyFromArray($styleArray);
   
  //AGREGAMOS EL ANCHO DE LA COLUMNA
  $hacer_pedido->getColumnDimension('A')->setWidth(30);
  $hacer_pedido->getColumnDimension('B')->setWidth(35);
  $hacer_pedido->getColumnDimension('C')->setWidth(10);
  $hacer_pedido->getColumnDimension('D')->setWidth(15);
  $hacer_pedido->getColumnDimension('E')->setWidth(20);
  $hacer_pedido->getColumnDimension('F')->setWidth(40);
  $hacer_pedido->getColumnDimension('G')->setWidth(30);

  //AGREGANDO EL TITUTLO DE LAS COLUMNAS
  $encabezado = ["ITEM","CANTIDAD", "UNIDAD DE MEDIDA","OBRA, BIEN O SERVICIO SOLICITADO","ESPECIFICACIONES"];
  $hacer_pedido->fromArray($encabezado, null, 'C14');


   // TITULO DEL REPORTE
  $valor = "SOLICITUD O REQUERIMIENTO DE OBRA BIEN O SERVICIO";
  $hacer_pedido->setCellValue('F2', $valor);
  $hacer_pedido->getStyle('F2')->applyFromArray($fontStyle);

    $fecha1 = $_POST["fecha"];

    // la consulta de los datos 
    $sql = "select cantidad, unidadMedida, nombreInsumo, descripcion from detallepedidos where id_pedido=?";
            
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
      $unidadMedida = $pedido ->unidadMedida;
      $nombreInsumo = $pedido ->nombreInsumo;
      $descripcion = $pedido ->descripcion;

      # Escribirlos en el documento
      $hacer_pedido -> setCellValueByColumnAndRow ( 3, $numeroDeFila , $item );
      $hacer_pedido -> setCellValueByColumnAndRow ( 4, $numeroDeFila , $cantidad );
      $hacer_pedido -> setCellValueByColumnAndRow ( 5, $numeroDeFila , $unidadMedida );
      $hacer_pedido -> setCellValueByColumnAndRow ( 6, $numeroDeFila , $nombreInsumo );
      $hacer_pedido -> setCellValueByColumnAndRow ( 7, $numeroDeFila , $descripcion );
      $numeroDeFila ++ ;
      $item ++;
      $id=$numeroDeFila-1;
      // aplica formato a la celda con el contenido
      // la consulta de los datos
         

      $hacer_pedido->getStyle('C14:C'.$id)->applyFromArray($styleArray);
      $hacer_pedido->getStyle('D14:D'.$id)->applyFromArray($styleArray);
      $hacer_pedido->getStyle('E14:E'.$id)->applyFromArray($styleArray);
      $hacer_pedido->getStyle('F14:F'.$id)->applyFromArray($styleArray); 
      $hacer_pedido->getStyle('G14:G'.$id)->applyFromArray($styleArray); 
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
    $hacer_pedido->setCellValue('E5', "FIRMA DEL SOLICITANTE:");
    $hacer_pedido->setCellValue('F5', " ");
    $hacer_pedido->setCellValue('E8', "FIRMA DEL AUTORIZANTE:");
    $hacer_pedido->setCellValue('F8', " ");
    $hacer_pedido->setCellValue('A11', "JUSTIFICACION DE LA SOLICITUD:");
    $hacer_pedido->setCellValue('B12', " ");

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
