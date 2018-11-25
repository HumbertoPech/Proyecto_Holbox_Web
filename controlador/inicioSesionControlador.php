<?php

function accion_iniciarSesion(){
    global $url_base, $variables_ruta, $errores;

    include('vista/inicioSesionVista.php');
}

function accion_validar() {
    global $url_base, $variables_ruta, $errores;
    include("modelo/inicioSesionModelo.php");
    $usuarioValido = validarUsuario($_POST["correo"], $_POST["contrasena"]);
    if(!$usuarioValido){
        //header("Location:{$url_base}inicioSesion/iniciarSesion");
        include("vista/inicioSesionVista.php");
    }else{
        header("Location:{$url_base}paginas/Inicio");
        //include("vista/paginasInicioVista.php");
    }
}

function accion_logout(){
    global $url_base;
    session_start();
    session_destroy();
    header("Location:{$url_base}paginas/Inicio");
}

?>