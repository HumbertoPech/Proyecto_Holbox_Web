<?php
function validarRegistro($nombre,$correo,$contrasena,$repetir_contrasena){
    global $url_base, $errores;
    //include("libs/funciones_comprobacion.php");

    //Comprobaciones antes de enviarselo a la base de datos.
    if(strlen($nombre) < 6){
        $errores['nombre'] = "El nombre debe de ser de almenos 6 carácteres.";
    }
    if(!comprobarEmail($correo)){
        $errores['correo'] = "El correo debe tener un formato.";
    }
    if(!comprobarContrasena($contrasena)){
        $errores['contrasena'] = "La contraseña debe ser mínimo 6 carácteres y máximo 20";
    }else{
        $contrasena_cifrada = password_hash($contrasena,PASSWORD_DEFAULT);
    }
    if($contrasena != $_POST['repetir_contrasena']){
        $errores['repetir_contrasena'] = "Las contraseñas no coinciden.";
    } 

    //Si todo está correcto, enviarlo a la base de datos
    if(empty($errores)){
        include("libs/agregar_usuario.php");
        $last_id = agregar($nombre, $correo, $contrasena_cifrada);
        if(!empty($last_id)){
            //Al momento de registrarse. El tipo de usuario será Usuario
            session_start();
            $_SESSION['id_usuario'] = $last_id;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['correo'] = $correo;
            $_SESSION['tipo_usuario'] = "Usuario";
            $_SESSION['permisos_especiales'] = array();
            return true;
            //header('Location:../../inicio.php');
            //include("../sistema_login/manejador_sesiones.php");
        }else{
            $errores['correoExists'] = "El correo ya se encuentra registrado.";
        }
    }
    return false;
}
?>