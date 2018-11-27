<?php
session_start();
/*El feed todos lo pueden ver
    if(isset($_SESSION['id_usuario'])){
    if($_SESSION['tipo_usuario'] != 'administrador'){
        echo "No tienes permitido entrar a esta página";
        exit();
    }
}else{
    //header("Location:../sistemas/sistema_login/login.php");
}*/
?>
<!DOCTYPE html>
<html lang="es-Mx">
    <head>
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilos_feed.css">   
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?=$url_base?>resources/css/estilosGenerales.css">
        <script src="<?=$url_base?>resources/js/jquery.min.js"></script>
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montaga'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Feed</title>
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
        <div id="contenido">

            <!-- The Modal -->
            <div id="myModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01">
                <div id="caption"></div>
            </div>

            <!--Seccion FLORA -->

            <div class="seccion" id="flora">
                <div class="titulo">
                    <h1 id="titulo-flora">
                    <span> FEED</span>
                    </h1>
                </div>
                    <?php
                    /*Carga las imagenes de LOS USUARIOS*/
                    cargarFeed();
                    ?>                 
                
            </div>
        </div>  

        <script>
            let divGroup = document.getElementsByClassName('contenedor-flora');

            for (let i=0; i< divGroup.length; i++) {
                let divElement = divGroup[i]
                divElement.addEventListener('click',expandirInfo,false);
            }

            // Get the modal


            function expandirInfo(){
        //obtener span de informacion del div principal que contiene el span
                let inf= this.getElementsByClassName("infoAdicional");
                let informacion= inf[0];

                //obtener imagen del div principal
                let imagenes= this.getElementsByTagName("img");
                let imagen= imagenes[0];
                // Get the image and insert it inside the modal - use its "alt" text as a caption
                llamarModal(imagen,informacion);

            }

            const modal = document.getElementById('myModal');
            //variables img y caption del modal
            let modalImg = document.getElementById("img01");
            let captionText = document.getElementById("caption");

            //Modificar el contenido del modal
            function llamarModal(imagen,informacion){
                modal.style.display = "block";
                modalImg.src = imagen.src;
                captionText.innerHTML = informacion.textContent;
            }

            // Get the <span> element that closes the modal
            let spanMod = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            spanMod.onclick= function close() {
                modal.style.display = "none";
            }

        </script>        
        
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