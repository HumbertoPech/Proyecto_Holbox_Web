<?php
//para la conexion de BD
header('Content-Type: application/json');
$accion = (isset($_GET['accion']))?$_GET['accion']:'leer';
require("../../config/Conexion.php");

$con = new Conexion();
$conexion = $con->get_conexion();



switch($accion){
    case 'agregar':
        //instruccion de agregar
        $title = $_POST["title"];
        $descripcion = $_POST['descripcion'];
        $color = $_POST['color'];
        $textColor = $_POST['textColor'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $sentencia = "INSERT INTO EVENTOS (title, descripcion, color, textColor, start, end) VALUES ('$title', '$descripcion', '$color','$textColor','$start','$end')";
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
            $sentencia = "DELETE FROM EVENTOS WHERE id = '$id'";
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
            $sentencia = "UPDATE EVENTOS SET title = '$title', descripcion = '$descripcion', color = '$color', textColor = '$textColor', start = '$start', end = '$end' WHERE id = '$id'";
            $conexion->query($sentencia);
            $respuesta = ($conexion->affected_rows>0)?true:false;
            $con->close_conexion();
            echo json_encode($respuesta);
        }
        break;
    default:
        $sentencia = "SELECT * FROM EVENTOS";
        $sentenciaSQL = $conexion->query($sentencia);
        $resultado = $sentenciaSQL->fetch_all(MYSQLI_ASSOC);
        $con->close_conexion();
        echo json_encode($resultado);
        break;
}


?>