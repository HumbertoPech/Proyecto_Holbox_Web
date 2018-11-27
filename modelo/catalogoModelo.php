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
    $resultados= consultarRestaurantes('SELECT * FROM restaurantes where disponibilidad=1');
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
                $tipo= "tipo_restaurante = '" . $_POST["tipoRest"][$i] . " ' ";
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
        $cadenaConsulta= $cadenaConsulta. " AND disponibilidad=1";
       $resultados= consultarRestaurantes($cadenaConsulta);

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
function hey(){
  return "hey";
}
function obtenerListado(){
  
   $id= $_SESSION["id_usuario"];
  $query = "sELECT * FROM restaurantes WHERE id_usuario="."'" .$id."'". "AND disponibilidad=1";
    $resultados= consultarRestaurantes($query); 

   foreach ($resultados as $restaurante) {
    echo '<option value="'.$restaurante['id_restaurante'].'">'.$restaurante['nombre_restaurante'].'</option>';
  }         
}

function insertarRestaurante(){
  include_once('core/Conexion.php'); 
  $conector = new Conexion();
  $con= $conector ->get_conexion();
 // escape variables for security
$id = mysqli_real_escape_string($con, $_POST['id_usuario']);
$nombre = mysqli_real_escape_string($con, $_POST['nombre_restaurante']);
$telefono = mysqli_real_escape_string($con, $_POST['telefono_restaurante']);
//SON TIME
$horario_abierto = mysqli_real_escape_string($con, $_POST['horario_abierto']);
$horario_cerrado = mysqli_real_escape_string($con, $_POST['horario_cerrado']);

$precio = mysqli_real_escape_string($con, $_POST['precio']);
$descripcion = mysqli_real_escape_string($con, $_POST['descripcion_restaurante']);
$tipo = mysqli_real_escape_string($con, $_POST['tipo_restaurante']);

$imagen = $_FILES['imagen_restaurante']['tmp_name'] ;

// leer del archvio temporal .. el binario subido.
$binario_contenido = addslashes(file_get_contents($imagen));

//mysqli_real_escape_string($con, $_POST['telefono_restaurante']);

$query= "INSERT INTO restaurantes 
        (id_usuario,nombre_restaurante, telefono_restaurante,horario_abierto,horario_cerrado,precio,
        descripcion_restaurante,tipo_restaurante,imagen_restaurante) VALUES
        ($id, '$nombre', '$telefono','$horario_abierto','$horario_cerrado','$precio','$descripcion',
        '$tipo','$binario_contenido')";

$resultado= añadir($query);
var_dump($resultado);

return true;
}

function eliminarRestaurante(){
  require_once('libs/conexionCatalogo.php');  
  $id= $_POST['id_restaurante'];
  $query = "UPDATE restaurantes SET disponibilidad=false WHERE id_restaurante=$id";
  $resultado=eliminar($query); 
  return $resultado; 
}

?>