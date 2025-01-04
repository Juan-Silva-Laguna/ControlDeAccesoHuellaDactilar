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
    <title>Personal Medimas</title>
    <style>
      .input{
        padding-top: 8px;
        padding-bottom: 8px;
        margin-bottom: 12px;
      }
    </style>
</head>
<body>
    <div style="margin-top: 70px;" class="container row text-right">
        <a  href="lista.php?token=<?php echo $_GET["token"]; ?>"><img src="../Recursos/Img/listar-desactivo.png"></a>
        <a  href="registrar.php?token=<?php echo $_GET["token"]; ?> &documento=&nombre=&nacimiento=&genero=&id="><img src="../Recursos/Img/registrar-desactivo.png" style="margin-right: 57px;"></a>
    </div>
    <div class="container" id="advanced-search-form" style="margin-top: 0px;height: 480px;overflow: scroll;"> 
        <div id="panel" class="row">
          <div class="col-md-12"><input type="text" class="form-control input" id="buscar" placeholder="Filtre por Nombre de Funcionario"> </div>
        </div>
        <input type="hidden" id="token" value="<?php echo $_GET["token"]; ?>">     
        <table id="dtBasicExample" class="table table-striped table-bordered" width="100%" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>N° Documento</th>
                <th>Nombre</th>
                <th>Genero</th>
                <th>Nacimiento</th>
                <th>Herramientas</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              
            </tbody>
        </table>   
    </div>
</body>
<script type='text/javascript' src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<script src="../Recursos/Js/jspdf/dist/jspdf.min.js"></script>
<script src="../Recursos/Js/jspdf.plugin.autotable.min.js"></script>
<script type='text/javascript' src="../Recursos/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
    listar({buscar:'',tipo:'listar'});

    $('#buscar').on('keyup',function () {
      datos = {buscar:$('#buscar').val(),tipo:'listar'}; 
      listar(datos);
    })
    
    function listar(datos) {
      $.post('../Modelo/personal.php', datos, function (respuesta) {
        console.log(respuesta);
          var table = null; 
          $.each(JSON.parse(respuesta), function(index, val) {            
            table += `
              <tr id="${val.id}">
                <td>${index+1}</td>
                <td>${val.documento}</td>
                <td>${val.nombre_completo}</td>
                <td>${val.genero}</td>
                <td>${val.nacimiento}</td>
                <td class="row">
                    <button class="btn btn-warning col-md-6" style="margin-left: 12px; margin-top:0px; width: 42px;" onclick="editar('${val.id}','${val.documento}','${val.nombre_completo}','${val.nacimiento}','${val.genero}')"><img src="../Recursos/Img/edit.png" width="15px" height="15px"></button>
                    <button class="btn btn-danger col-md-6" style="margin-left: 12px; margin-top:0px; width: 42px;" onclick="eliminar(${val.documento},'${val.nombre_completo}')"><img src="../Recursos/Img/delete.png" width="13px" height="15px"></button>
                </td>
              </tr>
            `;
          });
          $('#tableBody').html(table);
      })
      .fail(function(){
        Swal.fire(
          'Error!',
          'No se encontraron resultados en la tabla',
          'error'
        )
      })
    }
});
function eliminar(id, nombre) {
    Swal.fire({
        title: 'Seguro de eliminar a '+nombre+' del sistema?',
        text: "Si eliminas a el usuario ya no se volvera a llevar su control de acceso",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3AB1C9',
        cancelButtonColor: '#d9534',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, estoy seguro!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('../Modelo/personal.php', {documento:id,tipo:'eliminar'}, function (respuesta) {
                console.log(respuesta);
                if (respuesta=='1') {
                    Swal.fire(
                        'Muy Bien!',
                        'Se elimino al usuario con exito',
                        'success'
                    )                    
                }else{
                    Swal.fire(
                        'Error!',
                        'No se logro eliminar al usuario',
                        'error'
                    )
                }
                listar({buscar:'',tipo:'listar'});
            })
            .fail(function(){
                Swal.fire(
                'Error!',
                'Recargue la pagina y vuelva a intentarlo',
                'error'
                )
            })
        }
    })  
}

function editar(id, documento, nombre, nacimiento, genero) {
    window.location.href = `registrar.php?token=${$('#token').val()}&documento=${documento}&nombre=${nombre}&nacimiento=${nacimiento}&genero=${genero}&id=${id}`;
}   
</script>
</html>
