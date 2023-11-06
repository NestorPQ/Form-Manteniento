<?php

require_once '../models/Rol.php';

if (isset($_POST['operacion'])){

  $rol = new Rol();

  switch ($_POST['operacion']) {
    case 'listar':
      echo json_encode($rol->listar());
      break;
  }
}