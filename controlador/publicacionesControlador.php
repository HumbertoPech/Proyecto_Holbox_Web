<?php
function accion_iniciar() {
    global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;

    global $publicacionesCount;
    $arrayPublicaciones = array();
    include("modelo/cargarImagenesUsuario.php");
    include("modelo/proceso_guardar_imagenModelo.php");
    include('vista/perfil_usuarioVista.php');
}
?>