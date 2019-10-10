<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->

    <!-- sidebar menu: : style can be found in sidebar.less -->
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

      <li <?php if(isset($activar) and $activar == 'item_incidentes'){?>class="active"<?php }else{?> class=""<?php }?> >
        <a href="incidentes.php">
          <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span>Incidentes</span>
        </a>

      </li>

      <li <?php if(isset($activar) and  $activar == 'item_partidas'){?>class="active"<?php }else{?> class=""<?php }?> >
       <a href="partidas.php">
         <i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Partidas</span>
       </a>

     </li>

       <li class="">
        <a href="perdidas.php">
          <i class="fa fa-tasks" aria-hidden="true"></i> <span>Perdidas</span>
        </a>
      </li>

      <li class="">
        <a href="donaciones.php">
          <i class="fa fa-tasks" aria-hidden="true"></i> <span>Donaciones</span>
        </a>
      </li>

      <li class="">
        <a href="gastos.php">
          <i class="fa fa-tasks" aria-hidden="true"></i> <span>Gastos</span>
        </a>
      </li>

       <li class="">
            <a href="categorias.php">
              <i class="fa fa-users"></i> <span>Categoria</span>
              <span class="pull-right-container badge bg-blue">
                <i class="fa fa-bell pull-right">5</i>
              </span>
            </a>

        </li>
        <li class="">
            <a href="productos.php">
              <i class="fa fa-users"></i> <span>Producto</span>
              <span class="pull-right-container badge bg-blue">
                <i class="fa fa-bell pull-right">5</i>
              </span>
            </a>

        </li>

         <li class="treeview">
        <a href="compras.php">
          <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Compras</span>
          <span class="pull-right-container badge bg-blue">
            <i class="fa fa-bell pull-right">10</i>
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

          <ul class="treeview-menu">
          <li><a href="compras.php"><i class="fa fa-circle-o"></i> Compras</a></li>
          <li><a href="consultar_compras.php"><i class="fa fa-circle-o"></i> Consultar Compras</a></li>
          <li><a href="consultar_compras_fecha.php"><i class="fa fa-circle-o"></i> Consultar Compras Fecha</a></li>
          <li><a href="consultar_compras_mes.php"><i class="fa fa-circle-o"></i> Consultar Compras Mes</a></li>

        </ul>

      </li>

         <li class="">
        <a href="clientes.php">
          <i class="fa fa-users"></i> <span>Clientes</span>
          <span class="pull-right-container badge bg-blue">
            <i class="fa fa-bell pull-right">3</i>
          </span>
        </a>

      </li>

       <li class="treeview">
        <a href="ventas.php">
          <i class="fa fa-suitcase" aria-hidden="true"></i> <span>Ventas</span>
          <span class="pull-right-container badge bg-blue">
            <i class="fa fa-bell pull-right">8</i>
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

         <ul class="treeview-menu">
          <li><a href="ventas.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
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
          <li><a href="reporte_general_ventas.php"><i class="fa fa-circle-o"></i>Reporte General Ventas</a></li>

          <li><a href="reporte_ventas_mensual.php"><i class="fa fa-circle-o"></i> Reporte Mensual Ventas</a></li>

           <li><a href="reporte_ventas_cliente.php"><i class="fa fa-circle-o"></i> Reporte Ventas-Cliente</a></li>


        </ul>

      </li>


      <li class="">
        <a href="">
          <i class="fa fa-building" aria-hidden="true"></i> <span>Empresa</span>
        </a>
      </li>

      <li class="">
       <a href="respaldo.php">
         <i class="fa fa-list" aria-hidden="true"></i> <span>Respaldo</span>
       </a>

     </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
