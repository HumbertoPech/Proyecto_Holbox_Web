<?php
session_start();
//$_SESSION["tipo_usuario"]= 'proveedor';
//$_SESSION["permisos_especiales"]= array(90,1,14);


$nombre = "";
$redireccion = "catalogo/editar";

if (empty(validarPermisos($nombre))){
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
                        <li><a href="<?php echo $url_base;?>catalogo/iniciarCatalogo"> Catálogo</a></li>
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
           
    //Para los filtros
    function borrarFiltros() {

    }

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