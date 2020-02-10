<?php
//conexion a la base de datos
require_once "../config/conexion.php";

#valida que exista la sessión
/*if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}*/

class Usuarios extends Conectar
{
    public function login()
    {
        $conectar = parent::conexion();
        parent::set_names();

        if (isset($_POST["enviar"])) {

            //INICIO DE VALIDACIONES
            $password = $_POST["password"];
            $correo   = $_POST["correo"];
            $estado   = "1";

            $vl1 = 0;
            #valida que el formato sea valido
            if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["correo"])) {
                if (!preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $_POST["correo"])) {
                    $vl1 = 1;
                }
            }

            if (!preg_match('/^[a-záéíóúñA-ZÁÉÍÓÚÑ_0-9\s]*$/', $_POST["password"])) {
                $vl1 = 1;
            }

            // valida si los campos son enviados vacios o no corresponden al formato correcto
            if (empty($correo) or empty($password) or $vl1 != 0) {
                header("Location:" . Conectar::ruta() . "vistas/index.php?m=2");
                exit();
            } else {
                $sql = "select * from usuarios where correo=? or usuario=? and password=? and estado=?";
$encriptar1 = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $correo);
                $sql->bindValue(2, $correo);
                $sql->bindValue(3, $encriptar1);
                $sql->bindValue(4, $estado);
                $sql->execute();
                $resultado = $sql->fetch();
                //si existe el registro entonces se conecta en session
                if (is_array($resultado) and count($resultado) > 0) {
                    /*IMPORTANTE: la session guarda los valores de los campos de la tabla de la bd*/
                    $_SESSION["id_usuario"] = $resultado["id_usuario"];
                    $_SESSION["correo"]     = $resultado["correo"];
                    $_SESSION["nombre"]     = $resultado["nombres"];
                    $_SESSION["usuario"]    = $resultado["usuario"];
                    $_SESSION["imagen"]     = $resultado["usuario_imagen"];
                    $_SESSION["cargo"]     = $resultado["cargo"];
                    $_SESSION["idperfiles"]     = $resultado["idperfiles"];
                    $_SESSION["ultimoAcceso"] = date("Y-n-j H:i:s");
                   
                    //PERMISOS DEL USUARIO PARA ACCEDER A LOS MODULOS

        require_once("Usuarios.php");

        $usuario = new Usuarios();
        
       //VERIFICAMOS SI EL USUARIO TIENE PERMISOS A CIERTOS MODULOS
        $marcados = $usuario->listar_permisos_por_usuario($resultado["idperfiles"]);
       
        
        //print_r($marcados);

      //declaramos el array para almacenar todos los registros marcados

       $valores=array();

      //Almacenamos los permisos marcados en el array

          foreach($marcados as $row){

              $valores[]= $row["id_modulo"];
          }


      ////Determinamos los accesos del usuario
      //si los id_permiso estan en el array $valores entonces se ejecuta la session=1, en caso contrario el usuario no tendria acceso al modulo
      
      in_array(1,$valores)?$_SESSION['USUARIOS']=1:$_SESSION['USUARIOS']=0;
      in_array(2,$valores)?$_SESSION['INCIDENTES']=1:$_SESSION['INCIDENTES']=0;
      in_array(3,$valores)?$_SESSION['PARTIDAS']=1:$_SESSION['PARTIDAS']=0;
      in_array(4,$valores)?$_SESSION['PERDIDAS']=1:$_SESSION['PERDIDAS']=0;
      in_array(5,$valores)?$_SESSION['DONACIONES']=1:$_SESSION['DONACIONES']=0;
      in_array(6,$valores)?$_SESSION['GASTOS']=1:$_SESSION['GASTOS']=0;
      in_array(7,$valores)?$_SESSION['CAPACITACIONES']=1:$_SESSION['CAPACITACIONES']=0;
      in_array(8,$valores)?$_SESSION['CATEGORIA']=1:$_SESSION['CATEGORIA']=0;
      in_array(9,$valores)?$_SESSION['PRODUCTO']=1:$_SESSION['PRODUCTO']=0;
      in_array(10,$valores)?$_SESSION['PEDIDOS']=1:$_SESSION['PEDIDOS']=0;
      in_array(11,$valores)?$_SESSION['VENTA']=1:$_SESSION['VENTA']=0;
      in_array(12,$valores)?$_SESSION['INFORME FINANCIERO']=1:$_SESSION['INFORME FINANCIERO']=0;
      in_array(13,$valores)?$_SESSION['REPORTES DE VENTAS']=1:$_SESSION['REPORTES DE VENTAS']=0;
      in_array(14,$valores)?$_SESSION['RESPALDO']=1:$_SESSION['RESPALDO']=0;
      in_array(15,$valores)?$_SESSION['UNIDAD']=1:$_SESSION['UNIDAD']=0;
      in_array(16,$valores)?$_SESSION['PERMISO']=1:$_SESSION['PERMISO']=0;
          
          

      //FIN PERMISOS DEL USUARIO

     
                    header("Location:" . Conectar::ruta() . "vistas/home.php");
                    exit();
                } else {
                    //si no existe los datos del usuario le aparece un mensaje y redirecciona al home
                    header("Location:" . Conectar::ruta() . "vistas/index.php?m=1");
                    exit();
                }
            } //cierre del else
            //condicion enviar
        }

    }

    //llamar a todos los campos de la tabla usuarios
    function get_usuarios()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select *from usuarios as u
inner join perfil p on p.idperfil=u.idperfiles";
        //se pasa la consulta
        $sql = $conectar->prepare($sql);
        //ejecutar la conexion
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
  
    //metodo para registrar un nuevo usuario
    function registrar_usuario($nombre, $apellido, $email, $cargo, $usuario, $password1, $password2, $estado)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "insert into usuarios values(null,?,?,?,?,?,?,now(),?,?,?);";
        //se le pasa la consulta
        $sql            = $conectar->prepare($sql);
        $usuario_imagen = 'imagen_usuario_general.png';

