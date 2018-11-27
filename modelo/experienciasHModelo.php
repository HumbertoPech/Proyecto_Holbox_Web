<?php
session_start();
include('libs/conexionExperiencias.php');

function generarTitulo(){
    return "Experiencias Holbox";
}

    function delete_comment(){
    
        if(isset($_POST['eliminar'])){
            $descripcion_comment = ($_POST['id_com']);
            $con = new Conexion();
            $conexion = $con->get_conexion();
            //HAY QUE CAMBIAR LO QUE SE LE SETEA, POR UN BOOLEANO
            $sentencia = "UPDATE comentarios SET disponibilidad = '0' WHERE comentarios.id_comentario = $descripcion_comment";
            $conexion->query($sentencia);
                $affected_rows = $conexion->affected_rows;
                
                
            $con->close_conexion();
            //echo "<script type='text/javascript'>location.reload(true);</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }

    function do_comments(){
        $con = new Conexion();
        $conexion = $con->get_conexion();
        
        $id_user = mysqli_real_escape_string ($conexion,$_SESSION['id_usuario']);//envia el id del usuario que hace le comentario
        $comentario =  mysqli_real_escape_string ($conexion,$_POST["comment"]);// envia el comentario
        //var_dump($comentario);
        $disponible = mysqli_real_escape_string($conexion,1);//esto luego se quita porque está por defecto
        if($id_user !== '' && $comentario !== ''){
            $sentencia = "INSERT INTO comentarios (id_usuario, comentario, disponibilidad) VALUES('$id_user','$comentario','$disponible')";
                $conexion->query($sentencia);
                $affected_rows = $conexion->affected_rows;
                $con->close_conexion();
        }
    }

?>