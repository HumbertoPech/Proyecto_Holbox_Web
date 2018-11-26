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

//regresa los permisos en array
function validarPermisos($nombreModulo){
    global $aplicacion, $url_base;    
   
    if( !empty($nombreModulo)){
    // Incluye y crea la conexion para buscar en la bd:
        require_once('libs/consulta_permisos.php');  
        
        //buscando permisos del modulo
        $query = "SELECT p.id_permiso FROM permisos p JOIN modulos m ON p.id_modulo=m.id_modulo 
                  WHERE m.nombre_modulo =" ."'". $nombreModulo ."'";
        
        $permisosModulo= consultarPermisos($query);             
        //buscando permisos del rol:
        $query= "SELECT rp.id_permiso FROM roles_permisos rp JOIN roles r ON rp.id_rol=r.id_rol 
                  WHERE r.nombre_rol =" ."'". $_SESSION["tipo_usuario"] ."'";
        $permisosRol= consultarPermisos($query);
        //uniendo permisos del rol con permisos especiales.
        $permisosRecibidos=array_unique(array_merge($permisosRol, 
                            array_keys($_SESSION['permisos_especiales'])));     
        //El usuario tiene almenos un permisos del modulo.
        $permisosUsuario=array_intersect($permisosModulo, $permisosRecibidos);
        
        $consulta= array();
        foreach ($permisosUsuario as $idpermiso) {
            array_push($consulta, 'id_permiso= '.$idpermiso);
        }
        $consulta= implode(" OR ", $consulta);

        $query= "SELECT * FROM permisos  WHERE " . $consulta;
        return consultar($query);
    }
    return array();
          
}

?>