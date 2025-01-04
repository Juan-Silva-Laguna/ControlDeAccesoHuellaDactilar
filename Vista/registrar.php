<?php
if (!isset($_GET["token"])) {
    header("Location: error.php");
}
?>
<!DOCTYPE html>
<html style="background: url('../Recursos/Img/background2.jpg') no-repeat;background-size: cover;min-height: 100%;">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Recursos/Css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../Recursos/Css/styles.css">
    <title>Control Acceso Medimas</title>
</head>

<body>
    <div style="margin-top: 70px;" class="container row text-right">
        <a  href="lista.php?token=<?php echo $_GET["token"]; ?>"><img src="../Recursos/Img/listar-desactivo.png"></a>
        <a  href='registrar.php?token=<?php echo $_GET["token"]; ?>&documento=&nombre=&nacimiento=&genero=&id='><img src='../Recursos/Img/registrar-<?php echo $_GET["documento"] == ''?'activo':'desactivo'; ?>.png' style='margin-right: 57px;'></a>
    </div>
    <a  href="personal.php?token=<?php echo $_GET["token"]; ?>" style="position: fixed;left: 210px;top: 120px;"><img src="../Recursos/Img/usuarios.png" width="60px" height="60px"></a>
    <div class="container" id="advanced-search-form" style="margin-top: 0px;">
        <input type="hidden" id="token" value="<?php echo $_GET["token"]; ?>">  
        <?php echo $_GET["documento"] == '' ?"<h2>Registrar Personal</h2> ": "<h2>Editar Datos de ".$_GET["nombre"]."</h2> " ?>  
        <div class="form-group">  
            <input type="number" placeholder="Numero de Documento" value="<?php echo $_GET["documento"]; ?>" id="documento" class="form-control" style="width: 342px;"><br>
            <input type="text" placeholder="Nombre Completo" value="<?php echo $_GET["nombre"]; ?>" id="nombre" class="form-control" style="width: 342px;"><br>
            <input type="date" placeholder="Fecha de Nacimiento" value="<?php echo $_GET["nacimiento"]; ?>" id="nacimiento" class="form-control" style="width: 342px;"><br>
            <select id="genero" class="form-control"  style="width: 342px;">
                <?php if ($_GET["genero"] == '') {
                        echo "
                            <option value=''>Genero</option>
                            <option value='f'>Femenino</option>
                            <option value='m'>Masculino</option>
                        ";
                    }else{
                        echo $_GET["genero"]=='f'?  "<option value='f'>Femenino</option><option value='m'>Masculino</option>" :  "<option value='m'>Masculino</option><option value='f'>Femenino</option>";                 
                    }
                ?>
            </select><br>
            <!--<button type="submit" style="margin-left: 280px; width: auto;" class="btn btn-info btn-lg" onclick="addUser('<?php echo $_GET['token'] ?>')">  REGISTRAR </button> -->
            <?php echo $_GET["documento"] == '' ?
            "<button type='submit' style='margin-left: 280px; width: auto;' class='btn btn-info btn-lg' onclick='addUser(\"".$_GET["token"]."\")'>  REGISTRAR </button> "
            : "<button type='submit' style='margin-left: 280px; width: auto;' class='btn btn-info btn-lg' onclick='editUser(\"".$_GET["token"]."\")'>  ACTUALIZAR </button> " ?>
            
        </div>
        <div style="margin-left: 500px;">
            <div id="conteo"></div>
            <img src="../Recursos/Img/lector-dehuella.png" alt="" width="130" height="200" style="margin-left: 36px;" id="img1">
            <img src="../Recursos/Img/cargando-huella.gif" alt="" width="135" height="205" style="margin-left: 35px; display: none;" id="img2">
            
            <button id="activeSensorLocal" style="width: 200px" onclick="activarSensor('<?php echo $_GET["token"] ?>')" class="btn btn-info btn-responsive"><?php echo $_GET["documento"] == '' ?"Activar": "Cambiar huella" ?></button>     
            
        </div>
    </div>
</body>
<script type='text/javascript' src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<script type='text/javascript' src="../Recursos/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="../Recursos/Js/funciones.js" type="text/javascript"></script>
<script>
    cargar_push_registro();
</script>

</html>
