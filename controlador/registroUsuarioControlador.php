<?php

function accion_registrarUsuario(){
    global $url_base,$variables_ruta,$errores;
    include('vista/registroUsuarioVista.php');
}

function accion_validar(){
    global $url_base,$variables_ruta,$errores;
    include('modelo/registroUsuarioModelo.php');
    $registroValido = validarRegistro($_POST['nombre'], $_POST['correo'], $_POST['contrasena'], $_POST['repetir_contrasena']);
    if(!$registroValido){
        include("vista/registroUsuarioVista.php");
    }else{
        header("Location:{$url_base}paginas/Inicio");
    }
}

?>