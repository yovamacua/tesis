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

         <!-- linea de codigo para validar el color -->
         <li <?php if(isset($activar) and $activar == 'item_usuarios'){?>class="active"<?php }else{?> class=""<?php }?> >
            <a href="usuarios.php">
            <i class="fa fa-user" aria-hidden="true"></i> <span>Usuarios</span>
            </a>
         </li>

         <li <?php if(isset($activar) and $activar == 'item_incidentes'){?>class="active treeview menu-open"<?php }else{?> class="treeview"<?php }?> >
            <a href="#">
            <i class="fa fa-paperclip" aria-hidden="true"></i> <span>Incidentes</span>
            <span class="pull-right-container badge movarrow bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
               <li <?php if(isset($activar1) and $activar1 == 'item_incidentes1'){?>class="active"<?php }else{?><?php }?> >
                  <a href="incidentes.php">
                  <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span>Registar Incidente</span>
                  </a>
               </li>
               <li <?php if(isset($activar2) and $activar2 == 'item_incidentes2'){?>class="active"<?php }else{?><?php }?> ><a href="reporte_incidente.php">
                  <i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span>Reporte de Incidentes</span>
                  </a>
               </li>
            </ul>
         </li>

         <li <?php if(isset($activar) and  $activar == 'item_partidas'){?>class="active"<?php }else{?> class=""<?php }?> >
            <a href="partidas.php">
            <i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Partidas</span>
            </a>
         </li>

         <li class="">
            <a href="perdidas.php">
            <i class="fa fa-minus-square" aria-hidden="true"></i> <span>Perdidas</span>
            </a>
         </li>

         <li class="">
            <a href="donaciones.php">
            <i class="fa fa-gift" aria-hidden="true"></i> <span>Donaciones</span>
            </a>
         </li>

         <li class="">
            <a href="gastos.php">
            <i class="fa fa-money" aria-hidden="true"></i> <span>Gastos</span>
            </a>
         </li>

         <li class="">
            <a href="capacitaciones.php">
            <i class="fa fa-book" aria-hidden="true"></i> <span>Capacitaciones</span>
            </a>
         </li>

         <li class="">
            <a href="categorias.php">
            <i class="fa fa-users" aria-hidden="true"></i> <span>Categoria</span>
            </a>
         </li>

         <li class="">
            <a href="productos.php">
            <i class="fa fa-lemon-o" aria-hidden="true"></i> <span>Producto</span>
            </a>
         </li>

         <li class="treeview">
           <a href="pedidos.php">
             <i class="fa fa-shopping-bag" aria-hidden="true"></i> <span>Pedidos</span>
             <span class="pull-right-container badge bg-blue">
               <i class="fa fa-angle-left pull-right"></i>
             </span>
           </a>

           <ul class="treeview-menu">
             <li><a href="pedidos.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Pedidos</a></li>
             <li><a href="insumos.php"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Insumos</a></li>
           </ul>

         </li>

         <li class="treeview">
            <a href="ventas.php">
            <i class="fa fa-usd" aria-hidden="true"></i> <span>Ventas</span>
            <span class="pull-right-container badge bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="ventas.php"><i class="fa fa-usd"></i> Ventas</a></li>
               <li><a href="consultar_ventas.php"><i class="fa fa-circle-o"></i> Consultar Ventas</a></li>
               <li><a href="consultar_ventas_fecha.php"><i class="fa fa-circle-o"></i> Consultar Ventas Fecha</a></li>
               <li><a href="consultar_ventas_mes.php"><i class="fa fa-circle-o"></i> Consultar Ventas Mes</a></li>
            </ul>
         </li>

         <li class="treeview">
            <a href="reporte_compras.php">
            <i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Reportes de Compras</span>
            <span class="pull-right-container badge bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="reporte_general_compras.php"><i class="fa fa-circle-o"></i>Reporte General Compras</a></li>
               <li><a href="reporte_compras_mensual.php"><i class="fa fa-circle-o"></i> Reporte Mensual Compras</a></li>
               <li><a href="reporte_compras_proveedor.php"><i class="fa fa-circle-o"></i> Reporte Compras-Proveedor</a></li>
            </ul>
         </li>

         <li class="treeview">
            <a href="reporte_ventas.php">
            <i class="fa fa-pie-chart" aria-hidden="true"></i> <span>Reportes de Ventas</span>
            <span class="pull-right-container badge bg-blue">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
               <li><a href="reporte_general_ventas.php"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Reporte General Ventas</a></li>
               <li><a href="reporte_ventas_mensual.php"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Reporte Mensual Ventas</a></li>
               <li><a href="reporte_ventas_cliente.php"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Reporte Ventas-Cliente</a></li>
            </ul>
         </li>

         <li class="">
            <a href="">
            <i class="fa fa-building" aria-hidden="true"></i> <span>Empresa</span>
            </a>
         </li>
         <li <?php if(isset($activar) and  $activar == 'item_respaldo'){?>class="active"<?php }else{?> class=""<?php }?> >
            <a href="respaldo.php">
            <i class="fa fa-database" aria-hidden="true"></i> <span>Respaldo</span>
            </a>
         </li>

      </ul>
   </section>
   <!-- fin sidebar -->
</aside>