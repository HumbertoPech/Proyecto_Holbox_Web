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
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link href="https://fonts.googleapis.com/css?family=Montaga" rel="stylesheet">   
    <link rel="stylesheet" href="../archivos_necesarios/css/estilosGenerales.css">    
    <link rel="stylesheet" href="../archivos_necesarios/css/estilos_feed.css">
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
                        <li><a href="../inicio.php">Inicio</a></li>
                        <li><a href="">Secciones</a>
                            <ul>
                                <li><a href="Historia.php">Historia</a></li>
                                <li><a href="LugaresHolbox.php">¿Qué hacer?</a></li>
                                <li><a href="Gastronomia.php">Gastronomía</a></li>
                                <li><a href="FloraFauna.php">Flora y Fauna</a></li>
                            </ul>
                        </li>
                        <li><a href="experienciasH.php">Experiencias</a></li>
                        <li><a href="catalogo/iniciarCatalogo">Catálogo</a></li>
                        <?php
                        include("../sistemas/sistema_login/manejador_sesiones.php");
                        $menu = get_Menu();

                        foreach( $menu as $opcion => $link){
                            $link = "../".$link;
                            echo "<li><a href=\"$link\">$opcion</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <div id="sesiones">
                <?php
                if(empty($_SESSION)){
                    echo "<label><a href='../sistemas/sistema_login/login.php'>Iniciar Sesión  </a></label>";
                    echo "<label><a href='../sistemas/sistema_signup/signup.php'> Registrarse</a></label>";
                }else{
                    echo "<label>Bienvenido ".$_SESSION['nombre'] ." </label>";
                    echo "<label><a href='../sistemas/sistema_login/logout.php'>Cerrar Sesión </a></label>";
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
                    include("../config/conexion2.php");       
                    $query = "SELECT * FROM publicaciones";                   
                    if($conexion){
                        $arrayPublicaciones = array();
                        $resultado = $conexion->query($query);
                        $bandera = false;
                        while($row = $resultado->fetch_assoc()){                     
                            $bandera = true;
                            $arrayPublicaciones[]=$row;
                        }
                        if(!$bandera){
                            echo "No hay publicaciones para mostrar";
                        }else{                       
                            $publicacionesCount = count($arrayPublicaciones);
                            ?><div class="flex-container flex-flora"><?php
                            for($i=$publicacionesCount-1;$i>=0;$i--){                               
                            ?>  
                                <div class="contenedor-flora">
                                    <img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);?>" alt="mangle" style="width:90%"/>                                                           
                                    <div class="descripcion" >
                                        <p><?php echo "Usuario ".$arrayPublicaciones[$i]['id_usuario'].": ";echo $arrayPublicaciones[$i]['comentario']; ?></p>
                                    </div>
                                    <span class="infoAdicional">
                                        <?php echo "Usuario ".$arrayPublicaciones[$i]['id_usuario'].": " ?>
                                        <?php echo $arrayPublicaciones[$i]['comentario']; ?>
                                    </span>
                                </div>                                           
                            <?php                                       
                            }?>
                            </div>
                            <?php
                        }
                    }else{
                        echo "Conexion con la base de datos fallida";
                    }
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
                            <li><a href="../inicio.php">Inicio</a></li>
                            <li><a href="Historia.php">Historia</a></li>
                            <li><a href="LugaresHolbox.php">¿Qué hacer?</a></li>
                            <li><a href="Gastronomia.php">Gastronomía</a></li>
                            <li><a href="FloraFauna.php">Flora y Fauna</a></li>
                            <li><a href="experienciasH.php">Experiencias</a></li>
                            <li><a href="catalogo/iniciarCatalogo">Catálogo</a></li>
                            <?php
                                $menu = get_Menu();

                                foreach( $menu as $opcion => $link){
                                    $link = "../".$link;
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