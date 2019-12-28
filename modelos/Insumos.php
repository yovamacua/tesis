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
  
	Class Insumos extends Conectar{

		//listar los insumos
		public function get_insumos(){
			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select u.usuario, i.id_insumo, i.cantidad, i.precio, i.descripcion, i.fecha, i.idpedido, c.categoria, uni.nombre, i.iduni
				from insumos i 
				inner join categorias c on c.id_categoria = i.idcategoria 
				inner join pedidos p on p.id_pedido = i.idpedido 
				inner join usuarios u on p.id_usuario = u.id_usuario
				inner join unidad uni on i.iduni = uni.idunidad";

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
		public function registrar_insumo($cantidad, $precio, $descripcion, $fecha, $idpedido, $idcategoria, $iduni){

			try{
	            $conectar=parent::conexion();
	            parent::set_names();
	           
	            $date_inicial = $_POST["fecha"];
	            $date = str_replace('/', '-', $date_inicial);
	            $fecha = date("Y-m-d", strtotime($date));
	          
	          	$sql = "call registrar_insumo(?,?,?,?,?,?,?);";

	            $sql = $conectar->prepare($sql);
				$sql-> bindValue(1, $_POST["cantidad"], PDO::PARAM_INT);
				$sql-> bindValue(2, $_POST["precio"], PDO::PARAM_STR);
				$sql-> bindValue(3, $_POST["descripcion"], PDO::PARAM_STR);
				$sql-> bindValue(4, $fecha);
				$sql-> bindValue(5, $_POST["idpedido"], PDO::PARAM_INT);
				$sql-> bindValue(6, $_POST["idcategoria"], PDO::PARAM_INT);
				$sql-> bindValue(7, $_POST["iduni"], PDO::PARAM_INT);
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
		public function editar_insumo($id_insumo, $cantidad, $precio, $descripcion, $fecha, $idpedido, $idcategoria, $iduni){

			$conectar = parent::conexion();
			parent::set_names();

			$date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

			$sql = "update insumos set
            cantidad=?,
            precio=?,
            descripcion=?,
            fecha=?,
            idpedido=?,
            idcategoria=?,
            iduni=?
            where
            id_insumo=?";	

			$sql = $conectar->prepare($sql);

			$sql-> bindValue(1, $_POST["cantidad"]);
			$sql-> bindValue(2, $_POST["precio"]);
			$sql-> bindValue(3, $_POST["unidadMedida"]);
			$sql-> bindValue(4, $_POST["descripcion"]);
			$sql-> bindValue(5, $fecha);
			$sql-> bindValue(6, $_POST["idpedido"]);
			$sql-> bindValue(7, $_POST["idcategoria"]);
			$sql-> bindValue(8, $_POST["iduni"]);
			$sql-> bindValue(9, $_POST["id_insumo"]);
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
	}
?>