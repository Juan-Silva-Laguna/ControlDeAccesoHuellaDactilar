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
        <a  href="lista.php?token=<?php echo $_GET["token"]; ?>"><img src="../Recursos/Img/listar-activo.png"></a>
        <a  href="registrar.php?token=<?php echo $_GET["token"]; ?>&documento=&nombre=&nacimiento=&genero=&id="><img src="../Recursos/Img/registrar-desactivo.png" style="margin-right: 57px;"></a>
    </div>
    <a  href="personal.php?token=<?php echo $_GET["token"]; ?>" style="position: fixed;left: 210px;top: 120px;"><img src="../Recursos/Img/usuarios.png" width="60px" height="60px"></a>
    <div class="container" id="advanced-search-form" style="margin-top: 0px;height: 480px;overflow: scroll;"> 
        <div class="row" style=" margin-bottom: 15px; ">
          <div class="col-md-4"><input type="radio" name="opcionLista" id="hoy" value="hoy" checked> Reporte de Hoy</div><!--solo por funcionario-->
          <div class="col-md-4"><input type="radio" name="opcionLista" id="semana" value="semana"> Reporte de la Semana</div><!--solo por funcionario y dia-->
          <div class="col-md-4"><input type="radio" name="opcionLista" id="todo" value="todo"> Todos los accesos</div><!--solo por funcionario y dia y periodo de tiempo-->
        </div>
        <div id="panel" class="row">
          <div class="col-md-12"><input type="text"  class="form-control input" placeholder="Filtre por Nombre de Funcionario" id="nombre_fun_hoy"> </div>
          
          <div class="col-md-6"><input type="text"  class="form-control input" placeholder="Filtre por Nombre de Funcionario" id="nombre_fun_semana"> </div>
          <div class="col-md-6"><input type="text"  class="form-control input" placeholder="Filtre por Dia" id="dia_semana"> </div>

          <div class="col-md-6">De:<input type="date"  class="form-control input" style=" margin-bottom: 8px; margin-top: 0px; height: 46px;" id="fechaIni_todo"> </div>          
          <div class="col-md-6">Hasta:<input type="date"  class="form-control input" style=" margin-bottom: 8px; margin-top: 0px; height: 46px; " id="fechaFin_todo"> </div>
          <div class="col-md-6"><input type="text"  class="form-control input" placeholder="Filtre por Nombre de Funcionario" id="nombre_fun_todo"> </div>
          <div class="col-md-6"><input type="text"  class="form-control input" placeholder="Filtre por Dia" id="dia_todo"> </div>
        </div>        
        <button class="btn-flotante" style="left: 910px;top: 520px;" id="exportar">Exportar</button>
        <div id="reporte"> 
        <table id="dtBasicExample" class="table table-striped table-bordered" width="100%" id="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Dia</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Hora de Ingreso</th>
                <th>Hora de Salida</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              
            </tbody>
        </table>
      </div>   
    </div>
