<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="../archivos_necesarios/css/estilosGenerales.css">    
    <link rel="stylesheet" href="../archivos_necesarios/css/estilos_catalogo.css">
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


<!--.contenido-->
<div id="contenido">
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>

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


    <article class="seccion" id="catalogo">
         <div class="flex-container flex-catalogo" id="catalog-grid">

         </div>
    </article>

</div>

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

<script>
    let divGroup = document.getElementsByClassName('contenedor-restaurante');

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
      
        formData.append("buscar","Buscar");

        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	 document.getElementById("catalog-grid").innerHTML= xmlhttp.responseText;
            }
        };
        xmlhttp.open("POST", "busquedaRestaurantes.php", true);
        xmlhttp.send(formData);
    }

</script>

</body>
</html>