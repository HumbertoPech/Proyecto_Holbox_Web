<?php

function cargarImagenes($id){
    global $url_base;
    global $arrayPublicaciones;
    global $publicacionesCount;
    /*Carga las imagenes del usuario*/                
    require_once("core/Conexion.php");
    $con = new Conexion();
    $conexion = $con->get_conexion();    
    $usuario = $_SESSION['id_usuario'];
    $query = "SELECT * FROM publicaciones WHERE id_usuario = $id AND disponibilidad=true";                   
    if($conexion){
        //$arrayPublicaciones = array();
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
                        <a href="#<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>">
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
                //var_dump($arrayPublicaciones[$i]['imagen']);
                for($i=$publicacionesCount-1;$i>=0;$i--){                                                                   
                    $picture = base64_encode($arrayPublicaciones[$i]['imagen']);
                    $img = "data:image/jpg;base64,".$picture;
                    try {
                        list($width, $height, $type, $attr) = getimagesize($img);                                
                        $diferencia = $width-$height;
                        if($diferencia<=220 || ($diferencia>=-220 && $diferencia<=0)){
                            ?>
                            <div class="modal" id="<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>">
                                <div class="imagenModal">
                                    <p><?php echo $arrayPublicaciones[$i]['comentario']; ?></p>
                                    <img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);?>">
                                </div> 
                                    <a class="cerrar" href="#galeria">X</a>
                                    
                                    <form method="POST" action="<?=$url_base?>modelo/proceso_eliminar_imagenModelo.php" onsubmit="onEnviar(<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>)" enctype="multipart/form-data">
                                        <input id="variable<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>" name="variable" type="hidden" />
                                        <input class="boton" type="submit" value="Eliminar publicacion"/>
                                    </form>              
                                    
                            </div>
                        <?php
                        }
                        if($diferencia>0){/*Horizontal*/?>
                            <div class="modal" id="<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>">
                                <div class="imagenModal1">
                                    <p><?php echo $arrayPublicaciones[$i]['comentario']; ?></p>
                                    <img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);?>">
                                </div> 
                                    <a class="cerrar" href="#galeria">X</a> 
                                    <!-- -->
                                <form method="POST" action="<?=$url_base?>modelo/proceso_eliminar_imagenModelo.php" onsubmit="onEnviar(<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>)" enctype="multipart/form-data">
                                        <input id="variable<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>" name="variable" type="hidden" />
                                    <input class="boton" type="submit" value="Eliminar publicacion"/>
                                </form>                                                         
                            </div>
                        <?php    
                        }else{/*Modal vertical*/
                            ?>
                            <div class="modal" id="<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>">
                                <div class="imagenModal">
                                    <p><?php echo $arrayPublicaciones[$i]['comentario']; ?></p>
                                    <img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);?>">
                                </div> 
                                    <a class="cerrar" href="#galeria">X</a>
                                    
                                    <form method="POST" action="<?=$url_base?>modelo/proceso_eliminar_imagenModelo.php" onsubmit="onEnviar(<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>)" enctype="multipart/form-data">
                                        <input id="variable<?php echo $arrayPublicaciones[$i]['id_publicacion'];?>" name="variable" type="hidden" />
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
}
?>