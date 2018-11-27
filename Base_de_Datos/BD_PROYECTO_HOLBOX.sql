#Creamos la base de datos Proyecto_Holbox
CREATE DATABASE IF NOT EXISTS PROYECTO_HOLBOX_DB;

USE PROYECTO_HOLBOX_DB;

#Creamos la tabla usuarios
CREATE TABLE USUARIOS(
id_usuario int auto_increment Primary Key,
nombre_usuario varchar(255),
correo varchar(255) unique,
contrasena varchar(255),
disponibilidad boolean default true
) Engine = InnoDB;

#Creamos la tabla usuarios_accesos
CREATE TABLE USUARIOS_ACCESOS(
id_usuario_acceso int auto_increment primary Key,
id_usuario int not null,
fecha_acceso date,
hora_acceso time,
fecha_bloqueo date,
hora_bloqueo time,
num_intentos int,
foreign key(id_usuario)
references USUARIOS(id_usuario)
)Engine = InnoDB;

#Creamos la tabla roles
CREATE TABLE ROLES(
id_rol int auto_increment Primary Key,
nombre_rol varchar(60)
)Engine = InnoDB;

#Creamos la tabla modulos
CREATE TABLE MODULOS(
id_modulo int auto_increment Primary Key,
nombre_modulo varchar(255),
disponibilidad boolean default true
)Engine = InnoDB;

#Creamos la tabla permisos
CREATE TABLE PERMISOS(
id_permiso int auto_increment Primary Key,
nombre_permiso varchar(255),
id_modulo int,
disponibilidad boolean default true,
foreign key(id_modulo) 
references MODULOS(id_modulo)
)Engine = InnoDB;

#Creamos la tabla sistemas
CREATE TABLE SISTEMAS(
id_sistema int auto_increment Primary Key,
nombre_sistema varchar(60)
)Engine = InnoDB;

#Creamos la interrelacion entre usuarios y roles
CREATE TABLE USUARIOS_ROLES(
id_usuario int not null,
id_rol int not null,
primary key(id_usuario, id_rol),
foreign key(id_usuario)
references USUARIOS(id_usuario),
foreign key(id_rol)
references ROLES(id_rol)
)Engine = InnoDB;

#Creamos la interrelacion entre roles y permisos
CREATE TABLE ROLES_PERMISOS(
id_rol int not null,
id_permiso int not null,
primary key(id_rol, id_permiso),
foreign key(id_rol) 
references ROLES(id_rol),
foreign key(id_permiso)
references PERMISOS(id_permiso)
)Engine = InnoDB;

#Creamos la tabla permisos especiales (interrelacion entre usuarios y permisos)
CREATE TABLE PERMISOS_ESPECIALES(
id_usuario int not null,
id_permiso int not null,
primary key(id_usuario, id_permiso),
foreign key(id_usuario)
references USUARIOS(id_usuario),
foreign key(id_permiso)
references PERMISOS(id_permiso)
)Engine = InnoDB;

#Creamos la interrelacion entre sistemas y modulos
CREATE TABLE SISTEMAS_MODULOS(
id_sistema int not null,
id_modulo int not null,
primary key(id_sistema, id_modulo),
foreign key(id_sistema)
references SISTEMAS(id_sistema),
foreign key(id_modulo)
references MODULOS(id_modulo)
)Engine = InnoDB;

#Creamos la tabla acceso (interrelacion entre permisos y modulos)
CREATE TABLE ACCESOS(
id_permiso int not null,
id_modulo int not null,
primary key(id_permiso, id_modulo),
foreign key(id_permiso)
references PERMISOS(id_permiso),
foreign key(id_modulo)
references MODULOS(id_modulo)
)Engine = InnoDB;

#Creamos la interrelacion entre roles y sistemas
CREATE TABLE ROLES_SISTEMAS(
id_rol int not null,
id_sistema int not null,
primary key(id_rol,id_sistema),
foreign key(id_rol)
references ROLES(id_rol),
foreign key(id_sistema)
references SISTEMAS(id_sistema)
)Engine = InnoDB;

#Creamos la tabla bitacora (interrelacion entre usuarios, permisos y sistemas
CREATE TABLE BITACORA(
id_usuario int not null,
id_permiso int not null,
id_sistema int not null,
fecha_registro date not null,
hora_registro time not null,
actividad varchar(255),
primary key(id_usuario, id_permiso, id_sistema, fecha_registro, hora_registro),
foreign key(id_usuario)
references USUARIOS(id_usuario),
foreign key(id_permiso)
references PERMISOS(id_permiso),
foreign key(id_sistema)
references SISTEMAS(id_sistema)
)Engine = InnoDB;

#Creamos la tabla publicaciones
CREATE TABLE PUBLICACIONES(
id_publicacion int auto_increment Primary Key,
id_usuario int not null,
imagen mediumblob,
comentario varchar(200),
disponibilidad boolean default true,
foreign key(id_usuario)
references USUARIOS(id_usuario)
)Engine = InnoDB;

#Creamos la tabla eventos (del calendario)
CREATE TABLE EVENTOS(
id_evento int auto_increment Primary Key,
id_usuario int not null,
titulo varchar(255),
descripcion text,
color varchar(10),
textColor varchar(10),
inicio datetime,
final datetime,
disponibilidad boolean default true,
foreign key(id_usuario)
references USUARIOS(id_usuario)
)Engine = InnoDB;

