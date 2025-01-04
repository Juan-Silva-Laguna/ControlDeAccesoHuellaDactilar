<?php

include_once './bd.php';
$con = new bd();

$update = "UPDATE usuarios SET documento='" . $_POST['documento'] . "', nombre_completo='" . $_POST['nombre'] . "', nacimiento='" . $_POST['nacimiento'] . "', genero='" . $_POST['genero'] . "' WHERE documento=" . $_POST['documento'];
$row = $con->exec($update);
$con->desconectar();
echo $row;

