<?php  
	//conexion a la base de datos
	require_once("../config/conexion.php");

	#valida que exista la sessión
	if (!isset($_SESSION['id_usuario'])) {?>
	        <script type="text/javascript">
	        window.location="../vistas/home.php";
	        </script>
	    <?php
	}
  
	Class Perdidas extends Conectar{

		//listar las perdidas
		public function get_perdidas(){
			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select p.id_perdida, pr.producto, p.cantidad, p.descripcion, p.precioProduc, p.fecha, uni.nombre, u.usuario 
				from perdidas p 
				inner join producto pr on pr.id_producto = p.idproducto 
				inner join unidad uni on pr.id_unidad = uni.idunidad
				inner join usuarios u on p.id_usuario = u.id_usuario";

			$sql = $conectar->prepare($sql);
			$sql-> execute();

			return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		//mostrar las perdidas por el id
		public function get_perdidas_por_id($id_perdida){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select * from perdidas where id_perdida=?";	
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $id_perdida);
			$sql-> execute();

			return $resultado = $sql->fetchAll();
		}

		//obtener precio de venta por el id
		public function get_producto_por_id($idproducto){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select pe.idproducto, pro.precio_venta from perdidas pe inner join producto pro on pro.id_producto = pe.idproducto where idproducto=?;";	
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $idproducto);
			$sql-> execute();

			return $resultado = $sql->fetchAll();
		}

		//registrar perdidas
		public function registrar_perdidas($idproducto, $cantidad, $descripcion, $precioProduc, $fecha, $unidadDelProduc, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

			$sql = "insert into perdidas values(null,?,?,?,?,?,?,?);";
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $_POST["idproducto"]);
			$sql-> bindValue(2, substr($_POST["cantidad"], 0, 4));
			$sql-> bindValue(3, substr($_POST["descripcion"], 0, 100));
			$sql-> bindValue(4, $_POST["precioProduc"]);
			$sql-> bindValue(5, $fecha);
			$sql-> bindValue(6, $_POST["unidadDelProduc"]);
			$sql-> bindValue(7, $_POST["id_usuario"]);
			$sql-> execute();
			

		}
 
		//editar perdidas
		public function editar_perdida($id_perdida, $idproducto, $cantidad, $descripcion, $precioProduc, $fecha, $unidadDelProduc, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

			$sql = "update perdidas set
            idproducto=?,
            cantidad=?,
            descripcion=?,
            precioProduc=?,
            fecha=?,
            unidadDelProduc=?,
            id_usuario=?
            where
            id_perdida=?";	

			$sql = $conectar->prepare($sql);

			$sql-> bindValue(1, $_POST["idproducto"]);
			$sql-> bindValue(2, substr($_POST["cantidad"], 0, 4));
			$sql-> bindValue(3, substr($_POST["descripcion"], 0, 100));
			$sql-> bindValue(4, $_POST["precioProduc"]);
			$sql-> bindValue(5, $fecha);
			$sql-> bindValue(6, $_POST["unidadDelProduc"]);
			$sql-> bindValue(7, $_POST["id_usuario"]);
			$sql-> bindValue(8, $_POST["id_perdida"]);
			$sql-> execute();
		}

		// reportes de perdidas 

        public function get_perdidas_reporte_general()
        {
          $conectar = parent::conexion();
           parent::set_names();

           	$sql = "SELECT MONTHname(fecha) as mes, MONTH(fecha) as numero_mes, YEAR(fecha) as anio, SUM(precioProduc*cantidad) as totalPerdida FROM perdidas GROUP BY mes desc, numero_mes desc, anio desc;";
        	$sql = $conectar->prepare($sql);
        	$sql->execute();
        	return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_perdidas_anio_actual(){

	        $conectar=parent::conexion();
	        parent::set_names();

	        $sql = "SELECT YEAR(fecha) as anio, MONTHname(fecha) as mes, SUM(precioProduc*cantidad) as totalPerdida FROM perdidas
	        WHERE YEAR(fecha)=YEAR(CURDATE()) GROUP BY MONTHname(fecha) desc, YEAR(fecha) desc;";

	        $sql=$conectar->prepare($sql);
	        $sql->execute();
	        return $resultado=$sql->fetchAll();

    	}

        //metodo de llanado para grafica
    	public function get_perdidas_anio_actual_grafica()
    	{

	       $conectar=parent::conexion();
	       parent::set_names();

	       $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	       
	       $sql = "SELECT MONTHname(fecha) as mes, SUM(precioProduc*cantidad) as total_perdida_mes FROM perdidas
	        WHERE YEAR(fecha)=YEAR(CURDATE()) GROUP BY mes desc";
	           
	        $sql = $conectar->prepare($sql);
	        $sql->execute();

	        $resultado = $sql->fetchAll();
	             
	        //recorro el array y lo imprimo
	        foreach($resultado as $row){

          		$mes= $output["mes"]=$meses[date("n", strtotime($row["mes"]))-1];
	          	$total = $output["total_perdida_mes"] = $row["total_perdida_mes"];

	         echo $grafica= "{name:'".$mes."', y:".$total."},";

	        }
    	}

    	//grafica de reporte general
    	public function get_perdidas_general_grafica()
    	{

	       $conectar=parent::conexion();
	       parent::set_names();
	       
	       $sql = "SELECT YEAR(fecha) as anio, SUM(precioProduc*cantidad) as total_perdida_anio FROM perdidas
	        GROUP BY anio desc";
	           
	        $sql = $conectar->prepare($sql);
	        $sql->execute();
	        $resultado = $sql->fetchAll();
	             
	        // recorre el array y se imprime
            foreach ($resultado as $row) {
              $anio = $output["anio"] = $row["anio"];
              $total = $output["total_perdida_anio"] = $row["total_perdida_anio"];

              echo $grafica= "{name:'".$anio."', y:".$total."},";
            }
    	}

    	// SUMA EL TOTAL DE PERDIDAS POR AÑOS
      	public function suma_perdidas_total_anio()
      	{
        	$conectar = parent::conexion();
           	parent::set_names();
           	$sql = "SELECT YEAR(fecha) as anio, SUM(precioProduc*cantidad) as total_perdida_anio FROM perdidas GROUP BY YEAR(fecha) desc;";
           	$sql = $conectar->prepare($sql);
           	$sql->execute();
           	return $resultado=$sql->fetchAll();
      	}

		//método para eliminar un registro
        public function eliminar_perdida($id_perdida){
           $conectar = parent::conexion();
           parent::set_names();

           $sql="delete from perdidas where id_perdida=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1, $id_perdida);
           $sql->execute();

           return $resultado=$sql->fetch();
        }

        /****** Bloque agregado ******/

          public function get_perdida_por_id_usuario($id_usuario){
          $conectar= parent::conexion();
          $sql="select * from perdidas where id_usuario=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $id_usuario);
          $sql->execute();
          return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        /****** Fin bloque agregado ******/
	}
?>