</body>
<script type='text/javascript' src="../Recursos/Js/jquery-3.5.1.min.js"></script>
<script src="../Recursos/Js/jspdf/dist/jspdf.min.js"></script>
<script src="../Recursos/Js/jspdf.plugin.autotable.min.js"></script>
<script>
    $(document).ready(function() {
      var data = [], titulo;
      $('#exportar').on('click',function () {
        
        var pdf = new jsPDF({orientation: 'landscape'});
        pdf.text(20,20,titulo);

        var columns = ["#", "Dia", "Fecha", "Nombre", "Hora de Ingreso", "Hora de Salida"];
        
        pdf.autoTable(columns,data,
            { margin:{ top: 25  }}
          );
          data = [];
          pdf.save(titulo+'.pdf');
      });

      $("input[name=consulta]").click(function () {    
          seleccion($('input:radio[name=consulta]:checked').val());                
      });

      function seleccion(selec) {
        let datos = {};
        switch (selec) {
          case 'hoy':
              $('#nombre_fun_hoy').attr('style','display: show');
              $('#nombre_fun_semana').attr('style','display: none');
              $('#dia_semana').attr('style','display: none');
              $('#nombre_fun_todo').attr('style','display: none');
              $('#dia_todo').attr('style','display: none');
              $('#fechaIni_todo').attr('style','display: none');
              $('#fechaFin_todo').attr('style','display: none');
              datos = {opcion:'listar',tipo: 'hoy',nombre:'',dia:'',fechaIni:'',fechaFin:''}; 
              break;
          case 'semana':
              $('#nombre_fun_hoy').attr('style','display: none');
              $('#nombre_fun_semana').attr('style','display: show');
              $('#dia_semana').attr('style','display: show');
              $('#nombre_fun_todo').attr('style','display: none');
              $('#dia_todo').attr('style','display: none');
              $('#fechaIni_todo').attr('style','display: none');
              $('#fechaFin_todo').attr('style','display: none');  
              datos = {opcion:'listar',tipo: 'semana',nombre:'',dia:'',fechaIni:'',fechaFin:''}; 
              break;
          case 'todo':
              $('#nombre_fun_hoy').attr('style','display: none');
              $('#nombre_fun_semana').attr('style','display: none');
              $('#dia_semana').attr('style','display: none');
              $('#nombre_fun_todo').attr('style','display: show');
              $('#dia_todo').attr('style','display: show');
              $('#fechaIni_todo').attr('style','display: show');
              $('#fechaFin_todo').attr('style','display: show');
            datos = {opcion:'listar',tipo: 'todo1',nombre:'',dia:'',fechaIni:'',fechaFin:''}; 
            break;
        } 

        listar(datos);
    }
    seleccion($('input:radio[name=opcionLista]:checked').val());

    $("input[name=opcionLista]").click(function () {    
        seleccion($('input:radio[name=opcionLista]:checked').val());                
    });


    $('#nombre_fun_hoy').on('keyup',function () {
      datos = {opcion:'listar',tipo: 'hoy',nombre:$('#nombre_fun_hoy').val(),dia:'',fechaIni:'',fechaFin:''}; 
      listar(datos);
    })

    $('#nombre_fun_semana').on('keyup',function () {
      datos = {opcion:'listar',tipo: 'semana',nombre:$('#nombre_fun_semana').val(),dia:$('#dia_semana').val(),fechaIni:'',fechaFin:''}; 
      listar(datos);
    })

    $('#dia_semana').on('keyup',function () {
      datos = {opcion:'listar',tipo: 'semana',nombre:$('#nombre_fun_semana').val(),dia:$('#dia_semana').val(),fechaIni:'',fechaFin:''}; 
      listar(datos);
    })

    $('#nombre_fun_todo').on('keyup',function () {
      
      if ($('#fechaFin_todo').val() == '') {
        datos = {opcion:'listar',tipo: 'todo1',nombre:$('#nombre_fun_todo').val(),dia:$('#dia_todo').val(),fechaIni:$('#fechaIni_todo').val(),fechaFin:$('#fechaFin_todo').val()};
      }
      else{
        datos = {opcion:'listar',tipo: 'todo2',nombre:$('#nombre_fun_todo').val(),dia:$('#dia_todo').val(),fechaIni:$('#fechaIni_todo').val(),fechaFin:$('#fechaFin_todo').val()};
      }       
      listar(datos);
    })

    $('#dia_todo').on('keyup',function () {
      if ($('#fechaFin_todo').val() == '') {
        datos = {opcion:'listar',tipo: 'todo1',nombre:$('#nombre_fun_todo').val(),dia:$('#dia_todo').val(),fechaIni:$('#fechaIni_todo').val(),fechaFin:$('#fechaFin_todo').val()}; 
      }else{
        datos = {opcion:'listar',tipo: 'todo2',nombre:$('#nombre_fun_todo').val(),dia:$('#dia_todo').val(),fechaIni:$('#fechaIni_todo').val(),fechaFin:$('#fechaFin_todo').val()}; 
      }
      listar(datos);
    })

    $('#fechaIni_todo').on('change',function () {
      if ($('#fechaFin_todo').val() == '') {
        datos = {opcion:'listar',tipo: 'todo1',nombre:$('#nombre_fun_todo').val(),dia:$('#dia_todo').val(),fechaIni:$('#fechaIni_todo').val(),fechaFin:$('#fechaFin_todo').val()}; 
      }else{
        datos = {opcion:'listar',tipo: 'todo2',nombre:$('#nombre_fun_todo').val(),dia:$('#dia_todo').val(),fechaIni:$('#fechaIni_todo').val(),fechaFin:$('#fechaFin_todo').val()}; 
      }
      listar(datos);
    })

    $('#fechaFin_todo').on('change',function () {
      datos = {opcion:'listar',tipo: 'todo2',nombre:$('#nombre_fun_todo').val(),dia:$('#dia_todo').val(),fechaIni:$('#fechaIni_todo').val(),fechaFin:$('#fechaFin_todo').val()}; 
      listar(datos);
    })


    function listar(datos) {
      console.log(datos);
      $.post('../Modelo/listar.php', datos, function (respuesta) {
        console.log(respuesta);
          var table = null; 
          let min, max;
          $.each(JSON.parse(respuesta), function(index, val) {
            data.push(Array(index+1,val.asi_dia,val.asi_fecha,val.nombre_completo,val.asi_hora_ingreso,val.asi_hora_salida));
            if (index==0) {
              max = val.asi_fecha;
            }else if(JSON.parse(respuesta).length==index+1){
              min = val.asi_fecha;
            }
            table += `
              <tr id="${val.id_asistencia}">
                <td>${index+1}</td>
                <td>${val.asi_dia}</td>
                <td>${val.asi_fecha}</td>
                <td>${val.nombre_completo}</td>
                <td>${val.asi_hora_ingreso}</td>
                <td>${val.asi_hora_salida}</td>
              </tr>
            `;
          });
          if (min==max){
            titulo = "Reporte Control de Accesos del "+min;    
          }else{
            titulo = "Reporte Control de Accesos del "+min+" hasta el "+max;    
          }
          $('#tableBody').html(table);
          //$('#table').dataTable();
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
</script>
</html>
