<?php
include('core/Conexion.php'); 
function consultarRestaurantes($query){
                     $conector = new Conexion();
                     $conexion= $conector ->get_conexion();                               

                    if($conexion){
                        $arrayRestaurantes = array();
                        $resultado = $conexion->query($query);
                        if (!empty($resultado)) {
                            while($row = $resultado->fetch_assoc()){                     
                                $arrayRestaurantes[]=$row;
                            }
                            $conexion->close();
                            return $arrayRestaurantes;
                        }
                    }
                    return $arrayRestaurantes;
}

function añadir($query){
    $conector = new Conexion();
                     $conexion= $conector ->get_conexion();                           

                    if($conexion){
                        $resultado = $conexion->query($query);
                        if ($resultado === TRUE) {
                            $conexion->close();
                             return "Restaurante agregado";
                        }
                    }
                    $conexion->close();
    return $resultado->error();

}

function eliminar($query){
      $conector = new Conexion();
                     $conexion= $conector ->get_conexion();                           

                    if($conexion){
                        $resultado = $conexion->query($query);
                        if ($resultado === TRUE) {
                            $conexion->close();
                             return "Restaurante eliminado";
                        }
                    }
                    $conexion->close();
    return $resultado->error();


}
function actualizar($query){

}

?> 