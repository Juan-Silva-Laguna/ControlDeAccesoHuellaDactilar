<?php

include_once './bd.php';
$con = new bd();

switch ($_POST['tipo']) {
    case 'listar':
        $buscar = $_POST['buscar'];
        $consulta="SELECT * FROM usuarios WHERE  nombre_completo LIKE '%$buscar%' ORDER BY nombre_completo ASC";
        $resultado=$con->findAll($consulta);
        echo json_encode($resultado);
        break;
    case 'eliminar':
        $documento = $_POST['documento'];
        $consulta1="DELETE FROM huellas WHERE documento = '$documento'";
        $resultado1=$con->exec($consulta1);

        $consulta2="DELETE FROM usuarios WHERE documento = '$documento'";
        $resultado2=$con->exec($consulta2);
        $con->desconectar();
        if ($resultado1 == 1 && $resultado2 == 1) {
            echo 1;
        }else{
            echo 0;
        }
        break;
}