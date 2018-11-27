<?php
session_start();
/*$_SESSION["tipo_usuario"]= 'usuario';
$_SESSION["id_usuario"]= "1";
$_SESSION["permisos_especiales"]= array(10 => "editar restaurante" ,
11 => "eliminar restaurante");
*/

$nombre = "administracion de usuarios";
$redireccion = "";

if (empty(validarPermisos($nombre))){
    header("location:" . $url_base . $redireccion);
}
?>
<!DOCTYPE html>
<html lang="es-Mx">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de usuarios</title>

	<!-- Bootstrap -->
	<link href="<?=$url_base?>resources/css/bootstrap.min.css" rel="stylesheet">
	<!--<link href="css/style_nav.css" rel="stylesheet">-->

    <link rel="stylesheet" href="<?=$url_base?>resources/css/estilosGenerales.css">
    <script src="<?=$url_base?>resources/js/jquery.min.js"></script>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montaga'>
    <style>
		.content {
			margin-top: auto;
            width: 100%;
            background-color: white;
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
                        <li><a href="<?= $url_base ?>paginas/Inicio">Inicio</a></li>
                        <li><a href="">Secciones</a>
                            <ul>
                                <li><a href="<?= $url_base ?>paginas/Historia">Historia</a></li>
                                <li><a href="<?= $url_base ?>paginas/LugaresHolbox">¿Qué hacer?</a></li>
                                <li><a href="<?= $url_base ?>paginas/Gastronomia">Gastronomía</a></li>
                                <li><a href="<?= $url_base ?>paginas/FloraFauna">Flora y Fauna</a></li>
                            </ul>
                        </li>
                        <?php
                        include("libs/manejador_sesiones.php");
                        $menu = get_Menu();

                        foreach( $menu as $opcion => $link){
                            echo "<li><a href=\"$link\">$opcion</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <div id="sesiones">
                <?php
                if(empty($_SESSION)){
                    echo "<label><a href='{$url_base}inicioSesion/iniciarSesion'>Iniciar Sesión  </a></label>";
                    echo "<label><a href='{$url_base}registroUsuario/registrarUsuario'> Registrarse</a></label>";
                }else{
                    echo "<script src = '{$url_base}resources/js/autologout.js'></script>";
                    echo "<label>Bienvenido ".$_SESSION['nombre'] ." </label>";
                    echo "<label><a href='{$url_base}inicioSesion/logout'>Cerrar Sesión </a></label>";
                }
                ?>
            </div>
        </header>
	<nav class="navbar navbar-default navbar-fixed-top">
	</nav>
	<div class="container" style="width:100%;">
		<div class="content">
			<h2>Lista de usuarios</h2>
			<hr />

			<?php
			if(isset($_SESSION['aksi']) == 'delete'){
                $_SESSION['aksi'] = null;
				require_once("libs/conexionAdminUsuarios.php");
				eliminar();
			}
			?>


			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <th>No</th>
					<th>Id Usuario</th>
					<th>Nombre de usuario</th>
                    <th>Correo</th>
                    <th>Fecha de acceso</th>
					<th>Hora de acceso</th>
					<th>Estado</th>
					<th>Fecha de bloqueo</th>
					<th>Hora de bloqueo</th>
					<th>No de intentos</th>
                    <th>Acciones</th>
				</tr>
				<?php
				include("libs/conexionAdminUsuarios.php");
				$arrayUsuarios= array();
				$resultados= array();
				$resultados = solicitarListaUsuarios();
				if( count($resultados)<=0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					for($i=0; $i< count($resultados); $i++){
						$no = 1;							
						echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$resultados[$i]['id_usuario'].'</td>
							<td><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$resultados[$i]['nombre_usuario'].'</td>
							<td>'.$resultados[$i]['correo'].'</td>
							<td>'.$resultados[$i]['fecha_acceso'].'</td>
							<td>'.$resultados[$i]['hora_acceso'].'</td>
							<td>';
							if(is_null($resultados[$i]['fecha_bloqueo']) && is_null($resultados[$i]['hora_bloqueo'])){
								echo '<span class="label label-success">Activo</span>';
								echo '</td>';	
								echo '
									<td>'.$resultados[$i]['fecha_bloqueo'].'</td>
									<td>'.$resultados[$i]['hora_bloqueo'].'</td>
									<td>'.$resultados[$i]['num_intentos'].'</td>										
								';																
							}else{

								echo '<span class="label label-warning">Bloqueado</span>';
								echo '</td>';
								echo '
									<td>'.$resultados[$i]['fecha_bloqueo'].'</td>
									<td>'.$resultados[$i]['hora_bloqueo'].'</td>
									<td>'.$resultados[$i]['num_intentos'].'</td>										
								';
							}
                            //$url = $url_base."editarUsuarioVista.php?nik=".$resultado
							echo '
								<td>
									<a href="'.$url_base.'vista/filtroAdminVista.php?nik='.$resultados[$i]['id_usuario'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
									<a href="'.$url_base.'vista/filtroEliminarUsuarioVista?aksi=delete&nik='.$resultados[$i]['id_usuario'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$resultados[$i]['nombre_usuario'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
								</td>
								</tr>
							';
						$no++;							
					}
				}
				?>
			</table>
			</div>
		</div>
	</div>
	<footer>
            <div id="about">
                <div class="tamano-7" id="menu-footer">
                    <nav>
                        <ul>
                            <li><a href="<?=$url_base?>paginas/Inicio">Inicio</a></li>
                            <li><a href="<?= $url_base ?>paginas/Historia">Historia</a></li>
                            <li><a href="<?= $url_base ?>paginas/LugaresHolbox">¿Qué hacer?</a></li>
                            <li><a href="<?= $url_base ?>paginas/Gastronomia">Gastronomía</a></li>
                            <li><a href="<?= $url_base ?>paginas/FloraFauna">Flora y Fauna</a></li>
                            <?php
                                $menu = get_Menu();

                                foreach( $menu as $opcion => $link){
                                    echo "<li><a href=\"$link\">$opcion</a></li>";
                                }
                            ?>
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
        </footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="<?=$url_base?>resources/js/bootstrap.min.js"></script>
</body>
</html>
