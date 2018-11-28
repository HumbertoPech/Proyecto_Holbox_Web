<?php
session_start();
//include("libs/funciones_comprobacion.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registrarse</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montaga'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link rel="stylesheet" href="<?=$url_base?>resources/css/estilos.css">
    <script src = '<?=$url_base?>resources/js/local_storage.js'></script>
</head>
<body>
    <!--FORMULARIO-->
<div class="contenedor-formulario">
<h1>Registrarse</h1>
    <form id="formulario" class=" caja-login" method="post" action="<?=$url_base?>registroUsuario/validar">
        <div class="campo">
            <label for="usuario">Nombre: </label>
            <input type="text" name="nombre" id="usuario" placeholder="Usuario" value=<?=isset($_POST['nombre'])?$_POST['nombre']:""; ?>>
            <?=isError($errores,'nombre'); ?>
        </div>
        <div class="campo">
            <label for="correo">Correo: </label>
            <input type="text" name="correo" id="correo" placeholder="example@example.com" value=<?=isset($_POST['correo'])?$_POST['correo']:""; ?>>
            <?=isError($errores,'correo'); ?>
            <?=isError($errores,'correoExists'); ?>
        </div>
        <div class="campo">
            <label for="password">Contraseña: </label>
            <input type="password" name="contrasena" id="password" placeholder="Password">
            <?=isError($errores,'contrasena'); ?>
        </div>
        <div class="campo">
            <label for="password">Repetir contraseña: </label>
            <input type="password" name="repetir_contrasena" id="passwor" placeholder="repetir contraseña">
            <?=isError($errores, 'repetir_contrasena'); ?>
        </div>
        <div class="campo enviar">
            <input type="hidden" id="tipo" value="crear">
            <input type="submit" class="boton" value="Enviar"> <a href="<?=$url_base?>paginas/Inicio"><input type="button" value="Cancelar" class="boton"></a>
        </div>
    </form>
</div>
</body>
</html>