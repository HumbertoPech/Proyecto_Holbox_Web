<?php
function accion_iniciar() {
    global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;

    global $publicacionesCount;

    session_start();
    $arrayPublicaciones = array();
    include("modelo/cargarImagenesUsuario.php");
    include("modelo/proceso_guardar_imagenModelo.php");
    include('vista/perfil_usuarioVista.php');
}

function accion_logout(){global $url_base; session_start(); session_destroy();header("Location:{$url_base}paginas/Inicio");}
?>