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
      ->setTitle('Registro de Venta/Semanal')
      ->setDescription('Archivo generado por el Sistema de Campo Escuela para consulta la información de una cuenta');

     $registro_venta = $documento->getActiveSheet();
      //configuracion de impresión 
      $registro_venta->getPageSetup()->setHorizontalCentered(true);
      $registro_venta->getPageSetup()->setScale(75);
       $registro_venta->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
         $registro_venta->getPageMargins()->setTop(1.3);
  $registro_venta->getPageMargins()->setRight(0.3);
  $registro_venta->getPageMargins()->setLeft(0.3);
  $registro_venta->getPageMargins()->setBottom(1.3);

      

  $registro_venta->setTitle("Reporte de Venta");



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

   $registro_venta->getStyle('B10')->applyFromArray($styleArray);
   $registro_venta->getStyle('C10')->applyFromArray($styleArray);
   $registro_venta->getStyle('D10')->applyFromArray($styleArray);
   $registro_venta->getStyle('E10')->applyFromArray($styleArray);
    $registro_venta->getStyle('F10')->applyFromArray($styleArray);
   
      //AGREGAMOS EL ANCHO DE LA COLUMNA
  $registro_venta->getColumnDimension('A')->setWidth(25);
  $registro_venta->getColumnDimension('B')->setWidth(18);
  $registro_venta->getColumnDimension('C')->setWidth(15);
  $registro_venta->getColumnDimension('D')->setWidth(19);
  $registro_venta->getColumnDimension('E')->setWidth(18);
  $registro_venta->getColumnDimension('F')->setWidth(18);
  $registro_venta->getColumnDimension('G')->setWidth(18);
  $registro_venta->getColumnDimension('H')->setWidth(18);
  $registro_venta->getColumnDimension('I')->setWidth(18);
  //AGREGANDO EL TITUTLO DE TABLAS VENTAS POR PRODUCTOS
  $encabezado = ["PRODUCTO","CANTIDAD", "PRECIO VENTA","TOTAL","FECHA VENTA"];
  $registro_venta->fromArray($encabezado, null, 'B10');


  // la consulta de los datos
         $date_inicial = $_POST["fecha"];
              $date = str_replace('/', '-', $date_inicial);
              $fecha_inicial = date("Y-m-d", strtotime($date));

                $date_final = $_POST["fecha2"];
                $date = str_replace('/', '-', $date_final);
                $fecha_final = date("Y-m-d", strtotime($date));
                $id_categoria=$_POST["categoria"];
   // TITULO DEL REPORTE
  $valor= " CAMPO ESCUELA REPORTE DE VENTAS SEMANAL DE LA FECHA"." ".  $date_inicial." "."HASTA"." ".$date_final;
  $registro_venta->setCellValue('E2', $valor);
  $registro_venta->getStyle('E2')->applyFromArray($fontStyle);

         $sql= "select   p.producto ,sum(d.cantidad) as cantidad ,d.precio_venta,sum(d.cantidad*d.precio_venta) as total,  v.fechaventa as Fecha_venta
           from detalleventas d inner join producto p on d.id_producto= p.id_producto
            inner join  categorias c on p.idcategorias = c.id_categoria
           inner join ventas v on v.idventas =d.id_ventas where   v.fechaventa between ? and ? and c.id_categoria=? and v.estado='1'
            group by  p.producto, d.id_detalle order by  v.fechaventa, count(1) asc;";
            
              $sql = $bd->prepare($sql,[
      PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
  ]);
              $sql->bindValue(1, $fecha_inicial);
              $sql->bindValue(2,$fecha_final);
              $sql->bindValue(3,$id_categoria);
              $sql->execute();
             

      $numeroDeFila  =  11 ;
      //foreach($venta as $row){

  while ( $venta  =  $sql-> fetchObject ()) {
      # Obtener los datos de la base de datos
      $producto  =  $venta ->producto ;
      $cantidad  =  $venta ->cantidad ;
      $precio_venta  =  $venta ->precio_venta ;
      $total  =  $venta ->total;
      $Fecha_venta = $venta ->Fecha_venta;
      $newDate = date("d/m/Y", strtotime($Fecha_venta));
      # Escribirlos en el documento
      $registro_venta -> setCellValueByColumnAndRow ( 2 , $numeroDeFila , $producto );
      $registro_venta -> setCellValueByColumnAndRow ( 3 , $numeroDeFila , $cantidad );
      $registro_venta -> setCellValueByColumnAndRow ( 4, $numeroDeFila , $precio_venta );
      $registro_venta -> setCellValueByColumnAndRow ( 5, $numeroDeFila , $total );
      $registro_venta -> setCellValueByColumnAndRow ( 6, $numeroDeFila ,  $newDate );
      $numeroDeFila ++ ;
      $id=$numeroDeFila-1;
      // aplica formato a la celda con el contenido
      // la consulta de los datos
         

   $registro_venta->getStyle('B11:B'.$id)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
  $registro_venta->getStyle('C11:C'.$id)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
  $registro_venta->getStyle('D11:D'.$id)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
  $registro_venta->getStyle('E11:E'.$id)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00); 
  $registro_venta->getStyle('F11:F'.$id)->applyFromArray($styleArray)->getNumberFormat()
      ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY); 
    }
  $titulo=$id+8;
  //AGREGANDO EL TITUTLO DE TABLAS VENTAS POR DIA
  $registro_venta->setCellValue('E'.$titulo, "LISTADO DE VENTA POR PRODUCTO EN DÍA");
  $registro_venta->getStyle('E'.$titulo)->applyFromArray($fontStyle);


    //aplicando estilo a las celdas A LA SEGUNDA TABLA

  $i=$id+10;
  $registro_venta->getStyle('B'.$i)->applyFromArray($styleArray);
   $registro_venta->getStyle('C'.$i)->applyFromArray($styleArray);
   $registro_venta->getStyle('D'.$i)->applyFromArray($styleArray);
   $registro_venta->getStyle('E'.$i)->applyFromArray($styleArray);
    $registro_venta->getStyle('F'.$i)->applyFromArray($styleArray);
    $registro_venta->getStyle('G'.$i)->applyFromArray($styleArray);
    $registro_venta->getStyle('H'.$i)->applyFromArray($styleArray);
    $registro_venta->getStyle('I'.$i)->applyFromArray($styleArray);
    //arreglo para el titulo de las columnas
    $encabezado2 = ["PRODUCTO","LUNES", "MARTES","MIERCOLES","JUEVES","VIERNES","SABADO","TOTAL"];
    $registro_venta->fromArray($encabezado2, null, 'B'.$i);

    // datos vendido por dia
  $date_inicial = $_POST["fecha"];
              $date = str_replace('/', '-', $date_inicial);
              $fecha_inicial1 = date("Y-m-d", strtotime($date));

                $date_final = $_POST["fecha2"];
                $date = str_replace('/', '-', $date_final);
                $fecha_final2 = date("Y-m-d", strtotime($date));

         $sql1= "select p.producto,
  sum(IF(DATE_FORMAT(fechaventa,'%a')='Mon',d.cantidad*d.precio_venta,0)) as Lunes,
  sum(IF(DATE_FORMAT(fechaventa,'%a')='Tue',d.cantidad*d.precio_venta,0)) as Martes,
  sum(IF(DATE_FORMAT(fechaventa,'%a')='Wed',d.cantidad*d.precio_venta,0)) as Miercoles,
  sum(IF(DATE_FORMAT(fechaventa,'%a')='Thu',d.cantidad*d.precio_venta,0)) as Jueves, 
  sum(IF(DATE_FORMAT(fechaventa,'%a')='Fri',d.cantidad*d.precio_venta,0)) as Viernes,
  sum(IF(DATE_FORMAT(fechaventa,'%a')='Sat',d.cantidad*d.precio_venta,0)) as  Sabado 
  from producto p
  left join detalleventas d  on d.id_producto=p.id_producto
  inner join ventas on idventas=id_ventas
  inner join categorias c on c.id_categoria= p.idcategorias
  where fechaventa between ? and ? + INTERVAL 7 DAY

      and estado='1' and c.id_categoria=?
      group by producto;";

            $id_categorias=$_POST["categoria"];

           $sql1 = $bd->prepare($sql1,[
      PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
  ]);
              $sql1->bindValue(1, $fecha_inicial);
              $sql1->bindValue(2,$fecha_final);
              $sql1->bindValue(3,$id_categorias);
              $sql1->execute();
            $semana= $sql1->fetchall(PDO::FETCH_ASSOC);

              $numeroDeFilas=$i+1;
              
             foreach ($semana as $row) {
                   

      # Obtener los datos de la base de datos
      $Lunes=  $row["Lunes"];
      $Martes=  $row["Martes"];
      $Miercoles=$row["Miercoles"];
      $Jueves=$row["Jueves"];
      $Viernes= $row["Viernes"];
      $Sabado= $row["Sabado"];
      $productos=$row["producto"];
                 
    $registro_venta -> setCellValueByColumnAndRow ( 2 ,$numeroDeFilas,$productos);
    $registro_venta -> setCellValueByColumnAndRow ( 3 ,$numeroDeFilas,$Lunes);
    $registro_venta -> setCellValueByColumnAndRow ( 4 ,$numeroDeFilas,$Martes);
    $registro_venta -> setCellValueByColumnAndRow ( 5 , $numeroDeFilas , $Miercoles);
     $registro_venta -> setCellValueByColumnAndRow ( 6 ,$numeroDeFilas,$Jueves);
      $registro_venta -> setCellValueByColumnAndRow ( 7 ,$numeroDeFilas,$Viernes);
       $registro_venta -> setCellValueByColumnAndRow ( 8 ,$numeroDeFilas,$Sabado);
      ;
      $numeroDeFilas ++ ;
      $ids=$numeroDeFilas-1;
     //// realiza la suma de los totales
       $registro_venta->setCellValue('I'.$ids,"=SUM(C".$ids.":H".$ids.")");
   // aplica formato a la celda con el contenido
  
   $registro_venta->getStyle('B'.$ids.":B".$ids)->applyFromArray($styleArray);
  $registro_venta->getStyle('C'.$ids.":C".$ids)->applyFromArray($styleArray);
  $registro_venta->getStyle('D'.$ids.":D".$ids)->applyFromArray($styleArray);
  $registro_venta->getStyle('E'.$ids.":E".$ids)->applyFromArray($styleArray);
  $registro_venta->getStyle('F'.$ids.":F".$ids)->applyFromArray($styleArray);
  $registro_venta->getStyle('G'.$ids.":G".$ids)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00); 
  $registro_venta->getStyle('H'.$ids.":H".$ids)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00); 
  $registro_venta->getStyle('I'.$ids.":I".$ids)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode(\PhpOffice\phpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00); 
    }
  $registro_venta->getPageSetup()->setPrintArea('A1:I'.$ids);
// parte del titulo 
  $registro_venta->getStyle('A4:B5')->applyFromArray($fontStyle);
  $registro_venta->setCellValue('A4', "ELABORADO POR:");
  $registro_venta->getStyle('D8')->applyFromArray($fontStyle);
  $registro_venta->setCellValue('D8', "LISTADO DE VENTAS POR PRODUCTO:");
  $registro_venta->setCellValue('B4',  $_SESSION["nombre"]);
  $registro_venta->setCellValue('A5',  "FECHA  IMPRESA");
  $fecha=date("d-m-Y");
  $registro_venta->setCellValue('B5',  $fecha);
  //$registro_venta->setCellValue('B3',  $_SESSION["nombre"]);

  $archivogenerado = 'reporte-Semanal'.'.xlsx';
  $writer = new Xlsx($documento);
  # Le pasamos la ruta de guardado
  ob_end_clean();
  $writer->save($archivogenerado);

  header('Content-disposition: attachment; filename=' .$archivogenerado);
  header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  readfile($archivogenerado);
  unlink($archivogenerado);

   ?>
