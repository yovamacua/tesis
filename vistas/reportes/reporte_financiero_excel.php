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
        ->setTitle('Registro financiero /Anual')
        ->setDescription('Archivo generado por el Sistema de Campo Escuela para consulta la información de una cuenta');
       $documento->setActiveSheetIndex(0);// indice para diferenciar las hojas

        $estado_resultado=$documento->getActiveSheet();
   //configuracion de impresión 
        $estado_resultado->getPageSetup()->setHorizontalCentered(true);
        $estado_resultado->getPageSetup()->setScale(75);
         $estado_resultado->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
           $estado_resultado->getPageMargins()->setTop(1.3);
         $estado_resultado->getPageMargins()->setRight(0.3);
       $estado_resultado->getPageMargins()->setLeft(0.3);
         $estado_resultado->getPageMargins()->setBottom(1.3);
         $estado_resultado->setTitle("Estado de Resultado");// titulo de la hoja

  //***********************************************************************************///
  //estilo a usar para las celdas
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
            'size' => 13,
             'bold' => true,
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
    ];
  //*******************************************************************************///
   // parte del titulo 
    $estado_resultado->getStyle('A4:B5')->applyFromArray($fontStyle);
    $estado_resultado->setCellValue('A4', "ELABORADO POR:");
    $estado_resultado->setCellValue('B4',  $_SESSION["nombre"]);
    $estado_resultado->setCellValue('A5',  "FECHA  IMPRESA");
    $fecha=date("d-m-Y");
    $estado_resultado->setCellValue('B5',  $fecha);
     $estado_resultado->setCellValue('B10', "INGRESO");
  // dimesion de las columnas
    $estado_resultado->getColumnDimension('A')->setWidth(25);
    $estado_resultado->getColumnDimension('B')->setWidth(25);
    $estado_resultado->getColumnDimension('C')->setWidth(18);
    $estado_resultado->getColumnDimension('D')->setWidth(23);
    $estado_resultado->getColumnDimension('E')->setWidth(18);
    $estado_resultado->getColumnDimension('F')->setWidth(18);
    $estado_resultado->getColumnDimension('G')->setWidth(18);
    $estado_resultado->getColumnDimension('H')->setWidth(18);
    $estado_resultado->getColumnDimension('I')->setWidth(18);

    ///formato
     $estado_resultado->getStyle('B10:B50')->applyFromArray($fontStyle);
     $estado_resultado->getStyle('C10:C50')->applyFromArray($fontStyle);
     $estado_resultado->getStyle('D10:D50')->applyFromArray($fontStyle);
    $estado_resultado->getStyle('B10:D23')->applyFromArray($styleArray);
     $estado_resultado->getStyle('B10:B23')->applyFromArray($styleArray);
     $estado_resultado->getStyle('C10:C23')->applyFromArray($styleArray);
     $estado_resultado->getStyle('D10:D23')->applyFromArray($styleArray);

     // CAPTURA DE LOS DATOS POR METODO POST Y COMIENZA EL INGRESO
           $date_inicial = $_POST["fecha"];
                $date = str_replace('/', '-', $date_inicial);
                $fecha_inicial = date("Y-m-d", strtotime($date));

                  $date_final = $_POST["fecha2"];
                  $date = str_replace('/', '-', $date_final);
                  $fecha_final = date("Y-m-d", strtotime($date));

  //titulo de la hoja


   $valor= "ESTADO DE RESULTADO DEL CAMPO ESCUELA"."  ".   $date_inicial ."  "."AL"."  ".$date_final  ;
    $estado_resultado->setCellValue('C2', $valor);
    $estado_resultado->getStyle('C2')->applyFromArray($fontStyle);                

  // CONSULTA DE TOTAL DE VENTA */////
               $sql= "select sum(total_pagar) as total from ventas 
              where fechaventa  between ? and ? and estado='1';";
              
                $sql = $bd->prepare($sql,[
        PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
    ]);
                $sql->bindValue(1,$fecha_inicial);
                $sql->bindValue(2,$fecha_final);
                $sql->execute();


                $numeroDeFila  =  11 ;
        //foreach($venta as $row){

    while ( $venta  =  $sql-> fetchObject ()) {
        # Obtener los datos de la base de datos
        $total  =  $venta ->total ;
        # Escribirlos en el documento
        $estado_resultado -> setCellValueByColumnAndRow ( 3 , $numeroDeFila , $total );
        $numeroDeFila ++ ;
         $estado_resultado->setCellValue('B11', "VENTAS DE PRODUCTO");
     }
  $total_venta=$total; // captura del valor de venta para balance
     //*********************************
     //CONSULTA DE TOTAL DE DONACIONES*///
     $sql1= "select sum(precio*cantidad) as Total from donaciones
        where fecha between ? and ?;";
              
                $sql1 = $bd->prepare($sql1,[
        PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
    ]);
                $sql1->bindValue(1,$fecha_inicial);
                $sql1->bindValue(2,$fecha_final);
                $sql1->execute();
                 $donaciones= $sql1->fetchall(PDO::FETCH_ASSOC);

                $numeroDeFila  =  12 ;
        foreach($donaciones as $row){
       $Total=$row["Total"];
   
        $estado_resultado -> setCellValueByColumnAndRow ( 3 , $numeroDeFila , $Total );
        $numeroDeFila ++ ;
         $estado_resultado->setCellValue('B12', "DONACIONES");
         
     }
    $total_donacion=$Total;
     
  //CONSULTA DE TOTAL DEL INVENTARIO*///
     $sql2= "select sum(p.precio_venta*k.salida) as total from producto p 
  inner join  kardex k on k.id_producto1=p.id_producto;";
              
                $sql2 = $bd->prepare($sql2,[
        PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
    ]);
                $sql2->bindValue(1,$fecha_inicial);
                $sql2->bindValue(2,$fecha_final);
                $sql2->execute();
               $inventario = $sql2->fetchall(PDO::FETCH_ASSOC);

                $numeroDeFila  =  13 ;
    
     foreach($inventario as $row){
      
        # Obtener los datos de la base de datos
       $total=$row["total"];
        # Escribirlos en el documento
        $estado_resultado -> setCellValueByColumnAndRow ( 3 , $numeroDeFila , $total );
        $numeroDeFila ++ ;
         $estado_resultado->setCellValue('B13', "INVENTARIO");
         $ids=$numeroDeFila;
       
     }
     // CALCUCLO DE INGRESO
       $estado_resultado->setCellValue('D10','=SUM(C11:C13)');
       
     //****************************************************************************////////
     /// PARTE DE EGRESO
    $titulo=$ids+4;
   $estado_resultado->setCellValue('B'.$titulo, "EGRESO:");

   //CONSULTA  PARA EL CALCULO DEL COSTO DE PRODUCCION*///
    $date_inicial = $_POST["fecha"];
                $date = str_replace('/', '-', $date_inicial);
                $fecha_inicial1 = date("Y-m-d", strtotime($date));

                  $date_final = $_POST["fecha2"];
                  $date = str_replace('/', '-', $date_final);
                  $fecha_final1 = date("Y-m-d", strtotime($date));

                  $numeroDeFila  =  $titulo +1;
                $numero=$titulo;
                 $estado_resultado->setCellValue('B'.$numeroDeFila, "COSTO DE PRODUCCION ");

     $sql4= "select sum(i.precio*k.salida) as total from insumos i
          inner join kardexinsumo k on k.id_insumo=i.id_insumo
          where k.fechaS between ? and ? ";
              
                $sql4 = $bd->prepare($sql4,[
        PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
    ]);
                $sql4->bindValue(1,$fecha_inicial1);
                $sql4->bindValue(2,$fecha_final1);
                $sql4->execute();
               $costo = $sql4->fetchall(PDO::FETCH_ASSOC);
  //SE OBTIENE EL VALOR DE LA CONSULTA
        foreach($costo as $row){
        # Obtener los datos de la base de datos
        $costo=$row["total"];
        # Escribirlos en el documento
          // SE OBTIENE EL COSTO RESTADO TODO LO PEDIDO Y LO QUE SE TIENE EL INSUMO
        $estado_resultado -> setCellValueByColumnAndRow ( 3 , $numeroDeFila , $costo);
        $estado_resultado -> setCellValueByColumnAndRow ( 4 , $numero , $costo); 
        $numeroDeFila++;
     }
  $total_costo=$costo;// CAPTURA  PARA EL BALANCE GENERAL
  $i=$numeroDeFila+3;
    // SE CALCULA LA UTILIDAD
  $estado_resultado->setCellValue('B'.$i,"UTILIDAD NETA");
     $estado_resultado->setCellValue('D'.$i,'=D10-D18');
  //************BALANCE GENERAL*******************************************************/////
         // creacion de la segunda hoja en el libro
      $documento->createSheet(); 
      $documento->setActiveSheetIndex(1);
      $balance_general=$documento->getActiveSheet();
      $balance_general->getPageSetup()->setHorizontalCentered(true);
      $balance_general->getPageSetup()->setScale(75);
      $balance_general->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
      $balance_general->getPageMargins()->setTop(1.3);
      $balance_general->getPageMargins()->setRight(0.3);
      $balance_general->getPageMargins()->setLeft(0.3);
      $balance_general->getPageMargins()->setBottom(1.3);

      // parte del titulo 
    $balance_general->getStyle('A4:B5')->applyFromArray($fontStyle);
    $balance_general->setCellValue('A4', "ELABORADO POR:");
    $balance_general->setCellValue('B4',  $_SESSION["nombre"]);
    $balance_general->setCellValue('A5',  "FECHA  IMPRESA");
    $fecha=date("d-m-Y");
    $balance_general->setCellValue('B5',  $fecha);
  //*******************************************************************////
      //APLICACION DEL FORMATO A LAS CELDAS
    ///formato
    
    $balance_general->getStyle('C12:C50')->applyFromArray($fontStyle);
    $balance_general->getStyle('F13:F50')->applyFromArray($fontStyle);
  $balance_general->getStyle('C12:F28')->applyFromArray($styleArray);
  $balance_general->getStyle('C12:C28')->applyFromArray($styleArray);
    // dimesion de las columnas
    $balance_general->getColumnDimension('A')->setWidth(20);
    $balance_general->getColumnDimension('B')->setWidth(20);
    $balance_general->getColumnDimension('C')->setWidth(32);
    $balance_general->getColumnDimension('F')->setWidth(18);
  //**********************************************************************/////
         $balance_general->setTitle("Balance General");// titulo de la hoja
         $valor1= "BALANCE GENERAL DEL CAMPO ESCUELA"."  ".  $date_inicial ."  "."AL"."  ".$date_final ;
    $balance_general->setCellValue('C2', $valor1);
    $balance_general->getStyle('C2')->applyFromArray($fontStyle); 
  //*******************************************************/***
  $balance_general->setCellValue('C12',"ACTIVO CIRCULANTE");

  //******************CAJA CHICA******************************************/
   $sql6= "select sum(precio) as total from gastos
  where fecha between  ?  and ? ";
              
                $sql6 = $bd->prepare($sql6,[
        PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
    ]);
                $sql6->bindValue(1,$fecha_inicial);
                $sql6->bindValue(2,$fecha_final);
                $sql6->execute();
                 $caja= $sql6->fetchall(PDO::FETCH_ASSOC);

                $numeroFila  =  13 ;
        foreach($caja as $row){
       $totalCaja=$row["total"];
        $balance_general-> setCellValueByColumnAndRow ( 6 , $numeroFila , $totalCaja );
        $numeroFila ++ ;
         $balance_general->setCellValue('C13', "CAJA CHICA");
         
     }

       $balance_general->setCellValue('C15', "ACTIVO FIJOS"); 
      //****************INVENTARIO **************//
   $sql7= "select sum(p.precio_venta*k.stock) as total from producto p 
  inner join  kardex k on k.id_producto1=p.id_producto;";
              
                $sql7 = $bd->prepare($sql7,[
        PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
    ]);
                $sql7->bindValue(1,$fecha_inicial);
                $sql7->bindValue(2,$fecha_final);
                $sql7->execute();
                 $herramienta= $sql7->fetchall(PDO::FETCH_ASSOC);

                $numeroFila  =  16 ;
        foreach($herramienta as $row){
       $fertilizante=$row["total"];
        $balance_general-> setCellValueByColumnAndRow ( 6 , $numeroFila , $fertilizante);
        $numeroFila ++ ;
         $balance_general->setCellValue('C16', "INVENTARIO");
         
     }

  //******************************DONACIONES ***********************//
      $balance_general->setCellValue('C17', "HERRAMIENTA Y FERTILIZANTES");
       $balance_general->setCellValue('F17', $total_donacion);
     //***************************COSTO DE PRODUCCION PARA BALANCE *****//
       $balance_general->setCellValue('C18', "COSTO DE PRODUCCION");
       $balance_general->setCellValue('F18', $total_costo);
   //****************VENTA **************//
        $balance_general->setCellValue('C19', "VENTA");
       $balance_general->setCellValue('F19', $total_venta);
    $balance_general->setCellValue('C21', "TOTAL ACTIVO");
         $balance_general->setCellValue('F21', '=SUM(F13:F20)');
          
  //**********************PASIVO ****************// 
  $balance_general->setCellValue('C25',"PASIVO Y CAPITAL");
   //**********************PERDIDA ****************// 
   $anio = date("Y", strtotime($fecha_inicial));
   $sql8= "select sum(cantidad *precioProduc) as total from perdidas
  where anio=?;";
              
                $sql8 = $bd->prepare($sql8,[
        PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
    ]);
                $sql8->bindValue(1,$anio);
                $sql8->execute();
                 $perdida= $sql8->fetchall(PDO::FETCH_ASSOC);

                $numeroFila  =  26;
        foreach($perdida as $row){
       $perdid=$row["total"];
        $balance_general-> setCellValueByColumnAndRow ( 6 , $numeroFila , $perdid);
        $numeroFila ++ ;
         $balance_general->setCellValue('C26', "PERDIDA");
         
     }
     //**********************CAPITAL ****************//

    $sql9= "select sum(precio *cantidad) as totalInsumo from insumos ;";
             $sql9 = $bd->prepare($sql9,[
        PDO :: ATTR_CURSOR  =>  PDO :: CURSOR_SCROLL ,
    ]);
                $sql9->bindValue(1,$anio);
                $sql9->execute();
                 $capital= $sql9->fetchall(PDO::FETCH_ASSOC);   
               $numeroFila  =  27;
        foreach($capital as $row){
       $capital=$row["totalInsumo"];
       $patrimonio=$capital;
        $balance_general-> setCellValueByColumnAndRow ( 6 , $numeroFila , $patrimonio);
        $numeroFila ++ ;
         $balance_general->setCellValue('C27', "CAPITAL");
         
     }
      $balance_general->setCellValue('C28', "TOTAL PASIVO");
       $balance_general->setCellValue('F28', '=SUM(F26:F27)');
        $archivogenerado = 'reporte-finaciero'.'.xlsx';
    $writer = new Xlsx($documento);
    # Le pasamos la ruta de guardado
    ob_end_clean();
    $writer->save($archivogenerado);

    header('Content-disposition: attachment; filename=' .$archivogenerado);
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    readfile($archivogenerado);
    unlink($archivogenerado);

  ?>