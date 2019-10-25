<?php
  #incluye conexion
   require_once("../config/conexion.php");
   #valdia que exista la session
    if(isset($_SESSION["id_usuario"])){
      //validar que no viene vacio o redirecciona
      if (isset($_GET['identificador']) or
               isset($_GET['nombrecuenta'])) {
       $identificador = $_GET['identificador'];
       $nombre = $_GET['nombrecuenta'];
     }else{
       $redireccion = Conectar::ruta()."vistas/cuenta.php";?>
          <script type="text/javascript">
            bootbox.alert("Información insuficiente");
            self.location = '<?php echo $redireccion; ?>'
          </script>
<?php
   }
   #variable de item actio
   $activar = 'item_partidas';

   #incluendo header
     require_once("header.php");
     $conectar = new Conectar();
     $conectar =  $conectar->conexion();
   
   #variable para filtar resultados
     $identificador = $_GET['identificador'];
   
   #archivo de sumatoria
     include '../modelos/actions_table/sumatoria.php';
     $final = sumar($conectar, $identificador);
   
   ?>
<!-- estilo unico para entrada -->
<link rel="stylesheet" href="../public/css/estilo-entrada.css">

<!--- Cargar sidebar menu en modo colapsado -->
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper contenidostyle" onload="resolucion()">
   <section class="content-header">
      
      <h1>
         Administrar información de la cuenta: <b><?php echo $nombre;?></b>
         <a href="reportes/reporte-excel-cuenta.php?selector=<?php echo $identificador ?>" download><span class="btn btn-info btn-md hint--top" aria-label="Descargar Excel"><i class="fa fa fa-file-excel-o"></i></span></a>
      </h1>

    <!--- migas de pan--- >
      <ol class="breadcrumb">
         <li><a href="home.php"><i class="fa fa-home"></i>Inicio</a></li>
         <li><a href="partidas.php"><i class="fa fa-file-text-o"></i> Partidas</a></li>
         <li><a href="cuenta.php?id=<?php echo $_SESSION["seleccion_partida"]; ?>&partida=<?php echo $_SESSION["nombre_partida"]; ?>"><i class="fa fa-clipboard"></i> Cuentas</a></li>
         <li><i class="fa fa-list-alt"></i> Detalles de cuenta</li>
      </ol>

   </section>

   <section class="content">
      <div class="row">
         <div class="col-md-12">

            <!-- centro -->
            <div class="panel-body table-responsive">
               <div class="container box">
                <!-- contenido de tabla -->
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

          <!-- ventanita inferior derecha -->
               <div id="alert_message">

                  <div class="alert fixmobile alert-success"><?php echo $final; ?>&nbsp; </div>

               </div>
               
               <a href="#" class="scroll-down"><button type="button" name="add" id="add" class="addbottom">+</button>

               </a>
            </div>
         </div>
      </div>
   </section>
</div>
<!--Fin-Contenido-->

<?php
   $invalidar = 1;
   #incluyendo footer
    require_once("footer.php");
   
   ?>
   <!--- codigo js para hacer reordenable la tabla -->
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


<!--- codigo js para escribir solo numeros -->
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
   
   // escrolea hasta la posición para nuevo entrada

   $(function() {
       $('.scroll-down').click (function() {
         $('html, body').animate({scrollTop: $('tr.special').offset().top }, 'slow');
         return false;
       });
     });
   //end do scrolling bottom
   
   //muestra toda la información y la carga en la tabla
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

     //actualizar el contenido de la columna
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
   
   //actualiza al perder el foco
     $(document).on('blur', '.update', function(){
     contador = 0;
     var id = $(this).data("id");
      var column_name = $(this).data("column");
      var value = $(this).text();
      update_data(id, column_name, value);
     });
   
   
   
   //agrega campo en la tabla
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
     
   //campo agregado
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
   
   //inserta informacion en la bd
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
   
   //eliminar informacion
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
    #redireccion si la sessión no existe
         header("Location:".Conectar::ruta()."vistas/index.php");
   }
   ?>