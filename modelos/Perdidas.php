<?php  
	//conexion a la base de datos
	require_once("../config/conexion.php");
  
	Class Perdidas extends Conectar{

		//listar las perdidas
		public function get_perdidas(){
			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select * from perdidas";
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

		//registrar perdidas
		public function registrar_perdidas($nombreProduc, $cantidad, $descripcion, $precioProduc, $mes, $anio, $unidadDelProduc, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "insert into perdidas values(null,?,?,?,?,?,?,?,?);";
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $_POST["nombreProduc"]);
			$sql-> bindValue(2, $_POST["cantidad"]);
			$sql-> bindValue(3, $_POST["descripcion"]);
			$sql-> bindValue(4, $_POST["precioProduc"]);
			$sql-> bindValue(5, $_POST["mes"]);
			$sql-> bindValue(6, $_POST["anio"]);
			$sql-> bindValue(7, $_POST["unidadDelProduc"]);
			$sql-> bindValue(8, $_POST["id_usuario"]);
			$sql-> execute();
		}
 
		//editar perdidas
		public function editar_perdida($id_perdida, $nombreProduc, $cantidad, $descripcion, $precioProduc, $mes, $anio, $unidadDelProduc, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "update perdidas set
            nombreProduc=?,
            cantidad=?,
            descripcion=?,
            precioProduc=?,
            mes=?,
            anio=?,
            unidadDelProduc=?,
            id_usuario=?
            where
            id_perdida=?";	

			$sql = $conectar->prepare($sql);

			$sql-> bindValue(1, $_POST["nombreProduc"]);
			$sql-> bindValue(2, $_POST["cantidad"]);
			$sql-> bindValue(3, $_POST["descripcion"]);
			$sql-> bindValue(4, $_POST["precioProduc"]);
			$sql-> bindValue(5, $_POST["mes"]);
			$sql-> bindValue(6, $_POST["anio"]);
			$sql-> bindValue(7, $_POST["unidadDelProduc"]);
			$sql-> bindValue(8, $_POST["id_usuario"]);
			$sql-> bindValue(9, $_POST["id_perdida"]);
			$sql-> execute();
		}

		// //método si la perdida existe en la base de datos
		// public function get_nombre_perdida($nombreProduc){

	 //        $conectar=parent::conexion();
	 //        $sql="select * from perdidas where nombreProduc=?";
	 //        $sql=$conectar->prepare($sql);
	 //        $sql->bindValue(1, $nombreProduc);
	 //        $sql->execute();
  //          	return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
  //       }

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
	}
?>