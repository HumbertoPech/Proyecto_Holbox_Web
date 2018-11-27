<?php
    global $row;
function accionUsuarios($accion, $id){
    global $url_base;
    require_once("core/Conexion.php");
    $con = new Conexion();
    $conexion = $con->get_conexion();
    global $row;
    switch($accion){
        case 'mostrar':
            $query ="SELECT usuarios.*, usuarios_accesos.*  FROM usuarios"
            . " JOIN usuarios_accesos ON usuarios.id_usuario = usuarios_accesos.id_usuario WHERE usuarios.id_usuario =  $id";			
            $sql = mysqli_query($conexion, $query);
            if(mysqli_num_rows($sql) == 0){
                header("Location: index.php");
            }else{
                $row = mysqli_fetch_assoc($sql);
            }
            break;
        case 'mostrarRoles':
            $query = "SELECT * FROM roles";	
            $sql = mysqli_query($conexion, $query);
            if(mysqli_num_rows($sql) == 0){
                echo '<p>No hay datos de roles.</p>';
            }else{
                ?><option value="">- Selecciona los roles -</option>	
                <?php
                
                while($row = mysqli_fetch_assoc($sql)){?>

                    <option value='<?php  echo $row['id_rol'];?>'><?php echo $row['nombre_rol']; ?></option>
                <?php
                }
            }

            break;
        case 'mostrarMisRoles':
            $query = "SELECT USUARIOS_ROLES.*, ROLES.* FROM USUARIOS_ROLES JOIN ROLES ON USUARIOS_ROLES.id_rol = ROLES.id_rol WHERE id_usuario = $id";
            $sql = mysqli_query($conexion, $query);
            if(mysqli_num_rows($sql) == 0){
                echo '<p>No hay datos de roles.</p>';
            }else{
                ?><option value="">- Selecciona los roles -</option>	
                <?php
                while($row = mysqli_fetch_assoc($sql)){?>
                    <option value='<?php echo $row['id_rol'];?>'><?php echo $row['nombre_rol']; ?></option>
                    <?php
                }
            }        
            break;
        case 'mostrarPermisos':
            $query = "SELECT * FROM permisos ";	
            $sql = mysqli_query($conexion, $query);
            if(mysqli_num_rows($sql) == 0){
                echo '<p>No hay datos de permisos.</p>';
            }else{

                ?><option value="">- Selecciona los permisos -</option>	
                <?php
                while($row = mysqli_fetch_assoc($sql)){?>
                    <option value=<?php echo $row['id_permiso'];?>><?php echo $row['nombre_permiso']; ?></option>
                <?php
                }
            }
            break;
        case 'mostrarMisPermisos':						
            $query = "SELECT PERMISOS_ESPECIALES.*, PERMISOS.* FROM PERMISOS_ESPECIALES JOIN PERMISOS ON PERMISOS_ESPECIALES.id_permiso = PERMISOS.id_permiso WHERE id_usuario = $id";						
            $sql = mysqli_query($conexion, $query);
            if(mysqli_num_rows($sql) == 0){
                echo '<p>No hay datos de permisos.</p>';
            }else{

                ?><option value="">- Selecciona los permisos -</option>	
                <?php
                while($row = mysqli_fetch_assoc($sql)){?>
                    <option value=<?php echo $row['id_permiso'];?>><?php echo $row['nombre_permiso']; ?></option>
                <?php
                }
            }

        case 'actualizar':
				//update para roles

				$disponibilidad = mysqli_real_escape_string($conexion,(strip_tags($_POST["disponibilidad"],ENT_QUOTES)));//Escanpando caracteres 
				$roles =  mysqli_real_escape_string($conexion,(strip_tags($_POST["roles"],ENT_QUOTES)));//Escanpando caracteres 
				$permisos =  mysqli_real_escape_string($conexion,(strip_tags($_POST["permisos"],ENT_QUOTES)));//Escanpando caracteres
				if($permisos>0){
					//se agrega el nuevo permiso
					$query = "INSERT INTO permisos_especiales(id_permiso, id_usuario) VALUES ($permisos, $id)";	
					$insertPermiso= mysqli_query($conexion, $query);
					if ($insertPermiso === FALSE) {
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';			
					}						
				}
				if($roles >0){
					//se agrega el nuevo rol
					$query2 = "INSERT INTO usuarios_roles(id_rol, id_usuario) VALUES ($roles, $id)";
					$insertRol= mysqli_query($conexion, $query2);

					if ($insertRol === FALSE) {
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';		
					}
				}
				$update  = null;
				if ($disponibilidad == 1){
					//update para desbloquear/bloquear
					$update = mysqli_query($conexion, "UPDATE usuarios_accesos SET fecha_bloqueo=null, hora_bloqueo=null WHERE id_usuario=$id") or die(mysqli_error());	
					//update para roles
				}else if($disponibilidad == 2){
					$date=date("Y-m-d");
					$hora_registro = date('H:i:s');
					//update para desbloquear/bloquear
					$update = mysqli_query($conexion, "UPDATE usuarios_accesos SET fecha_bloqueo='$date', hora_bloqueo='$hora_registro' WHERE id_usuario=$id") or die(mysqli_error());	
				}

				if($update){
					header("Location: {$url_base}vista/filtroEditarUsuarioVista.php?nik=".$id."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}

            break;
        default:
            break;
    }
    
}

?>