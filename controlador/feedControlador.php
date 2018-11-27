<?php

function accion_iniciar(){
    global $url_base, $variables_ruta; 
    include("modelo/feedModelo.php");
    include("vista/feed.php");
}
?>