<?php 
    /*Carga las imagenes del usuario*/                
/*"<?=$url_base?>*/
    require_once("core/Conexion.php");
    //require_once("../core/Conexion.php");

    $con = new Conexion();
    $conexion = $con->get_conexion();
    $errores = array();
    if(isset($_POST['submit_post']) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $comentario = $_POST['comentario'];   
        if(isset($_FILES['imagen'])){           
            if(validarImagen()){
                
                if(!empty($_FILES['imagen']['tmp_name'])) {
                    $imagen= addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
                    $comentario = "";
                    if(isset($_POST["comentario"])){
                        $comentario = $_POST['comentario'];
                    }
                    $id_usuario = $_SESSION['id_usuario'];
                    $query = "INSERT INTO publicaciones(id_usuario, imagen, comentario) VALUES ($id_usuario, '$imagen', '".$comentario."')";
                    $resultado = $conexion->query($query); 
                    if(!$resultado){
                        echo "<p id='error' style='color:red'>Error al agregar publicacion</p>";                
                    }                 
                }else{
                    echo "<p id='error' style='color:red'>Error al cargar imagen, demasiado grande</p>";
                }                
                     
            }else{
                //style="padding: 8px 16px; overflow: hidden;"
                $cadena="";
                foreach( $errores as $value ) {
                    $cadena .= $value;
                }       
                echo "<p id=error style='color:red'>No se pudo publicar el post debido a: $cadena</p>";                                               
            }     
        }
    } 
    
    function validarImagen(){
        $extensionesValidas = array("jpg", "png");        
        $max_file_size = "100000000"; //760KB   =  7,600,000         100MB
        
        $nombreArchivo = $_FILES['imagen']['name'];
        $filesize = $_FILES['imagen']['size'];
        $tipoArchivo = $_FILES['imagen']['type'];
        $arrayArchivo = pathinfo($nombreArchivo);
        $extension = $arrayArchivo['extension'];
        // Comprobamos la extensión del archivo
        global $errores;
        if(!in_array($extension, $extensionesValidas)){
            
            $errores[] = "La extensión del archivo no es válida debe ser .jpg o .png";
            return false;
        }
        // Comprobamos el tamaño del archivo
        if($filesize > $max_file_size){
            $errores[] = "La imagen debe de tener un tamaño inferior a 10MB";
            return false;
        }
        return true;
    }
?>