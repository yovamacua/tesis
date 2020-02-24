<?php
 //llamo a la conexion de la base de datos
  require_once("../config/conexion.php");
  require_once("../modelos/Categorias.php");
   require_once("../modelos/Roles.php");
  require_once("mensajes.php");
  #valida que exista la sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}



//objeto de tipo Incidentes
  $categorias = new Categorias();
  $usuario = new Roles();

   $id_categoria=isset($_POST["id_categoria"]);
   $categoria=isset($_POST["categoria"]);
   $descripcion=isset($_POST["descripcion"]);
   $id_usuario=isset($_POST["id_usuario"]);

      switch($_GET["op"]){
          case "guardaryeditar":
          if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]*$/', $_POST["categoria"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["descripcion"])) 
        {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {

      $datos = $categorias->get_nombre_categoria($_POST["categoria"]);
	       	   /*si el titulo no existe entonces lo registra
	           importante: se debe poner el $_POST sino no funciona*/
	          if(empty($_POST["id_categoria"])){
	       	  /*verificamos si el incidente existe en la base de datos, si ya existe un registro con la categoria entonces no se registra*/
			       	   if(is_array($datos)==true and count($datos)==0){
			       	   	  //no existe la categoria por lo tanto hacemos el registros
		 $categorias->registrar_categoria($categoria,$descripcion,$id_usuario);
			       	   	  $messages[]="La categoria se registró correctamente";
			       	   } //cierre de validacion de $datos
			       	      /*si ya existes el titulo del incidente entonces aparece el mensaje*/
				              else {
				              	  $errors[]="Existe una categoria con el mismo nombre";
				              }

			    }//cierre de empty

	            else {
	            	/*si ya existe entonces editamos el incidente*/
	             $categorias-> editar_categoria($id_categoria,$categoria,$descripcion,$id_usuario);
	            	  $messages[]="La categoria se editó correctamente";
	            }
            }
     //mensaje success
     //mensaje success
          if (isset($messages)) {
              echo exito($messages);
          }
          //fin success
          //mensaje error
          if (isset($errors)) {
              echo error($errors);
          }
          //fin mensaje error
			
	 //fin success
     break;

      case 'mostrar':
	//selecciona del incidente
  //el parametro id_incidente se envia por AJAX cuando se edita la categoria
	$datos=$categorias->get_categorias_por_id($_POST["id_categoria"]);
          // si existe el id del incidnete entonces recorre el array
	      if(is_array($datos)==true and count($datos)>0){
    				foreach($datos as $row)
    				{
              $output["id_categoria"] = $row["id_categoria"];
              $output["categoria"] = $row["categoria"];
              $output["descripcion"] = $row["descripcion"];
    		
    				}
              echo json_encode($output);
	        } else {
                 //si no existe la categoria entonces no recorre el array
                $errors[]="la categoria  no existe";
	        }

         //inicio de mensaje de error
				if(isset($errors)){
					?>
					<div class="alert alert-danger" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Error!</strong>
							<?php
								foreach ($errors as $error) {
										echo $error;
									}
								?>
					</div>
					<?php
			      }
	        //fin de mensaje de error
	 break;
        case "listar":
     $datos=$categorias->get_categoria();
     $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
      $valores=array();

      //Almacenamos los permisos marcados en el array
foreach($rol as $rows){

              $valores[]= $rows["codigo"];
          }
        
         
 	 $data= Array();

     foreach($datos as $row)
      {
        $sub_array = array();
      $sub_array[] = $row["categoria"];
      $sub_array[] = $row["descripcion"];

              $button_editar=' <button type="button" onClick="mostrar('.$row["id_categoria"].');"  id="'.$row["id_categoria"].'" class="btn btn-primary btn-md update hint--top" aria-label="Editar Categoria" ><i class="fa fa-pencil-square-o"></i></button>';

                          $button_eliminar=' <button type="button" onClick="eliminar('.$row["id_categoria"].');"  id="'.$row["id_categoria"].'" class="btn btn-danger btn-md hint--top" aria-label="Eliminar Perdida "><i class="fa fa-trash"></i></button></div>';
            ?>
          <?php  
          if(in_array("EDCATE",$valores) and in_array("ELCATE",$valores)){
                 $sub_array[]='<div class="cbtns">'.$button_editar.''.$button_eliminar.'</div>';
              } elseif (in_array("EDCATE",$valores)) {
                 $sub_array[]='<div class="cbtns">'.$button_editar.'</div>';
              }elseif(in_array("ELCATE",$valores)){
                  $sub_array[]='<div class="cbtns">'.$button_eliminar.'</div>';

              }else{
                
                  $sub_array[]='<div class="cbtns badge bg-red-active"> No Acciones</div>';

              }

              
      ?>
         
          
      <?php     
      $data[] = $sub_array;
      }

      $results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);


     break;

     case "eliminar_categoria":

  $datos= $categorias->get_categorias_por_id($_POST["id_categoria"]);
  
     if(is_array($datos)==true and count($datos)>0){
          $categorias->eliminar_categoria($_POST["id_categoria"]);
          $messages[]=" La categoria se eliminó exitosamente";
     }else {
       $errors[]="No hay registro que borrar";
     }

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
break;
}
?>
