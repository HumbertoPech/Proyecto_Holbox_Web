<?php

function accion_iniciar(){
    global $url_base;
    include("vista/calendarioVista.php");
}

function accion_obtenerPermisos(){
    session_start();
    $respuesta = validarPermisos("calendario de eventos");
    $respuesta[] = $_SESSION;
    echo json_encode($respuesta,JSON_FORCE_OBJECT);
}
?>