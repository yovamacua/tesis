<?php
#agrega conexion
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){
      //validar que no viene vacio o redirecciona
      if (isset($_GET['identificador']) or
               isset($_GET['nombrecuenta'])) {
        #asigana valor a variable
       $identificador = $_GET['identificador'];
       $nombre = $_GET['nombrecuenta'];
     }else{
      #redirecciona si falta informacion
       $redireccion = Conectar::ruta()."vistas/cuenta.php";?>
      <script type="text/javascript">
       alert("información Insuficiente")
       self.location = '<?php echo $redireccion; ?>'
       </script>
       <?php
     }
?>
<?php
#variables item activo 
$activar = 'item_partidas';
  require_once("header.php");
  $conectar = new Conectar();
  $conectar =  $conectar->conexion();

  $identificador = $_GET['identificador'];
#sumar valores
  include '../modelos/actions_table/sumatoria.php';
  $final = sumar($conectar, $identificador);

?>
<?php if($_SESSION["PARTIDAS"]==1)

     {

     ?>
<style>
#user_data_processing{display: none!important;}

tbody tr td:nth-child(7):before {
content: "$";
float: left;
}
tbody tr td:nth-child(7) div{margin-left: 1.5rem; }
#user_data{width: auto!important;}
.table>thead>tr>th{text-align: center!important;}
body
{
 margin:0;
 padding:0;
 background-color:#f1f1f1;
}
.box
{
width: 98%;
padding: 1%;
 background-color:#fff;
 border:1px solid #ccc;
 border-radius:5px;
 box-sizing:border-box;
}

#user_data_filter:before {
  content: '';
  display: block;
  clear: both;
}

.addbottom{
      z-index: 9999;
      width: 60px;
      height: 60px;
      background: #F44336;
      right: 6px;
      bottom: 21px;
      position: fixed;
      border: none;
      outline: none;
      color: #FFF;
      font-size: 36px;
      border-radius: 0px 3px 3px 0px;
}

.alert-success{
  position: fixed;
  bottom: 20px;
  right: 5px;
  width: 30%;
  background-color: white!important;
  border-color: black;
  color: black!important;
}

th{
pointer-events: none;
cursor: default;
}

.sumaview{display: inline-flex;
  background: red;
  padding: 0.45rem;
  color: white;
  font-weight: 700;}

  .handle {
    width:12px;
    margin: 5px 0 0 0;
    height:34px;
    /*float: left;*/
    cursor: move;
    background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAAH0lEQVQIW2OcN2/efwYgSEpKYgTRjBgCIFFkAFaGDAC2jQgFaRPeawAAAABJRU5ErkJggg==) repeat;
}
[contenteditable="true"]:active,
[contenteditable="true"]:focus{
border:dashed 1px black;
-webkit-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
padding: 0.2rem!important;
}
.special td:focus{border:dashed 1px black;
-webkit-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
padding: 0.2rem!important;}

