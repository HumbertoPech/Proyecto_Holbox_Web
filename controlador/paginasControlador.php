<?php

function accion_Inicio(){global $url_base, $variables_ruta; include("vista/paginasInicioVista.php");}
function accion_LugaresHolbox(){global $url_base, $variables_ruta; include("vista/paginasLugaresHolboxVista.php");}
function accion_Gastronomia(){global $url_base, $variables_ruta; include("vista/paginasGastronomiaVista.php");}
function accion_FloraFauna(){global $url_base, $variables_ruta;include("vista/paginasFloraFaunaVista.php");}
function accion_Historia(){global $url_base, $variables_ruta; include("vista/paginasHistoriaVista.php");}
function accion_logout(){global $url_base; session_start(); session_destroy();header("Location:{$url_base}paginas/Inicio");}
?>