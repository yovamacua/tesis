<?php

  //llamar a la conexion de la base de datos
  require_once("../config/conexion.php");
  //llamar a el modelo Usuarios
  require_once("../modelos/Usuarios.php");
  //se crea un objeto de tipo usuario
  $usuarios = new Usuarios();

  //se declaran las variables de los valores que se envian por el formulario
  //y se valida que no se esten recibiendo vacias

   $id_usuario = isset($_POST["id_usuario"]);
   $nombre=isset($_POST["nombre"]);
   $apellido=isset($_POST["apellido"]);
   $email=isset($_POST["email"]);
   $cargo=isset($_POST["cargo"]);
   $usuario=isset($_POST["usuario"]);
   $password1=isset($_POST["password1"]);
   $password2=isset($_POST["password2"]);
   //este es el que se envia del formulario
   $estado=isset($_POST["estado"]);

   // switch para seleccionar opcion segun parametro enviado en la url
   switch($_GET["op"]){
   case "guardaryeditar":

   /*verificamos si existe correo en la base de datos
   si ya existe un registro con esecorreo entonces no se registra el usuario*/

   $datos = $usuarios->get_correo_del_usuario($_POST["email"]);
   //validacion que los 2 password enviados sean iguales
   if($password1 == $password2){
   /*si el id no existe entonces lo registra
	 importante: se debe poner el $_POST sino no funciona*/

	 if(empty($_POST["id_usuario"])){
     /*si coincide password1 y password2 entonces verificamos si ya
     existe el correo en la base de datos, si existe no se registra el usuario*/
       	   if(is_array($datos)==true and count($datos)==0){
             //no existe el usuario por lo tanto hacemos el registros
                  $usuarios->registrar_usuario($nombre,$apellido,$email,$cargo,$usuario,$password1,$password2,$estado);
            /*si se registra el usuario aparece siguente mensaje*/
                         $messages[]="El usuario se registró correctamente";
	                     	   } else {
             /*si NO se registra el usuario aparece siguente mensaje*/
                                    $messages[]="La cédula o el correo ya existe";
	                     	   }
	                     } //cierre de la validacion empty que valida el id usuario no sea vacio

	                     else {
             /*si ya existe entonces editamos el usuario*/
            $usuarios->editar_usuario($id_usuario,$nombre,$apellido,$email,$cargo,$usuario,$password1,$password2,$estado);
            /*si edita el usuario aparece siguente mensaje*/
                             $messages[]="El usuario se editó correctamente";
	                     }
                 } else {
                 	  /*si las 2 constraseñas no coinciden, entonces se muestra el mensaje de error*/
                        $errors[]="El password no coincide";
                 }

// inicio bloque de mensaje de notificacion de accion realizada o no realizada
    //mensaje de exito
     if(isset($messages)){

				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}
	 // fin mensaje de exito

    //mensaje de error
         if(isset($errors)){

			?>
				<div class="alert alert-danger" role="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Error!</strong>
						<?php
							foreach($errors as $error) {
									echo $error;
								}
							?>
				</div>
			<?php
			}
	 //fin mensaje error
   // fin bloque de mensaje de notificacion
      break; // fin del primer caso

//inicio otro caso
         case "mostrar":
        //selecciona el id del usuario
       //el parametro id_usuario se envia por AJAX cuando se edita el usuario
        $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);
        //validacion del id del usuario
             if(is_array($datos)==true and count($datos)>0){
               //recorriendo todas la posiciones del array
             	 foreach($datos as $row){
                 //nombre cualquier / campo bd, trata de usar siempre los mismo en ambos lados
                    $output["nombre"] = $row["nombres"];
            				$output["apellido"] = $row["apellidos"];
                    $output["correo"] = $row["correo"];
            				$output["cargo"] = $row["cargo"];
            				$output["usuario"] = $row["usuario"];
            				$output["password1"] = $row["password"];
            				$output["password2"] = $row["password2"];
            				$output["estado"] = $row["estado"];
             	 }
               //devuelve datos de registro de usuario
             	 echo json_encode($output);
             } else {
               //si no existe el registro entonces no recorre el array
                $errors[]="El usuario no existe";

             }


	         //inicio de mensaje de error

				if(isset($errors)){
					?>
					<div class="alert alert-danger" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Error!</strong>
							<?php
								foreach($errors as $error) {
										echo $error;
									}
								?>
					</div>
					<?php
			      }
	        //fin de mensaje de error

// inicio caso
         break;
         case "activarydesactivar":
        //los parametros id_usuario y estado vienen por via ajax
              $datos = $usuarios->get_usuario_por_id($_POST["id_usuario"]);
                //valida el id del usuario
                 if(is_array($datos)==true and count($datos)>0){
                  //edita el estado del usuario
                    $usuarios->editar_estado($_POST["id_usuario"],$_POST["est"]);
                 }
         break;

//inicio caso
         case "listar":
         $datos = $usuarios->get_usuarios();
         //declaramos el array
         $data = Array();
         foreach($datos as $row){
           $sub_array= array();
            $est = '';
            //imprimir palabra en vez de el numero 0 o 1
	         $atrib = "btn btn-success btn-md estado";
	        if($row["estado"] == 0){
	          $est = 'INACTIVO';
	          $atrib = "btn btn-warning btn-md estado";
	        }
	        else{
	          if($row["estado"] == 1){
	            $est = 'ACTIVO';

	          }
	        }

//imprimr la palabra en vez del numero
          if($row["cargo"]==1){
              $cargo="ADMINISTRADOR";
            } else{
            	if($row["cargo"]==0){
                   $cargo="EMPLEADO";
            	}
            }
            //campos de la tabla usuario
      $sub_array[] = $row["nombres"];
      $sub_array[] = $row["apellidos"];
      $sub_array[] = $row["usuario"];
      $sub_array[] = $row["correo"];
      $sub_array[] = $cargo;
      //se formate el la fecha, tipo y formato
      $sub_array[] = date("d-m-Y",strtotime($row["fecha_ingreso"]));
      //botones con valores de los campos en el id
      $sub_array[] = '<button type="button" onClick="cambiarEstado('.$row["id_usuario"].','.$row["estado"].');" name="estado" id="'.$row["id_usuario"].'" class="'.$atrib.'">'.$est.'</button>';
      $sub_array[] = '<button type="button" onClick="mostrar('.$row["id_usuario"].');"  id="'.$row["id_usuario"].'" class="btn btn-warning btn-md update"><i class="glyphicon glyphicon-edit"></i> Editar</button>';
      $sub_array[] = '<button type="button" onClick="eliminar('.$row["id_usuario"].');"  id="'.$row["id_usuario"].'" class="btn btn-danger btn-md"><i class="glyphicon glyphicon-edit"></i> Eliminar</button>';
	     $data[]=$sub_array;
     }

     //"configuraciones" para el data table
      $results= array(
      "sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
      echo json_encode($results);
      break;
     }
?>
