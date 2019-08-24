<?php
  //conexion a la base de datos
   require_once("../config/conexion.php");

    class Usuarios extends Conectar {

    public function login(){
    $conectar=parent::conexion();
    parent::set_names();

    if(isset($_POST["enviar"])){

      //INICIO DE VALIDACIONES
      $password = $_POST["password"];
      $correo = $_POST["correo"];
      $estado = "1";

      // valida si los campos son enviados vacios
        if(empty($correo) and empty($password)){
          header("Location:".Conectar::ruta()."vistas/index.php?m=2");
         exit();
        }
      /*   else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){12,15}$/", $password)) {
      header("Location:".Conectar::ruta()."vistas/index.php?m=1");
      exit();
    } */

     else {
          $sql= "select * from usuarios where correo=? and password=? and estado=?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1, $correo);
          $sql->bindValue(2, $password);
          $sql->bindValue(3, $estado);
          $sql->execute();
          $resultado = $sql->fetch();
              //si existe el registro entonces se conecta en session
              if(is_array($resultado) and count($resultado)>0){
               /*IMPORTANTE: la session guarda los valores de los campos de la tabla de la bd*/
               $_SESSION["id_usuario"] = $resultado["id_usuario"];
               $_SESSION["correo"] = $resultado["correo"];
               $_SESSION["nombre"] = $resultado["nombres"];
                header("Location:".Conectar::ruta()."vistas/home.php");
                 exit();
              } else {
                  //si no existe los datos del usuario le aparece un mensaje y redirecciona al home
                  header("Location:".Conectar::ruta()."vistas/index.php?m=1");
                  exit();
               }
           }//cierre del else
    }//condicion enviar
}


       //llamar a todos los campos de la tabla usuarios
       public function get_usuarios(){
         $conectar=parent::conexion();
         parent::set_names();
         $sql="select * from usuarios";
         //se pasa la consulta
         $sql=$conectar->prepare($sql);
         //ejecutar la conexion
         $sql->execute();
         return $resultado=$sql->fetchAll();
       }

        //metodo para registrar un nuevo usuario
   	    public function registrar_usuario($nombre,$apellido,$email,$cargo,$usuario,$password1,$password2,$estado){

             $conectar=parent::conexion();
             parent::set_names();
             $sql="insert into usuarios values(null,?,?,?,?,?,?,?,now(),?);";
             //se le pasa la consulta
             $sql=$conectar->prepare($sql);

            //informacion capturada de los formulario y se le pasan a la consulta
             $sql->bindValue(1, $_POST["nombre"]);
             $sql->bindValue(2, $_POST["apellido"]);
             $sql->bindValue(3, $_POST["email"]);
             $sql->bindValue(4, $_POST["cargo"]);
             $sql->bindValue(5, $_POST["usuario"]);
             $sql->bindValue(6, $_POST["password1"]);
             $sql->bindValue(7, $_POST["password2"]);
             $sql->bindValue(8, $_POST["estado"]);
             //se ejecuta
             $sql->execute();
   	    }

        //metodo para editar usuario
   	    public function editar_usuario($id_usuario,$nombre,$apellido,$email,$cargo,$usuario,$password1,$password2,$estado){
             $conectar=parent::conexion();
             parent::set_names();
             //consulta para editar la informacion
             $sql="update usuarios set
              nombres=?,
              apellidos=?,
              correo=?,
              cargo=?,
              usuario=?,
              password=?,
              password2=?,
              estado = ?
              where id_usuario=? ";

              //echo $sql;

              //se le pasa la consulta
             $sql=$conectar->prepare($sql);
             //informacion capturada de los formulario y se le pasan a la consulta
             $sql->bindValue(1,$_POST["nombre"]);
             $sql->bindValue(2,$_POST["apellido"]);
             $sql->bindValue(3,$_POST["email"]);
             $sql->bindValue(4,$_POST["cargo"]);
             $sql->bindValue(5,$_POST["usuario"]);
             $sql->bindValue(6,$_POST["password1"]);
             $sql->bindValue(7,$_POST["password2"]);
             $sql->bindValue(8,$_POST["estado"]);
             $sql->bindValue(9,$_POST["id_usuario"]);
             $sql->execute();

             //print_r($_POST);
   	    }


        //mostrar los datos del usuario por el id
   	    public function get_usuario_por_id($id_usuario){
          $conectar=parent::conexion();
          parent::set_names();
             //consulta para seleccionar la informacion
          $sql="select * from usuarios where id_usuario=?";

          $sql=$conectar->prepare($sql);
          //se le pasa el id campurado por el boton
          $sql->bindValue(1, $id_usuario);
          $sql->execute();

          return $resultado=$sql->fetchAll();

   	    }

   	    //editar el estado del usuario, activar y desactiva el estado
   	    public function editar_estado($id_usuario,$estado){
   	    	$conectar=parent::conexion();
   	    	parent::set_names();

            //el parametro est se envia por via ajax
   	    	if($_POST["est"]=="0"){	$estado=1; }
          else { $estado=0;}

   	    	$sql="update usuarios set estado=? where id_usuario=?";
          //se le pasa la consulta
   	    	$sql=$conectar->prepare($sql);
          //recibe informacion capturada del formulario y el boton
   	    	$sql->bindValue(1,$estado);
   	    	$sql->bindValue(2,$id_usuario);
   	    	$sql->execute();
   	    }


   	    //valida correo

        public function get_correo_del_usuario($email){
        $conectar=parent::conexion();
        parent::set_names();
        $sql="select * from usuarios where correo=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $email);
        $sql->execute();
        return $resultado=$sql->fetchAll();
      }
   }



?>
