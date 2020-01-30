<?php
/*validamos si no existe una variable de session entonces el id de session es menor que 1 entonces iniciaria la session y si ya existen una session iniciada entonces no vamos hacer nada, esto para omitir algunos errores de que si ya ha existido la session anteriormente*/
 if(strlen(session_id()) < 1)

  session_start();
?>
<aside class="main-sidebar">
   <section class="sidebar">
      <!-- Sidebar panel -->

      <ul class="sidebar-menu" data-widget="tree">

         <li class="header">MENU</li>

         <li <?php if(isset($activar) and $activar == 'item_home'){?>class="active"<?php }else{?> class=""<?php }?> >
            <a href="home.php">
            <i class="fa fa-home" aria-hidden="true"></i> <span>Inicio</span>
            </a>
         </li>

        
        
               <li <?php if(isset($activar) and $activar == 'item_usuario'){?>class="active"<?php }else{?><?php }?> >
          
              <?php if($_SESSION["USUARIOS"]==1)
         
          {
           echo '<a href="usuarios.php">
            <i class="fa fa-user" aria-hidden="true"></i> <span>Usuarios</span>
            </a>';
             }

         ?>
         </li>
          
       <li <?php if(isset($activar) and $activar == 'item_permiso'){?>class="active treeview menu-open"<?php }else{?> class="treeview"<?php }?> >
             <?php if($_SESSION["PERMISO"]==1)
         
          {
            echo '<a href="#">
            <i class="fa fa-expeditedssl" aria-hidden="true"></i> <span>Permiso</span>
            <span class="pull-right-container badge movarrow bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>';
              }

         ?>
            
            <ul class="treeview-menu">
               <li <?php if(isset($activar1) and $activar1 == 'item_perfil'){?>class="active"<?php }else{?><?php }?> >
                   <?php if($_SESSION["PERMISO"]==1)
         
          {
                echo'  <a href="perfilese.php">
                  <i class="fa fa-male" aria-hidden="true"></i> <span>Perfiles</span>
                  </a>
               </li>';
            }
            ?>
               <li <?php if(isset($activar2) and $activar2 == 'item_rol'){?>class="active"<?php }else{?><?php }?> >
                   <?php if($_SESSION["PERMISO"]==1)
         
          {
                 echo' <a href="rol.php">

                  <i class="fa fa-plus-square" aria-hidden="true"></i> <span>Roles</span>
                  </a>';
               }
               ?>
               </li>
            </ul>
         </li>

          

         <li <?php if(isset($activar) and $activar == 'item_incidentes'){?>class="active treeview menu-open"<?php }else{?> class="treeview"<?php }?> >
             <?php if($_SESSION["INCIDENTES"]==1)
         
          {
            echo '<a href="#">
            <i class="fa fa-paperclip" aria-hidden="true"></i> <span>Incidentes</span>
            <span class="pull-right-container badge movarrow bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>';
              }

         ?>
            
            <ul class="treeview-menu">
               <li <?php if(isset($activar1) and $activar1 == 'item_incidentes1'){?>class="active"<?php }else{?><?php }?> >
                   <?php if($_SESSION["INCIDENTES"]==1)
         
          {
                echo'  <a href="incidentes.php">
                  <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span>Registar Incidente</span>
                  </a>
               </li>';
            }
            ?>
               <li <?php if(isset($activar2) and $activar2 == 'item_incidentes2'){?>class="active"<?php }else{?><?php }?> >
                   <?php if($_SESSION["INCIDENTES"]==1)
         
          {
                 echo' <a href="reporte_incidente.php">

                  <i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span>Reporte de Incidentes</span>
                  </a>';
               }
               ?>
               </li>
            </ul>
         </li>
         <li <?php if(isset($activar) and $activar == 'item_partidas'){?>class="active"<?php }else{?> class=""<?php }?> >
   <?php if($_SESSION["PARTIDAS"]==1)
         
          {
        echo ' <a href="partidas.php">
            <i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Partidas</span>
            </a>';
      }
         ?>
