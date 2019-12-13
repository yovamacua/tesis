  <?php 
  //llamo a la conexion de la base de datos
    require_once("../config/conexion.php");
    require_once("../modelos/InforCajas.php");

  if (!isset($_SESSION['id_usuario'])) {?>
          <script type="text/javascript">
          window.location="../vistas/home.php";
          </script>
      <?php
  }
  class infocajas extends InforCajas
  {
  	  
  	public function infoproducto()
    {
    	$datos=parent::getProductos();
  if(is_array($datos)==true and count($datos)>0){
   foreach ($datos as $row) {
    		$productos=$row["producto"];
    	}
    	echo  '<span class="info-box-number" >'.$productos.'</span>';

  }else{
  echo '<span class="info-box-number">0</span>';
    	 	
    	 }
    }


    public function infoventas()
    {
     $datos=parent::getVentas();
  if(is_array($datos)==true and count($datos)>0){
   foreach ($datos as $row) {
    		$ventas=$row["ventas"];
    	}
    	echo  '<span class="info-box-number"  >'.$ventas.'</span>';
  }else{
  echo '<span class="info-box-number">0</span>';
    	 	
    	 }
    }


    public function infodonaciones()
    {
    	$datos=parent::getDonaciones();
  if(is_array($datos)==true and count($datos)>0){
   foreach ($datos as $row) {
    		$donaciones=$row["donaciones"];
    	}
    	echo  '<span class="info-box-number"  >'.$donaciones.'</span>';

  }else{
  echo '<span class="info-box-number">0</span>';
    	 	
    	 }
    }
    public function infoincidentes()
    {
  $datos=parent::getIncidentes();
  if(is_array($datos)==true and count($datos)>0){
   foreach ($datos as $row) {
    		$incidentes=$row["incidentes"];
    	}
    	echo  '<span class="info-box-number"  >'.$incidentes.'</span>';

  }else{
  echo '<span class="info-box-number">0</span>';
    	 	
    	 }
    }
  }




   ?>