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

			$sql = "select i.id_insumo, i.cantidad, i.precio,  i.unidadMedida, i.descripcion, i.fecha, i.idpedido, c.categoria from insumos i inner join categorias c on c.id_categoria = i.idcategoria";
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
		public function registrar_insumo($cantidad, $precio, $unidadMedida, $descripcion, $fecha, $idpedido, $idcategoria){

			$conectar = parent::conexion();
			parent::set_names();

			$date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

			$sql = "insert into insumos values(null,?,?,?,?,?,?,?);";
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $_POST["cantidad"]);
			$sql-> bindValue(2, $_POST["precio"]);
			$sql-> bindValue(3, $_POST["unidadMedida"]);
			$sql-> bindValue(4, $_POST["descripcion"]);
			$sql-> bindValue(5, $fecha);
			$sql-> bindValue(6, $_POST["idpedido"]);
			$sql-> bindValue(7, $_POST["idcategoria"]);
			$sql-> execute();

		}
 
		//editar insumos
		public function editar_insumo($id_insumo, $cantidad, $precio, $unidadMedida, $descripcion, $fecha, $idpedido, $idcategoria){

			$conectar = parent::conexion();
			parent::set_names();

			$date_inicial = $_POST["fecha"];
            $date = str_replace('/', '-', $date_inicial);
            $fecha = date("Y-m-d", strtotime($date));

			$sql = "update insumos set
            cantidad=?,
            precio=?,
            unidadMedida=?,
            descripcion=?,
            fecha=?,
            idpedido=?,
            idcategoria=?
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
			$sql-> bindValue(8, $_POST["id_insumo"]);
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