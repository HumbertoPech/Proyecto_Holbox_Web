<?php
                    /*Carga las imagenes de LOS USUARIOS*/
include('core/Conexion.php'); 
function consultar($query){
                     $conector = new Conexion();
                     $conexion= $conector ->get_conexion();                               

                    if($conexion){
                        $arrayRestaurantes = array();
                        $resultado = $conexion->query($query);
                        if (!empty($resultado)) {
                            while($row = $resultado->fetch_assoc()){                     
                                $arrayRestaurantes[]=$row;
                            }
                            return $arrayRestaurantes;
                        }
                    }
                    return $arrayRestaurantes;
}

function eliminar($query){

}
function actualizar($query){

}

?> 