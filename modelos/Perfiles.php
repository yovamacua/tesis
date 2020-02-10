<?php
require_once("../config/conexion.php");
class Perfiles extends Conectar{
       //método para seleccionar registros

       public function mostrar_perfiles(){
          $conectar=parent::conexion();
          parent::set_names();
          $sql="SELECT * FROM perfil";
          $sql=$conectar->prepare($sql);
          $sql->execute();
          return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
           /*$resultado = $sql->fetchAll();
          echo json_encode($resultado);*/
       }
       //método para mostrar los datos de un registro a modificar
        public function get_perfil_por_codigo($codigo,$idperfil){

            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM perfil WHERE nombre= ? and idperfil=?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $codigo);
             $sql->bindValue(2, $idperfil);
            $sql->execute();
            return $resultado=$sql->fetchAll();
           
        }
         public function get_perfil_por_id($idperfil){

            $conectar= parent::conexion();
            parent::set_names();
            //$idperfil=1;
            $sql="SELECT * FROM perfil WHERE idperfil =?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idperfil);
            $sql->execute();
            return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
            /* $resultado = $sql->fetchAll();
          echo json_encode($resultado);*/
        }

      
         public function registar_perfiles($nombre,$codigo,$estado)
        {
         $conectar= parent::conexion();
           parent::set_names();

           $sql="insert into perfil
           values(null,?,?,?);";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["nombre"]);
          $sql->bindValue(2,$_POST["clave"]);
          $sql->bindValue(3,$_POST["estado"]);
          $sql->execute();
         // print_r($_POST);
         
        }
        public function editar_perfiles($nombre,$codperfil,$estado,$idperfil)
        {
        	 $conectar= parent::conexion();
           parent::set_names();
       $sql="update perfil SET nombre =?,
            codperfil=?,
            estados=?
           WHERE idperfil =?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["nombre"]);
           $sql->bindValue(2,$_POST["clave"]);
            $sql->bindValue(3,$_POST["estado"]);
           $sql->bindValue(4,$_POST["idperfil"]);
          $sql->execute();
    
        }
      
        public function deletes_perfil($idperfil)
        {
        	$conectar= parent::conexion();
           parent::set_names();
        	  $sql="DELETE FROM perfil WHERE idperfil = ?;";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["idperfil"]);
           $sql->execute();
           //print_r($sql);
        }
        public function asignar_modulo($idperfil,$modulo)
        {
        	 $conectar= parent::conexion();
           parent::set_names();
  
$sql_delete="delete from perfil_modulo where idperfiles=?";
                     $sql_delete=$conectar->prepare($sql_delete);
                     $sql_delete->bindValue(1,$_POST["idperfil"]);
                     $sql_delete->execute();


                      //insertamos los modulos
                    
                    //almacena todos los checkbox que han sido marcados
                    //este es un array tiene un name=modulo[]
                       
                  if(isset($_POST["modulo"])){
                        
                        $num_elementos=0;

                          while($num_elementos<count($_POST["modulo"])){

                            $sql_detalle= "insert into perfil_modulo
                            values(null,?,?)";

                              $sql_detalle=$conectar->prepare($sql_detalle);
                              $sql_detalle->bindValue(1, $_POST["modulo"][$num_elementos]);
                              $sql_detalle->bindValue(2, $_POST["idperfil"]);
                              
                              $sql_detalle->execute();
                              

                              //recorremos los modulos con este contador
                              $num_elementos=$num_elementos+1;
                          } 
                        }
}
         


                       
                          
public function ver_asignacion($idmodulo,$idprof)
{
	 $conectar= parent::conexion();
           parent::set_names();
        	  $sql="SELECT * FROM perfil_modulo WHERE id_modulo = ? AND idperfiles = ?;";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$idmodulo);
          $sql->bindValue(2,$idprof);
           $sql->execute();
           return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
}

public function perfil_usuario($pro)
{
          $conectar= parent::conexion();
           parent::set_names();
        	  $sql="select *from perfil_modulo  as p 
    inner join perfil_usuario as up on up.idperfil=p.idperfiles where up.idusuarios=?;";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_SESSION["id_usuario"]);
           $sql->execute();
           return $resultado=$sql->fetchAll();


}
// metodo para obtener el valor del numero de venta
    public function codigo(){
$conectar=parent::conexion();
        parent::set_names();

     
        $sql="select codperfil from perfil;";

        $sql=$conectar->prepare($sql);

        $sql->execute();
        $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
          foreach($resultado as $k=>$v){

            $cod["codperfil"]=$v["codperfil"];

          }
      if(!empty($cod["codperfil"])){
$caracteres = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-.#!';
for($x = 0; $x < 1; $x++){
  $aleatoria = substr(str_shuffle($caracteres), 0, 6);
  echo'<input type="text" class="form-control" id="clave" name="clave" placeholder="Número"  "  value="'.$aleatoria.'" readonly/>';

    }
  }
                      
                  /* if(empty($cod["codperfil"]))
                    {
                      echo'<input type="text" class="form-control" id="clave" name="numero_venta" placeholder="Número"  value="PM00001" />';
                    }else{
                        $num     = substr($cod["codperfil"] , 2);
                        $dig     = $num + 1;
                        $fact = str_pad($dig, 5, "0", STR_PAD_LEFT);
                       // echo '<script>location.reload()</script>';
                        echo '<input type="text" class="form-control" id="clave" name="clave" placeholder="Número"  style="width:50%;"  value="PM'.$fact.'" readonly/>';
                        
                    }*/
     
        }

    
}


?>