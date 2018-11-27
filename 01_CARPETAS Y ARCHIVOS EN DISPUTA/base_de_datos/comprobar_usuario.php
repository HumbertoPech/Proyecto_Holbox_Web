<?php
require ("../../config/Conexion.php");

function comprobar_ingreso($correo, $contrasena){
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
            $datos['nombre'] = $registro['nombre'];
            $datos['correo'] = $registro['correo'];
            //$datos['contrasena'] = $registro['contrasena'];
            $datos['tipo_usuario'] = $registro['tipo_usuario'];
        } 
    }

    $con->close_conexion();

    return $datos;
}
?>