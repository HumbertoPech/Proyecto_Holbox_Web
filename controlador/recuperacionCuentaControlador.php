<?php

function accion_recuperar(){
    global $url_base, $variables_ruta, $errores;

    include('vista/recuperacionCuentaVista.php');
}

function accion_enviarCorreo() {
    global $url_base, $variables_ruta, $errores;
    include("modelo/recuperacionCuentaModelo.php");

    $enviado = enviarCorreo($_POST["correo"],$url_base);
    echo $enviado;
}


?>