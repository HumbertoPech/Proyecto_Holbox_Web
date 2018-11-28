<?php

function accion_iniciar(){
    global $url_base, $variables_ruta; 
    include("modelo/feedModelo.php");
    include("vista/feed.php");
}

function accion_logout(){global $url_base; session_start(); session_destroy();header("Location:{$url_base}paginas/Inicio");}
?>