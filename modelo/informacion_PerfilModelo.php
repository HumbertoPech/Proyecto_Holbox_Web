<?php

function cargarDatos($id){
    global $bandera, $contrasena, $nombre, $correo;
    /*Carga los datos del usuario*/                
    require_once("core/Conexion.php");
    
    $query = "SELECT * FROM usuarios WHERE id_usuario = $id";      
    $con = new Conexion();
    $conexion = $con->get_conexion();      
    if($conexion){
        $resultado = $conexion->query($query);
        $bandera = false;
        while($row = $resultado->fetch_assoc()){                     
            $bandera = true;
            $contrasena = $row['contrasena'];
            $nombre = $row['nombre_usuario'];
            $correo = $row['correo'];
        }
        if(!$bandera){
            echo "No existe usuario registrado";
        }          
    }
}
function eliminarCuenta($id){
    require_once("core/Conexion.php");
    $con = new Conexion();
    $conexion = $con->get_conexion();
	$query = "UPDATE usuarios SET disponibilidad=false WHERE id_usuario=$id";

    $resultado1 = $conexion->query($query);
    
    $query2 = "UPDATE publicaciones SET disponibilidad=false WHERE id_usuario=$id";
    $resultado2 = $conexion->query($query2);
    if($resultado2 && $resultado1){ //logout
        header("Location:{$url_base}iniciar");
    }else{
        header("Location:{$url_base}iniciar");
        echo "No se elimino";
    }    

}

function actualizarCampos(){
    require_once("core/Conexion.php");
    session_start();
    $con = new Conexion();
    $conexion = $con->get_conexion();
    $id = $_SESSION['id_usuario'];
    $nombre = $_SESSION['nombre'];
    $contrasena = $_SESSION['contrasenaNueva'];
    if($contrasena !=null){
        $query = "UPDATE usuarios SET nombre_usuario='$nombre', contrasena = '$contrasena' WHERE id_usuario='$id'";
        $resultado = $conexion->query($query);
    }else{
        $query = "UPDATE usuarios SET nombre_usuario='$nombre' WHERE id_usuario='$id'";
        $resultado = $conexion->query($query);
    }

}
    
function comprobarContrasenaNueva($contrasenaNueva1,$contrasenaNueva2){
    if($contrasenaNueva1 == $contrasenaNueva2){
        if(strlen($contrasenaNueva1) >= 6 && strlen($contrasenaNueva1) <= 20){
            return true;
        }else{
            echo '<script type="text/javascript"> document.getElementById("p3").innerText = "La contraseña debe tener un tamaño entre 6 y 20 caracteres";  </script>';
            return false;                        
        }
    }else{
        echo '<script type="text/javascript"> document.getElementById("p3").innerText = "La contraseñas no coinciden";  </script>';                    
        return false;
    }
}
function validarUsuario($correo, $contrasena){
    global $url_base,$errores;
    include("libs/comprobar_usuario.php");
    $datos = comprobar_ingreso($correo, $contrasena);
    if(!empty($datos)){
        if(isset($datos['bloqueado'])){
            $errores['bloqueado'] = "Usted ha sido bloqueado, contacté con servicio.";
            return false;
        }
        if(isset($datos['num_intentos'])){
            $errores['num_intentos'] = "Usted ha superado el número máximo de intentos. Usuario bloqueado.";
            return false;
        }
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
?>