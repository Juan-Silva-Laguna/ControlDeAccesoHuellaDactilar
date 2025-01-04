<?php

include_once './bd.php';
$con = new bd();

$changeHuella = "UPDATE huellas SET huella=(SELECT huella FROM huellas_temp WHERE pc_serial = '" . $_POST['token'] . "'), imgHuella=(SELECT imgHuella FROM huellas_temp WHERE pc_serial = '" . $_POST['token'] . "') WHERE documento=". $_POST['documento'] ;
$row = $con->exec($changeHuella);

$delete = "delete from huellas_temp where pc_serial = '" . $_POST['token'] . "'";

$row = $con->exec($delete);

$con->desconectar();
echo json_encode("{\"filas\":$row}");
