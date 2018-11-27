<?php
        include("../../config/conexion2.php");
        session_start();   
	$id = $_SESSION['id_usuario'];
	$nombre = $_SESSION['nombre'];
        $contrasena = $_SESSION['contrasenaNueva'];
                
	$query = "UPDATE usuarios SET nombre='$nombre', contrasena = '$contrasena' WHERE id_usuario='$id'";
        $resultado = $conexion->query($query);

        header("Location:../../paginas/paginas_usuarios/informacion_perfil.php");


?>
