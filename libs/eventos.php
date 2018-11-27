<?php
//para la conexion de BD
header('Content-Type: application/json');
$accion = (isset($_GET['accion']))?$_GET['accion']:'leer';
require("../core/Conexion.php");
Conexion::setDefaultInclude(false);

$con = new Conexion();
$conexion = $con->get_conexion();

Conexion::setDefaultInclude(true);


switch($accion){
    case 'agregar':
        //instruccion de agregar
        $id_usuario = $_POST['id_usuario'];
        $title = $_POST["title"];
        $descripcion = $_POST['descripcion'];
        $color = $_POST['color'];
        $textColor = $_POST['textColor'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $sentencia = "INSERT INTO EVENTOS (id_usuario,titulo, descripcion, color, textColor, inicio, final) VALUES ('$id_usuario','$title', '$descripcion', '$color','$textColor','$start','$end')";
        $conexion->query($sentencia);
        $respuesta = ($conexion->affected_rows>0)?true:false;
        $con->close_conexion();
        echo json_encode($respuesta);
        break;
    case 'eliminar':
        //instrucciones para eliminar
        //$respuesta = false;
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $sentencia = "UPDATE EVENTOS SET disponibilidad = 0 WHERE id_evento = '$id'";
            //$sentencia = "DELETE FROM EVENTOS WHERE id = '$id'";
            $conexion->query($sentencia);
            $respuesta = ($conexion->affected_rows>0)?true:false;
            $con->close_conexion();
            echo json_encode($respuesta);
        }
        break;
    case 'modificar':
        //instrucciones para modificar
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $title = $_POST["title"];
            $descripcion = $_POST['descripcion'];
            $color = $_POST['color'];
            $textColor = $_POST['textColor'];
            $start = $_POST['start'];
            $end = $_POST['end'];
            $sentencia = "UPDATE EVENTOS SET titulo = '$title', descripcion = '$descripcion', color = '$color', textColor = '$textColor', inicio = '$start', final = '$end' WHERE id_evento = '$id'";
            $conexion->query($sentencia);
            $respuesta = ($conexion->affected_rows>0)?true:false;
            $con->close_conexion();
            echo json_encode($respuesta);
        }
        break;
    default:
        $sentencia = "SELECT * FROM EVENTOS";
        $sentenciaSQL = $conexion->query($sentencia);
        $resultado = array();
        $contador = 0;
        while($casilla = $sentenciaSQL->fetch_array(MYSQLI_ASSOC)){
            if($casilla['disponibilidad']){
                //preparando para enviar
                $temp = array();
                $temp['id'] = $casilla['id_evento'];
                $temp['title'] = $casilla['titulo'];
                $temp['descripcion'] = $casilla['descripcion'];
                $temp['color'] = $casilla['color'];
                $temp['txtColor'] = $casilla['textColor'];
                $temp['start'] = $casilla['inicio'];
                $temp['end'] = $casilla['final'];
                $resultado[$contador] = $temp;
                $contador++;
            }
        }

        $con->close_conexion();
        echo json_encode($resultado);
        break;
}


?>