#Creamos la tabla comentarios (Experiencias comentarios)
CREATE TABLE COMENTARIOS(
    id_comentario int auto_increment Primary Key,
    id_usuario int not null,
    comentario text not null,
    disponibilidad boolean default true,
    foreign key(id_usuario)
    references USUARIOS(id_usuario)
)Engine = InnoDB;

#Creamos la tabla restaurantes
CREATE TABLE RESTAURANTES(
    id_restaurante int auto_increment primary Key,
    id_usuario int not null,
    nombre_restaurante varchar(255),
    telefono_restaurante varchar(255),
    horario_abierto time,
    horario_cerrado time,
    precio varchar(255),
    descripcion_restaurante text,
    tipo_restaurante varchar(255),
    imagen_restaurante longblob,
    disponibilidad boolean default true,
    foreign key(id_usuario)
    references USUARIOS(id_usuario)
)Engine = InnoDB;

#Insertando Roles
INSERT INTO ROLES(nombre_rol) VALUES
('Administrador'),
('Usuario'),
('Proveedor');

#Añadiendo Administrador y Proovedor
INSERT INTO USUARIOS(nombre_usuario, correo, contrasena) VALUES
('Administrador', 'admin', '$2y$10$hSrX3DQk6TOgkareETL1YOoPfsA4vPtDjL7Zrdn6VNTA1hthXWBri'),
('Proveedor', 'proveedor','$2y$10$WegYZJPiaOdPZH4YOMH0SOKI.mP6adRU3ny.fj5n5BNkijp5MYtHq');
INSERT INTO USUARIOS_ROLES(id_usuario, id_rol) VALUES
(1,1),
(1,3);

#Creando sistema
INSERT INTO SISTEMAS(nombre_sistema) VALUES ('SISTEMA GENERAL');

#Añadiendo modulos
INSERT INTO MODULOS(nombre_modulo) VALUES
('iniciar sesion'),
('cerrar sesion'),
('registrar usuario'),
('calendario de eventos'),
('mis publicaciones'),
('perfil de usuario'),
('catalogo de restaurantes'),
('experiencias'),
('recuperacion de cuenta'),
('administracion de usuarios'),
('bitacora');

#Añadiendo permisos
INSERT INTO PERMISOS(nombre_permiso, id_modulo) VALUES
('crear evento', 4),
('eliminar evento', 4),
('modificar evento', 4),
('crear publicacion', 5),
('eliminar publicacion', 5),
('cambiar nombre de usuario',6),
('cambiar contrasena de usuarios',6),
('eliminar cuenta',6),
('agregar restaurante',7),
('editar restaurante',7),
('eliminar restaurante', 7),
('crear comentario',8),
('eliminar comentario',8),
('bloquear usuario', 10),
('desbloquear usuario', 10),
('eliminar usuario',10),
('asignar rol',10),
('asignar permiso',10),
('ver bitacora', 11),
('filtrar bitacora',11),
('limpiar bitacora', 11),
('recuperar cuenta', 9),
('iniciar sesion', 1),
('cerrar sesion', 2),
('registrar usuario', 3);

INSERT INTO SISTEMAS_MODULOS(id_sistema, id_modulo) VALUES
(1,1), (1,2), (1,3), (1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11);

INSERT INTO ROLES_SISTEMAS(id_rol, id_sistema) VALUES
(1,1), (2,1) , (3,1);

INSERT INTO ROLES_PERMISOS(id_rol, id_permiso) VALUES
(1,1), (1,2), (1,3), (1,14), (1,15), (1,16), (1,17), (1,25), (1,18),(1,19),(1,20),
(2,4), (2,5),(2,6), (2,7),(2,8), (2,12), (2,13), (2,21),
(3,9), (3,10), (3,11);



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
ELSEIF NEW.disponibilidad != OLD.disponibilidad THEN --Decia NEW.status
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
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Subió una nueva publicación con id = ", NEW.id), 4, 1);
end
$$
DELIMITER ;

--
-- Disparadores `publicaciones` cuando se aplica UPDATE a STATUS
--
DROP TRIGGER IF EXISTS `after_publicaciones_update`;
DELIMITER $$
CREATE TRIGGER `after_publicaciones_update` AFTER UPDATE ON `publicaciones` FOR EACH ROW BEGIN
if NEW.disponibilidad != OLD.disponibilidad THEN --Decia NEW.status
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'disponibilidad' de la publicacion ", NEW.id, " de ", OLD.disponibilidad, " a ", NEW.disponibilidad), 5, 1);
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
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Subió una nueva publicación con id = ", NEW.id), 12, 1);
end
$$
DELIMITER ;

--
-- Disparadores `comentarios` cuando se aplica UPDATE a STATUS eliminado
--
DROP TRIGGER IF EXISTS `after_comentarios_update`;
DELIMITER $$
CREATE TRIGGER `after_publicaciones_update` AFTER UPDATE ON `comentarios` FOR EACH ROW BEGIN
if NEW.disponibilidad != OLD.disponibilidad THEN
insert into bitacora values (NEW.id_usuario, CURDATE(), CURTIME(), CONCAT("Se cambió el campo: 'disponibilidad' del comentario ", NEW.id, " de ", OLD.disponibilidad, " a ", NEW.disponibilidad), 13, 1);
end if;
end
$$
DELIMITER ;
