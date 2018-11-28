
/*TRIGGERED*/

DROP TRIGGER IF EXISTS `after_comentarios_insert`;
DELIMITER $$
CREATE TRIGGER `after_comentarios_insert` AFTER INSERT ON `comentarios` FOR EACH ROW BEGIN
insert into bitacora values (NEW.id_usuario, 12, 1, CURDATE(), CURTIME(), CONCAT("Subió un nuevo xcomentario con id = ", NEW.id_comentario));
end
$$
DELIMITER ;

--
-- Disparadores `comentarios` cuando se aplica UPDATE a STATUS eliminado
--
DROP TRIGGER IF EXISTS `after_comentarios_update`;
DELIMITER $$
CREATE TRIGGER `after_comentarios_update` AFTER UPDATE ON `comentarios` FOR EACH ROW BEGIN
if NEW.disponibilidad != OLD.disponibilidad THEN
insert into bitacora values (NEW.id_usuario, 13, 1, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'disponibilidad' del comentario ", NEW.id_comentario, " a inactiva "));
end if;
end
$$
DELIMITER ;


DROP TRIGGER IF EXISTS `after_usuarios_insert`;
DELIMITER $$
CREATE TRIGGER `after_usuarios_insert` AFTER INSERT ON `usuarios` FOR EACH ROW BEGIN
insert into bitacora values (NEW.id_usuario, 25, 1, CURDATE(), CURTIME(), CONCAT("Registro de nueva cuenta con el nombre: ", NEW.nombre_usuario));
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
insert into bitacora values (NEW.id_usuario, 7, 1, CURDATE(), CURTIME(), "Se cambió el campo: 'contraseña'");
ELSEIF NEW.nombre_usuario != OLD.nombre_usuario THEN
insert into bitacora values (NEW.id_usuario, 6, 1, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'nombre de usuario' de ", OLD.nombre_usuario, " a ", NEW.nombre_usuario));
ELSEIF NEW.disponibilidad != OLD.disponibilidad THEN
insert into bitacora values (NEW.id_usuario, 8, 1, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'disponibilidad' de ", OLD.disponibilidad, " a ", NEW.disponibilidad));
end if;
end
$$
DELIMITER ;


DROP TRIGGER IF EXISTS `after_publicaciones_insert`;
DELIMITER $$
CREATE TRIGGER `after_publicaciones_insert` AFTER INSERT ON `publicaciones` FOR EACH ROW BEGIN
insert into bitacora values (NEW.id_usuario, 4, 1, CURDATE(), CURTIME(), CONCAT("Subió una nueva publicación con id = ", NEW.id_publicacion));
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
insert into bitacora values (NEW.id_usuario, 5, 1, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'disponibilidad' de la publicacion ", NEW.id_publicacion, " de ", OLD.disponibilidad, " a ", NEW.disponibilidad));
end if;
end
$$
DELIMITER ;




DROP TRIGGER IF EXISTS `after_usuarios_accesos_update`;
DELIMITER $$
CREATE TRIGGER `after_usuarios_accesos_update` AFTER UPDATE ON `usuarios_accesos` FOR EACH ROW BEGIN
if NEW.fecha_bloqueo is not null then
insert into bitacora values (NEW.id_usuario, 14, 1, CURDATE(), CURTIME(), "Se bloqueó al usuario");
else
insert into bitacora values (NEW.id_usuario, 15, 1, CURDATE(), CURTIME(), "Se desbloqueó al usuario");
end if;
end
$$
DELIMITER ;


DROP TRIGGER IF EXISTS `after_usuarios_accesos_insert`;
DELIMITER $$
CREATE TRIGGER `after_usuarios_accesos_insert` AFTER INSERT ON `usuarios_accesos` FOR EACH ROW BEGIN
insert into bitacora values (NEW.id_usuario, 23, 1, CURDATE(), CURTIME(), "El usuario accedió a su cuenta");
end
$$
DELIMITER ;



-- Disparadores para eventos
DROP TRIGGER IF EXISTS `after_eventos_insert`;
DELIMITER $$
CREATE TRIGGER `after_eventos_insert` AFTER INSERT ON `eventos` FOR EACH ROW BEGIN
insert into bitacora values (NEW.id_usuario, 1, 1, CURDATE(), CURTIME(), CONCAT("Subió un nuevo evento con id = ", NEW.id_evento));
end
$$
DELIMITER ;

--
-- Disparadores `eventos` cuando se aplica UPDATE a STATUS
--
DROP TRIGGER IF EXISTS `after_eventos_update`;
DELIMITER $$
CREATE TRIGGER `after_eventos_update` AFTER UPDATE ON `eventos` FOR EACH ROW BEGIN
if NEW.disponibilidad != OLD.disponibilidad THEN
insert into bitacora values (NEW.id_usuario, 2, 1, CURDATE(), CURTIME(), CONCAT("Se deshabilitó el evento: ", NEW.id_evento));
end if;
end
$$
DELIMITER ;



-- Disparadores para restaurantes
DROP TRIGGER IF EXISTS `after_restaurantes_insert`;
DELIMITER $$
CREATE TRIGGER `after_restaurantes_insert` AFTER INSERT ON `restaurantes` FOR EACH ROW BEGIN
insert into bitacora values (NEW.id_usuario, 9, 1, CURDATE(), CURTIME(), CONCAT("Subió un nuevo restaurante con id = ", NEW.id_restaurante));
end
$$
DELIMITER ;

--
-- Disparadores `restaurantes` cuando se aplica UPDATE a STATUS
--
DROP TRIGGER IF EXISTS `after_restaurantes_update`;
DELIMITER $$
CREATE TRIGGER `after_restaurantes_update` AFTER UPDATE ON `restaurantes` FOR EACH ROW BEGIN
if NEW.disponibilidad != OLD.disponibilidad THEN
insert into bitacora values (NEW.id_usuario, 11, 1, CURDATE(), CURTIME(), CONCAT("Se deshabilitó el restaurante ", NEW.id_restaurante));
end if;
end
$$
DELIMITER ;