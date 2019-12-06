<?php
#incluir conexion
require_once "../config/conexion.php";

#valida que exista sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

class partidas extends Conectar
{
    //método para seleccionar registros
    public function get_partidas($iduse)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select * from partidas where id_usuario = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $iduse);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function conteo($cont){
        $conectar= parent::conexion();      
        $sql="select * from cuentas where id_partida = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cont);
        $sql->execute();
        $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
        return $sql->rowCount();   
      }

    public function dinero($cont){
        $conectar= parent::conexion();      
        $sql="Select SUM(e.Financiero) from entrada e INNER JOIN  cuentas c on c.id_cuenta = e.id_cuenta INNER JOIN partidas p where c.id_partida = ? and p.id_partida = ?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $cont);
        $sql->bindValue(2, $cont);
        $sql->execute();
        $total = $sql->fetch(PDO::FETCH_NUM);
        return $total[0];
      }

    //método para mostrar los datos de un registro a modificar
    function get_partidas_por_id($id_partida)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select * from partidas where id_partida=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_partida);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //método para insertar registros

    function registrar_partidas($nombrepartida, $responsable, $id_usuario,$anio)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "insert into partidas values(null,?,?,?,?,?);";

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, substr($_POST["nombrepartida"], 0, 50));
        $sql->bindValue(2, substr($_POST["responsable"], 0, 50));
        $sql->bindValue(3, $_POST["id_usuario"]);
        $sql->bindValue(4, substr($_POST["anio"], 0, 4));
        $sql->bindValue(5, '0');
        $sql->execute();

    }


   //editar el estado del usuario, activar y desactiva el estado
    function editar_estado($id_partida, $estado)
    {
        $conectar = parent::conexion();
        parent::set_names();

        //el parametro est se envia por via ajax
        if ($_POST["est"] == "0") {$estado = 1;} else { $estado = 0;}

        $sql = "update partidas set estado=? where id_partida=?";
        //se le pasa la consulta
        $sql = $conectar->prepare($sql);
        //recibe informacion capturada del formulario y el boton
        $sql->bindValue(1, $estado);
        $sql->bindValue(2, $id_partida);
        $sql->execute();
    }

    function editar_partidas($id_partida, $nombrepartida, $responsable, $id_usuario)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "update partidas set nombrepartida=?, responsable=?, id_usuario=?, anio=?  where id_partida=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, substr($_POST["nombrepartida"], 0, 50));
        $sql->bindValue(2, substr($_POST["responsable"], 0, 50));
        $sql->bindValue(3, $_POST["id_usuario"]);
        $sql->bindValue(4, $_POST["anio"]);
        $sql->bindValue(5, $_POST["id_partida"]);
        $sql->execute();
    }

    function get_nombre_partidas($nombrepartida)
    {

        $conectar = parent::conexion();
        $sql      = "select * from partidas where nombrepartida=?";
        $sql      = $conectar->prepare($sql);
        $sql->bindValue(1, $nombrepartida);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //método para eliminar un registro
    function eliminar_partida($id_partida)
    {
        $conectar = parent::conexion();
        $sql      = "delete from partidas where id_partida=?";
        $sql      = $conectar->prepare($sql);
        $sql->bindValue(1, $id_partida);
        $sql->execute();

        return $resultado = $sql->fetch();
    }

    #valida si hay registros asociados
    function get_partida_por_id_usuario($id_usuario)
    {
        $conectar = parent::conexion();
        $sql      = "select * from partidas where id_usuario=?";
        $sql      = $conectar->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
