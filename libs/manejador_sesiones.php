<?php
//session_start();
function get_menu(){
    #verificar si hay  sesion activa
    global $url_base;
    $menu = array();
    
    #experienciasm catalogo y feed será visible para todos
    $menu['Feed'] = $url_base . "feed/iniciar";
    $menu['Experiencias'] = $url_base . "experiencias/iniciar";
    $menu['Catalogo'] = $url_base . "catalogo/iniciar";
    
    #Hacer $modulos global
    $modulos = array(
        "calendario de eventos" =>  "calendario/iniciar",
        "mis publicaciones" => "publicaciones/iniciar",
        "perfil de usuario" => "perfil/iniciar",
        "catalogo de restaurantes" => "catalogo/iniciar",
        "experiencias" => "experiencias/iniciar",
        "recuperacion de cuenta" => "recuperacionCuenta/iniciar",
        "administracion de usuarios" => "administracionUsuarios/iniciar"
    );
    $nombre_modulos = array(
        "calendario de eventos" =>  "Gestionar Eventos",
        "mis publicaciones" => "Mis publicaciones",
        "perfil de usuario" => "Perdil",
        "catalogo de restaurantes" => "Catalogo de restaurantes",
        "experiencias" => "Experiencias",
        "recuperacion de cuenta" => "Recuperacion cuenta",
        "administracion de usuarios" => "Administracion de Usuarios"
    );
    
    foreach( $modulos as $key => $contenido){
        $temp = validarPermisos($key);
        
        
            if(!empty($temp)){
                $menu[$nombre_modulos[$key]] = $url_base.$contenido;
            }
    }
    

    return $menu;
}


?>
