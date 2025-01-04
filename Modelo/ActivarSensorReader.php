<?php

include_once './bd.php';
$con = new bd();
$delete = "delete from huellas_temp where pc_serial = '" . $_GET['token'] . "'";
$con->exec($delete);
$insert = "insert into huellas_temp (pc_serial, texto, opc) "
        . "values ('" . $_GET['token'] . "', 'El sensor de huella dactilar esta activado','leer')";
$con->exec($insert);
$con->desconectar();
if ($_GET['y']==0) {
    header("Location: ../Vista/control-acceso.php?token=" . $_GET['token']."&x=0");
}else {
    header("Location: ../Vista/control-acceso.php?token=" . $_GET['token']."&x=1");
}

