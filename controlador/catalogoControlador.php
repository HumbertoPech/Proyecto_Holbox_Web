<?php
/**
* Controlador de la pagina del catalogo
*
* Contiene todas las funciones para el control de catalogo,
* desde busquedas hasta  eliminaciones y ediciones. Llama al modelo y la vista necesaria
*
* @package catalogo
* @author Wendy Sosa
* @version 1.5
* @date 24/11/2018
*
**/

/**
* Presenta la pagina del catalogo.
* Carga el archivo modelo/catalogoModelo.php.
* Carga el archivo vista/catalogoVista.php
*
* @uses $aplicacion
* @uses $url_base
* @uses $variables_ruta
* @uses $controlador
* @uses $accion
*
* * @uses generarTitulo
*/

function accion_iniciarCatalogo() {

	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;

	/** @ignore */
	// Incluye el modelo que corresponde
	include('modelo/catalogoModelo.php');
	
    $titulo = generarTitulo(); 

    $catalogoPrincipal= cargarPrincipal();
    
	/** @ignore */
	// Pasa a la vista toda la informacion que se desea representar
	
    include('vista/catalogoVista.php');    
	
}
/**
* Regresa el resultado de la llamada AJAX de busqueda.
*Regresa una cadena HTML.
* Carga el archivo modelo/catalogoModelo.php.
*
* @uses $aplicacion
* @uses $url_base
* @uses $variables_ruta
* @uses $controlador
* @uses $accion
*
* * @uses generarTitulo
*/
function accion_buscarRestaurante() {

	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion;

	/** @ignore */
	// Incluye el modelo que corresponde
	include('modelo/catalogoModelo.php');
	
	$titulo = generarTitulo();
	$resultado= realizarBusqueda();
	echo $resultado;
}
?>