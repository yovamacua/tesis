<?php
   require_once("../config/conexion.php");
    if(isset($_SESSION["id_usuario"])){
      //validar que no viene vacio o redirecciona
      if (isset($_GET['identificador'])) {
       $identificador = $_GET['identificador'];
     }else{
       $redireccion = Conectar::ruta()."vistas/cuenta.php";?>
      <script type="text/javascript">
       alert("Debe seleccionar una cuenta primero")
       self.location = '<?php echo $redireccion; ?>'
       </script>
       <?php
     }
?>
<?php
  require_once("header.php");
  $conectar = new Conectar();
  $conectar =  $conectar->conexion();

  $identificador = $_GET['identificador'];

  include '../modelos/actions_table/sumatoria.php';
  $final = sumar($conectar, $identificador);

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
      z-index: 9999!important;
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
  padding: 0.5rem;
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
/*.table-responsive{overflow-x: visible!important;}*/
.ui-sortable-handle{background-color:white!important;cursor: move!important;}
.ui-sortable-helper{background-color:#f9f9f9!important; height:auto!important;cursor: -webkit-grabbing!important; cursor: grabbing!important;}
thead>tr>th:first-child{padding: 5px!important;}
table>tbody>tr>td:first-child{padding: 5px!important;}

</style>
<!--- Cargar sidebar menu colapsado -->
<script type="text/javascript">
var body = document.body;
body.classList.add("sidebar-collapse");
</script>
  <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
             <h2 style="margin-top: 0.5rem!important;">Administrar Cuenta</h2>
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
                             <th scope="col">Acción</th>
                            </tr>
                           </thead>
                           <tbody id="sortable">
                           </tbody>
                          </table>
                           <input type="hidden" name="page_order_list" id="page_order_list" />
                         </div>
                        </div>
                          <div id="alert_message"><div class="alert alert-success"><?php echo $final; ?>&nbsp; </div></div>
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
   $('tbody#sortable tr td div').each(function(){
    page_id_array.push($(this).attr("id"));
    $.blockUI({
      message: '<img src="../public/plugins/BlockUI/loading.gif" /><br><h3> Procesando... por favor espere.</h3>',
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
    setTimeout($.unblockUI, 2000);
   });
   $.ajax({
    url:"../modelos/actions_table/update-row.php",
    method:"POST",
    data:{page_id_array:page_id_array},
    success:function(data)
    {
     //alert(data);
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
   var value = $(this).text();
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


  });

  $(document).on('click', '#insert', function(){
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
   if(confirm("Esta seguro de borrar esta información?"))
   {
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
</script>


<?php
  } else {
        header("Location:".Conectar::ruta()."vistas/index.php");
  }
?>
