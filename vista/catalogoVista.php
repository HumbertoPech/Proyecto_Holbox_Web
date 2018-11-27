<?php
session_start();
$nombre = "";
$redireccion = "catalogo/editar";

if (empty(validarPermisos($nombre))){
}else{
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
    <title> <?php  echo $aplicacion;?> </title>
    
    <link rel="stylesheet" href="<?php echo $url_base;?>resources/css/estilosGenerales.css" type="text/css">
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


<!--.contenido-->
<div id="contenido">
    

    <!--Seccion CATALOGO -->
    <div class="nav-bar">
        <div class="restaurante-filtro">
            <span> Selecciona tu restaurante</span>
           
        </div>

        <form id="filtros-restaurantes">

            <div class="restaurante-filtro" name="filtro-tipo">
                <div class="titulo-filtro"> Tipo de restaurante</div>
                <input type="checkbox" name="tipoRest[]" value="Bares" /> Bares y discos<br />
                <input type="checkbox" name="tipoRest[]" value="Restaurantes" /> Restaurantes<br />
                <input type="checkbox" name="tipoRest[]" value="Postres" /> Postres<br />

            </div>

            <div class="restaurante-filtro" name="filtro-precio">
                <div class="titulo-filtro"> Precio</div>
                <input type="checkbox" name="precioRest[]" value="Costoso" /> $$$<br />
                <input type="checkbox" name="precioRest[]" value="Medio" /> $$<br />
                <input type="checkbox" name="precioRest[]" value="Economico" /> $<br />
            </div>

           <input type="button" id="buscar" name="buscar" value="Buscar" onclick="buscarRestaurantes()" />
        </form>

    </div>


    <article class="seccion " id="catalogo">
         <div class="flex-container flex-catalogo" id="catalog-grid">
            <?php echo $catalogoPrincipal;?>
         </div>
    </article>
</div>

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

<script type="text/javascript">
           
    function buscarRestaurantes() {

    	let checkboxTipo = document.getElementsByName("tipoRest[]");
        let checkboxPrecio= document.getElementsByName("precioRest[]");

        let formData = new FormData();
        for(let i=0; i<checkboxTipo.length; i++)
        {
            if(checkboxTipo[i].checked){
                formData.append(checkboxTipo[i].name, checkboxTipo[i].value);
            }
        }
        for(let i=0; i<checkboxPrecio.length; i++)
        {
            if(checkboxPrecio[i].checked){
                formData.append(checkboxPrecio[i].name, checkboxPrecio[i].value);
            }
        }
        let xmlhttp = new XMLHttpRequest();


        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	 document.getElementById("catalog-grid").innerHTML= xmlhttp.responseText;
            }else if (xmlhttp.status == 400) {

              alert('There was an error 400');
           }
        };

        xmlhttp.open("POST", "<?php echo $url_base;?>catalogo/buscarRestaurante", true);
        xmlhttp.send(formData);
    }

</script>

</body>
</html>