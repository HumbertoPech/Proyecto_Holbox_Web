<?php
session_start();
$_SESSION["tipo_usuario"]= 'proveedor';
$_SESSION["permisos_especiales"]= array(12 => "editar restaurante" ,
    18 => "eliminar restaurante");

$nombre = "catalogo de restaurantes";
$redireccion = "catalogo/iniciarCatalogo";
 
if (empty(validarPermisos($nombre);)){   
    header("location:" . $url_base . $redireccion);        
}else{
    echo "puedes pasar";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php  echo $aplicacion;?> </title>
    <link rel="stylesheet" href="<?php echo $url_base;?>resources/css/estilos_catalogo.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $url_base;?>resources/css/estilosGenerales.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montaga" rel="stylesheet">

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
                        <li><a href="<?php echo $url_base;?>catalogo/editar"> Catálogo</a></li>
                         <?php
                        $toinclude ="01_CARPETAS Y ARCHIVOS EN DISPUTA/sistemas/sistema_login/manejador_sesiones.php";
                        include($toinclude);                        
                        $menu = get_menu();

                        foreach( $menu as $opcion => $link){
                            $link = "../".$link;
                            echo "<li><a href=\"$link\"> $opcion</a></li>" ;
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


<!--.contenido-->
<div id="contenido">

    <!--Seccion Navegacion -->
    <div class="nav-bar">
        <div class="restaurante-filtro">
            <span> Configuraciones</span>           
        </div>
        <div class="flex-container flex-catalogo" id="content-area">            
            <button class="tablinks" onclick="abrirConfig(event, 'agregar')" 
                    id="defaultOpen">Agregar restaurante</button>

            <button class="tablinks" onclick="abrirConfig(event, 'eliminar')" 
                    id="defaultOpen">Eliminar restaurante</button>

           <button class="tablinks" onclick="abrirConfig(event, 'editar')" 
                    id="defaultOpen">Editar restaurante</button>
         </div>        
    </div>
    
    <article class="seccion " id="catalogo">
        <div>
            <span> Bienvenido al editor de restaurantes</span>           
        </div>
         <div class="flex-container flex-catalogo" id="content-area">
         </div>
         <div id="agregar" class="tabcontent">
           <h3>Agrega un restaurante</h3>
           <p>London is the capital city of England.</p>
    </div>
    <div id="eliminar" class="tabcontent">
                <h3>Elimina un restaurante</h3>
                <p>London is the capital city of England.</p>
    </div>

    <div id="editar" class="tabcontent">
                <h3>Edita un restaurante</h3>
    </div>


    </article>
   

</div>

<footer>
    <div id="about">
        <div class="tamano-7" id="menu-footer">
            <nav>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Historia</a></li>
                    <li><a href="#">¿Qué hacer?</a></li>
                    <li><a href="#">Gastronomía</a></li>
                    <li><a href="#">Flora y Fauna</a></li>
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

<script type="text/javascript">
     
   function abrirConfig(evt, nombreConfig) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(nombreConfig).style.display = "block";
    evt.currentTarget.className += " active";
}

</script>

</body>
</html>