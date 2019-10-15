<?php  
	//conexion a la base de datos
	require_once("../config/conexion.php");
  
	Class Gastos extends Conectar{

		//listar los gastos
		public function get_gastos(){
			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select * from gastos";
			$sql = $conectar->prepare($sql);
			$sql-> execute();

			return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		//mostrar los gastos por el id
		public function get_gastos_por_id($id_gasto){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select * from gastos where id_gasto=?";	
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $id_gasto);
			$sql-> execute();

			return $resultado = $sql->fetchAll();
		}

		//registrar gastos
		public function registrar_gastos($fecha, $descripcion, $precio, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "insert into gastos values(null,?,?,?,?);";
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $_POST["fecha"]);
			$sql-> bindValue(2, $_POST["descripcion"]);
			$sql-> bindValue(3, $_POST["precio"]);
			$sql-> bindValue(4, $_POST["id_usuario"]);
			$sql-> execute();

		}
 
		//editar gastos
		public function editar_gasto($id_gasto, $fecha, $descripcion, $precio, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "update gastos set
            fecha=?,
            descripcion=?,
            precio=?,
            id_usuario=?
            where
            id_gasto=?";	

			$sql = $conectar->prepare($sql);

			$sql-> bindValue(1, $_POST["fecha"]);
			$sql-> bindValue(2, $_POST["descripcion"]);
			$sql-> bindValue(3, $_POST["precio"]);
			$sql-> bindValue(4, $_POST["id_usuario"]);
			$sql-> bindValue(5, $_POST["id_gasto"]);
			$sql-> execute();
		}

		//método para eliminar un gasto
        public function eliminar_gasto($id_gasto){
           $conectar = parent::conexion();
           parent::set_names();

           $sql="delete from gastos where id_gasto=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1, $id_gasto);
           $sql->execute();

           return $resultado=$sql->fetch();
        }
	}
?>