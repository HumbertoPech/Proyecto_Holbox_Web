<?php
    session_start();
    //($_SESSION['tipo_usuario'])
?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="<?=$url_base?>resources/css/estilosGenerales.css">
    <script src="<?=$url_base?>resources/js/jquery.min.js"></script>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montaga'>
    <meta lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo  $aplicacion; ?></title>
    
    <style>
        h1{
            text-align:center;
        }
        form{
            margin: 2% 0 0 2%;
        }
        label{
            display: inline-block;
            /*text-align: right;*/
            width: 100px;
            /*border: solid black 1px;*/
        }
        input[type="text"], textarea{
            display:block;
            font-size:24px;
        }
        input[type="submit"]{
            height: 30px;
            width:100px;
            font-size:20px;
        }
        textarea{
            height: 150px;
            width:65%;
            resize:none;
            margin-bottom:10px;
        }
        
        .usuario{
            margin-top:1px;
            margin-bottom:7px;
            font-weight: bold;
        }
        .comment{
            margin-bottom:0;
        }

    .parrafo{
        display: inline-block;
            width: 65%;
            padding: 5px;
        border: solid lightblue 1px;
    }
    </style>
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

    <h1>Experiencias Holbox</h1>
    <script type="text/javascript">

        
    </script>
    
    <form   action= "<?php echo $url_base;?>experiencias/hacerComentario" method="post">        
            <?php
                if(isset($_SESSION['tipo_usuario'])){//escribir comentario
                    if (!empty(validarPermisos("experiencias"))){
                        $arreglo = validarPermisos("experiencias");
                        
                        //$_SESSION['']
                        if($arreglo[0]['nombre_permiso'] == "crear comentario"){

                            echo "<div>
                            <label style=\"font-size:30px; font-weight: bold;\">".$_SESSION['nombre'] ." </label>
                            </div>
                            <div>
                            <label>Comentar</label>
                            <textarea name=\"comment\" placeholder=\"Escriba su experiencia\" required></textarea>
                            <input type=\"submit\" name=\"aceptar\" value=\"Comentar\">
                            </div>";
                        }
                    }
                    
                        
                    
                }
            ?>
    </form>
    
    
</body>
</html>

<?php
show_comments();
function show_comments(){
    global $url_base;
    $comentarios = consultarComentarios();
    $claseDiv = "class=\"parrafo\"";
    $claseUsu = "class=\"usuario\"";
    $claseCom = "class=\"comment\"";
        
    echo "<div><p style=\"display:block;\">Comentarios</p></div>";
    $eliminacion = "";//Agrega los botones de "eliminar" al comentario
    if (isset($_SESSION['tipo_usuario'])){
        if (!empty(validarPermisos("experiencias"))){
            $arreglo = validarPermisos("experiencias");
            
            if($arreglo[0]['nombre_permiso'] == "eliminar comentario"){//comprueba que lo contenga
                
                $eliminacion = "<input type=\"submit\" name=\"eliminar\" value=\"Eliminar\" style=\"float:right\">";
            }
        }
        
    }
        
    for ($i=0; $i < count($comentarios); $i++) { 

        $nombreComentario = $comentarios[$i]['nombre_usuario'];
        $comment = $comentarios[$i]['comentario'];
        $id_comentario = $comentarios[$i]['id_comentario'];

        $input_hidden = "<input type=\"hidden\" name=\"id_com\" value=\"$id_comentario\">";
        echo "<div $claseDiv><form action= '".$url_base."experiencias/eliminarComentario' method=\"POST\">".$eliminacion.$input_hidden."<p $claseUsu>$nombreComentario</p>
        <p $claseCom>$comment</p></form></div>".PHP_EOL;
        
    }
}
//hace el footer
    echo "<footer>" .
    "            <div id=\"about\">" .
    "                <div class=\"tamano-7\" id=\"menu-footer\">." .
    "                    <nav>" .
    "                        <ul>" .
    "                            <li><a href=\"".$url_base."paginas/Inicio\">Inicio</a></li>" .
    "                            <li><a href=\"".$url_base."paginas/Historia\">Historia</a></li>" .
    "                            <li><a href=\"\"".$url_base."paginas/LugaresHolbox\">¿Qué hacer?</a></li>" .
    "                            <li><a href=\"\"".$url_base."paginas/Gastronomia\">Gastronomía</a></li>" .
    "                            <li><a href=\"\"".$url_base."paginas/FloraFauna\">Flora y Fauna</a></li>";
                            $menu = get_Menu();

                            foreach( $menu as $opcion => $link){
                                echo "<li><a href=\"$link\">$opcion</a></li>";
                            }

    echo "                   </ul>" .
    "                    </nav>" .
    "                </div>" .
    "                <div class=\"tamano-5\" id=\"nosotros\">" .
    "                    <h3>Sobre Nosotros</h3>" .
    "                    <ul>" .
    "                        <li>Chuc Arcia Alejandro</li>" .
    "                        <li>Ancona Graniel Ulises</li>" .
    "                        <li>Interian Bojorquez Shaid</li>" .
    "                        <li>Pech Huchin Humberto</li>" .
    "                        <li>Sosa Lopez Wendy</li>" .
    "                    </ul>" .
    "                </div>" .
    "            </div>" .
    "            <p id=\"copyright\">" .
    "                Todos los derechos reservados &copy;. Holbox 2018" .
    "            </p>" .
    "        </footer>";
    
?>