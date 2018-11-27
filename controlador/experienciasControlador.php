<?php
session_start();
function accion_iniciar() {//accion_iniciar
	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;

	/** @ignore */
	// Incluye el modelo que corresponde

	include('modelo/experienciasHModelo.php');	
    $titulo = generarTitulo();
    
    
	/** @ignore */
	// Pasa a la vista toda la informacion que se desea representar
	
    include('vista/experienciasHVista.php');    
	
}
function accion_inicio() {//accion_iniciar
	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;

	/** @ignore */
	// Incluye el modelo que corresponde

	include('modelo/experienciasHModelo.php');	
    $titulo = generarTitulo();
    
    
	/** @ignore */
	// Pasa a la vista toda la informacion que se desea representar
	
    include('vista/experienciasHVista.php');    
	
}

function accion_eliminarComentario() {
	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;
	include('modelo/experienciasHModelo.php');	
	$titulo = generarTitulo();
	delete_comment();
	//header ("location:" . $url_base . "vista/recurso/buscar");
	header("Location:". $url_base."experiencias/iniciar");
	//include('vista/experienciasHVista.php');
	
}
function accion_hacerComentario() {
	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;
	include('modelo/experienciasHModelo.php');	
	$titulo = generarTitulo();
	do_comments();
	header("Location:". $url_base."experiencias/iniciar");
	
	//include('vista/experienciasHVista.php');
}
// y demas botones :(
?>