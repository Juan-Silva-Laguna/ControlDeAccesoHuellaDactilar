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
        <a target="_self" href="../Modelo/ActivarSensorReader.php?token=<?php echo $_GET["token"];?>&y=0"><img src="../Recursos/Img/acceso-desactivo.png"></a>
        <a target="_self" href="ingreso-admin.php?token=<?php echo $_GET["token"]; ?>"><img src="../Recursos/Img/ingreso-activo.png"  style="margin-right: 57px;"></a>
    </div>
    <div class="container" id="advanced-search-form" style="margin-top: 0px;">
    <input type="hidden" id="token" value="<?php echo $_GET["token"]; ?>">    
        <h2>Ingresar Como Administrador</h2>
        
        <div class="col-md-3"></div>
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" class="form-control" placeholder="Usuario" id="usuario" style="width: 322px;">
            <br>        
            <label for="contraseña">Contraseña</label>
            <input type="password" class="form-control" placeholder="Contraseña" id="pass"  style="width: 322px;">
        </div>
        <div class="clearfix"></div>
        <button class="btn btn-info btn-lg btn-responsive" id="ingresa">  INGRESAR </button>
    
    </div>
</body>
<script type='text/javascript' src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<script type='text/javascript' src="../Recursos/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('#ingresa').on('click',function (e) {
            e.preventDefault();
            
            if ($('#usuario').val() != '' || $('#pass').val() != '') {
                const datos = {
                    usuario: $('#usuario').val(),
                    password: $('#pass').val()
                };
                $.post('../Modelo/autenticar.php', datos, function (respuesta) {
                    console.log(respuesta);
                    switch (respuesta) {
                        case '0':
                            Swal.fire('Administrador No Reconocido','---','error');
                            break;
                        case '1':
                            Swal.fire('Contraseña Incorrecta','---','error');
                            break;
                        case '2':
                            window.location.href = "./registrar.php?token="+$('#token').val()+"&documento=&nombre=&nacimiento=&genero=&id=";
                            break;
                    }
                    
                    $('#usuario').val('');
                    $('#pass').val('');
                    
                    
                })
            }else{
                Swal.fire('Todos los campos son obligatorios!!','---','error');
            }
        })
        
    });
</script>
</html>
