<?php


function comprobar_ingreso($correo, $contrasena){
    require ("core/Conexion.php");
    $datos = array();

    $con = new Conexion();
    $conexion = $con->get_conexion();

    $correo = mysqli_real_escape_string($conexion,$correo);
    $contrasena = mysqli_real_escape_string($conexion,$contrasena);

    $sentencia = "SELECT * FROM USUARIOS WHERE correo = '$correo'";

    $resultado = $conexion->query($sentencia);

    while($registro = $resultado->fetch_array(MYSQLI_ASSOC)){
        if(password_verify($contrasena, $registro['contrasena'])){
            $datos['id_usuario'] = $registro['id_usuario'];

            $continue = comprobarAcceso($datos['id_usuario'], $conexion);
            if(!$continue){
                $datos['bloqueado'] = true;
                break;
            }

            $datos['nombre'] = $registro['nombre_usuario'];
            $datos['correo'] = $registro['correo'];
            
            //Sabiendo que el usuario existe, obtener su rol y permisos especiales
            $id_usuario = $datos['id_usuario'];
            //obteniendo rol
            $sentencia = "SELECT r.nombre_rol, r.id_rol FROM ROLES r JOIN USUARIOS_ROLES ur ON ur.id_rol = r.id_rol WHERE ur.id_usuario = {$id_usuario}";
            $registro = ($conexion->query($sentencia))->fetch_array(MYSQLI_ASSOC);
            $datos['tipo_usuario'] = $registro['nombre_rol'];
            //obteniendo permisos especiales
            $sentencia = "SELECT p.id_permiso, p.nombre_permiso FROM PERMISOS p JOIN PERMISOS_ESPECIALES pe ON pe.id_permiso = p.id_permiso WHERE id_usuario = {$id_usuario}";
            $resultadoPermisos = $conexion->query($sentencia);
            $permisosEspeciales = array();
            while($registro = $resultadoPermisos->fetch_array(MYSQLI_ASSOC)){
                $permisosEspeciales[$registro['id_permiso']] = $registro['nombre_permiso'];
            }
            $datos['permisos_especiales'] = $permisosEspeciales;
            resetIntentos($datos['id_usuario'], $conexion);
        }else{
            $continue = comprobarIntentos($registro['id_usuario'], $conexion);
            if(!$continue){
                $datos['num_intentos'] = true;
                break;
            }
        } 
    }

    $con->close_conexion();

    return $datos;
}

function comprobarAcceso($id, $con){
    $sentencia = "SELECT  fecha_bloqueo FROM USUARIOS_ACCESOS WHERE id_usuario = '$id'";
    $registro = ($con->query($sentencia))->fetch_array(MYSQLI_ASSOC);
    $bol = false;
    if(is_null($registro['fecha_bloqueo'])){
        $bol = true;
    }
    return $bol;
       
}

function numeroDeIntentos($id, $con){
    $sentencia = "SELECT num_intentos FROM USUARIOS_ACCESOS WHERE id_usuario = '$id'";
    $registro = ($con->query($sentencia))->fetch_array(MYSQLI_ASSOC);
    return $registro['num_intentos'];
}

function comprobarIntentos($id, $con){
    $num_intentos = numeroDeIntentos($id, $con);
    if($num_intentos > 3){
        bloquearPorIntentos($id, $con);
        return false;      
    }
    $num_intentos++;
    $sentencia = "UPDATE USUARIOS_ACCESOS set num_intentos = '$num_intentos' WHERE id_usuario = '$id'";
    $registro = $con->query($sentencia);
    
    return true;
}

function resetIntentos($id,$con){
    $sentencia = "UPDATE USUARIOS_ACCESOS set num_intentos = 0 WHERE id_usuario = '$id'";
    $registro = $con->query($sentencia);
}

function bloquearPorIntentos($id,$con){
    $fecha_bloqueo =date("Y-m-d");
    $hora_bloqueo = date('H:i:s');
    $sentencia = "UPDATE USUARIOS_ACCESOS set fecha_bloqueo = '$fecha_bloqueo', hora_bloqueo = '$hora_bloqueo' WHERE id_usuario = '$id'";
    $registro = $con->query($sentencia);
}
?>