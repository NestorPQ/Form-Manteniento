
--  SP para registrar usuario
DELIMITER $$
CREATE PROCEDURE sp_registrar_usuario(
    IN p_avatar VARCHAR(200),
    IN p_idrol INT,
    IN p_idnacionalidad INT,
    IN p_apellidos VARCHAR(50),
    IN p_nombres VARCHAR(50),
    IN p_email VARCHAR(60),
    IN p_claveacesso VARCHAR(150)
)
BEGIN
    INSERT INTO usuarios (avatar, idrol, idnacionalidad, apellidos, nombres, email, claveacesso)
    VALUES (NULLIF(p_avatar, ''), p_idrol, p_idnacionalidad, p_apellidos, p_nombres, p_email, p_claveacesso);
END$$

--  SP para eliminacion logica del usuario
DELIMITER $$
CREATE PROCEDURE sp_eliminar_usuario(
    IN p_idusuario INT
)
BEGIN
    UPDATE usuarios
    SET inactive_at = NOW()
    WHERE idusuario = p_idusuario;
END$$
DELIMITER ;


--  SP para listar los usuarios activos
DELIMITER $$
CREATE PROCEDURE sp_listar_usuarios_activos()
BEGIN
    SELECT 
		us.idusuario,
        us.avatar,
        rol.rol as 'rol',
        nac.nombrepais as 'nacionalidad',
        us.apellidos,
        us.nombres,
        us.email
    FROM usuarios us
    INNER JOIN roles rol ON us.idrol = rol.idrol
    INNER JOIN nacionalidades nac ON us.idnacionalidad = nac.idnacionalidad
    WHERE us.inactive_at IS NULL;
END$$

--  SP para listar las nacionalidades
DELIMITER $$
CREATE PROCEDURE sp_listar_nacionalidad()
BEGIN
    SELECT 
		*
    FROM nacionalidades;
END$$

--  SP para listar los roles
DELIMITER $$
CREATE PROCEDURE sp_listar_roles()
BEGIN
    SELECT 
		*
    FROM roles;
END$$


call sp_listar_usuarios_activos();

CALL sp_registrar_usuario(?,?,?,?,?,?,?);

select * from usuarios;
-- Llamada al procedimiento almacenado para registrar un usuario
CALL sp_registrar_usuario(
    '', -- Puedes proporcionar la ruta de la imagen o un valor vacío si no tienes una
    1,                -- ID de rol (debes tener un rol válido en la tabla roles)
    1,                -- ID de nacionalidad (debes tener una nacionalidad válida en la tabla nacionalidades)
    'Pomachahua Quispe',       -- Apellido del usuario
    'Néstor',         -- Nombre del usuario
    'nestorpq2001@gmail.com', -- Dirección de correo electrónico válida
    'nestor200'   -- Clave de acceso del usuario
);


   
DELIMITER $$
CREATE PROCEDURE sp_usuarios_login_test(in _iduser int)
BEGIN
    SELECT 
		us.idusuario,
        us.avatar,
        rol.rol as 'rol',
        nac.nombrepais as 'nacionalidad',
        us.apellidos,
        us.nombres,
        us.email
    FROM usuarios us
    INNER JOIN roles rol ON us.idrol = rol.idrol
    INNER JOIN nacionalidades nac ON us.idnacionalidad = nac.idnacionalidad
    WHERE us.inactive_at IS NULL AND
    us.idusuario = _iduser;
END $$

DELIMITER $$
CREATE PROCEDURE sp_usuarios_login_correo(in _email varchar(60))
BEGIN
    SELECT 
		us.idusuario,
        us.avatar,
        rol.rol as 'rol',
        nac.nombrepais as 'nacionalidad',
        us.apellidos,
        us.nombres,
        us.email,
        us.claveacesso
    FROM usuarios us
    INNER JOIN roles rol ON us.idrol = rol.idrol
    INNER JOIN nacionalidades nac ON us.idnacionalidad = nac.idnacionalidad
    WHERE us.inactive_at IS NULL AND
    us.email = _email;
END $$

CREATE VIEW vista_productos AS
SELECT 
    pro.idproducto,
    cat.idcategoria,
    cat.categoria,
    pro.descripcion,
    pro.precio,
    pro.garantia,
    pro.fotografia,
    pro.create_at
