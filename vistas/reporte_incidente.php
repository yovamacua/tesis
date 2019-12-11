<?php   
	#incluendo conexion
   require_once("../config/conexion.php");
   #validando la session
   if(isset($_SESSION["id_usuario"])){
   	#incluyendo archivo de modelo
   require_once("../modelos/Incidentes.php");
   #creando nuevo objeto
   $incidentes=new Incidentes();

   #variable para mostrar como item activo
   $activar = 'item_incidentes';
   $activar2 = 'item_incidentes2';

   #incluyendo header
   require_once("header.php");?>

<!-- Librerias para pdf -->
<script src="../public/plugins/pdf/jspdf/dist/jspdf.min.js"></script>
<script src="../public/plugins/pdf/js/jspdf.plugin.autotable.min.js"></script>

<!-- Contenido -->
<div class="content-wrapper">
   <section class="content-header">
      
      <h1> Reportes de Incidentes</h1>

      <!-- migas de pan -->
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
         <li><i class="fa fa-book"></i> Reporte Incidentes</li>
      </ol>

   </section><br>

   <div class="panel-default col-md-12">
      <div class="panel-body box">
      	<!-- Formulario para filtrar incidente -->
         <form  action="reporte_incidente.php" class="form-inline" method="GET">
            <?php
            #validando para mostrar el boton de generar reporte pdf.
               if (empty($_GET['fecha'])) {
               	$fch = '';
               	echo "<style>#GenerarMysql{pointer-events: none;}</style>";
               }else{
               	$fch = $_GET['fecha'];
               	echo "<style>#GenerarMysql{pointer-events: auto;}</style>";
               }
               
               if (empty($_GET['fecha2'])) {
               	$fch2 = '';
               }else{
               	$fch2 = $_GET['fecha2'];
               }
                ?>
            <div class="form-row" style="text-align: center;">
               <div class="form-group col-md-3">

                  <label for="Fecha Inicial">Fecha Inicial</label><br>
                  <input style="width: 100%;background: white;" type="text" id="fecha" name="fecha"  autocomplete="off" class="form-control" value="<?php echo $fch; ?>"placeholder="Fecha" required readonly />

               </div>
               <div class="form-group col-md-3">

                  <label for="Fecha Final">Fecha Final</label><br>
                  <input style="width: 100%;background: white;"type="text" id="fecha2" name="fecha2" value="<?php echo $fch2; ?>" autocomplete="off" class="form-control" placeholder="Fecha" required readonly/>
               
               </div>
               <div class="form-group col-md-2"><br>

                  <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i>Consultar</button>

               </div>
               <div class="form-group col-md-2">
                  <br>

                  <a href="# "id="GenerarMysql" class="btn btn-default">Generar PDF </a>   

               </div>

               <div class="form-group col-md-2">
                  <br>

                  <a href="reporte_incidente.php " class="btn btn-default">Limpiar</a>   

               </div>
            </div>

         </form>

      </div>
   </div>
   <div class="col-md-12">
      <div class="box">
         <div>
         	<!--- tabla mostrando resultados -->
            <table class="table table-bordered" style="white-space: pre!important;">
               <thead>
                  <tr>
                     <th width="25%">Titulo</th>
                     <th width="50%">Descripcion</th>
                     <th width="10%">Autor</th>
                     <th width="15%">Fecha</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     //si existe el envia del post entonces se llama al metodo
                     if(isset($_GET["fecha"]) and isset($_GET["fecha2"])){
                     $datos= $incidentes->get_incidentes_fecha($_GET["fecha"], $_GET["fecha2"]);
                     $f1 = $_GET["fecha"];
                     $date = $_GET["fecha"];
                     $date_inicial = str_replace('/', '-', $date);
                     $fecha = date("Y-m-d",strtotime($date_inicial));
                     $f2 = $_GET["fecha2"];
                     $date2 = $_GET["fecha2"];
                     $date_inicial2 = str_replace('/', '-', $date2);
                     $fecha2 = date("Y-m-d",strtotime($date_inicial2));
                     
                     }else{
                     # variables setiadas a un valor "vacio"
                     $f1 = 0;
                     $fecha = '01/01/2000';
                     $f2 = 0;
                     $fecha2 = '01/01/2000';
                     	$datos= $incidentes->get_incidentes_limit();
                     } 
                     #recorriendo los resultados 
                      for($i=0;$i<count($datos);$i++){
                      	#imprimiendo resultados
                        ?>
                  <tr>
                     <td><?php echo $datos[$i]["titulo"]?></td>
                     <td><?php echo $datos[$i]["descripcion"]?></td>
                     <td><?php echo $datos[$i]["usuario"]?></td>
                     <td><?php echo date("d/m/Y", strtotime($datos[$i]["fecha"]));

                     
                     
                     ?></td>
                  </tr>
                  <?php
                     }//cierre del for                                              
                     ?>
               </tbody>
            </table>
         </div>
         <!--fin box-body-->
      </div>
   </div>
</div>
<?php 
	#incluendo footer
	require_once("footer.php");

	#codigo para generar informacion de el reporte pdf
   $conectar = new Conectar();
   $conectar =  $conectar->conexion();
   $sql = "SELECT i.titulo, i.descripcion, i.fecha, u.usuario 
        from incidentes i INNER JOIN usuarios u on (i.id_usuario = u.id_usuario)
        where i.fecha BETWEEN '".$fecha."' AND '".$fecha2."' order by i.fecha ASC";
   $hoy = getdate();
   $stmt = $conectar->query($sql);
   $users = array();
   while ($user = $stmt->fetchObject()) {
   $users[] = $user;
   }
   ?>
   <!-- codigo para genera pdf-->
<script>
	//variables a usar para la información del reporte
   var fechainicio = '<?php echo $f1 ?>';
   if (fechainicio == 0) {
   	fechainicio = 0;
   }   
   var fechafin = '<?php echo $f2 ?>';
   if (fechafin == 0) {
   	fechainicio = 0;
   }   
   var creador = '<?php echo $_SESSION["nombre"]; ?>';
   
   $("#GenerarMysql").click(function(){
   	//encabezado del reporte
     var pdf = new jsPDF();
   pdf.setFontSize(18);
   pdf.text(75,20,"Reporte de Incidentes");
   pdf.setFontSize(14);
   pdf.text(15,30,"Fecha Inicio: "+fechainicio);
   pdf.text(15,40,"Fecha Fin: "+fechafin);
   pdf.text(15,50,"Reporte Creado por: "+creador);
   

   //contenido del reporte
   var columns = ["Titulo", "Descripcion", "Autor", "Fecha"];
   var data = [
   <?php foreach($users as $c):?>
   ["<?php echo str_replace('
', '\n', $c->titulo); ?>", 
   "<?php echo str_replace('
', '\n', $c->descripcion); ?>", "<?php echo $c->usuario; ?>","<?php echo date("d/m/Y", strtotime($c->fecha)); ?>"],
   <?php endforeach; ?>  
     ];
   
     pdf.autoTable(columns,data,
       { margin:{ top: 60  }}
     );
   var d = new Date();
	//codigo para genera la fecha del reporte
   var months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciember"];
   var today = months[d.getMonth()]+' '+d.getDate();
     pdf.save('Reporte de '+today);
   
   });
</script>
<?php
} else {
	#redirreccion si la session no existe
header("Location:".Conectar::ruta()."vistas/index.php");
}