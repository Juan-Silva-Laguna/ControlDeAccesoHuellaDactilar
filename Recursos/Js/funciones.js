var timestamp = null;
var conteoHuella = null;
    function activarSensor(srn) {
        $.ajax({
            async: true,
            type: "POST",
            url: "../Modelo/ActivarSensorAdd.php",
            data: "&token=" + srn,
            dataType: "json",
            success: function (data) {
                var json = JSON.parse(data);
                if (json["filas"] === 1) {
                    $('#conteo').html(`
                        <img src="../Recursos/Img/uno.png" alt="" width="45" height="45">
                        <img src="../Recursos/Img/dos.png" alt="" width="45" height="45">
                        <img src="../Recursos/Img/tres.png" alt="" width="45" height="45">
                        <img src="../Recursos/Img/cuatro.png" alt="" width="45" height="45">                    
                    `);
                    $('#img2').css('display','block');
                    $('#img1').css('display','none');
                }
            }
        });
        conteoHuella = 4;
    }

    function addUser(srn) {
        if (conteoHuella == 0) {
            var data = {"token": srn, "documento": $("#documento").val(),"nombre": $("#nombre").val(), "nacimiento": $("#nacimiento").val(), "genero": $("#genero").val()};   
            $.ajax({
                async: true,
                type: "POST",
                url: "../Modelo/CrearUsuario.php",
                data: data,
                dataType: "json",
                success: function (data) {
                    var json = JSON.parse(data);
                    if (json["filas"] === 1) {
                        $('#img2').css('display','none');
                        $('#img1').css('display','block');
                        Swal.fire('Excelente!!','Has registrado a '+($('#genero').val()=='m'?'el funcionario ' : 'la funcionaria ')+$('#nombre').val()+' con Exito!','success').then(function () {
                            window.location.href = "./registrar.php?token="+$('#token').val()+'&documento=&nombre=&nacimiento=&genero=&id="';
                        });    
                    }
                }
            });
        }
        else{
            Swal.fire('Aun Falta tu huella!','Por favor verifica que hayas colocado cuatro veces tu huella en el sensor.','error');
        }
        
    }

    function editUser(srn) {
        
        if (conteoHuella != null) {
            
            var data = {"token": srn, "documento": $("#documento").val()};   
            $.ajax({
                async: true,
                type: "POST",
                url: "../Modelo/cambiarHuella.php",
                data: data,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    var json = JSON.parse(data);
                    if (json["filas"] === 1) {
                        $('#img2').css('display','none');
                        $('#img1').css('display','block');
                    }
                }
            });
        }
        var datos = {"token": srn, "documento": $("#documento").val(),"nombre": $("#nombre").val(), "nacimiento": $("#nacimiento").val(), "genero": $("#genero").val()};   
        $.post("../Modelo/editarUsuario.php", datos, function (res) {
            var json = JSON.parse(res);
            if (json["filas"] === 1) {
                Swal.fire('Excelente!!','Has actualizado los datos con Exito!','success').then(function () {
                    window.location.href = "./registrar.php?token="+$('#token').val()+'&documento=&nombre=&nacimiento=&genero=&id="';
                });    
            }
        }) 
        window.location.href = "./registrar.php?token="+$('#token').val()+'&documento=&nombre=&nacimiento=&genero=&id="';  
    }

    function cargar_push_registro() {
        $.ajax({
            async: true,
            type: "POST",
            url: "../Modelo/httpush.php",
            data: "&timestamp=" + timestamp,
            dataType: "json",
            success: function (data) {
                var json = JSON.parse(JSON.stringify(data));
                
                timestamp = json["timestamp"];
                imageHuella = json["imgHuella"];
                tipo = json["tipo"];
                id = json["id"];
                conteoHuella = Number(json["statusPlantilla"][json["statusPlantilla"].length-1]);
                conteo(conteoHuella);
                setTimeout(() => {
                    cargar_push_registro()
                }, 1000);
                //setTimeout("cargar_push_registro()", 1000);
            }
        });
    }

    function cargar_push() {
        $.ajax({
            async: true,
            type: "POST",
            url: "../Modelo/httpush.php",
            data: "&timestamp=" + timestamp,
            dataType: "json",
            success: function (data) {
                var json = JSON.parse(JSON.stringify(data));

                timestamp = json["timestamp"];
                imageHuella = json["imgHuella"];
                tipo = json["tipo"];
                id = json["id"];

                verificacion(json["statusPlantilla"],json["documento"]);

            }
        });
    }

    function conteo(x) {
        console.log(x);
        switch (x) {
            case 3:
                $('#conteo').html(`
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/dos.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/tres.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/cuatro.png" alt="" width="45" height="45">                    
                `);                    
                break;
            case 2:
                $('#conteo').html(`
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/tres.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/cuatro.png" alt="" width="45" height="45">                    
                `); 
                break;
            case 1:
                $('#conteo').html(`
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/cuatro.png" alt="" width="45" height="45">                    
                `); 
                break;
            case 0:
                $('#conteo').html(`
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">
                    <img src="../Recursos/Img/bien.png" alt="" width="45" height="45">                    
                `); 
                break;
        }
        
    }

    function verificacion(dato, doc) {
        console.log(dato);
        console.log(doc);
        if (dato == '0') {
            Swal.fire('Tal parece que el funcionario no esta registrado','Por favor comuniquese con el celador para que se realice su registro','error').then(function () {
                window.location.href = "../Modelo/ActivarSensorReader.php?token="+$('#token').val()+"&y=0";
            });            
        }else if (dato == '1') {
            let datos = {documento: doc, opcion: 'acceso'};
            $.post('../Modelo/asistencia.php', datos, function (res) {
                let respuesta = JSON.parse(res);
                if (respuesta[0] == '0') {
                    Swal.fire('Tal parece que el funcionario no esta registrado','Por favor comuniquese con el celador para que se realice su registro','error').then(function () {
                        window.location.href = "../Modelo/ActivarSensorReader.php?token="+$('#token').val()+"&y=0";
                    });
                }else if (respuesta[0] == '1') {
                    Swal.fire(respuesta[1],'Que tengas un muy buen día con tu familia MediMas!','success').then(function () {
                        window.location.href = "../Modelo/ActivarSensorReader.php?token="+$('#token').val()+"&y=0";
                    });         
                }
                else if (respuesta[0] == '2') {
                    Swal.fire('Error De Acceso','Por favor recargue la pagina y vuelva a intentarlo','error').then(function () {
                        window.location.href = "../Modelo/ActivarSensorReader.php?token="+$('#token').val()+"&y=0";
                    });            
                }
                else if (respuesta[0] == '3') {
                    Swal.fire(respuesta[1],'MediMas agradece tus labores, esperamos hayas tenido un excelente dia!','success').then(function () {
                        window.location.href = "../Modelo/ActivarSensorReader.php?token="+$('#token').val()+"&y=0";
                    });
                }
            })        
        }
    }
