<?php

require_once 'Conexion.php';

class Producto extends Conexion
{
  private $conexion;

  public function __CONSTRUCT()
  {
    $this->conexion = parent::getConexion();
  }

  public function listar()
  {
    try {
      $consulta = $this->conexion->prepare("CALL spu_productos_listar()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage()); //Desarrollo > Producción
    }
  }

  public function listaImagenes($datos = [])
  {
    try {
      $consulta = $this->conexion->prepare("call sp_listar_imagenes_por_producto(?)");
      $consulta->execute(
        array(
          $datos['idproducto']
        )
      );
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage()); //Desarrollo > Producción
    }
  }

  public function registrar($datos = [])
  {
    try {
      $consulta = $this->conexion->prepare("CALL spu_productos_registrar(?,?,?,?,?)");
      $consulta->execute(
        array(
          $datos['idcategoria'],
          $datos['descripcion'],
          $datos['precio'],
          $datos['garantia'],
          $datos['fotografia']
        )
      );
      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function eliminar($datos = [])
  {
    try {
      $consulta = $this->conexion->prepare("CALL spu_productos_eliminar(?)");
      $status = $consulta->execute(
        array(
          $datos['idproducto']
        )
      );
      return $status;
    } catch (Exception $e) {
      die($e->getMessage()); //Desarrollo > Producción
    }
  }

  public function filtrar($datos = [])
  {
    try {
      $consulta = $this->conexion->prepare("call spu_productos_listar_por_categoria(?)");
      $consulta->execute(
        array(
          $datos['idcategoria']
        )
      );
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function agregarImagen($datos = [])
  {
    try {
      $consulta = $this->conexion->prepare("CALL sp_agregar_imagen_galeria(?,?)");
      $consulta->execute(
        array(
          $datos['idproducto'],
          $datos['imagen']
        )
      );
      return json_encode($consulta->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function agregarCaracteristica($datos = []){
    try {
      $consulta = $this->conexion->prepare("call sp_insertar_especificacion(?,?,?)");
      $consulta->execute(
        array(
          $datos['idproducto'],
          $datos['caracteristica'],
          $datos['valor']
        )
      );
      return json_encode($consulta->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function listaEspecificaciones($datos = [])
  {
    try {
      $consulta = $this->conexion->prepare("call sp_listar_caracteristicas_por_producto(?);");
      $consulta->execute(
        array(
          $datos['idproducto']
        )
      );
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage()); //Desarrollo > Producción
    }
  }
}
