<?php

    include_once './bd.php';
    $con = new bd();

    date_default_timezone_set('America/Bogota');

    $arrayDias = array( 'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
            
    $fecha = date('Y').'/'.date('m').'/'.date('d');
    $dia = $arrayDias[date('w')];
    $hora = date('H').':'.date('i').':'.date('s');

    $documento = $_POST['documento'];

    $consulta="SELECT * FROM usuarios WHERE documento='$documento'";
    $resultadoConsulta = $con->findAll($consulta);


    if(count($resultadoConsulta)>=1){
        $nombre='';
        $nacimiento = '';
        $genero = '';
        foreach ($resultadoConsulta as $key => $dato) {
            $genero = $dato['genero'];
            $nombre = $dato['nombre_completo'];
            $nacimiento = $dato['nacimiento'];
        }
        $consulta="SELECT * FROM asistencia WHERE documento='$documento' AND asi_fecha='$fecha' AND asi_hora_salida='0'";
        $resultadoConsulta = $con->findAll($consulta);
        
        if(count($resultadoConsulta)>=1){
            $consulta="UPDATE asistencia SET asi_hora_salida='$hora' WHERE documento='$documento' AND asi_fecha='$fecha' AND asi_hora_salida='0'";
            $resultadoConsulta = $con->exec($consulta);
            if($resultadoConsulta>=1){                
                $con->desconectar();
                echo json_encode([3, 'Hasta luego <br>'.$nombre]);
            }
            else{
                
                $con->desconectar();
                echo json_encode([2]);
            }
        }else{
            $consulta="INSERT INTO asistencia VALUES(null, '$fecha', '$dia', '$hora', '', '$documento')";
            $resultadoConsulta = $con->exec($consulta);
            if($resultadoConsulta>=1){
                if ($genero=='m') {
                    $nombre = "Bienvenido <br>".$nombre;
                }else{
                    $nombre = "Bienvenida <br>".$nombre;
                }
                
                $con->desconectar();
                echo json_encode([1, $nombre]);
            }
            else{
                
                $con->desconectar();
                echo json_encode([2]);
            }
        }
        
    }
    else{
        
        $con->desconectar();
        echo json_encode([0]);        
    }