$encriptar1 = crypt($_POST["password1"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
$encriptar2 = crypt($_POST["password2"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

        //informacion capturada de los formulario y se le pasan a la consulta
        $sql->bindValue(1, substr($_POST["nombre"], 0, 50));
        $sql->bindValue(2, substr($_POST["apellido"], 0, 50));
        $sql->bindValue(3, substr($_POST["email"], 0, 100)); 
        $sql->bindValue(4, substr($_POST["usuario"], 0, 50));
        $sql->bindValue(5, $encriptar1);
        $sql->bindValue(6, $encriptar2);
        $sql->bindValue(7, $_POST["estado"]);
        $sql->bindValue(8, $usuario_imagen);
        $sql->bindValue(9, $_POST["cargo"]);
        //se ejecuta
        $sql->execute();

  
            
            
    }

    //metodo para editar usuario
    function editar_usuario($id_usuario, $nombre, $apellido, $email, $cargo, $usuario, $password1, $password2, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();

        if ($_POST["password1"] == '123456axxxxx' and $_POST["password2"] == '123456axxxxx') {
            $sql = "update usuarios set nombres=?, apellidos=?,
              correo=?, usuario=?, estado = ?, idperfiles=? where id_usuario=? ";

            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, substr($_POST["nombre"], 0, 50));
            $sql->bindValue(2, substr($_POST["apellido"], 0, 50));
            $sql->bindValue(3, substr($_POST["email"], 0, 100));
            $sql->bindValue(4, substr($_POST["usuario"], 0, 50));
            $sql->bindValue(5, $_POST["estado"]);
            $sql->bindValue(6, $_POST["cargo"]);
            $sql->bindValue(7, $_POST["id_usuario"]);
            
            $sql->execute();  
        } else {
            $sql = "update usuarios set nombres=?, apellidos=?, correo=? , usuario=?, password=?, password2=?, estado = ?, idperfiles=? where id_usuario=? ";
            $sql = $conectar->prepare($sql);
$encriptar1 = crypt($_POST["password1"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
$encriptar2 = crypt($_POST["password2"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            $sql->bindValue(1, substr($_POST["nombre"], 0, 50));
            $sql->bindValue(2, substr($_POST["apellido"], 0, 50));
            $sql->bindValue(3, substr($_POST["email"], 0, 100));       
            $sql->bindValue(4, $_POST["usuario"]);
            $sql->bindValue(5, $encriptar1);
            $sql->bindValue(6, $encriptar2);
            $sql->bindValue(7, $_POST["estado"]);
            $sql->bindValue(8, $_POST["cargo"]);
            $sql->bindValue(9, $_POST["id_usuario"]);
           
            $sql->execute();
           
        }
    }

    //mostrar los datos del usuario por el id
    function get_usuario_por_id($id_usuario)
    {
        $conectar = parent::conexion();
        parent::set_names();
        //consulta para seleccionar la informacion
        $sql = "select * from usuarios where id_usuario=?";

        $sql = $conectar->prepare($sql);
        //se le pasa el id campurado por el boton
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    var_dump($sql);
    }

    //editar el estado del usuario, activar y desactiva el estado
    function editar_estado($id_usuario, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();

        //el parametro est se envia por via ajax
        if ($_POST["est"] == "0") {$estado = 1;} else { $estado = 0;}

        $sql = "update usuarios set estado=? where id_usuario=?";
        //se le pasa la consulta
        $sql = $conectar->prepare($sql);
        //recibe informacion capturada del formulario y el boton
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $id_usuario);
        $sql->execute();
    }

    //valida correo

    function get_correo_del_usuario($email)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select * from usuarios where correo=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $email);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    //método para eliminar un registro
    function eliminar_usuario($id_usuario)
    {
        $conectar = parent::conexion();
        $sql = "delete from usuario_permiso where id_usuario=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();

        ////
        $sql1= "delete from usuarios where id_usuario=?";
        $sql1= $conectar->prepare($sql1);
        $sql1->bindValue(1, $id_usuario);
        $sql1->execute();
        return $resultado = $sql1->fetch();
    }
     // Funcion permite alistar los permisos (No Marcado)
        public function permisos(){

            $conectar=parent::conexion();

            $sql="select * from modulo;";

            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();


              } 
      
  

public function listar_permisos_por_usuario($idperfiles){

            $conectar=parent::conexion();

            $sql="select pm.id_modulo from perfil_modulo as pm
inner join perfil as p on pm.idperfiles = p.idperfil where  pm.idperfiles=? and p.estados='1';";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idperfiles);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
       
 

 
  public function ver_modulos($idusuario){
    

       $conectar = parent::conexion();
             parent::set_names();

            $sql="select DISTINCT id_modulo from perfil_modulo as pm
 inner join usuarios as u on u.idperfiles = pm.idperfiles where u.id_usuario=?;";

             $sql=$conectar->prepare($sql);
               $sql->bindValue(1, $idusuario);
            $sql->execute();
            return $resultado=$sql->fetchAll();
    
  }
    # code...
  



         public function get_usuario_permiso_por_id_usuario($id_usuario){

          $conectar= parent::conexion();

           $sql="select * from usuario_permiso where id_usuario=?";

              $sql=$conectar->prepare($sql);

              $sql->bindValue(1, $id_usuario);
              $sql->execute();

              return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);


      }   
}
/*$v= new Usuarios();
$p=4;
$v-> listar_roles_por_usuario($p);*/


?>
