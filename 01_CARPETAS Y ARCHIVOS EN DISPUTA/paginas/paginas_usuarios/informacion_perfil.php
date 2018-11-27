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
        <title>Informacion de mi perfil</title>
        <link rel="stylesheet" href="../../archivos_necesarios/css/estilos_informacion_perfil_usuario.css">
        <link rel="stylesheet" href="../../archivos_necesarios/css/estilosGenerales.css">          
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
                        <li><a href="../../inicio.php">Inicio</a></li>
                        <li><a href="">Secciones</a>
                            <ul>
                                <li><a href="../../Historia.php">Historia</a></li>
                                <li><a href="../../LugaresHolbox.php">¿Qué hacer?</a></li>
                                <li><a href="../../Gastronomia.php">Gastronomía</a></li>
                                <li><a href="../../FloraFauna.php">Flora y Fauna</a></li>
                            </ul>
                        </li>
                        <li><a href="../../experienciasH.php">Experiencias</a></li>
                        <li><a href="../../catalogo.php">Catálogo</a></li>

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
        <?php
            include("../../config/conexion2.php");
            $usuario = $_SESSION['id_usuario'];
            $query = "SELECT * FROM usuarios WHERE id_usuario = '$usuario'";              
            $contrasena="";
            $nombre="";
            $correo="";
            if($conexion){
                $resultado = $conexion->query($query);
                $bandera = false;
                while($row = $resultado->fetch_assoc()){                     
                    $bandera = true;
                    $contrasena = $row['contrasena'];
                    $nombre = $row['nombre'];
                    $correo = $row['correo'];
                }
                if(!$bandera){
                    echo "No existe usuario registrado";
                }          
            }                 
        ?>
        <div id="main">
            <h1>Información de mi perfil</h1>
            <div id="container"> 
                <div class='seccion'>
                    <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" > <br>
                        <label>Nombre:</label><br />
                        <input type='text' name="nombre" id='nombre' value="<?php echo $nombre?>"> <br />
                        <p id='p1'></p><br /><br />

                        <label>Cambiar la contraseña:</label><br />

                        <label>Escribe tu contraseña actual:</label><br />                  
                        <input type='password' name="contrasenaActual" id='contrasena' value=""/><br/>
                        <p id='p2'></p><br /><br />

                        <label>Escribe tu contraseña nueva:</label><br />                  
                        <input type='password' name ="contrasenaNueva" id='contrasenaNueva' name="contrasenaNueva1" /><br />   

                        <label>Escribe tu contraseña nueva de nuevo:</label> <br />                 
                        <input type='password' name="contrasenaNueva2" id='contrasenaNueva2' name="contrasenaNueva2"/><br />                 
                        <p id="p3"></p> <br /><br />

                        
                        <input type="submit" name="submit" value="Aplicar cambios">
                    </form>
                    <form method="POST" action="../../funciones/base_de_datos/proceso_eliminar_cuenta.php">
                        <input type="submit" value="Eliminar cuenta" id="boton_eliminar" name="boton_eliminar"/>
                    </form>                     
                    
                </div>                
                
            </div>
        </div>              
            <?php
            if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST['nombre']) && !$_POST['nombre']=="" ){
                    $nombreNuevo = $_POST['nombre'];
                    if(isset($_POST['contrasenaActual'])){
                        $contrasenaAVerif = $_POST['contrasenaActual'];
                        $contrasenaNueva = $_POST['contrasenaNueva'];
                        $contrasenaNueva2 = $_POST['contrasenaNueva2'];                        
                        
                        $_SESSION['nombre']= $nombreNuevo;
                        if($contrasenaAVerif=="" && $contrasenaNueva2=="" && $contrasenaNueva==""){                          
                            header("Location:../../funciones/base_de_datos/proceso_editar_informacion_usuario.php");
                            
                            //SE MODIFICA SOLO EL NOMBRE y la contraseña antigua
                        }else{
                            if(password_verify($contrasenaAVerif, $contrasena)){
                                if(comprobarContrasenaNueva($contrasenaNueva, $contrasenaNueva2)){
                                    $hash = password_hash($contrasenaNueva, PASSWORD_DEFAULT);
                                    $_SESSION['contrasenaNueva']=$hash;
                                    header("Location:../../funciones/base_de_datos/proceso_editar_informacion_usuario.php");
                                }                                
                            }else{
                                echo "
                                    <script type=\"text/javascript\">
                                    document.getElementById('p2').innerText='Las contraseña que escribiste no coincide con la original';
                                    </script>
                                ";
                            }                            
                        }
                    }else{
                        echo "
                            <script type=\"text/javascript\">
                            document.getElementById('p2').innerText='Contraseña vacia, ingrese caracteres';
                            </script>
                        ";                                                                    
                    }
                }else{
                    echo "
                        <script type=\"text/javascript\">
                        document.getElementById('p1').innerText='Nombre invalido';
                        </script>
                    ";    
                }
            }
            
            function comprobarContrasenaNueva($contrasenaNueva1,$contrasenaNueva2){
                if($contrasenaNueva1 == $contrasenaNueva2){
                    if(strlen($contrasenaNueva1) >= 6 && strlen($contrasenaNueva1) <= 20){
                        return true;
                    }else{
                        echo '<script type="text/javascript"> document.getElementById("p3").innerText = "La contraseña debe tener un tamaño entre 6 y 20 caracteres";  </script>';
                        return false;                        
                    }
                }else{
                    echo '<script type="text/javascript"> document.getElementById("p3").innerText = "La contraseñas no coinciden";  </script>';                    
                    return false;
                }
            }             
            ?>  
        <footer>
            <div id="about">
                <div class="tamano-7" id="menu-footer">
                    <nav>
                        <ul>
                            <li><a href="../../inicio.php">Inicio</a></li>
                            <li><a href="../../Historia.php">Historia</a></li>
                            <li><a href="../../LugaresHolbox.php">¿Qué hacer?</a></li>
                            <li><a href="../../Gastronomia.php">Gastronomía</a></li>
                            <li><a href="../../paginas/FloraFauna.php">Flora y Fauna</a></li>
                            <li><a href="../../experienciasH.php">Experiencias</a></li>
                            <li><a href="../../catalogo.php">Catálogo</a></li>
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
