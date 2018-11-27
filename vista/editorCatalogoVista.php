<?php
session_start();
$_SESSION["tipo_usuario"]= 'usuario';
$_SESSION["id_usuario"]= "1";
$_SESSION["permisos_especiales"]= array(10 => "editar restaurante" ,
    11 => "eliminar restaurante");

$nombre = "catalogo de restaurantes";
$redireccion = "catalogo/iniciarCatalogo";
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
    <!--Seccion Navegacion -->
    <div class="nav-bar">
        <div class="restaurante-filtro">
            <span> Configuraciones</span>           
        </div>
        <div class="flex-container flex-catalogo" id="content-area">            
            <button class="tablinks" onclick="abrirConfig(event, 'agregar')" 
                    id="defaultOpen">Agregar restaurante</button>

            <button class="tablinks" id= "tabEliminar" onclick="abrirConfig(event, 'eliminar')">
                    Eliminar restaurante</button>

           <button class="tablinks" onclick="abrirConfig(event, 'editar')">Editar restaurante</button>
         </div>        
    </div>
    
    <article class="seccion " id="catalogo">
        <div>
            <span> Bienvenido al editor de restaurantes</span>           
        </div>

        <div id="agregar" class="tabcontent" >
           <h3>Agrega un restaurante</h3>
           <div class="container">

            <form  id="agregarForm" name="agregarForm" method="post" action="<?php echo  $url_base?>catalogo/agregarRestaurante" enctype= "multipart/form-data">

                <div class="row"> 
                <input type="text" id="nombrerest" name="id_usuario" 
                        value= "<?php echo $_SESSION['id_usuario']?>" style="display: none;"> 

                  <div class="col-25">
                    <label for="nombre">Nombre Restaurante</label>
                  </div>
                  <div class="col-75">
                    <input type="text" id="nombrerest" name="nombre_restaurante" placeholder="Nombre de tu restaurante.." required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-25">
                    <label for="tel">Telefono</label>
                  </div>
                  <div class="col-75">
                    <input type="text" id="telefonorest" name="telefono_restaurante" placeholder="Telefono.." required>
                  </div>
                </div>

                 <div class="row">
                  <div class="col-25">
                    <label for="hora">Horarios</label>
                  </div>
                  <div class="col-75">
                    De <input type="time" id="horarioAbierto" name= "horario_abierto">
                    a <input type="time" id="horarioCerrado" name="horario_cerrado">
                  </div>
                </div>

                <div class="row">
                  <div class="col-25">
                    <label for="precio">Precio</label>
                  </div>
                  <div class="col-75">
                    <select id="preciorest" name="precio" required>
                      <option value="Costoso">Costoso</option>
                      <option value="Medio">Medio</option>
                      <option value="Economico">Economico</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-25">
                    <label for="tipo">Tipo </label>
                  </div>
                  <div class="col-75">
                    <select id="tiporest" name="tipo_restaurante" required>
                      <option value="Restaurantes">Restaurantes</option>
                      <option value="Bares">Bares</option>
                      <option value="Postres">Postres</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-25">
                    <label for="descripcion">Descripcion</label>
                  </div>
                  <div class="col-75">
                    <textarea id="descripcionrest" name="descripcion_restaurante" placeholder="Describa el lugar.." style="height:200px"></textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="col-25">
                    <label for="imagen">Sube una foto</label>
                  </div>
                  <div class="col-75">                   
                    <input type="file" id= "imgrest" name="imagen_restaurante" required>
                  </div>
                  <div id="image-preview"></div>
                </div>
                <div class="row">
                  <input type="submit" value="Agregar" onsubmit=" return validateForm()">
                </div>
              </form>
           </div>
        </div>
 
    <div id="eliminar" class="tabcontent" >
                <h3>Elimina un restaurante</h3>
          <form  id="eliminarRest" name="eliminarRest">
                <div class="row">
                  <div class="col-25">
                    <label for="tipo">Tipo </label>
                  </div>
                  <div class="col-75">
                    <select id="listaRest" name="nombreRestaurante" required>
                        <?php  obtenerListado(); ?>
                    </select>
                  </div>
                </div>                
                <div class="row">
                  <input type="button" value="eliminar" onclick= "eliminarRestaurantes('listaRest')">
                </div>
              </form>      
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
     // Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

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

function validateForm() {
    var fileInput = document.getElementById('imgrest');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Solo sube fotos con extension .jpeg/.jpg/.png ');
        fileInput.value = '';
        return false;
    }
    return true;  
}
function eliminarRestaurantes(nombreRestaurante) {

        var seleccion = document.getElementById('listaRest');
        let xmlhttp = new XMLHttpRequest();


        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                 alert(xmlhttp.responseText);
                 document.getElementById("tabEliminar").click();
            }else if (xmlhttp.status == 400) {

              alert('There was an error 400');
           }
        };
            let formData = new FormData();

        $id= seleccion.options[seleccion.selectedIndex].value;
        formData.append("id_restaurante", $id);
        xmlhttp.open("POST", "<?php echo $url_base;?>catalogo/eliminarRestaurante", true);
        xmlhttp.send(formData);
    }



</script>

</body>
</html>