FROM productos pro
INNER JOIN categorias cat ON cat.idcategoria = pro.idcategoria
WHERE pro.inactive_at IS NULL;


DELIMITER $$
CREATE PROCEDURE spu_productos_listar_por_categoria(IN categoria_id INT)
BEGIN
    IF categoria_id = -1 THEN
        -- Devolver todos los productos usando la vista
        SELECT * FROM vista_productos
        ORDER BY create_at
        LIMIT 12;
    ELSE
        -- Devolver productos por la categoría especificada usando la vista
        SELECT * FROM vista_productos
        WHERE idcategoria = categoria_id  -- Usar el nombre real de la columna
        ORDER BY create_at
        LIMIT 12;
    END IF;
END $$

DELIMITER $$
CREATE PROCEDURE sp_listar_caracteristicas_por_producto(_idproducto  INT)
BEGIN
    SELECT 
        caracteristica, 
        valor
        FROM especificaciones
        WHERE   idproducto = _idproducto 
        AND     inactive_at IS NULL;
END $$

call sp_listar_caracteristicas_por_producto(1);


DELIMITER $$
CREATE PROCEDURE GenerarCodigoUsuario(IN usuario_identifier VARCHAR(60), IN codigo_generado VARCHAR(6))
BEGIN
    DECLARE usuario_id INT;

    -- Buscar al usuario según el correo electrónico o el número de teléfono
    SELECT idusuario INTO usuario_id FROM usuarios WHERE email = usuario_identifier OR telefono = usuario_identifier;

    -- Si se encontró un usuario, asignar el código
    IF usuario_id IS NOT NULL THEN
        UPDATE usuarios SET codigo = codigo_generado WHERE idusuario = usuario_id;
    END IF;
END $$

DELIMITER $$
create PROCEDURE BuscarUsuarioPorCorreoOTelefono(
  IN pCorreoOrTelefono VARCHAR(255)
)
BEGIN
  SELECT * FROM usuarios
  WHERE email = pCorreoOrTelefono OR telefono = pCorreoOrTelefono;
END $$


DELIMITER $$
CREATE PROCEDURE CambiarContrasena(IN pCorreoTelefono VARCHAR(255), IN pNuevaContrasena VARCHAR(255))
BEGIN
  DECLARE vUsuarioID INT;

  -- Buscar al usuario por correo o teléfono
  SELECT idusuario INTO vUsuarioID
  FROM usuarios
  WHERE email = pCorreoTelefono OR telefono = pCorreoTelefono;

  -- Verificar si se encontró al usuario
  IF vUsuarioID IS NOT NULL THEN
    -- Actualizar la contraseña del usuario
    UPDATE usuarios
    -- SET claveacesso = SHA1(pNuevaContrasena)
    SET claveacesso = pNuevaContrasena
    WHERE idusuario = vUsuarioID;

    SELECT 'Contraseña actualizada' AS mensaje;
  ELSE
    SELECT 'Usuario no encontrado' AS mensaje;
  END IF;
END $$

call CambiarContrasena("987654321", "clavecambiada");

DELIMITER $$

CREATE PROCEDURE LimpiarCodigo(IN pCorreoTelefono VARCHAR(255))
BEGIN
  UPDATE usuarios
  SET codigo = NULL
  WHERE email = pCorreoTelefono OR telefono = pCorreoTelefono;
  
  SELECT 'Código limpiado' AS mensaje;
END $$
DELIMITER ;



select * from usuarios;

call BuscarUsuarioPorCorreoOTelefono("987654321");


update usuarios 
set telefono = "987654321"
where idusuario = 1;

CALL GenerarCodigoUsuario('987654321', '000000');







use appstore;
call spu_productos_listar_por_categoria(2);
--  SENATI123
update usuarios set
	claveacesso = "$2y$10$.v7KLNpu6.uUnW5Wb7t0R.CY4ij4mS730s2VCTHcaNhVHFnslLdCC";

select * from usuarios;
-- luis.gonzalez@example.com

select * from galerias;

delete from galerias where idgaleria in(20,21,22,23,24);
