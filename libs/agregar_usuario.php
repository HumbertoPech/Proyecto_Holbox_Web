<?php

/**
 * Devuelve id usuario si se hizó la insercción correcta
 */
function agregar($nombre, $correo, $contrasena){
    require("core/Conexion.php");
    $con = new Conexion();
    $conexion = $con->get_conexion();

    $nombre = mysqli_real_escape_string($conexion,$nombre);
    $correo = mysqli_real_escape_string($conexion,$correo);
    $contrasena = mysqli_real_escape_string($conexion,$contrasena);

    $sentencia = "INSERT INTO USUARIOS (nombre_usuario, correo, contrasena) VALUES('$nombre','$correo','$contrasena')";
    $conexion->query($sentencia);
    $affected_rows = $conexion->affected_rows;
    
    
    //Si una fila fue afectada, se insertó un usuario nuevo.
    if($affected_rows > 0){
        $last_id = $conexion->insert_id;

        //Se le asigna por default: Rol = Usuario
        #Se busca el id del rol a insertar
        $sentencia = "SELECT * FROM ROLES WHERE nombre_rol = 'Usuario'";
        $registro = ($conexion->query($sentencia))->fetch_array(MYSQLI_ASSOC);
        $id_rol = $registro['id_rol'];
        #Se inserta el id_usuario y id_rol en la tabla USUARIOS_ROLES
        $sentencia = "INSERT INTO USUARIOS_ROLES(id_usuario,id_rol) VALUES({$last_id},{$id_rol})";
        $conexion->query($sentencia);

        agregarUsuarioAcceso($last_id,$conexion);
    }
    $con->close_conexion();
    return $last_id;
}

function agregarUsuarioAcceso($id, $con){
    $fecha_registro = date("Y-m-d");
    $hora_registro = date('H:i:s');

    $sentencia= "INSERT INTO USUARIOS_ACCESOS(id_usuario, fecha_acceso, hora_acceso, num_intentos) VALUES('$id','$fecha_registro','$hora_registro',0)";

    $con->query($sentencia);
}

?>