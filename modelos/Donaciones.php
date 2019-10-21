<?php  
	//conexion a la base de datos
	require_once("../config/conexion.php");
  
	Class Donaciones extends Conectar{

		//listar las donaciones
		public function get_donaciones(){
			$conectar = parent::conexion();
			parent::set_names();

			$sql = "select * from donaciones";
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
		public function registrar_donaciones($fecha, $donante, $descripcion, $cantidad, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "insert into donaciones values(null,?,?,?,?,?);";
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $_POST["fecha"]);
			$sql-> bindValue(2, $_POST["donante"]);
			$sql-> bindValue(3, $_POST["descripcion"]);
			$sql-> bindValue(4, $_POST["cantidad"]);
			$sql-> bindValue(5, $_POST["id_usuario"]);
			$sql-> execute();

		}
 
		//editar donaciones
		public function editar_donacion($id_donacion, $fecha, $donante, $descripcion, $cantidad, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "update donaciones set
            fecha=?,
            donante=?,
            descripcion=?,
            cantidad=?,
            id_usuario=?
            where
            id_donacion=?";	

			$sql = $conectar->prepare($sql);

			$sql-> bindValue(1, $_POST["fecha"]);
			$sql-> bindValue(2, $_POST["donante"]);
			$sql-> bindValue(3, $_POST["descripcion"]);
			$sql-> bindValue(4, $_POST["cantidad"]);
			$sql-> bindValue(5, $_POST["id_usuario"]);
			$sql-> bindValue(6, $_POST["id_donacion"]);
			$sql-> execute();
		}

		//método para eliminar un registro
        public function eliminar_donacion($id_donacion){
           $conectar = parent::conexion();
           parent::set_names();

           $sql="delete from donaciones where id_donacion=?";
           $sql=$conectar->prepare($sql);
           $sql->bindValue(1, $id_donacion);
           $sql->execute();

           return $resultado=$sql->fetch();
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