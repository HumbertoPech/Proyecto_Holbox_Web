<?php
function accion_iniciar(){
	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;
	include_once("vista/adminUsuariosVista.php");	
}

/*function accion_usuarios($accion,$id){
	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;
	include ("modelo/adminUsuariosModelo.php");
	accionUsuarios($accion,$id);
}*/

function accion_editarUsuario(){
    global $url_base;
    include("vista/editarUsuariosVista.php");
}

function accion_logout(){global $url_base; session_start(); session_destroy();header("Location:{$url_base}paginas/Inicio");}
?>