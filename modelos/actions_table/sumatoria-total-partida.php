<?php
#incluir conexion
require_once "../../config/conexion.php";

#valida que exista sessión
if (!isset($_SESSION['id_usuario'])) {?>
        <script type="text/javascript">
        window.location="../vistas/inicio.php";
        </script>
    <?php
}

class partidas extends Conectar
{
     public function sumaranio(){
        $conectar= parent::conexion();      
        $sql="Select SUM(e.Financiero) from entrada e INNER JOIN  cuentas c on c.id_cuenta = e.id_cuenta INNER JOIN partidas p where c.id_partida = p.id_partida and p.estado=1 and p.id_usuario='".$_SESSION["id_usuario"]."'";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $total = $sql->fetch(PDO::FETCH_NUM);
        return $total[0];
    }
}
$partidas = new partidas();
if ($partidas->sumaranio() <= 0){
    echo '$ 0.00';
}else{
    echo "$ ".$partidas->sumaranio();
}
?>
