<?php
    session_start();
    if(isset($_SESSION['id_usuario'])){
        if($_SESSION['tipo_usuario'] != 'usuario'){
            echo "No tienes permitido entrar a esta página";
            exit();
        }
    }else{
        header("Location:../../sistemas/sistema_login/login.php");
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">             
        <title>Mi Perfil</title>
        <link rel="stylesheet" href="../../archivos_necesarios/css/estilosModal_perfil_usuario.css">
        <link rel="stylesheet" href="../../archivos_necesarios/css/estilosGenerales.css">    
        <link rel="stylesheet" href="../../archivos_necesarios/css/estilos_perfil_usuario.css">        
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
                        <li><a href="../../inicio.php">Inicio</a></li>
                        <li><a href="">Secciones</a>
                            <ul>
                                <li><a href="../Historia.php">Historia</a></li>
                                <li><a href="../LugaresHolbox.php">¿Qué hacer?</a></li>
                                <li><a href="../Gastronomia.php">Gastronomía</a></li>
                                <li><a href="../FloraFauna.php">Flora y Fauna</a></li>
                            </ul>
                        </li>
                        <li><a href="../experienciasH.php">Experiencias</a></li>
                        <li><a href="../catalogo.php">Catálogo</a></li>

                        <?php
                        include("../../sistemas/sistema_login/manejador_sesiones.php");
                        $menu = get_Menu();

                        foreach( $menu as $opcion => $link){
                            $link = "../../".$link;
                            echo "<li><a href=\"$link\">$opcion</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <div id="sesiones">
                <?php
                if(empty($_SESSION)){
                    echo "<label><a href='../../sistemas/sistema_login/login.php'>Iniciar Sesión  </a></label>";
                    echo "<label><a href='../../sistemas/sistema_signup/signup.php'> Registrarse</a></label>";
                }else{
                    echo "<label>Bienvenido ".$_SESSION['nombre'] ." </label>";
                    echo "<label><a href='../../sistemas/sistema_login/logout.php'>Cerrar Sesión </a></label>";
                }
                ?>
            </div>
        </header>          
    <!-- Se muestran las imagenes en una tabla-->
        <center><br><br><br>
            <a href="../paginas_usuarios/informacion_perfil.php"> Ver mi información </a>
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
                /*Carga las imagenes del usuario*/                
                include("../../config/conexion2.php");
                include("../../funciones/base_de_datos/proceso_guardar_imagen.php");
                
                $usuario = $_SESSION['id_usuario'];
                $query = "SELECT * FROM publicaciones WHERE id_usuario = '$usuario'";                   
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
                        ?>
                            <div class="galeria">
                                <h1>Mis publicaciones</h1>                           
                                <div class="linea"></div>
                                <div class="contenedor-imagenes"> 
                        <?php                        
                            $publicacionesCount = count($arrayPublicaciones);
                            for($i=$publicacionesCount-1;$i>=0;$i--){                               
                            ?>  <div class="imagen">
                                <img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);?>" alt=""/>                                                           
                                    <a href="#<?php echo $arrayPublicaciones[$i]['id'];?>">
                                    <div class="overlay">
                                        <h2><?php echo $arrayPublicaciones[$i]['comentario']; ?></h2>
                                    </div></a>
                                </div>
                            <?php                                       
                            }
                            ?>
                                </div> <!--fin de div contenedor-imagenes-->
                            </div> <!--fin de div galeria-->
                            
                            <?php
                            for($i=$publicacionesCount-1;$i>=0;$i--){                                                                   
                                $picture = base64_encode($arrayPublicaciones[$i]['imagen']);
                                $img = "data:image/jpg;base64,".$picture;
                                try {
                                    list($width, $height, $type, $attr) = getimagesize($img);                                
                                    $diferencia = $width-$height;
                                    if($diferencia<=220 || ($diferencia>=-220 && $diferencia<=0)){
                                        ?>
                                        <div class="modal" id="<?php echo $arrayPublicaciones[$i]['id'];?>">
                                            <div class="imagenModal">
                                                <p><?php echo $arrayPublicaciones[$i]['comentario']; ?></p>
                                                <img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);?>">
                                            </div> 
                                                <a class="cerrar" href="#galeria">X</a>
                                                
                                                <form method="POST" action="../../funciones/base_de_datos/proceso_eliminar_imagen.php" onsubmit="onEnviar(<?php echo $arrayPublicaciones[$i]['id'];?>)" enctype="multipart/form-data">
                                                    <input id="variable<?php echo $arrayPublicaciones[$i]['id'];?>" name="variable" type="hidden" />
                                                    <input class="boton" type="submit" value="Eliminar publicacion"/>
                                                </form>              
                                                
                                        </div>
                                    <?php
                                    }
                                    if($diferencia>0){/*Horizontal*/?>
                                        <div class="modal" id="<?php echo $arrayPublicaciones[$i]['id'];?>">
                                            <div class="imagenModal1">
                                                <p><?php echo $arrayPublicaciones[$i]['comentario']; ?></p>
                                                <img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);?>">
                                            </div> 
                                                <a class="cerrar" href="#galeria">X</a> 
                                                
                                                <form method="POST" action="../../funciones/base_de_datos/proceso_eliminar_imagen.php" onsubmit="onEnviar(<?php echo $arrayPublicaciones[$i]['id'];?>)" enctype="multipart/form-data">
                                                    <input id="variable<?php echo $arrayPublicaciones[$i]['id'];?>" name="variable" type="hidden" />
                                                <input class="boton" type="submit" value="Eliminar publicacion"/>
                                            </form>                                                         
                                        </div>
                                    <?php    
                                    }else{/*Modal vertical*/
                                        ?>
                                        <div class="modal" id="<?php echo $arrayPublicaciones[$i]['id'];?>">
                                            <div class="imagenModal">
                                                <p><?php echo $arrayPublicaciones[$i]['comentario']; ?></p>
                                                <img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);?>">
                                            </div> 
                                                <a class="cerrar" href="#galeria">X</a>
                                                
                                            <form method="POST" action="../../funciones/base_de_datos/proceso_eliminar_imagen.php" onsubmit="onEnviar(<?php echo $arrayPublicaciones[$i]['id'];?>)" enctype="multipart/form-data">
                                                    <input id="variable<?php echo $arrayPublicaciones[$i]['id'];?>" name="variable" type="hidden" />
                                                <input class="boton" type="submit" value="Eliminar publicacion"/>
                                            </form>                                                     
                                        </div>
                                        <?php
                                    } 



                                } catch (Exception $e) {
                                    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
                                }                                                                    
                            }
                    }
                }else{
                    echo "Conexion con la base de datos fallida";
                }
                ?>
        </center> 
            <footer>
            <div id="about">
                <div class="tamano-7" id="menu-footer">
                    <nav>
                        <ul>
                            <li><a href="../inicio.php">Inicio</a></li>
                            <li><a href="../Historia.php">Historia</a></li>
                            <li><a href="../LugaresHolbox.php">¿Qué hacer?</a></li>
                            <li><a href="../Gastronomia.php">Gastronomía</a></li>
                            <li><a href="../paginas/FloraFauna.php">Flora y Fauna</a></li>
                            <li><a href="../experienciasH.php">Experiencias</a></li>
                            <li><a href="../catalogo.php">Catálogo</a></li>
                            <?php
                                $menu = get_Menu();

                                foreach( $menu as $opcion => $link){
                                    $link = "../../".$link;
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