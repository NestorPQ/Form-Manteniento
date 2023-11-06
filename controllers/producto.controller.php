<?php

// Configurar la zonal Local
date_default_timezone_set("America/Lima");

require_once '../models/Producto.php';

if (isset($_POST['operacion'])) {

  $producto = new Producto();

  // ¿Que operación es?
  switch ($_POST['operacion']) {
    case 'listar':
      // EL método listar retorna un array PHP asociativo, esto no lo entiende el navegador
      // Entonces convertimos el arreglo en un objeto JSON y lo enviamos a la vista.
      echo json_encode($producto->listar());
      // render... ENVIAR ETIQUETAS / DATOS NAVEGADOR
      break;

    case 'listarImagenes':
      $datosEnviar = [
        'idproducto' => $_POST['idproducto']
      ];
      echo json_encode($producto->listaImagenes($datosEnviar));

      break;

    case 'agregarCaracteristica':

      $datosEnviar = [
        'idproducto'        => $_POST['idproducto'],
        'caracteristica'    => $_POST['caracteristica'],
        'valor'             => $_POST['valor']
      ];

      echo json_encode($producto->agregarCaracteristica($datosEnviar));

      break;

    case 'agregarImagen':
      // Generar un nombre a partir del momento exacto
      $ahora = date('dmYhis');
      $nombreArchivo = sha1($ahora) . ".jpg";

      // Recolectar / recibir los valores enviados desde la vista
      $datosEnviar = [
        'idproducto'   => $_POST['idproducto'],
        'imagen'    => ''
      ];

      //  Solo movemos la imagen, si esta existe (uploaded)
      if (isset($_FILES['imagen'])) {
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], "../images/images-producto/" . $nombreArchivo)) {
          // Enviamos el arreglo al método
          $datosEnviar["imagen"] = $nombreArchivo;
          if ($producto->agregarImagen($datosEnviar)) {
            // Si la imagen se agregó exitosamente, respondemos con un JSON
            echo json_encode(['idproducto' => $datosEnviar['idproducto']]);
          } else {
            // Si hubo un error al agregar la imagen, respondemos con un JSON de error
            echo json_encode(['error' => 'Hubo un error al agregar la imagen']);
          }
        } else {
          // Error al mover el archivo
          echo json_encode(['error' => 'No se pudo mover el archivo']);
        }
      } else {
        // No se recibió una imagen válida
        echo json_encode(['error' => 'No se recibió una imagen válida']);
      }
      break;

    case 'registrar':

      // Generar un nombre a partir del momento exacto
      $ahora = date('dmYhis');
      $nombreArchivo = sha1($ahora) . ".jpg";

      // Recolectar / recibir los valores enviados desde la vista
      $datosEnviar = [
        'idcategoria'   => $_POST['idcategoria'],
        'descripcion'   => $_POST['descripcion'],
        'precio'        => $_POST['precio'],
        'garantia'      => $_POST['garantia'],
        'fotografia'    => ''
      ];

      //  Solo movemos la imagen, si esta existe (uploaded)
      if (isset($_FILES['fotografia'])) {
        if (move_uploaded_file($_FILES['fotografia']['tmp_name'], "../images/" . $nombreArchivo)) {
          // Enviamos el arreglo al método
          $datosEnviar["fotografia"] = $nombreArchivo;
        }
      }

      echo json_encode($producto->registrar($datosEnviar));
      break;

    case 'eliminar':
      $datosEnviar = ["idproducto" => $_POST['idproducto']];
      $retorno = $producto->eliminar($datosEnviar);
      echo ($retorno);
      break;

    case 'filtrar':
      $idcategoria = isset($_POST['idcategoria']) ? ['idcategoria' => $_POST['idcategoria']] : 0;

      echo json_encode($producto->filtrar($idcategoria));
      break;
    case 'listarCaracteristica':
      $datosEnviar = [
        'idproducto' => $_POST['idproducto']
      ];
      echo json_encode($producto->listaEspecificaciones($datosEnviar));

      break;
  }
}
