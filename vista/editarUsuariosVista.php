<?php
session_start();
// $_SESSION["tipo_usuario"]= 'usuario';
// $_SESSION["id_usuario"]= "1";
// $_SESSION["permisos_especiales"]= array(10 => "editar restaurante" ,
//     11 => "eliminar restaurante");

//require_once("../libs/funciones_comprobacion.php");
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
	<title>Datos de empleados</title>
	<link rel="stylesheet" href="<?=$url_base?>resources/css/estilosGenerales.css">
     <script src="<?=$url_base?>resources/js/jquery.min.js"></script>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montaga'>

	<!-- Bootstrap -->
	<link href="<?=$url_base?>resources/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=$url_base?>resources/css/bootstrap-datepicker.css" rel="stylesheet">
	<!--<link href="css/style_nav.css" rel="stylesheet">-->
	<style>
		.content {
			margin-top: 80px;
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
		<?php //include("nav.php");?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del empleados &raquo; Editar datos</h2>
			<hr />
			
			<?php
			include_once("modelo/adminUsuariosModelo.php");
			$id = $_SESSION["nik"];
			accionUsuarios('mostrar', $id);
			if(isset($_POST['save'])){
				accionUsuarios('actualizar', $id);
			}
			
			if(isset($_SESSION['pesan']) == 'sukses'){
                $_SESSION['pesan'] = null;
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			}
			?>
			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<div class="col-sm-2">
						<p>Usuario: <?php echo $row ['nombre_usuario']; ?></p>
					</div>
				</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-4">
						<select name="disponibilidad" class="form-control">
							<option value="">- Selecciona estado -</option>						
                            <option value="1" <?php if (is_null($row['fecha_bloqueo'])){echo "selected";} ?>>Activo</option>
							<option value="2" <?php if (!is_null($row['fecha_bloqueo'])){echo "selected";} ?>>Bloqueado</option>
						</select> 
					</div>
                </div>
				<br><br><br>



				<div class="form-group">
					<label class="col-sm-3 control-label">Asignar roles</label>
					<div class="col-sm-4">
						<label >Todos los roles</label>
						<select name="roles" class="form-control">
						
						<?php
							accionUsuarios('mostrarRoles', $id );
							?>
						</select> 
					</div>

					<div class="col-sm-4">
						<label >Mis roles</label>
						<select name="mis_roles" class="form-control">
						<?php
							accionUsuarios('mostrarMisRoles', $id );
							?>
						</select> 
					</div>
                </div>
				<br><br><br>

				<div class="form-group">
					<label class="col-sm-3 control-label">Asignar permisos</label>
					<div class="col-sm-4">
						<label >Todos los permisos</label>
						<select name="permisos" class="form-control">
						
						<?php
							accionUsuarios('mostrarPermisos', $id );
							?>
						</select> 
					</div>

					<div class="col-sm-4">
						<label >Mis permisos</label>
						<select name="mis_permisos" class="form-control">
						<?php
							accionUsuarios('mostrarMisPermisos', $id );
							?>
						</select> 
					</div>
                </div>
				<br><br><br>
			
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="<?=$url_base?>adminUsuarios/iniciar" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>
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
	<script src="<?=$url_base?>resources/js/bootstrap-datepicker.js"></script>
	<script>
	</script>
</body>


</html>