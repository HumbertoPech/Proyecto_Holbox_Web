<?php
function consultarPermisos($query){
include_once('core/Conexion.php');  
    $conector = new Conexion();
    $conexion= $conector ->get_conexion();                               
    $idPermisos = array();
    if($conexion){
        $resultado = $conexion->query($query);
        if (!empty($resultado)) {
            while($row = $resultado->fetch_array()){                     
                array_push($idPermisos, (int)$row['id_permiso']);
            }
        }
    }
        
    return $idPermisos;
}
function consultar($query){
    $conector = new Conexion();
    $conexion= $conector ->get_conexion();                               
    if($conexion){
        $arrayRespuesta = array();
        $resultado = $conexion->query($query);
        if (!empty($resultado)) {
            while($row = $resultado->fetch_assoc()){                     
                $arrayRespuesta[]=$row;
            }
        }
    }
    return $arrayRespuesta;
}
?>