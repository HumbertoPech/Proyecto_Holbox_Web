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
?>