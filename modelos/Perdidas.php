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

			$sql = "select p.id_perdida, pr.producto, p.cantidad, p.descripcion, p.precioProduc, p.mes, p.anio, uni.nombre, u.usuario 
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

		//registrar perdidas
		public function registrar_perdidas($idproducto, $cantidad, $descripcion, $precioProduc, $mes, $anio, $unidadDelProduc, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "insert into perdidas values(null,?,?,?,?,?,?,?,?);";
			$sql = $conectar->prepare($sql);
			$sql-> bindValue(1, $_POST["idproducto"]);
			$sql-> bindValue(2, substr($_POST["cantidad"], 0, 4));
			$sql-> bindValue(3, substr($_POST["descripcion"], 0, 100));
			$sql-> bindValue(4, $_POST["precioProduc"]);
			$sql-> bindValue(5, substr($_POST["mes"], 0, 2));
			$sql-> bindValue(6, substr($_POST["anio"], 0, 4));
			$sql-> bindValue(7, $_POST["unidadDelProduc"]);
			$sql-> bindValue(8, $_POST["id_usuario"]);
			$sql-> execute();
			

		}
 
		//editar perdidas
		public function editar_perdida($id_perdida, $idproducto, $cantidad, $descripcion, $precioProduc, $mes, $anio, $unidadDelProduc, $id_usuario){

			$conectar = parent::conexion();
			parent::set_names();

			$sql = "update perdidas set
            idproducto=?,
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

			$sql-> bindValue(1, $_POST["idproducto"]);
			$sql-> bindValue(2, substr($_POST["cantidad"], 0, 4));
			$sql-> bindValue(3, substr($_POST["descripcion"], 0, 100));
			$sql-> bindValue(4, $_POST["precioProduc"]);
			$sql-> bindValue(5, substr($_POST["mes"], 0, 2));
			$sql-> bindValue(6, substr($_POST["anio"], 0, 4));
			$sql-> bindValue(7, $_POST["unidadDelProduc"]);
			$sql-> bindValue(8, $_POST["id_usuario"]);
			$sql-> bindValue(9, $_POST["id_perdida"]);
			$sql-> execute();
		}

		 // reportes de perdidas 

        public function get_perdidas_reporte_general()
        {
          $conectar = parent::conexion();
           parent::set_names();

           	$sql = "SELECT mes as Mes, anio as Año, SUM(precioProduc) as totalPerdida
					FROM perdidas GROUP BY anio desc, mes desc;";
        	$sql = $conectar->prepare($sql);
        	$sql->execute();
        	return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //metodo de llanado para grafica
    	public function get_perdidas_anio_actual_grafica()
    	{

	       $conectar=parent::conexion();
	       parent::set_names();

	       $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	       
	       $sql = "SELECT  mes as Mes, SUM(precioProduc) as total_perdida_mes FROM perdidas
	        GROUP BY mes desc";
	           
	        $sql = $conectar->prepare($sql);
	        $sql->execute();

	        $resultado = $sql->fetchAll();
	             
	        //recorro el array y lo imprimo
	        foreach($resultado as $row){
	        	//$fecha = $arregloReg[$i]["mes"];
               // $fecha_mes = $meses[$fecha-1];

	          	$mes = $output["mes"] = $meses[$row["Mes"]-1];
	          	$total = $output["total_perdida_mes"] = $row["total_perdida_mes"];

	         echo $grafica= "{name:'".$mes."', y:".$total."},";

	        }
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