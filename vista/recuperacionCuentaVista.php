<?php
session_start();
//include("libs/funciones_comprobacion.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montaga'>
    <link rel="stylesheet" href="<?=$url_base;?>resources/css/estilos.css">
</head>
<body>
<div class="contenedor-formulario" id="respuesta">
<h1>Iniciar de sesion</h1>
<form id="formulario"  class="caja-login" >
    <div class="campo">
        <label for="correo">Correo: </label>
        <input type="text" name="correo" id="correo" placeholder="Correo">
    </div>
    <div class="campo">
        <p>Se te enviara un correo con tu contraseña</label>        
    </div>
    <div class="campo enviar">
        <input type="button" class="boton" value="Enviar" onclick="enviarCorreo()"><a href="<?=$url_base?>paginas/Inicio">
        <input type="button" value="Cancelar" class="boton"></a>       
    </div>
</form>
</div>
<script type="text/javascript">
           
    function enviarCorreo() {

        let correo = document.getElementById("correo");
        let formData = new FormData();
       formData.append("correo", correo.value);
         
        let xmlhttp = new XMLHttpRequest();


        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                 document.getElementById("respuesta").innerHTML= xmlhttp.responseText;
            }else if (xmlhttp.status == 400) {

              alert('There was an error 400');
           }
        };

        xmlhttp.open("POST", "<?php echo $url_base;?>recuperacionCuenta/enviarCorreo", true);
        xmlhttp.send(formData);
    }

</script>

</body>
</html>