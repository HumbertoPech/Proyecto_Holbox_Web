<?php
    //include("core/Conexion.php");
    include('core/Conexion.php'); 
    
    function consultarComentarios(){
    
        $con = new Conexion();
        $conexion = $con->get_conexion();     
        $query = "SELECT * FROM comentarios INNER JOIN usuarios ON comentarios.id_usuario = usuarios.id_usuario ORDER BY comentarios.id_comentario ASC";
        //$conexion->query($query);
        if ($conexion){
            $arrayComentarios = array();
            $resultado = $conexion->query($query);
            
            if (!empty($resultado)) {
                while($row = $resultado->fetch_assoc()){                  
                
                    if($row['disponibilidad'] !== "0" && $row['comentario'] !== ''){
                        $arrayComentarios[]=$row;
                    }
                }
            return $arrayComentarios;
            } /*else {
                echo "No hay comentarios";
            }*/
        } else {
            echo "Conexion con la base de datos fallida";
        }
        //$affected_rows = $conexion->affected_rows;
        /*if($affected_rows > 0){
            $last_id = $conexion->insert_id;
        }*/
        $con->close_conexion();
        
        return $arrayComentarios;
    }

    
    
?>
