<?php
    include("../../config/conexion2.php");
    session_start();
    $id = $_SESSION['id_usuario'];
    $query1 = "DELETE from publicaciones WHERE id_usuario='$id'";
    $resultado1 = $conexion->query($query1);
    
    if(!$resultado1){
        header("Location: informacion_perfil.php");
    }
    
    $query2 = "DELETE from usuarios WHERE id_usuario='$id'";
    $resultado2 = $conexion->query($query2);
    if($resultado2){
        header("Location:../../sistemas/sistema_login/logout.php");
        echo "Si se elimino";
    }else{
        header("Location:../../paginas/paginas_usuarios/informacion_perfil.php");
        echo "No se elimino";
    }

?>
