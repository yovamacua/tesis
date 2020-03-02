<?php  
	//conexion a la base de datos
	require_once("../config/conexion.php");

	#valida que exista la sessión
	if (!isset($_SESSION['id_usuario'])) {?>
	        <script type="text/javascript">
	        window.location="../vistas/inicio.php";
	        </script>
	    <?php
	}
  
	Class Insumos extends Conectar{

		//listar los insumos
		public function get_insumos(){
			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select u.usuario, i.id_insumo, i.cantidad, i.precio, i.descripcion, i.fecha, c.categoria, uni.nombre, i.iduni
				from insumos i 
				inner join categorias c on c.id_categoria = i.idcategoria 
				inner join unidad uni on uni.idunidad = i.iduni
				inner join usuarios u on u.id_usuario = uni.idusuariouni";

			$sql = $conectar->prepare($sql);
			$sql-> execute();

			return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		//mostrar los insumos por el id
		public function get_insumos_por_id($id_insumo){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select * from insumos where id_insumo=?";	
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $id_insumo);
			$sql-> execute();

			return $resultado = $sql->fetchAll();
		}

		//registrar insumos
		public function registrar_insumo($cantidad, $precio, $descripcion, $fecha, $idcategoria, $iduni){

			try{
	            $conectar=parent::conexion();
	            parent::set_names();
	           
	            $date_inicial = $_POST["fecha"];
	            $date = str_replace('/', '-', $date_inicial);
	            $fecha = date("Y-m-d", strtotime($date));
	          
	          	$sql = "call registrar_insumo(?,?,?,?,?,?);";

	            $sql = $conectar->prepare($sql);
				$sql-> bindValue(1, $_POST["cantidad"], PDO::PARAM_INT);
				$sql-> bindValue(2, $_POST["precio"], PDO::PARAM_STR);
				$sql-> bindValue(3, $_POST["descripcion"], PDO::PARAM_STR);
				$sql-> bindValue(4, $fecha);
				$sql-> bindValue(5, $_POST["idcategoria"], PDO::PARAM_INT);
				$sql-> bindValue(6, $_POST["iduni"], PDO::PARAM_INT);
				$sql-> execute();

         	}catch(PDOException $ex){

          echo $ex->getMessage();
         }

        }

        //editar insumos
		public function editar_cantidad($idinsumo, $salida, $fechaS){

			$conectar = parent::conexion();
			parent::set_names();

			$date_inicial = $_POST["fechaS"];
            $date = str_replace('/', '-', $date_inicial);
            $fechaS = date("Y-m-d", strtotime($date));

			$sql = "call editar_insumo(?,?,?);";	

			$sql = $conectar->prepare($sql);

			$sql-> bindValue(1, $_POST["idinsumo"], PDO::PARAM_INT);
			$sql-> bindValue(2, $_POST["salida"], PDO::PARAM_INT);
			$sql-> bindValue(3, $fechaS);
			$sql-> execute();
			
		}
 
		//editar insumos
		public function editar_insumo($id_insumo, $cantidad, $precio, $descripcion, $fecha, $idcategoria, $iduni, $cantidad1){

			$conectar = parent::conexion();
			parent::set_names();

			$date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

			$sql = "call editar_valoresinsumo(?,?,?,?,?,?,?,?);";	

			$sql = $conectar->prepare($sql);

			$sql-> bindValue(1, $_POST["id_insumo"]);
			$sql-> bindValue(2, $_POST["cantidad"]);
			$sql-> bindValue(3, $_POST["precio"]);
			$sql-> bindValue(4, $_POST["descripcion"]);
			$sql-> bindValue(5, $fecha);
			$sql-> bindValue(6, $_POST["idcategoria"]);
			$sql-> bindValue(7, $_POST["iduni"]);
			$sql-> bindValue(8, $_POST["cantidad1"]);
			$sql-> execute();
		}

		//método para eliminar un insumos
        public function eliminar_insumo($id_insumo){
           $conectar = parent::conexion();
           parent::set_names();

           $sql="delete from insumos where id_insumo=?"; 
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1, $id_insumo);
           $sql->execute();

           return $resultado=$sql->fetch();
        }

        //método para eliminar un registro de kardexinsumo
        public function eliminar_kardexinsumo($id_insumo){
          $conectar = parent::conexion();
          parent::set_names();

            //Sentencia para eliminar kardexinsumo con ese id
            $sql = "delete ki from kardexinsumo ki 
					inner join insumos i
					on ki.idinsumo = i.id_insumo
					where i.id_insumo = ?";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id_insumo);
            $sql->execute();

            return $resultado = $sql->fetch();
        }
	}
?>