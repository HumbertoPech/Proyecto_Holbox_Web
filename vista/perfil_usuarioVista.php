<?php
    session_start();
    $nombre = "";
    $nombre = "mis publicaciones";
    $redireccion = "paginas/Inicio";
     $a= validarPermisos($nombre);

    if (empty($a)){   
        header("location:" . $url_base . $redireccion);
    }
?>

<html lang="es-Mx">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">             
        <title>Mi Perfil</title>
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilosModal_perfil_usuario.css">
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilosGenerales.css">    
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilos_perfil_usuario.css">        
        <link href="https://fonts.googleapis.com/css?family=Montaga" rel="stylesheet">          
    </head>
    <body>
        <script type="text/javascript">        
            function onEnviar(i){
                document.getElementById("variable"+i).value= i;
            }
            
        </script>        
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
    <!-- Se muestran las imagenes en una tabla-->
        <center><br><br><br>
        <div class="container">           
            <form action="" method="POST" enctype ="multipart/form-data">
                <input type="file" name="imagen" required=""/>
                <br><br>
                <div class="comment">
                    <div class="comment-text-area">
                      <textarea name="comentario" class="textinput"  maxlength="200" rows="4" placeholder="Escriba un comentario"></textarea>
                    </div>
                </div>
                <br><br>
                <input class="button" type="submit" name="submit_post" value="Subir publicación"/>              
            </form>           
        </div>
        </center>
        <center><br><br><br>
                <?php
                    cargarImagenes($_SESSION['id_usuario']);
                ?>
        </center> 

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