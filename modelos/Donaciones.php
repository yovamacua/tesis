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
  
	Class Donaciones extends Conectar{

		//listar las donaciones
		public function get_donaciones(){
			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select d.id_donacion, d.fecha, d.donante, d.descripcion, d.cantidad, d.precio, u.usuario from donaciones d inner join usuarios u on d.id_usuario = u.id_usuario";
			$sql = $conectar->prepare($sql);
			$sql-> execute();

			return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		//mostrar las donaciones por el id
		public function get_donaciones_por_id($id_donacion){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select * from donaciones where id_donacion=?";	
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $id_donacion);
			$sql-> execute();

			return $resultado = $sql->fetchAll();
		}

		//registrar donaciones
		public function registrar_donaciones($fecha, $donante, $descripcion, $cantidad, $precio, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

			$sql = "insert into donaciones values(null,?,?,?,?,?,?);";
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $fecha);
			$sql-> bindValue(2, substr($_POST["donante"], 0, 45));
			$sql-> bindValue(3, substr($_POST["descripcion"], 0, 100));
			$sql-> bindValue(4, substr($_POST["cantidad"], 0, 4));
			$sql-> bindValue(5, $_POST["precio"]);
			$sql-> bindValue(6, $_POST["id_usuario"]);
			$sql-> execute();

		}
 
		//editar donaciones
		public function editar_donacion($id_donacion, $fecha, $donante, $descripcion, $cantidad, $precio, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

			$sql = "update donaciones set
            fecha=?,
            donante=?,
            descripcion=?,
            cantidad=?,
            precio=?,
            id_usuario=?
            where
            id_donacion=?";	

			$sql = $conectar->prepare($sql);

			$sql-> bindValue(1, $fecha);
			$sql-> bindValue(2, substr($_POST["donante"], 0, 45));
			$sql-> bindValue(3, substr($_POST["descripcion"], 0, 100));
			$sql-> bindValue(4, substr($_POST["cantidad"], 0, 4));
			$sql-> bindValue(5, $_POST["precio"]);
			$sql-> bindValue(6, $_POST["id_usuario"]);
			$sql-> bindValue(7, $_POST["id_donacion"]);
			$sql-> execute();
		}

		//método para eliminar un registro
        public function eliminar_donacion($id_donacion){
           $conectar = parent::conexion();
           parent::set_names();

           $sql = "delete from donaciones where id_donacion=?";
           $sq = $conectar->prepare($sql);
           $sql->bindValue(1, $id_donacion);
           $sql->execute();

           return $resultado = $sql->fetch();
        }

         public function get_year_donaciones(){
        	$conectar = parent::conexion();

          	$sql = "select year(fecha) as fecha from donaciones group by year(fecha) asc";
          
          	$sql = $conectar->prepare($sql);
          	$sql->execute();
          	return $resultado = $sql->fetchAll();
     	}

        public function get_donacion_mensual($fecha){
        	$conectar = parent::conexion();
      
	      	if(isset($_POST["year"])){
	        	$fecha = $_POST["year"];

	        	$sql = "select MONTH(fecha) as mes, YEAR(fecha) as anio
						from donaciones where YEAR(fecha)=? group by mes desc, anio desc;";
	           
	          	$sql = $conectar->prepare($sql);
	          	$sql->bindValue(1, $fecha);
	          	$sql->execute();
	         	return $resultado = $sql->fetchAll();
	        }else{

	          	//sino se envia el POST, entonces se mostraria los datos del año actual cuando se abra la pagina por primera vez
	          	$fecha_inicial = date("Y");

	            $sql = "select MONTH(fecha) as mes, YEAR(fecha) as anio
						from donaciones where YEAR(fecha)=? group by mes desc, anio desc;";

	         	$sql=$conectar->prepare($sql);
	          	$sql->bindValue(1, $fecha_inicial);
	          	$sql->execute();
	            return $resultado = $sql->fetchAll();
        	}
     	}

                /****** Bloque agregado ******/

          public function get_donaciones_por_id_usuario($id_usuario){
          $conectar= parent::conexion();
          $sql="select * from donaciones where id_usuario=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $id_usuario);
          $sql->execute();
          return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        /****** Fin bloque agregado ******/
	}
?>