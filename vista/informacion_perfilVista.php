<?php
    session_start();
    $nombre = "";
    $redireccion = "catalogo/editar";

    $nombre = "perfil de usuario";
    $redireccion = "paginas/Inicio";
     $a= validarPermisos($nombre);
    if (empty($a)){   
        header("location:" . $url_base . $redireccion);
    }
?>
<!DOCTYPE html>
<html lang="es-Mx">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilosGenerales.css">
        <script src="<?=$url_base?>resources/js/jquery.min.js"></script>
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montaga'>
        <title>Mi Perfil</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilos_informacion_perfil_usuario.css">          
    </head>
    <body>
    <header class="header-general">
        <div style="padding: 8px 16px; overflow: hidden;">
                <div class="tamano-5" id="logo"><span>HOLBOX</span></div>
                <div class="tamano-5" id="logo-derecho"><span>VIVE UNA EXPERIENCIA SIN IGUAL</span></div>
            </div>
            <div class="menu-general">
                <nav>
                    <ul class ="nav">
                        <li><a href="<?= $url_base ?>paginas/Inicio">Inicio</a></li>
                        <li><a href="">Secciones</a>
                            <ul>
                                <li><a href="<?= $url_base ?>paginas/Historia">Historia</a></li>
                                <li><a href="<?= $url_base ?>paginas/LugaresHolbox">¿Qué hacer?</a></li>
                                <li><a href="<?= $url_base ?>paginas/Gastronomia">Gastronomía</a></li>
                                <li><a href="<?= $url_base ?>paginas/FloraFauna">Flora y Fauna</a></li>
                            </ul>
                        </li>
                        <?php
                        include("libs/manejador_sesiones.php");
                        $menu = get_Menu();

                        foreach( $menu as $opcion => $link){
                            echo "<li><a href=\"$link\">$opcion</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <div id="sesiones">
                <?php
                if(empty($_SESSION)){
                    echo "<label><a href='{$url_base}inicioSesion/iniciarSesion'>Iniciar Sesión  </a></label>";
                    echo "<label><a href='{$url_base}registroUsuario/registrarUsuario'> Registrarse</a></label>";
                }else{
                    echo "<script src = '{$url_base}resources/js/autologout.js'></script>";
                    echo "<label>Bienvenido ".$_SESSION['nombre'] ." </label>";
                    echo "<label><a href='{$url_base}inicioSesion/logout'>Cerrar Sesión </a></label>";
                }
                ?>
            </div>
        </header>     
        <?php
            $usuario = $_SESSION['id_usuario'];
            cargarDatos($usuario);      
        ?>
        <div id="main">
            <h1>Información de mi perfil</h1>
            <div id="container"> 
                <div class='seccion'>
                    <form id="form" method="post" action="" > <br>
                        <label>Nombre:</label><br />
                        <input type='text' name="nombre" id='nombre' value="<?php echo $nombre?>"> <br />
                        <p id='p1'></p><br /><br />

                        <label>Cambiar la contraseña:</label><br />

                        <label>Escribe tu contraseña actual:</label><br />                  
                        <input type='password' name="contrasenaActual" id='contrasena' value=""/><br/>
                        <p id='p2'></p><br /><br />

                        <label>Escribe tu contraseña nueva:</label><br />                  
                        <input type='password' name ="contrasenaNueva" id='contrasenaNueva' name="contrasenaNueva1" /><br />   

                        <label>Escribe tu contraseña nueva de nuevo:</label> <br />                 
                        <input type='password' name="contrasenaNueva2" id='contrasenaNueva2' name="contrasenaNueva2"/><br />                 
                        <p id="p3"></p> <br /><br />

                        
                        <input type="submit" name="submit" value="Aplicar cambios">
                    </form>                                                
                </div>
                <form id="button" method="POST" action="<?=$url_base?>informacionPerfil/eliminarCuenta">
                        <input type="submit" value="Eliminar cuenta" id="boton_eliminar" name="boton_eliminar"/>
                        <?php echo $usuario;?>
                        <input type="hidden" name='id' id="id" value="<?php echo $usuario?>">
                    </form>                 
            </div>
        </div>              
            <?php      
            if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST['nombre']) && !$_POST['nombre']=="" ){
                    $nombreNuevo = $_POST['nombre'];
                    if(isset($_POST['contrasenaActual'])){
                        $contrasenaAVerif = $_POST['contrasenaActual'];
                        $contrasenaNueva = $_POST['contrasenaNueva'];
                        $contrasenaNueva2 = $_POST['contrasenaNueva2'];                        
                        
                        $_SESSION['nombre']= $nombreNuevo;
                        if($contrasenaAVerif=="" && $contrasenaNueva2=="" && $contrasenaNueva==""){  
                            actualizarCampos();
                            //SE MODIFICA SOLO EL NOMBRE y la contraseña antigua
                        }else{
                            if(password_verify($contrasenaAVerif, $contrasena)){
                                if(comprobarContrasenaNueva($contrasenaNueva, $contrasenaNueva2)){
                                    $hash = password_hash($contrasenaNueva, PASSWORD_DEFAULT);
                                    $_SESSION['contrasenaNueva']=$hash;
                                    actualizarCampos();
                                }                                
                            }else{
                                echo "
                                    <script type=\"text/javascript\">
                                    document.getElementById('p2').innerText='Las contraseña que escribiste no coincide con la original';
                                    </script>
                                ";
                            }                            
                        }
                    }else{
                        echo "
                            <script type=\"text/javascript\">
                            document.getElementById('p2').innerText='Contraseña vacia, ingrese caracteres';
                            </script>
                        ";                                                                    
                    }
                }else{
                    echo "
                        <script type=\"text/javascript\">
                        document.getElementById('p1').innerText='Nombre invalido';
                        </script>
                    ";    
                }
            }
            ?>  
        <footer>
            <div id="about">
                <div class="tamano-7" id="menu-footer">
                    <nav>
                        <ul>
                            <li><a href="<?=$url_base?>paginas/Inicio">Inicio</a></li>
                            <li><a href="<?= $url_base ?>paginas/Historia">Historia</a></li>
                            <li><a href="<?= $url_base ?>paginas/LugaresHolbox">¿Qué hacer?</a></li>
                            <li><a href="<?= $url_base ?>paginas/Gastronomia">Gastronomía</a></li>
                            <li><a href="<?= $url_base ?>paginas/FloraFauna">Flora y Fauna</a></li>
                            <?php
                                $menu = get_Menu();

                                foreach( $menu as $opcion => $link){
                                    echo "<li><a href=\"$link\">$opcion</a></li>";
                                }
                            ?>
                        </ul>
                    </nav>
                </div>
                <div class="tamano-5" id="nosotros">
                    <h3>Sobre Nosotros</h3>
                    <ul>
                        <li>Chuc Arcia Alejandro</li>
                        <li>Ancona Graniel Ulises</li>
                        <li>Interian Bojorquez Shaid</li>
                        <li>Pech Huchin Humberto</li>
                        <li>Sosa Lopez Wendy</li>
                    </ul>
                </div>
            </div>
            <p id="copyright">
                Todos los derechos reservados &copy;. Holbox 2018
            </p>
        </footer>
    </body>
</html>
