<?php
    function cargarFeed(){

        require_once("core/Conexion.php");
        $con = new Conexion();
        $conexion = $con->get_conexion();
        $query = "SELECT * FROM publicaciones";  
        if($conexion){
            $arrayPublicaciones = array();
            $resultado = $conexion->query($query);
            $bandera = false;
            while($row = $resultado->fetch_assoc()){                     
                $bandera = true;
                $arrayPublicaciones[]=$row;
            }
            if(!$bandera){
                echo "No hay publicaciones para mostrar";
            }else{                       
                $publicacionesCount = count($arrayPublicaciones);
                ?><div class="flex-container flex-flora"><?php
                for($i=$publicacionesCount-1;$i>=0;$i--){                               
                ?>  
                    <div class="contenedor-flora">
                        <img src="data:image/jpg;base64,<?php echo base64_encode($arrayPublicaciones[$i]['imagen']);?>" alt="mangle" style="width:90%"/>                                                           
                        <div class="descripcion" >
                            <p><?php echo "Usuario ".$arrayPublicaciones[$i]['id_usuario'].": ";echo $arrayPublicaciones[$i]['comentario']; ?></p>
                        </div>
                        <span class="infoAdicional">
                            <?php echo "Usuario ".$arrayPublicaciones[$i]['id_usuario'].": " ?>
                            <?php echo $arrayPublicaciones[$i]['comentario']; ?>
                        </span>
                    </div>                                           
                <?php                                       
                }?>
                </div>
                <?php
            }
        }else{
            echo "Conexion con la base de datos fallida";
        }


    }


?>