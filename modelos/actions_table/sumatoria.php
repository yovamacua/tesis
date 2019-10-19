<?php
function sumar($conectar, $unico)
{
    $query1     = "SELECT SUM(Financiero) FROM entrada WHERE id_cuenta =" . $unico . "";
    $statement1 = $conectar->prepare($query1);
    $statement1->execute();
    $result1 = $statement1->fetchAll();

    foreach ($result1 as $row) {
        $final = $row['SUM(Financiero)'];
    }
    return '<span class="sumaview">Total: ' . number_format($final, 2) . '</span><span class="loghide"> - Información Cargada</span>';
}