/*.table-responsive{overflow-x: visible!important;}*/
.ui-sortable-handle{background-color:white!important;cursor: move!important;}
.ui-sortable-helper{background-color:#f9f9f9!important; height:auto!important;cursor: -webkit-grabbing!important; cursor: grabbing!important;}
thead>tr>th:first-child{padding: 5px!important;}
table>tbody>tr>td:first-child{padding: 5px!important;}
body{font-size: 15px!important;}
.panel-body{padding: 0px!important;}
.col-md-12{padding: 0px!important;}
</style>
<!--- Cargar sidebar menu colapsado -->
<script type="text/javascript">
var body = document.body;
body.classList.add("sidebar-collapse");
$(function resolucion() {
        if (screen.width < 1280) 
          bootbox.alert("La resolución de su pantalla es: <b>" + screen.width + "px</b> Se recomienda una resolución mayor para su correcta visualización", function() {
                console.log();
            });
      })
</script>


  <!--Contenido-->
      <div class="content-wrapper" onload="resolucion()">
          <section class="content-header">
      <h1>
       <a href="reportes/reporte-excel-cuenta.php?selector=<?php echo $identificador ?>&selector2=<?php echo $_SESSION['seleccion_partida'] ?>" download><span class="btn btn-info btn-md hint--top" aria-label="Descargar Excel"><i class="fa fa fa-file-excel-o"></i></span></a> Nombre de cuenta: <b><?php echo $nombre;?></b>        
      </a>
      </h1>

      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
        <li><a href="partidas.php"><i class="fa fa-file-text-o"></i> Partidas</a></li>
        <li><a href="cuenta.php?id=<?php echo $_SESSION["seleccion_partida"]; ?>&partida=<?php echo $_SESSION["nombre_partida"]; ?>"><i class="fa fa-clipboard"></i> Cuentas</a></li>
        <li><i class="fa fa-list-alt"></i> Detalle de cuenta</li>
      </ol>

    </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive">
                      <div class="container box">
                         <div class="table-responsive">
                          <table id="user_data" class="table table-bordered table-striped ">
                           <thead>
                            <tr>
                            <th scope="col"></th>
                              <th scope="col">Actividad<br>General</th>
                             <th scope="col">Actividad<br>Especifica</th>
                             <th scope="col">Responsable</th>
                             <th scope="col">Recurso<br>Academico</th>
                             <th scope="col">Recurso<br>Tecnico</th>
                             <th scope="col">Recurso<br>Financiero</th>
                             <th scope="col">Recurso<br>Infraestructura</th>
                             <th scope="col">Plazo <br>Inicio</th>
                             <th scope="col">Plazo <br>Fin</th>
                             <th scope="col">Indicador<br>de Logro</th>
                             <th scope="col"></th>
                            </tr>
                           </thead>
                           <tbody id="sortable">
                           </tbody>
                          </table>
                           <input type="hidden" name="page_order_list" id="page_order_list" />
                         </div>
                        </div>
                          <div id="alert_message"><div class="alert fixmobile alert-success"><?php echo $final; ?>&nbsp; </div></div>
                          <a href="#" class="scroll-down"><button type="button" name="add" id="add" class="addbottom">+</button>
                          </a>
                    </div>
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php
 $invalidar = 1;
  require_once("footer.php");

?>
<script>
$(document).ready(function(){
  $(function() {
    $("#sortable").sortable({handle: '.handle'});
  });

 $("#sortable" ).sortable({
  placeholder : "ui-state-highlight",
  update  : function(event, ui)
  {
   var page_id_array = new Array();
   $('tbody#sortable tr td div.mvdown').each(function(){
    page_id_array.push($(this).attr("id"));
    $.blockUI({
      message: '<img src="../public/plugins/BlockUI/loading.gif" /><br><h3> Procesando...</h3>',
       css: {
            border: 'none',
            padding: '20px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .7,
            color: '#fff'
        }
     });
   });
   $.ajax({
    url:"../modelos/actions_table/update-row.php",
    method:"POST",
    data:{page_id_array:page_id_array},
    success:function(data)
    {
      setTimeout($.unblockUI, data);
    }
   });
  }
 });

});
</script>



<script type="text/javascript" language="javascript" >

//validate only numbers
function restrictAlphabets(e){
        var x=e.which||e.keycode;
        if((x>=48 && x<=57) || x==8 ||
          (x>=35 && x<=40)|| x==46)
          return true;
        else
          return false;
      return (this.innerText.length <= 4);

      }
// end validate only numbers


//do scrolling bottom
$(function() {
    $('.scroll-down').click (function() {
      $('html, body').animate({scrollTop: $('tr.special').offset().top }, 'slow');
      return false;
    });
  });
//end do scrolling bottom

 $(document).ready(function(){

  fetch_data();
 var contador = 0;
  function fetch_data()
  {
   var dataTable = $('#user_data').DataTable({
    "processing" : true,
    "serverSide" : true,
    "bInfo" : false,
    "paging" : false,
    "bSort" : false,
    "responsive" : true,
    "order" : [],
    "ajax" : {
     url:"../modelos/actions_table/fetch.php?valor="+<?php echo $identificador; ?>,
     type:"POST"
    }
   });
  }
  function update_data(id, column_name, value)
  {
  contador = 0;
   $.ajax({
    url:"../modelos/actions_table/update.php?valor="+<?php echo $identificador; ?>,
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#user_data').DataTable().destroy();
     fetch_data();
    contador = 0;
    }
   });
  }

  $(document).on('blur', '.update', function(){
  contador = 0;
  var id = $(this).data("id");
   var column_name = $(this).data("column");
   var value = $(this).html();
   update_data(id, column_name, value);
  });




  $('#add').click(function(){
  var ActGeneral = $('#data1').text();
  var ActEspecifica = $('#data2').text();
  var Responsable = $('#data3').text();
  var Academico = $('#data4').text();
  var Tecnico = $('#data5').text();
  var Financiero = $('#data6').text();
  var Infraestructura = $('#data7').text();
  var Logro = $('#data8').text();
  var Inicio = $('#data9').text();
  var Fin = $('#data10').text();
  

  if(contador == 0)
   {
    var html = '<tr class="special">';
    html += '<td id="data0"></td>';
   html += '<td contenteditable id="data1" onkeypress="return (this.innerText.length <= 100)"></td>';
   html += '<td contenteditable id="data2" onkeypress="return (this.innerText.length <= 100)"></td>';
   html += '<td contenteditable id="data3" onkeypress="return (this.innerText.length <= 100)"></td>';
   html += '<td contenteditable id="data4" onkeypress="return (this.innerText.length <= 100)"></td>';
   html += '<td contenteditable id="data5" onkeypress="return (this.innerText.length <= 100)"></td>';
   html += '<td contenteditable id="data6" onkeypress="return (this.innerText.length <= 9) && restrictAlphabets(event);"></td>';
   html += '<td contenteditable id="data7" onkeypress="return (this.innerText.length <= 100)"></td>';
   html += '<td contenteditable id="data8" onkeypress="return (this.innerText.length <= 100)"></td>';
   html += '<td contenteditable id="data9" onkeypress="return (this.innerText.length <= 100)"></td>';
   html += '<td contenteditable id="data10" onkeypress="return (this.innerText.length <= 100)"></td>';
   html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Guardar</button></td>';
   html += '</tr>';
   $('#user_data tbody').append(html);
    contador = 1;
   }else{
        alert("Solo puede crear un campo a la vez");
   }
document.getElementById("data1").focus();

  });

  $(document).on('click', '#insert', function(){
  var ActGeneral = $('#data1').html();
  var ActEspecifica = $('#data2').html();
  var Responsable = $('#data3').html();
  var Academico = $('#data4').html();
  var Tecnico = $('#data5').html();
  var Financiero = $('#data6').text();
  var Infraestructura = $('#data7').html();
  var Logro = $('#data8').html();
  var Inicio = $('#data9').html();
  var Fin = $('#data10').html();

    contador = 0;
    $.ajax({
     url:"../modelos/actions_table/insert.php?valor="+<?php echo $identificador; ?>,
     method:"POST",
     data:{ActGeneral:ActGeneral, ActEspecifica:ActEspecifica, Responsable:Responsable, Academico:Academico, Tecnico,Tecnico, Financiero:Financiero, Infraestructura:Infraestructura, Logro:Logro, Inicio:Inicio, Fin:Fin},
     success:function(data)
     {
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
  });

  $(document).on('click', '.delete', function(){
   var id = $(this).attr("id");
  contador = 0;

bootbox.confirm("¿Está Seguro de eliminar este registro?", function(result) {
  if (result) {
    $.ajax({
     url:"../modelos/actions_table/delete.php?valor="+<?php echo $identificador; ?>,
     method:"POST",
     data:{id:id},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });

}
});
  });
 });
</script>
<?php  } else {

       require("noacceso.php");
  }
   
  ?><!--CIERRE DE SESSION DE PERMISO -->

<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
