<?php

class Conexion
{

  //1. Almacenamos los datos de conexión
  private $servidor = "localhost";
  private $puerto = "3306";
  private $baseDatos = "appstore";
  private $usuario = "root";
  private $clave = "";

  //2. Método que retornará la conexión (será utilizada por las clases en el MODELS)
  public function getConexion()
  {

    try {
      //3. Instancia de la clase PDO (PHP Data Objects)
      //No olvidar que la sintaxis es:
      //new PDO("CADENA_CONEXION", "USUARIO_MYSQL", "CLAVE_MYSQL");
      //new PDO("mysql:host=localhost;port=3306;dbname=TU_BD;charset=UTF8", "USUARIO_MYSQL", "CLAVE_MYSQL");

      $pdo = new PDO(
        "mysql:host={$this->servidor};
        port={$this->puerto};
        dbname={$this->baseDatos};
        charset=UTF8",
        $this->usuario,
        $this->clave
      );

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
}
