<?php   
   require_once("../config/conexion.php");
   if(isset($_SESSION["id_usuario"])){
   require_once("../modelos/Incidentes.php");
   $incidentes=new Incidentes();
?>
<!-- INICIO DEL HEADER - LIBRERIAS -->
<?php require_once("header.php");?>

<!-- FIN DEL HEADER - LIBRERIAS -->
<script src="../public/plugins/pdf/jspdf/dist/jspdf.min.js"></script>
<script src="../public/plugins/pdf/js/jspdf.plugin.autotable.min.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

        <section class="content-header">
      <h1>
        Reportes de Incidentes
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
        <li><i class="fa fa-book"></i> Reporte Incidentes</li>
      </ol>
    </section><br>
   <div class="panel-default col-md-12">
        
        <div class="panel-body box">
            <form  action="reporte_incidente.php" class="form-inline" method="post">

<?php
if (empty($_POST['fecha'])) {
	$fch = '';
	echo "<style>#GenerarMysql{pointer-events: none;}</style>";
}else{
	$fch = $_POST['fecha'];
	echo "<style>#GenerarMysql{pointer-events: auto;}</style>";
}

if (empty($_POST['fecha2'])) {
	$fch2 = '';
}else{
	$fch2 = $_POST['fecha2'];
}
 ?>
<div class="form-row" style="text-align: center;">
<div class="form-group col-md-4">
<label for="Fecha Inicial">Fecha Inicial</label><br>
	<input style="width: 100%;background: white;" type="text" id="fecha" name="fecha"  autocomplete="off" class="form-control" value="<?php echo $fch; ?>"placeholder="Fecha" required readonly /></div>

<div class="form-group col-md-4">
<label for="Fecha Final">Fecha Final</label><br>
  	<input style="width: 100%;background: white;"type="text" id="fecha2" 
  	name="fecha2" value="<?php echo $fch2; ?>" autocomplete="off" class="form-control" placeholder="Fecha" required readonly/>
               </div>

<div class="form-group col-md-2">
<br>
                 <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i>Consultar</button>
</div>

<div class="form-group col-md-2">
<br>
			      <a href="# "id="GenerarMysql" class="btn btn-default">Generar PDF </a>        
</div>
             </div>  

           </form>

       </div>
      </div>

	 <div class="col-md-12">

	    <div class="box">

	       <div class="">
				  <table class="table table-bordered">
				    <thead>
				      <tr>
				        <th width="25%">Titulo</th>
				        <th width="50%">Descripcion</th>
				        <th width="25%">Fecha</th>
				      </tr>
				    </thead>

				     <tbody>

				     
                   <?php

			   	  //si existe el envia del post entonces se llama al metodo
			   	  if(isset($_POST["fecha"]) and isset($_POST["fecha2"])){
			      $datos= $incidentes->get_incidentes_fecha($_POST["fecha"], $_POST["fecha2"]);
	$f1 = $_POST["fecha"];
	$date = $_POST["fecha"];
    $date_inicial = str_replace('/', '-', $date);
    $fecha = date("Y-m-d",strtotime($date_inicial));
	$f2 = $_POST["fecha2"];
	$date2 = $_POST["fecha2"];
    $date_inicial2 = str_replace('/', '-', $date2);
    $fecha2 = date("Y-m-d",strtotime($date_inicial2));

			  }else{
			  		$f1 = 0;
					$fecha = '01/01/2000';
						$f2 = 0;
						$fecha2 = '01/01/2000';
			      	$datos= $incidentes->get_incidentes();
			      } 
			       for($i=0;$i<count($datos);$i++){
    			     ?>
					      <tr>
					        <td><?php echo $datos[$i]["titulo"]?></td>
					        <td><?php echo $datos[$i]["descripcion"]?></td>
					        <td><?php echo $datos[$i]["fecha"]?></td>
					      </tr>
					      
				      <?php
                 }//cierre del for                                              
?>
                      
                  
				    </tbody>

				   
				  </table>

		   </div><!--fin box-body-->
      </div><!--fin box-->
			
		</div><!--fin col-xs-12-->


</div>
  <!-- /.content-wrapper -->

   <?php require_once("footer.php");
$conectar = new Conectar();
$conectar =  $conectar->conexion();
$sql = "SELECT * FROM incidentes where fecha 
		BETWEEN '".$fecha."' AND '".$fecha2."'";
$hoy = getdate();
$stmt = $conectar->query($sql);
$users = array();
while ($user = $stmt->fetchObject()) {
$users[] = $user;
}



   ?>

<script>

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
  var pdf = new jsPDF();
pdf.setFontSize(18);
pdf.text(75,20,"Reporte de Incidentes");
pdf.setFontSize(14);
pdf.text(15,30,"Fecha Inicio: "+fechainicio);
pdf.text(15,40,"Fecha Fin: "+fechafin);
pdf.text(15,50,"Reporte Creado por: "+creador);

  var columns = ["Titulo", "Descripcion", "Fecha"];
  var data = [
<?php foreach($users as $c):?>
 ["<?php echo $c->titulo; ?>", "<?php echo $c->descripcion; ?>", "<?php echo $c->fecha; ?>"],
<?php endforeach; ?>  
  ];

  pdf.autoTable(columns,data,
    { margin:{ top: 60  }}
  );
var d = new Date();
var months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Dicimber"];
var today = months[d.getMonth()]+' '+d.getDate();
  pdf.save('Reporte de '+today);

});
</script>
<?php
   }
