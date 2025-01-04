<?php

include_once './bd.php';
$con = new bd();

$usu = $_POST['usuario'];
$pass = $_POST['password'];

$consulta = "SELECT * FROM admin WHERE usuario='$usu'";
$resultado = $con->findAll($consulta);
if (count($resultado)>=1) {
    foreach ($resultado as $key => $value) {
        if (password_verify($pass, $value['password']))  {   
            //echo "<script>window.location.href = '../Vista/registrar.php?token=$token'</script>";
            session_start();
            $_SESSION['usu'] = $value['usuario'];
            $con->desconectar();
            echo 2;
        }else{
            $con->desconectar();
            echo 1;
        }
    }
    $con->desconectar(); 
}else{
    $con->desconectar(); 
    echo 0;
}