</li>
 
         <li <?php if(isset($activar) and  $activar == 'item_perdidas'){?>class="active"<?php }else{?> class=""<?php }?> >
            <?php if($_SESSION["PERDIDAS"]==1)
         
          {
        echo ' <a href="perdidas.php">
            <i class="fa fa-minus-square" aria-hidden="true"></i> <span>Pérdidas</span>
            </a>';
      }
         ?>
            
         </li>

         <li <?php if(isset($activar) and  $activar == 'item_donaciones'){?>class="active"<?php }else{?> class=""<?php }?> >
             <?php if($_SESSION["DONACIONES"]==1)
         
          {
        echo ' <a href="donaciones.php">
            <i class="fa fa-gift" aria-hidden="true"></i> <span>Donaciones</span>
            </a>';
      }
         ?>
            
         </li>

         <li <?php if(isset($activar) and  $activar == 'item_gastos'){?>class="active"<?php }else{?> class=""<?php }?> >
              <?php if($_SESSION["GASTOS"]==1)
         
          {
        echo ' <a href="gastos.php">
            <i class="fa fa-money" aria-hidden="true"></i> <span>Gastos</span>
            </a>';
      }
         ?>
            
         </li>

         <li <?php if(isset($activar) and  $activar == 'item_capacitaciones'){?>class="active"<?php }else{?> class=""<?php }?> >
          <?php if($_SESSION["CAPACITACIONES"]==1)
         
          {
        echo ' <a href="capacitaciones.php">
            <i class="fa fa-book" aria-hidden="true"></i> <span>Capacitaciones</span>
            </a>';
      }
         ?>
            
            
         </li>


         <li <?php if(isset($activar) and $activar == 'item_categorias'){?>class="active treeview menu-open"<?php }else{?> class="treeview"<?php }?> >
             <?php if($_SESSION["CATEGORIA"]==1)
         
          {
            echo '<a href="#">
            <i class="fa fa-cubes" aria-hidden="true"></i> <span>Categoria</span>
            <span class="pull-right-container badge movarrow bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>';
              }

         ?>
            
            <ul class="treeview-menu">
              <li <?php if(isset($activar) and  $activar == 'item_categorias'){?>class="active"<?php }else{?> class=""<?php }?> >
            <?php if($_SESSION["CATEGORIA"]==1)
         
          {
        echo '<a href="categorias.php">
            <i class="fa fa-cubes" aria-hidden="true"></i> <span>Categoria</span>
            </a>';
      }
         ?>
            
         </li>
               <li <?php if(isset($activar2) and $activar2 == 'item_unidad'){?>class="active"<?php }else{?><?php }?> >
                   <?php if($_SESSION["CATEGORIA"]==1)
         
          {
                 echo' <a href="unidads.php">

                  <i class="fa fa-cube" aria-hidden="true"></i> <span>Unidad</span>
                  </a>';
               }
               ?>
               </li>
            </ul>
         </li>

         
         <li <?php if(isset($activar) and  $activar == 'item_productos'){?>class="active"<?php }else{?> class=""<?php }?> >
             <?php if($_SESSION["PRODUCTO"]==1)
         
          {
        echo '<a href="productos.php">
            <i class="fa fa-leaf" aria-hidden="true"></i> <span>Producto</span>
            </a>';
      }
         ?>
            
         </li>

          <li <?php if(isset($activar) and $activar == 'item_pedidos'){?>class="active treeview menu-open"<?php }else{?> class="treeview"<?php }?> >
             <?php if($_SESSION["PEDIDOS"]==1)
         
          {
        echo '<a href="#">
            <i class="fa fa-shopping-bag" aria-hidden="true"></i> <span>Pedidos</span>
            <span class="pull-right-container badge bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
           </a>';
      }
         ?>
            

           <ul class="treeview-menu">
                <li <?php if(isset($activar1) and $activar1 == 'item_pedidos1'){?>class="active"<?php }else{?><?php }?> >
                  <?php if($_SESSION["PEDIDOS"]==1)
         
          {
        echo '<a href="pedidos.php">
                  <i class="fa fa-shopping-bag" aria-hidden="true"></i><span>Hacer Pedido</span>
                  </a>';
      }
         ?>
                  
               </li>
               <li <?php if(isset($activar2) and $activar2 == 'item_pedidos2'){?>class="active"<?php }else{?><?php }?> >
                    <?php if($_SESSION["PEDIDOS"]==1)
         
          {
        echo '<a href="insumos.php">
                  <i class="fa fa-shopping-basket" aria-hidden="true"></i><span>Registar Insumos</span>
                  </a>';
      }
         ?>
                  
               </li>
           </ul>
         </li>

         <li <?php if(isset($activar) and $activar == 'item_venta'){?>class="active treeview menu-open"<?php }else{?> class="treeview"<?php }?> >
                      <?php if($_SESSION["VENTA"]==1)
         
          {
        echo '<a href="v#">
            <i class="fa fa-usd" aria-hidden="true"></i> <span>Venta</span>
            <span class="pull-right-container badge bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>';
      }
         ?>
            
            <ul class="treeview-menu">
                <li <?php if(isset($activar1) and $activar1 == 'item_venta1'){?>class="active"<?php }else{?><?php }?> >
                          <?php if($_SESSION["VENTA"]==1)
         
          {
        echo '<a href="ventas.php">
                  <i class="fa fa-usd"></i><span>Registar Venta</span>
                  </a>';
      }
         ?>
                   
               </li>
               
               </li>
                <li <?php if(isset($activar3) and $activar3 == 'item_venta3'){?>class="active"<?php }else{?><?php }?> >
                                 <?php if($_SESSION["VENTA"]==1)
         
          {
        echo '<a href="consultar_ventas_fecha.php">
                  <i class="fa fa-info-circle"></i><span>Consultar Ventas Fecha</span>
                  </a>';
      }
      ?>  
                  
               </li>
               <li <?php if(isset($activar4) and $activar4 == 'item_venta4'){?>class="active"<?php }else{?><?php }?> >
                  <?php if($_SESSION["VENTA"]==1)
         
          {
        echo '<a href="consultar_ventas_mes.php">
                  <i class="fa fa-info-circle"></i><span>Consultar Ventas Mes</span> 
                  </a>';
      }
      ?> 
                  
               </li>
            </ul>
         </li>

          <li <?php if(isset($activar) and  $activar == 'item_reporteFinanciero'){?>class="active"<?php }else{?> class=""<?php }?> >
                <?php if($_SESSION["INFORME FINANCIERO"]==1)
         
          {
        echo '<a href="estados_financiero.php">
            <i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Reporte Financiero</span>
            </a>';
      }
      ?>  
            
         </li>

         <li <?php if(isset($activar) and $activar == 'item_reporteVenta'){?>class="active treeview menu-open"<?php }else{?> class="treeview"<?php }?> >
             <?php if($_SESSION["REPORTES DE VENTAS"]==1)
         
          {
        echo '<a href="reporte_ventas.php">
            <i class="fa fa-pie-chart" aria-hidden="true"></i> <span>Reportes de Ventas</span>
            <span class="pull-right-container badge bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>';
      }
      ?>  
           
            <ul class="treeview-menu">
               <li <?php if(isset($activar1) and $activar1 == 'item_reporteVenta1'){?>class="active"<?php }else{?><?php }?> >
                    <?php if($_SESSION["REPORTES DE VENTAS"]==1)
         
          {
        echo '<a href="reporte_general_ventas.php">
                  <i class="fa fa-file-pdf-o" aria-hidden="true"></i><span>Reporte General de Ventas</span>
                  </a>';
      }
      ?> 
                  
               </li>
               <li <?php if(isset($activar2) and $activar2 == 'item_reporteVenta2'){?>class="active"<?php }else{?><?php }?> >
                  <?php if($_SESSION["REPORTES DE VENTAS"]==1)
         
          {
        echo '<a href="reporte_ventas_mensual.php">
                     <i class="fa fa-file-pdf-o" aria-hidden="true"></i><span>Reporte Mensual de Ventas</span> 
                  </a>';
      }
      ?> 
                  
               </li>
               <li <?php if(isset($activar3) and $activar3 == 'item_reporteVenta3'){?>class="active"<?php }else{?><?php }?> >
                    <?php if($_SESSION["REPORTES DE VENTAS"]==1)
         
          {
        echo '<a href="reporte_ventas_Semanal.php">
                     <i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span>Reportes de Ventas Semanal</span>
                  </a>';
      }
      ?>
                  
               </li>
            </ul>
         </li>
         
         <li <?php if(isset($activar) and  $activar == 'item_respaldo'){?>class="active"<?php }else{?> class=""<?php }?> >
                   <?php if($_SESSION["RESPALDO"]==1)
         
          {
        echo ' <a href="respaldo.php">
            <i class="fa fa-database" aria-hidden="true"></i> <span>Respaldo</span>
            </a>';
      }
      ?>
           
         </li>

      </ul>
   </section>
   <!-- fin sidebar -->
</aside>