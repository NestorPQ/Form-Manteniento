-- SQLBook: Code
use appstore;

create database appstore;


create table roles(
	idrol 	int auto_increment primary key,
	rol 	varchar(20) 	not null,
    create_at		datetime 		not null	default now(),
	update_at		datetime 		null,
	inactive_at		datetime 		null
);

create table nacionalidades(
	idnacionalidad 	int auto_increment primary key,
    nombrepais		varchar(60) 	not null,
    nombrecorto		varchar(4)		not null,
    create_at		datetime 		not null	default now(),
	update_at		datetime 		null,
	inactive_at		datetime 		null
);


create table usuarios(
	idusuario 		int		auto_increment		primary key,
	avatar			varchar(200)	null,
	idrol			int				not	null,
	idnacionalidad 	int				not null,
	apellidos		varchar(50)		not null,
	nombres			varchar(50)		not null,
	email			varchar(60)		not null,
	telefono		varchar(9)		not null,
	codigo 			varchar(6)		null,
	claveacesso		varchar(150)	not null,
	create_at		datetime 		not null	default now(),
	update_at		datetime 		null,
	inactive_at		datetime 		null,
	telefono varchar(9) not null,
	codigo varchar(6) null,
    constraint		fk_idrol_usu	foreign key (idrol) references roles (idrol),
    constraint		fk_idnacionalidad_usu	foreign key (idnacionalidad) references nacionalidades (idnacionalidad),
    constraint		ch_email_usu	check (email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,4}$')
);

CREATE TABLE `especificaciones` (
  `idespecificacion` int(11) NOT NULL AUTO_INCREMENT,
  `idproducto` int(11) NOT NULL,
  `caracteristica` varchar(100) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL,
  `inactive_at` datetime DEFAULT NULL,
  PRIMARY KEY (`idespecificacion`),
  KEY `fk_idproducto_esp` (`idproducto`),
  CONSTRAINT `fk_idproducto_esp` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`)
) ENGINE=InnoDB ;


alter table usuarios
add column telefono varchar(9) not null,
add column codigo varchar(6) null;

UPDATE usuarios
SET telefono = '987654321'
WHERE inactive_at IS NULL;




use appstore;
select * from usuarios;
