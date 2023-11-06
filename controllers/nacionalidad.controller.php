<?php

require_once '../models/Nacionalidad.php';

if (isset($_POST['operacion'])){

  $nacionalidad = new Nacionalidad();

  switch ($_POST['operacion']) {
    case 'listar':
      echo json_encode($nacionalidad->listar());
      break;
  }
}