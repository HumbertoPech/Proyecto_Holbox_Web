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

	include_once('modelo/catalogoModelo.php');	
    $titulo = generarTitulo();
    $catalogoPrincipal= cargarPrincipal();
    
	/** @ignore */
	// Pasa a la vista toda la informacion que se desea representar
	
    include('vista/catalogoVista.php');    
	
}

function accion_validarPermisos($nombreModulo,$redireccion){
	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion,$directorio_base;
	
   
	if(!empty($nombreModulo)){
	// Incluye y crea la conexion para buscar en la bd:
		require_once('libs/conexionCatalogo.php');  
	    
	    //buscando permisos del modulo
	    $query = "SELECT p.id_permiso FROM permisos p JOIN modulos m ON p.id_modulo=m.id_modulo 
	              WHERE m.nombre_modulo =" ."'". $nombreModulo ."'";
	    
	    $permisosModulo= consultarPermisos($query);
	    	
		//buscando permisos del rol:
		$query= "SELECT rp.id_permiso FROM roles_permisos rp JOIN roles r ON rp.id_rol=r.id_rol 
	              WHERE r.nombre_rol =" ."'". $$_SESSION["tipo_usuario"] ."'";
	              
		$permisosRol= consultarPermisos($query);
		//uniendo permisos del rol con permisos especiales.
		$permisosUsuario=array_unique(array_merge($permisosRol, 
							array_keys($_SESSION['permisos_especiales'])
						 ));		
		//El usuario tiene almenos un permisos del modulo.
		if (count(array_intersect($permisosModulo, $permisosUsuario)) === 0) {
		    header("location:" . $url_base . $redireccion);  //no permisos.
		} else {
		    echo "puedes pasar a esta pagina";
		}
	}		
}

function accion_editar(){
	global $aplicacion, $url_base, $variables_ruta, $controlador, $accion,$directorio_base;
	// Incluye el modelo que corresponde
	include ('vista/editorCatalogoVista.php');
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