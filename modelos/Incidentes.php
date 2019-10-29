<?php
#incluye conexion
require_once "../config/conexion.php";

#valida que exista sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/home.php";
        </script>
    <?php
}

class Incidentes extends Conectar
{
    //método para seleccionar registros

    public function get_incidentes()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select i.id_incidente, i.titulo, i.descripcion, i.fecha, u.usuario 
        from incidentes i INNER JOIN usuarios u on (i.id_usuario = u.id_usuario)";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    #seleccionar registros pero limitados
    function get_incidentes_limit()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select i.id_incidente, i.titulo, i.descripcion, i.fecha, u.usuario 
        from incidentes i INNER JOIN usuarios u on (i.id_usuario = u.id_usuario) order by i.fecha ASC limit 10;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    #obtener registros por fechas
    function get_incidentes_fecha($fecha, $fecha2)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select i.id_incidente, i.titulo, i.descripcion, i.fecha, u.usuario 
        from incidentes i INNER JOIN usuarios u on (i.id_usuario = u.id_usuario)
        where i.fecha between ? and ? order by i.fecha ASC;";

        $date         = $_GET["fecha"];
        $date_inicial = str_replace('/', '-', $date);
        $fecha        = date("Y-m-d", strtotime($date_inicial));

        $date2         = $_GET["fecha2"];
        $date_inicial2 = str_replace('/', '-', $date2);
        $fecha2        = date("Y-m-d", strtotime($date_inicial2));

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $fecha);
        $sql->bindValue(2, $fecha2);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //método para mostrar los datos de un registro a modificar
    function get_incidentes_por_id($id_incidente)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "select * from incidentes where id_incidente=?";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id_incidente);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    //método para insertar registros

    function registrar_incidentes($titulo, $descripcion, $id_usuario)
    {
        $conectar = parent::conexion();
        parent::set_names();

        $sql = "insert into incidentes values(null,?,?,?,?);";

        $date         = $_POST["fecha"];
        $date_inicial = str_replace('/', '-', $date);
        $fecha        = date("Y-m-d", strtotime($date_inicial));

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, substr($_POST["titulo"], 0, 50));
        $sql->bindValue(2, substr($_POST["descripcion"], 0, 250));
        $sql->bindValue(3, $fecha);
        $sql->bindValue(4, $_POST["id_usuario"]);
        $sql->execute();

    }

    function editar_incidentes($id_incidente, $titulo, $descripcion, $id_usuario)
    {

        $conectar = parent::conexion();
        parent::set_names();

        $sql = "update incidentes set titulo=?, descripcion=?, fecha=?, id_usuario=?
            where id_incidente=?";

        $date         = $_POST["fecha"];
        $date_inicial = str_replace('/', '-', $date);
        $fecha        = date("Y-m-d", strtotime($date_inicial));

        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, substr($_POST["titulo"], 0, 50));
        $sql->bindValue(2, substr($_POST["descripcion"], 0, 250));
        $sql->bindValue(3, $fecha);
        $sql->bindValue(4, $_POST["id_usuario"]);
        $sql->bindValue(5, $_POST["id_incidente"]);
        $sql->execute();

    }
    #obtener registros por titulo
    function get_nombre_incidentes($titulo)
    {
        $conectar = parent::conexion();
        $sql      = "select * from incidentes where titulo=?";
        $sql      = $conectar->prepare($sql);
        $sql->bindValue(1, $titulo);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //método para eliminar un registro
    function eliminar_incidente($id_incidente)
    {
        $conectar = parent::conexion();
        $sql      = "delete from incidentes where id_incidente=?";
        $sql      = $conectar->prepare($sql);
        $sql->bindValue(1, $id_incidente);
        $sql->execute();

        return $resultado = $sql->fetch();
    }

    #valida si hay registros asociados
    function get_incidente_por_id_usuario($id_usuario)
    {
        $conectar = parent::conexion();
        $sql      = "select * from incidentes where id_usuario=?";
        $sql      = $conectar->prepare($sql);
        $sql->bindValue(1, $id_usuario);
        $sql->execute();
        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
