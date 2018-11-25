<?php
/**
* Modelo de catalogo
*
* Contiene todas las funciones para el procesamientos de datos para el catalogo de restaurantes*
* 
**/

/** Carga las funciones para la gestion de bases de datos*/
//VERIFICAR SI SE CAMBIAN O QUE PEPE
include('libs/conexionCatalogo.php');

/**
* Elimina la informacion de un recurso
*
* @param int $recurso Id del recurso
* @return integer Numero de registros eliminados
*
* @uses ejecutarSQL
*/
function eliminarRecurso($recurso) {

	$SQL = 'DELETE FROM recursos WHERE id_recurso = ' . $usuario['id_recurso'];
	$resultado = ejecutarSQL($SQL);

	return $resultado;
}

/**
* Genera el titulo de un formulario
*
* @return text Titulo del formulario
*
*/
function generarTitulo() {

	return "Catalogo de restaurantes";
}

function cargarPrincipal(){  
    $HTMLrespuesta= array();
    $resultados= consultar('SELECT * FROM restaurantes');
    for($i=0; $i< count($resultados); $i++){
            array_push($HTMLrespuesta,presentarResultados($resultados[$i]));
       }
    return implode(" ", $HTMLrespuesta);
}

function realizarBusqueda(){

    if(!empty($_POST)){
      $parametrosBusqueda= array();
      $cadenaInicial= 'SELECT * FROM restaurantes WHERE';
    
    //SELECT * FROM `restaurantes` WHERE `precio`= "Costoso" AND `tipo` = "Restaurantes"
       
       if(isset($_POST["tipoRest"])) {
            $tiposSolicitados= array(); 
            for($i=0 ; $i<count($_POST["tipoRest"]);$i++){
                $tipo= "tipo = '" . $_POST["tipoRest"][$i] . " ' ";
                array_push($tiposSolicitados, $tipo);
            }
           
            $parametrosTipo = implode(" OR ", $tiposSolicitados); 
            array_push($parametrosBusqueda, $parametrosTipo);           
       }

       if(isset($_POST["precioRest"])) {
           $preciosSolicitados= array(); 
            for($i=0 ; $i<count($_POST["precioRest"]);$i++){
                $precio= "precio = '" . $_POST["precioRest"][$i] . " ' ";
                array_push($preciosSolicitados, $precio);
            }           
            $parametrosPrecio = implode(" OR ", $preciosSolicitados); 
            array_push($parametrosBusqueda, $parametrosPrecio);  
       }

        $cadenaConsulta= $cadenaInicial ." ". implode(" AND ", $parametrosBusqueda);

       $resultados= consultar($cadenaConsulta);

       if(!empty($resultados)){
          $HTMLrespuesta= array();
          for($i=0; $i< count($resultados); $i++){
            array_push($HTMLrespuesta,presentarResultados($resultados[$i]));
          }
        return implode(" ", $HTMLrespuesta);
       }
       return sinResultados();
  
    }else{
      return cargarPrincipal();
    }    
}

function sinResultados(){
    return "No se encontraron restaurantes";
}

function presentarResultados($rest){

    switch ($rest['precio']) {
        case 'Costoso':
            $precio= "$$$";
            break;
        case 'Medio':
            $precio= "$$";
            break;
        case 'Economico':
            $precio= "$";
            break;
        default:
            break;
    }
    $image= base64_encode($rest['imagen_restaurante']);
    //<img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);" alt="mangle" style="width:90%"/>
    
 $columnas= <<<XYZ
            <div class="contenedor-restaurante">
                <img src="data:image/jpg;base64,{$image}" alt="{$rest['nombre_restaurante']}" style="width:100%">
                <div class="descripcion" >
                    <div class="item name" > {$rest['nombre_restaurante']} </div>
                    <div class="item price">{$precio}</div>
                    <div class="item horario">{$rest['horario_abierto']}-{$rest['horario_cerrado']} </div>
                    <div class="item telefono">{$rest['telefono_restaurante']} </div>
                </div>
            </div>
XYZ;
return $columnas;
}

function validarUsuario($roles,$permisos){
  $permisoEspecial = false;

  if (count(array_intersect($_SESSION["permisos_especiales"], $permisos)) === 0) {
     $permisoEspecial=false; //no permisos especiales.
  } else {
    $permisoEspecial=true;
  }
  return (in_array($_SESSION["tipo"],$roles) || $permisoEspecial);
}

?>