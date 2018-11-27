<?php

function solicitarListaUsuarios(){
    require_once('core/Conexion.php');  
    $con = new Conexion();
    $conexion = $con->get_conexion();
    $query = "SELECT usuarios.*, usuarios_accesos.*  FROM usuarios JOIN usuarios_accesos ON usuarios.id_usuario = usuarios_accesos.id_usuario WHERE disponibilidad = true";
    $arrayUsuarios = null;
    if($conexion){
        $arrayUsuarios = array();
        $resultado = $conexion->query($query);
        if (!empty($resultado)) {
            while($row = $resultado->fetch_assoc()){                    
                $arrayUsuarios[]=$row;
            }
            return $arrayUsuarios;
        }
    }
    return $arrayUsuarios;
}

function eliminar(){
    require_once('core/Conexion.php');  
    $con2 = new Conexion();
    $conexion2 = $con2->get_conexion();
    $id = mysqli_real_escape_string($conexion2,(strip_tags($_GET["nik"],ENT_QUOTES)));
    $cek = mysqli_query($conexion2, "SELECT * FROM usuarios WHERE id_usuario=$id");
    if(mysqli_num_rows($cek) == 0){
        echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
    }else{
        $query = "UPDATE usuarios SET disponibilidad=false WHERE id_usuario=$id";
        //"DELETE FROM usuarios2 WHERE codigo='$nik'"
        $delete = mysqli_query($conexion2, $query);
        $con2->close_conexion();
        if($delete){
            echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminados correctamente.</div>';
            return true;
        }else{
            echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudieron eliminar los datos.</div>';
            return false;
        }
    }
}
?>



