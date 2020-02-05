<?php
require_once("../config/conexion.php");
class Roles extends Conectar{
       //método para seleccionar registros

       public function mostrar_roles() {
        //YA
          $conectar=parent::conexion();
          parent::set_names();
          $sql="select r.idrol, r.rol, m.nombre from rol as r
inner join modulo as m on m.idmodulo= r.idmodulos;";
          $sql=$conectar->prepare($sql);
          $sql->execute();
         return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
         
       }
       //método para mostrar los datos de un registro a modificar
        public function get_roles_por_id($idrol){
//ya
            $conectar= parent::conexion();
            parent::set_names();
            $sql="select r.idrol,r.codigo,r.descripcion, r.rol,r.idmodulos from rol as r
inner join modulo as m on m.idmodulo= r.idmodulos where r.idrol=?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $idrol);
            $sql->execute();
          return $resultado=$sql->fetchAll();
         
        }

         public function registar_roles($nombre,$codigo,$descripcion,$modulo)
        {
          //YA
         $conectar= parent::conexion();
           parent::set_names();

           $sql="insert into rol
           values(null,?,?,?,?);";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["nombre"]);
           $sql->bindValue(2,$_POST["codigo"]);
          $sql->bindValue(3,$_POST["descripcion"]);
          $sql->bindValue(4,$_POST["modulo"]);
          $sql->execute();
           return $resultado=$sql->fetchAll();
           //print_r($sql);
        }
        public function editar_roles($nombre,$codigo,$descripcion,$modulo,$idroles)
        {
        	 $conectar= parent::conexion();
           parent::set_names();
       $sql="update rol SET rol =?,
       codigo=?,
             descripcion=?,
            idmodulo=?
			WHERE idrol =?";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["nombre"]);
            $sql->bindValue(2,$_POST["codigo"]);
          $sql->bindValue(3,$_POST["descripcion"]);
          $sql->bindValue(4,$_POST["modulo"]);
            $sql->bindValue(5,$_POST["idroles"]);
          $sql->execute();
     
        }
        public function modulo_rol($nombre,$modulo)
        {
          //YA
        	 $conectar= parent::conexion();
           parent::set_names();
        	  $sql="SELECT * FROM rol WHERE rol= ? and idmodulos=?;";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["nombre"]);
          $sql->bindValue(2,$_POST["modulo"]);
           $sql->execute();
        return $resultado=$sql->fetchAll();
         
        }
         public function rol_modulo($idmodulo)
        {
          //YA
           $conectar= parent::conexion();
           parent::set_names();
            $sql="select * from rol as r
inner join modulo as m  on m.idmodulo=r.idmodulos where r.idmodulos=?;";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$idmodulo);
           $sql->execute();
        return $resultado=$sql->fetchAll();
         /* $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
          echo json_encode($resultado);*/
         
        }
         public function rol_usuario($idusuario)
        {
          //YA
         // var_dump($idroles);
           $conectar= parent::conexion();
           parent::set_names();
            $sql="SELECT * FROM roles_usuario WHERE 
                 id_usuarios =?;";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$idusuario);
           $sql->execute();
        return $resultado=$sql->fetchAll();
         /* $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
          echo json_encode($resultado);*/
        }
        public function deletes($idrol)
        {
        	$conectar= parent::conexion();
           parent::set_names();
        	  $sql="DELETE FROM rol WHERE idrol= ?;";
          $sql=$conectar->prepare($sql);
          $sql->bindValue(1,$_POST["idroles"]);
           $sql->execute();
        }
        public function asignar_roles($roles,$idusuarios)
        {
           $conectar= parent::conexion();
           parent::set_names();
             
   
   //insertamos los permiso                   
                    //almacena todos los checkbox que han sido marcados
                    //este es un array tiene un name=permiso[]
                    $sql_delete="delete from roles_usuario where id_usuarios=?";
                     $sql_delete=$conectar->prepare($sql_delete);
                     $sql_delete->bindValue(1,$_POST["id_usuario"]);
                     $sql_delete->execute();
            
                       $num_elementos=0;
                      
                        if(isset($_POST["roles"])){
                          while($num_elementos<count($_POST["roles"])){

                            $sql_detalle= "insert into roles_usuario
                            values(null,?,?)";

                              $sql_detalle=$conectar->prepare($sql_detalle);
                            $sql_detalle->bindValue(1,$_POST["roles"][$num_elementos]);
                             $sql_detalle->bindValue(2,$_POST["id_usuario"]);
                              
                              $sql_detalle->execute();
                             
                              //recorremos los modulos con este contador
                              $num_elementos=$num_elementos+1;
                        }
                      }
                
        	}
           //lista de roles que tiene el usuario
        public function listar_roles_por_usuario($id_usuario){

            $conectar=parent::conexion();

            $sql="select r.codigo from rol as r
                inner join roles_usuario as rm on rm.idroles = r.idrol where rm.id_usuarios=?;";

            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $id_usuario);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        
}
    

  }
   

     
   


/*$d=4;
$v= new Roles();
$v->rol_usuario($d);*/
?>

 