<?php
function accion_iniciar() {
    global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;

    /** @ignore */
    // Incluye el modelo que corresponde
    $data_usuarios=array();
    $data_permisos=array();
    $data_sistemas=array();
    include('modelo/bitacoraFiltrosModelo.php');
    //include('modelo/bitacoraTablaModelo.php');
	//$titulo = generarTitulo();
	/** @ignore */
	// Pasa a la vista toda la informacion que se desea representar
	include('vista/bitacoraVista.php');
}

function accion_logout(){global $url_base; session_start(); session_destroy();header("Location:{$url_base}paginas/Inicio");}
?>