<?php

require_once '../models/Categoria.php';

if (isset($_POST['operacion'])){

  $categoria = new Categoria();

  switch ($_POST['operacion']) {
    case 'listar':
      echo json_encode($categoria->listar());
      break;
    case 'registrar':
      $datosEnviar = [
        'categoria'   => $_POST['categoria'],
      ];
      $categoria->registrar($datosEnviar);
      break;
  }

}