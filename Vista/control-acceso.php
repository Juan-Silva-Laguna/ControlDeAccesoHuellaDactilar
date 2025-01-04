<?php
if (!isset($_GET["token"])) {
    header("Location: error.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Recursos/Css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../Recursos/Css/styles.css">
    <title>Control Acceso Medimas</title>
</head>

<body>
    <div style="margin-top: 70px;" class="container row text-right">
        <a target="_self" href="control-acceso.php?token=<?php echo $_GET["token"]; ?>"><img src="../Recursos/Img/acceso-activo.png"></a>
        <a target="_self" href="ingreso-admin.php?token=<?php echo $_GET["token"]; ?>"><img src="../Recursos/Img/ingreso-desactivo.png" style="margin-right: 57px;"></a>
    </div>
    <div class="container" id="advanced-search-form" style="margin-top: 0px;">        
        <h2>Control De Acceso</h2>
        <center>
            <?php
                if ($_GET['x']==0) {
                    echo '<img src="../Recursos/Img/lector-dehuella.png" alt="" width="200" height="300">';
                }
                else{
                    echo '<img src="../Recursos/Img/cargando-huella.gif" alt="" width="230" height="330">';
                }
            ?>
            <a href="../Modelo/ActivarSensorReader.php?token=<?php echo $_GET["token"];?>&y=1" class="btn btn-info">Activar</a>

        </center>
    </div>
    <input type="hidden" id="token" value="<?php echo $_GET["token"]; ?>">
</body>
<script type='text/javascript' src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<script type='text/javascript' src="../Recursos/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="../Recursos/Js/funciones.js"></script>
<?php
    if ($_GET['x']==0) {
        echo '';
    }
    else{
        echo '<script>cargar_push();</script>';
    }
?>

</html>
