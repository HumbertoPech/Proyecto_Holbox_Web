
/*TRIGGERED*/

--
-- Disparadores `usuarios` cuando se aplica INSERT
--
DROP TRIGGER IF EXISTS `after_usuarios_insert`;
DELIMITER $$
CREATE TRIGGER `after_usuarios_insert` AFTER INSERT ON `usuarios` FOR EACH ROW BEGIN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Registro de nueva cuenta con el nombre: ", NEW.nombre_usuario), 25, 1);
end
$$
DELIMITER ;


--
-- Disparadores `usuarios` cuando se aplica UPDATE 
--
DROP TRIGGER IF EXISTS `after_usuarios_update`;
DELIMITER $$
CREATE TRIGGER `after_usuarios_update` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
if NEW.contrasena != OLD.contrasena THEN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'contraseña'"), 7, 1);
ELSEIF NEW.nombre_usuario != OLD.nombre_usuario THEN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'nombre de usuario' de ", OLD.nombre_usuario, " a ", NEW.nombre_usuario), 6, 1);
ELSEIF NEW.disponibilidad != OLD.disponibilidad THEN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'disponibilidad' de ", OLD.disponibilidad, " a ", NEW.disponibilidad), 8, 1);
end if;
end
$$
DELIMITER ;


--
-- Disparadores `publicaciones` cuando se aplica INSERT
--
DROP TRIGGER IF EXISTS `after_publicaciones_insert`;
DELIMITER $$
CREATE TRIGGER `after_publicaciones_insert` AFTER INSERT ON `publicaciones` FOR EACH ROW BEGIN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Subió una nueva publicación con id = ", NEW.id_publicacion), 4, 1);
end
$$
DELIMITER ;

--
-- Disparadores `publicaciones` cuando se aplica UPDATE a STATUS
--
DROP TRIGGER IF EXISTS `after_publicaciones_update`;
DELIMITER $$
CREATE TRIGGER `after_publicaciones_update` AFTER UPDATE ON `publicaciones` FOR EACH ROW BEGIN
if NEW.disponibilidad != OLD.disponibilidad THEN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'disponibilidad' de la publicacion ", NEW.id_publicacion, " de ", OLD.disponibilidad, " a ", NEW.disponibilidad), 5, 1);
end if;
end
$$
DELIMITER ;




--
-- Disparadores `usuarios_accesos` cuando se aplica UPDATE
--
DROP TRIGGER IF EXISTS `after_usuarios_accesos_update`;
DELIMITER $$
CREATE TRIGGER `after_usuarios_accesos_update` AFTER UPDATE ON `usuarios_accesos` FOR EACH ROW BEGIN
if NEW.fecha_acceso != OLD.fecha_acceso THEN
if NEW.fecha_bloqueo = null THEN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("El usuario  ", NEW.id_usuario, " inicio sesion el ", NEW.fecha_acceso), 23, 1);
else 
if NEW.fecha_bloqueo != null then
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Se cambiaron los campos: 'disponibilidad' del usuario ", NEW.id_usuario, " de ", OLD.disponibilidad, " a ", NEW.disponibilidad, ", fecha de bloqueo: ", NEW.fecha_bloqueo, "hora de bloqueo: ", NEW.hora_bloqueo), 14, 1);
else
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Se cambiaron los campos: 'disponibilidad' del usuario ", NEW.id_usuario, " de ", OLD.disponibilidad, " a ", NEW.disponibilidad), 15, 1);
end if;
end if;
end if;
end
$$
DELIMITER ;


--
-- Disparadores `comentarios` cuando se aplica INSERT CHECAR PUBLICACION
--
DROP TRIGGER IF EXISTS `after_comentarios_insert`;
DELIMITER $$
CREATE TRIGGER `after_comentarios_insert` AFTER INSERT ON `comentarios` FOR EACH ROW BEGIN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Subió una nueva publicación con id = ", NEW.id_comentario), 12, 1);
end
$$
DELIMITER ;

--
-- Disparadores `comentarios` cuando se aplica UPDATE a STATUS eliminado
--
DROP TRIGGER IF EXISTS `after_publicaciones_update`;
DELIMITER $$
CREATE TRIGGER `after_publicaciones_update` AFTER UPDATE ON `comentarios` FOR EACH ROW BEGIN
if NEW.disponibilidad != OLD.disponibilidad THEN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'disponibilidad' del comentario ", NEW.id_comentario, " de ", OLD.disponibilidad, " a ", NEW.disponibilidad), 13, 1);
end if;
end
$$
DELIMITER ;