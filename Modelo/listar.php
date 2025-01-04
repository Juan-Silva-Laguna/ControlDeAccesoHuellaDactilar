<?php

include_once './bd.php';
$con = new bd();


date_default_timezone_set('America/Bogota');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
     
$fecha = date('Y').'-'.date('m').'-'.date('d');
$dia = $arrayDias[date('w')];
$hora = date('H').':'.date('i').':'.date('s');


switch ($_POST['tipo']) {
    case 'hoy':
        $nombre = $_POST['nombre'];
        $consulta="SELECT asistencia.*,usuarios.nombre_completo FROM asistencia INNER JOIN usuarios ON asistencia.documento=usuarios.documento WHERE asistencia.asi_fecha LIKE '%$fecha%' AND usuarios.nombre_completo LIKE '%$nombre%' ORDER BY asistencia.id_asistencia DESC";
        $resultado=$con->findAll($consulta);
        echo json_encode($resultado);
        break;
    case 'semana':
        $nombre = $_POST['nombre'];
        $dia = $_POST['dia'];
        $consulta="SELECT asistencia.*,usuarios.nombre_completo FROM asistencia INNER JOIN usuarios ON asistencia.documento=usuarios.documento WHERE asistencia.asi_fecha >= date_add(curdate(), INTERVAL - 7 DAY) AND asistencia.asi_fecha <= curdate() AND usuarios.nombre_completo LIKE '%$nombre%' AND asistencia.asi_dia LIKE '%$dia%' ORDER BY asistencia.id_asistencia DESC";
        $resultado=$con->findAll($consulta);
        echo json_encode($resultado);
        break;
    case 'todo1':
        $nombre = $_POST['nombre'];
        $dia = $_POST['dia'];
        $fechaIni = $_POST['fechaIni'];
        $fechaFin = $_POST['fechaFin'];
        $consulta="SELECT asistencia.*,usuarios.nombre_completo FROM asistencia INNER JOIN usuarios ON asistencia.documento=usuarios.documento WHERE asistencia.asi_fecha LIKE '%$fechaIni%' AND usuarios.nombre_completo LIKE '%$nombre%' AND asistencia.asi_dia LIKE '%$dia%' ORDER BY asistencia.id_asistencia DESC";
        $resultado=$con->findAll($consulta);
        echo json_encode($resultado);
        break;
    case 'todo2':
        $nombre = $_POST['nombre'];
        $dia = $_POST['dia'];
        $fechaIni = $_POST['fechaIni'];
        $fechaFin = $_POST['fechaFin'];
        $consulta="SELECT asistencia.*,usuarios.nombre_completo FROM asistencia INNER JOIN usuarios ON asistencia.documento=usuarios.documento WHERE asistencia.asi_fecha BETWEEN '$fechaIni' AND '$fechaFin' AND usuarios.nombre_completo LIKE '%$nombre%' AND asistencia.asi_dia LIKE '%$dia%' ORDER BY asistencia.id_asistencia DESC";
        $resultado=$con->findAll($consulta);
        echo json_encode($resultado);
        break;
}