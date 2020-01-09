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
        public function get_perfil_por_codigo($codigo){

            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM perfil WHERE codperfil =?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $codigo);
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
          $sql->bindValue(2,$_POST["codigo"]);
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
            estado=?
           WHERE idperfil =?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["nombre"]);
           $sql->bindValue(2,$_POST["codigo"]);
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

     public function codigoperfil(){

       $conectar=parent::conexion();
        parent::set_names();

     
        $sql="select codperfil from perfil;";

        $sql=$conectar->prepare($sql);

        $sql->execute();
        $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
          //echo json_encode($resultado);
          foreach($resultado as $k=>$v){

            $perfil["codperfil"]=$v["codperfil"];

          }

                      
                    if(empty($perfil["codperfil"]))
                    {
                      echo'<input type="text" class="form-control" id="codigo" name="codigo" placeholder="codigo perfil"  value="PM0001" readonly/>';
                    }else{
                        $num     = substr($perfil["codperfil"] , 2);
                        $dig     = $num + 1;
                        $fact = str_pad($dig, 4, "0", STR_PAD_LEFT);
                        echo '<input type="text" class="form-control" id="codigo" name="codigo" placeholder="codigo perfil"    value="PM'.$fact.'" readonly/>';
                        
                    }
     
        }
}
/*$V= NEW Perfiles();
$r= $V->codigoperfil();*/

?>