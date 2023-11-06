-- SQLBook: Code
CREATE DATABASE appstore;
USE appstore;

CREATE TABLE categorias (
	idcategoria INT PRIMARY KEY AUTO_INCREMENT,
	categoria 	VARCHAR(30)	NOT NULL,
	create_at 	DATETIME		DEFAULT NOW(),
	update_at	DATETIME		NULL,
	inactive_at	CHAR(1)		NULL
)ENGINE = INNODB;

CREATE TABLE productos(
	idproducto		INT PRIMARY KEY AUTO_INCREMENT,
	idcategoria 	INT 			NOT NULL,
	descripcion 	VARCHAR(150)	NOT NULL,
	precio			FLOAT(7,2)		NOT NULL,
	garantia		TINYINT			NOT NULL,
	fotografia		VARCHAR(200)	NULL,
	create_at 		DATETIME		DEFAULT NOW(),
	update_at		DATETIME		NULL,
	inactive_at		DATETIME		NULL,
	CONSTRAINT fk_idcategoria FOREIGN KEY (idcategoria) REFERENCES categorias(idcategoria)
)ENGINE = INNODB;

INSERT INTO categorias(categoria) VALUES
	('Computadoras'),
	('Telefonos Moviles'),
	('Monitores'),
	('Accesorios'),
	('Perifericos');

INSERT INTO productos(idcategoria, descripcion, precio, garantia) VALUES
	(1,'Laptop HP Pavilon',2500,'12'),
	(2,'iPhone 13 Pro',3500,'24'),
	(3,'Monitor LG 27',1000,'12'),
	(4,'Auricular Sony',250,'12'),
	(5,'Impresora a Epson',1500,'18');


DELIMITER $$
CREATE PROCEDURE spu_productos_listar ()
BEGIN 
	SELECT pro.idproducto, 
	cat.categoria, 
	pro.descripcion, 
	pro.precio, 
	pro.garantia, 
	pro.fotografia
	FROM productos pro
	INNER JOIN categorias cat ON cat.idcategoria = pro.idcategoria
	WHERE pro.inactive_at IS NULL;
END $$

DELIMITER $$
CREATE PROCEDURE spu_productos_buscar (IN idproducto INT)
BEGIN 
	SELECT pro.idproducto, 
	cat.categoria, 
	pro.descripcion, 
	pro.precio, 
	pro.garantia, 
	pro.fotografia
	FROM productos pro
	INNER JOIN categorias cat ON pro.idcategoria = cat.idcategoria
	WHERE pro.idproducto = idproducto;
END $$

DELIMITER $$
CREATE PROCEDURE spu_productos_registrar
(
	IN _idcategoria		INT,
	IN _descripcion 	VARCHAR(150),
	IN _precio			FLOAT(7,2),
	IN _garantia		TINYINT,
	IN _fotografia		VARCHAR(200)
)
BEGIN
	INSERT INTO productos
		(idcategoria, descripcion, precio, garantia, fotografia)
		VALUES
		(_idcategoria, _descripcion, _precio, _garantia, NULLIF(_fotografia, ''));
END $$

-- En cualquier proceso de consulta / listado / búsqueda, debemos recuperar PK
DELIMITER $$
CREATE PROCEDURE spu_categorias_listar()
BEGIN
	SELECT idcategoria, categoria
		FROM categorias
		WHERE inactive_at IS NULL;
END $$

DELIMITER $$
CREATE PROCEDURE spu_categorias_registrar(
	IN _categoria 	VARCHAR(30)
)
BEGIN
	INSERT INTO categorias (categoria) VALUES (_categoria);
END $$

select * from productos
