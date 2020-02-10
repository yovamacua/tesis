<?php
//llamo a la conexion de la base de datos
require_once "../config/conexion.php";
require_once "../modelos/Cuenta.php";
require_once("../modelos/Roles.php");
require_once "mensajes.php";

//objeto de tipo cuentas
$cuentas = new cuentas();
$usuario = new Roles();

$id_cuenta    = isset($_POST["id_cuenta"]);
$nombrecuenta = isset($_POST["nombrecuenta"]);
$id_partida   = isset($_POST["id_partida"]);
$estrategia   = isset($_POST["estrategia"]);
$objetivo     = isset($_POST["objetivo"]);

if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

switch ($_GET["op"]) {
    case "guardaryeditar":

        // se reciben las variables y se valida si el formato es correcto
        if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9.:,¿?!¡\s]*$/', $_POST["nombrecuenta"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["estrategia"]) or
            !preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["objetivo"])) {
            $errors[] = "Formatos de Información no validos";
            echo error($errors);
        } else {

            $datos = $cuentas->get_nombre_cuentas($_POST["nombrecuenta"]);

            /*si el titulo no existe entonces lo registra
            importante: se debe poner el $_POST sino no funciona*/
            if (empty($_POST["id_cuenta"])) {
                /*verificamos si el cuenta existe en la base de datos */
                //no existe la cuenta por lo tanto hacemos el registros
                $cuentas->registrar_cuentas($nombrecuenta, $id_partida, $estrategia, $objetivo);
                $messages[] = "La cuenta se registró correctamente";
                //cierre de validacion de $datos
            } //cierre de empty
            else {
                /*si ya existe entonces editamos el cuenta*/
                $cuentas->editar_cuentas($id_cuenta, $nombrecuenta, $id_partida, $objetivo, $estrategia);
                $messages[] = "El cuenta se editó correctamente";
            }
        }
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
        break;

    case 'mostrar':
        //selecciona del cuenta
        //el parametro id_cuenta se envia por AJAX cuando se edita la cuenta
        $datos = $cuentas->get_cuentas_por_id($_POST["id_cuenta"]);
        // si existe el id del incidente entonces recorre el array
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["id_cuenta"]    = $row["id_cuenta"];
                $output["nombrecuenta"] = $row["nombrecuenta"];
                $output["objetivo"]     = $row["objetivo"];
                $output["estrategia"]   = $row["estrategia"];
            }
            echo json_encode($output);
        } else {
            //si no existe la cuenta entonces no recorre el array
            $errors[] = "La cuenta no existe";
        }

        //mensaje error
        if (isset($errors)) {
            echo error($errors);
        }
        //fin de mensaje de error
        break;
    case "listar":
        $identificador = $_SESSION["seleccion_partida"];
        $datos         = $cuentas->get_cuentas($identificador);
           $rol=$usuario->listar_roles_por_usuario($_SESSION['id_usuario']);
      $valores=array();

      //Almacenamos los permisos marcados en el array
foreach($rol as $rows){

              $valores[]= $rows["codigo"];
          }

        $data          = array();

        foreach ($datos as $row) {

        if ($cuentas->dinero($row["id_cuenta"]) <= 0) {
                $nulo = 0;
            }else{
                $nulo = $cuentas->dinero($row["id_cuenta"]);
            }

            $sub_array   = array();
            $sub_array[] = $row["nombrecuenta"];
            $sub_array[] = $row["objetivo"];
            $sub_array[] = $row["estrategia"];
            $sub_array[] = $nulo;

        
     $boton_registrar= '<a href="entrada.php?identificador=' . $row["id_cuenta"] . '&nombrecuenta=' . $row["nombrecuenta"] . '">
      <button type="button" class="btn btn-primary btn-md"><i class="glyphicon glyphicon-edit"></i> Administar <span class="notistyle">'. $cuentas->conteo($row["id_cuenta"]).'</span></button>
      </a>';
     
     $boton_editar='<button type="button" onClick="mostrar(' . $row["id_cuenta"] . ');"  id="' . $row["id_cuenta"] . '" class="btn btn-primary btn-md update hint--top" aria-label="Editar"><i class="fa fa-pencil-square-o"></i></button>&nbsp;';

$boton_imprimir='<a href="reportes/reporte-excel-cuenta.php?selector=' . $row["id_cuenta"] . '&selector2='.$_SESSION["seleccion_partida"].'" download>
      <button type="button" class="btn btn-info btn-md update hint--top" aria-label="Descargar Excel"><i class="fa fa fa-file-excel-o"></i></button>
      </a>';
      
     $boton_eliminar='<button type="button" onClick="eliminar(' . $row["id_cuenta"] . ');"  id="' . $row["id_cuenta"] . '" class="btn btn-danger btn-md hint--top" aria-label="Eliminar"><i class="fa fa-trash"></i></button>
     ';
     if(in_array("REPART",$valores) and in_array("EDPART",$valores)and in_array("ELPART",$valores)){
            $sub_array[]='<div class="cbtns">'.$boton_registrar.'</div>';
                 $sub_array[]='<div class="cbtns">'.$boton_editar.''.$boton_eliminar.''.$boton_imprimir.'</div>';
                  
              }
              elseif (in_array("EDPART",$valores)and in_array("ELPART",$valores)) {
                    $sub_array[]='<div class="cbtns">'.$boton_editar.' '.$boton_eliminar.''.$boton_imprimir.'</div>';
              }
              elseif (in_array("REPART",$valores)and in_array("EDPART",$valores)) {
                    $sub_array[]='<div class="cbtns">'.$boton_registrar.' '.$boton_editar.''.$boton_imprimir.'</div>';
                }
                elseif (in_array("ELPART",$valores)and in_array("REPART",$valores)) {
                    $sub_array[]='<div class="cbtns">'.$boton_editar.' '.$boton_eliminar.''.$boton_imprimir.'</div>';
                }
                elseif (in_array("EDPART",$valores)) {
                    $sub_array[]='<div class="cbtns">'.$boton_editar.' '.$boton_imprimir.'</div>';
                }
                elseif(in_array("ELPART",$valores)){
                    $sub_array[]='<div class="cbtns">'.$boton_eliminar.''.$boton_imprimir.'</div>';
                }
                elseif(in_array("REPART",$valores)){
                    $sub_array[]='<div class="cbtns">'.$boton_registrar.''.$boton_imprimir.'</div>';
                    }
                    else{
                       $sub_array[]='<div class="cbtns badge bg-red-active"> No Acciones</div>';
                       $sub_array[]='<div class="cbtns">'.$boton_imprimir.'</div>';
                   }
                
            $data[] = $sub_array;
        }

        $results = array(
            "sEcho"                => 1, //Información para el datatables
            "iTotalRecords"        => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData"               => $data);
        echo json_encode($results);

        break;

    case "eliminar_cuenta":

        $datos = $cuentas->get_cuentas_por_id($_POST["id_cuenta"]);
        if (is_array($datos) == true and count($datos) > 0) {
            $cuentas->eliminar_cuenta($_POST["id_cuenta"]);
            $messages[] = "La cuenta se eliminó exitosamente";
        } else {
            $errors[] = "No hay registro que borrar";
        }

        //mensaje success
        if (isset($messages)) {
            echo exito($messages);
        }
        //fin success
        //mensaje error
        if (isset($errors)) {
            echo error($errors);
        }
        break;
}