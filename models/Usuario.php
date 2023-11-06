<?php

require_once 'Conexion.php';

class Usuario extends Conexion
{
  private $conexion;

  public function __CONSTRUCT()
  {
    $this->conexion = parent::getConexion();
  }

  public function listar()
  {
    try {
      $consulta = $this->conexion->prepare("call sp_listar_usuarios_activos()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function registrar($datos = [])
  {
    try {
      $consulta = $this->conexion->prepare("CALL sp_registrar_usuario(?,?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $datos['avatar'],
          $datos['idrol'],
          $datos['idnacionalidad'],
          $datos['apellidos'],
          $datos['nombres'],
          $datos['email'],
          $datos['claveacesso']
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
      $consulta = $this->conexion->prepare("CALL sp_eliminar_usuario(?)");
      $status = $consulta->execute(
        array(
          $datos['idusuario']
        )
      );
      return $status;
    } catch (Exception $e) {
      //throw $th;
      die($e->getMessage());
    }
  }

  public function login($datos = [])
  {
    try {
      $consulta = $this->conexion->prepare("call sp_usuarios_login_correo(?)");
      $consulta->execute(
        array(
          $datos['email']
        )
      );
      return $consulta->fetch(PDO::FETCH_ASSOC);
      
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

}
