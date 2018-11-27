<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Experiencias</title>
    <link href='https://fonts.googleapis.com/css?family=Montaga' rel='stylesheet'>
    <link rel="stylesheet" href="../archivos_necesarios/css/estilosGenerales.css">
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
        
        /*div{
            margin: 10px 0 10px 20px;
            padding:0;
        }*/
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
                        <li><a href="catalogo.php">Catálogo</a></li>
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
    <h1>Experiencias Holbox</h1>
    <script type="text/javascript">

        function call_php(){
            
            //var x=document.getElementById("texto");
     "<?php do_comments();?>"
     //document.getElementById("texto").appendChild(documents.getElementsByClassName("parrafo")[0]);
            "<?php #do_comments();?>";
            //alert(0);
        }

    </script>
    
    <form  onclick="call_php()" action="experienciasH.php" method="post">
        <div>
            <label>Usuario</label>
            <input type="text" name="usuario" value="Anónimo" placeholder="usuario prueba" readonly>
        </div>
        <div>
            <label>Comentar</label>
            <textarea name="comment" placeholder="Escriba su experiencia" required></textarea> 
            <input type="submit" name="aceptar" value="Comentar">
        </div>


    </form>
    
    <!--<footer style="margin-top: 340px;">
        <div id="about">
            <div class="tamano-7" id="menu-footer">
                <nav>
                    <ul>
                        <li><a href="../inicio.html">Inicio</a></li>
                        <li><a href="Historia.html">Historia</a></li>
                        <li><a href="LugaresHolbox.html">¿Qué hacer?</a></li>
                        <li><a href="Gastronomia.html">Gastronomía</a></li>
                        <li><a href="FloraFauna.html">Flora y Fauna</a></li>
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
    </footer>-->
</body>
</html>

<?php
function do_comments(){
//var_dump ($_POST);
$usuario = $_POST["usuario"];
$comentario = $_POST["comment"];

    if(isset($_POST) && $_POST["comment"] != ""){
    #write
    
    $write = fopen("comentarios.txt","a+");
    $claseDiv = "class=\"parrafo\"";
    $claseUsu = "class=\"usuario\"";
    $claseCom = "class=\"comment\"";
    fwrite($write, "<div $claseDiv><p $claseUsu>$usuario</p><p $claseCom>$comentario</p></div>".PHP_EOL);
    fclose($write);

    
    }
    Header("Location: experienciasH.php");
}
if(file_exists("comentarios.txt")){
    $read = fopen ("comentarios.txt","r+t");
    echo "<div><p style=\"display:block;\">Comentarios</p></div>";

    /*$html = file_get_contents("comments.php");
    libxml_use_internal_errors(true);
$doc = new DOMDocument(); 
$doc->loadHTML($html);
//get the element you want to append to
$descBox = $doc->getElementById('texto');
//create the element to append to #element1
$appended = $doc->createElement('li', 'This is a test element.');
//actually append the element
$descBox->appendChild($appended);
echo $doc->saveHTML();*/
    while(!feof($read)){
    echo fread($read, 1024);
    }
    fclose($read);
}
?>