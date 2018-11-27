<?php

ECHO "hA";
    $id = $_SESSION['id_usuario'];
    echo $id."ALIMINA";
    require_once("../core/Conexion.php");
    $con = new Conexion();
    $conexion = $con->get_conexion();
	$query = "UPDATE usuarios SET disponibilidad=false WHERE id_usuario='$id'";

    //$query1 = "UPDATE  publicaciones WHERE id_usuario='$id'";
    $resultado1 = $conexion->query($query1);
    
    if(!$resultado1){
        header("Location: vista/informacion_perfilVista.php");
    }
    
    $query2 = "UPDATE publicaciones SET disponibilidad=false WHERE id_usuario='$id'";
    $resultado2 = $conexion->query($query2);
    if($resultado2){
        header("{$url_base}inicioSesion/logout");
        echo "Si se elimino";
    }else{
        header("Location: vista/informacion_perfilVista.php");
        echo "No se elimino";
    }

?>
