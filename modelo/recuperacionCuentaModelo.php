<?php
function enviarCorreo($correo,$base){
 require ("core/Conexion.php");
    $datos = array();

    $con = new Conexion();
    $conexion = $con->get_conexion();

    $correo = mysqli_real_escape_string($conexion,$correo);
    $contrasena = mysqli_real_escape_string($conexion,$contrasena);

    $sentencia = "SELECT * FROM USUARIOS WHERE correo = '$correo'";

    $resultado = $conexion->query($sentencia);
    $registro = $resultado->fetch_array(MYSQLI_ASSOC);
   

echo $url_base;

$contrasena= "rock123";
$usuario= $registro['nombre_usuario'];

$mensaje = <<<XYZ
<!DOCTYPE html>
<html>
<head>
</head>
<body >
<div class="header" style="padding: 30px; text-align: center; background: white">
  <h1 style= "font-size: 50px">MAGIC HOLBOX</h1>
  <p> No es magia,es verdad</p>
</div>
  <div class="leftcolumn" style= "float: left" width= 75%>
    <div class="card" style= "background-color: white; padding: 20px; margin-top: 20px">
      <h2> Hola,$usuario</h2>           
      <p>Solicitaste un reestablecimiento de contrase&ntilde;a.<br>Tu contrase&ntilde;a es:</p>
      <h5>$contrasena</h5>         
     </div> 
  </div>
<div class="footer" style= " padding: 20px;text-align: center; background: #ddd;
    margin-top: 20px">
  <h2>www.MagicHolbox.com</h2>
</div>
</body>
</html>
XYZ;
//titulo
$titulo = "Restablecimiento de contrase&ntilde;a";
//cabecera
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
//dirección del remitente 
$headers .= "From: Holbox Team < $correo >\r\n";
//Enviamos el mensaje a tu_dirección_email 
$bool = mail($correo,$titulo,$mensaje,$headers); 
$columnas= <<<ABC
            <div class="caja-login">
                <h1>Exito</h1>
                <p>Se ha enviado una correo con tu contraseña<p>
                <div class="campo enviar">
        		<a href="{$base}paginas/inicio"><input type="button" class="boton" value="Ok"></a>
    			</div>
            </div>
ABC;
return $columnas;

}

?>