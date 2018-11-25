<?php
function comprobarEmail($email){
    if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){
        return true;
    }
    return false;
}

function comprobarContrasena($contrasena){
    if(strlen($contrasena) >= 6 && strlen($contrasena) <= 20){
        return true;
    }
    return false;
}

function isError($errores, $campo){
    $return = "";
    if(!empty($errores) && !empty($campo) && isset($errores[$campo]) && !empty($errores[$campo])){
        $return = "<span class='error'>".$errores[$campo]."</span>";
    }
    return $return;
}

?>