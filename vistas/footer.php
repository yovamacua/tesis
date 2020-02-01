<footer class="main-footer">
   <!-- <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
   </div> -->
   <div style="text-align: center;"><strong>Proyeto Campo Escuela - Salcoatitan &copy; <?php echo date('Y');?>  <a href="https://www.usonsonate.edu.sv" target="_blank">Universidad De Sonsonate</a></strong></div>
 </footer>
<!-- jQuery 3 -->
<script src="../public/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../public/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="../public/bower_components/jquery-ui/ui/i18n/datepicker-es.js" charset="UTF-8"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
   $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<!--<script src="../public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>-->
<script src="../public/datatables/jquery.dataTables.min.js"></script>
<script src="../public/datatables/dataTables.buttons.min.js"></script>
<script src="../public/datatables/buttons.html5.min.js"></script>
<script src="../public/datatables/buttons.colVis.min.js"></script>
<script src="../public/datatables/jszip.min.js"></script>
<script src="../public/datatables/pdfmake.min.js"></script>
<script src="../public/datatables/vfs_fonts.js"></script>
<!--- modal popup loading -->
<script src="../public/plugins/BlockUI/blockUI.js"></script>
<!-- Morris.js charts -->
<script src="../public/bower_components/raphael/raphael.min.js"></script>
<script src="../public/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="../public/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../public/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../public/bower_components/moment/min/moment.min.js"></script>
<script src="../public/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../public/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../public/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../public/dist/js/demo.js"></script>
<!--LIBRERIA DE MENSAJE MODAL-->
<script src="js/bootbox.min.js"></script>
<!--BOOTSTRAP FILE STYLE-->
<script src="../public/bootstrap-filestyle/src/bootstrap-filestyle.min.js"></script>
<script>
   $(":file").filestyle({input: false, buttonText: " Seleccionar archivo",buttonName: "btn-primary"});
</script>
<script>
   !function(a){a.fn.datepicker.dates.es={days:["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"],daysShort:["Dom","Lun","Mar","Mié","Jue","Vie","Sáb"],daysMin:["Do","Lu","Ma","Mi","Ju","Vi","Sa"],months:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],monthsShort:["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],today:"Hoy",monthsTitle:"Meses",clear:"Borrar",weekStart:1,format:"dd/mm/yyyy"}}(jQuery);  
   
         $('#fecha').datepicker({
         dateFormat: 'dd-mm-yyyy',
         /*autoclose: true*/
          /*format: "yyyy-mm-dd",*/
           /*clearBtn: true, */
           language: "es",
           autoclose: false,
           /*keyboardNavigation: false,*/
           todayHighlight: true
       })
   
         $('#fecha2').datepicker({
         dateFormat: 'dd-mm-yyyy',
         /*autoclose: true*/
          /*format: "yyyy-mm-dd",*/
           /*clearBtn: true, */
           language: "es",
           autoclose: false,
           /*keyboardNavigation: false,*/
           todayHighlight: true
       })
         
         $('#fecha1').datepicker({
         dateFormat: 'dd-mm-yyyy',
         /*autoclose: true*/
          /*format: "yyyy-mm-dd",*/
           /*clearBtn: true, */
           language: "es",
           autoclose: false,
           /*keyboardNavigation: false,*/
           todayHighlight: true
       })

         $('#Fecha').datepicker({
         dateFormat: 'dd-mm-yyyy',
         /*autoclose: true*/
          /*format: "yyyy-mm-dd",*/
           /*clearBtn: true, */
           language: "es",
           autoclose: false,
           /*keyboardNavigation: false,*/
           todayHighlight: true
       })
   
</script>
<!-- boton bonito resposive -->
<?php
   if (isset($invalidar)) {
   }else{ ?>
<script type="text/javascript" src="../public/datatables/datatables.min.js"></script>
<?php } ?>
<!--GRAFICA COMPRAS Y VENTAS-->
<script src="../public/plugins/Highcharts/highcharts.js"></script>
<script src="../public/plugins/Highcharts/exporting.js"></script>


</body>
</html>