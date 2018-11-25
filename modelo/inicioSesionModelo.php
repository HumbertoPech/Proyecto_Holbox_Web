<?php

//include("../../funciones/funciones_comprobacion.php");
function validarUsuario($correo, $contrasena){
    global $url_base,$errores;
    include("libs/comprobar_usuario.php");
    $datos = comprobar_ingreso($correo, $contrasena);
    if(!empty($datos)){
        session_start();
        $_SESSION['id_usuario'] = $datos['id_usuario'];
        $_SESSION['nombre'] = $datos['nombre'];
        $_SESSION['correo'] = $datos['correo'];
        $_SESSION['tipo_usuario'] = $datos['tipo_usuario'];
        $_SESSION['permisos_especiales'] = $datos['permisos_especiales'];
        return true;
    }else{
        $errores['no_login'] = "Comprueba tu correo y contraseña";
        return false;
    }
}

//$errores = array();
?>