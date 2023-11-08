<?php
session_start();  //  Crea o hereda la sesión

date_default_timezone_set("America/Lima");

require_once '../models/Usuario.php';
require_once '../test/email.php';

if (isset($_POST['operacion'])) {
  $usuario = new Usuario;

  switch ($_POST['operacion']) {
    case 'listar':
      # code...
      echo json_encode($usuario->listar());
      break;
    case 'registrar':
      $ahora = date('dmYhis');
      $nombreArchivo = sha1($ahora) . ".jpg";
      $claveEncriptada = sha1($_POST['claveacesso']);

      $datosEnviar = [
        'idrol'   => $_POST['idrol'],
        'idnacionalidad'   => $_POST['idnacionalidad'],
        'apellidos'   => $_POST['apellidos'],
        'nombres'   => $_POST['nombres'],
        'email'   => $_POST['email'],
        'claveacesso'   => $claveEncriptada,
        'avatar'   => ''
      ];

      //  Solo mover la imagen, si esta existe (uploaded)
      if (isset($_FILES['avatar'])) {
        # code...
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], "../images/" . $nombreArchivo)) {
          # code...
          $datosEnviar["avatar"] = $nombreArchivo;
        }
      }
      echo json_encode($usuario->registrar($datosEnviar));
      break;

    case 'eliminar':
      $datosEnviar = ["idusuario" => $_POST['idusuario']];
      $retorno = $usuario->eliminar($datosEnviar);
      echo ($retorno);
      break;

    case 'login':
      $datosEnviar = ["email" => $_POST["email"]];

      $registro = $usuario->login($datosEnviar);

      $statusLogin = [
        "acceso"    =>    false,
        "mensaje"   =>    ""
      ];

      if ($registro == false) {

        $_SESSION["status"] = false;
        $statusLogin["mensaje"] = "El correo no existe";
      } else {
        $claveEncriptada = $registro["claveacesso"];
        $_SESSION["idusuario"] = $registro["idusuario"];
        $_SESSION["rol"] = $registro["rol"];
        $_SESSION["apellidos"] = $registro["apellidos"];

        if (password_verify($_POST["claveacesso"], $claveEncriptada)) {
          # code...
          $_SESSION["status"] = true;
          $statusLogin["acceso"] = true;
          $statusLogin["mensaje"] = "La clave y el acceso son correctos";
        } else {
          $_SESSION["status"] = true;
          $statusLogin["mensaje"] = "Error en la clave";
        }
      }
      echo json_encode($statusLogin);
      break;

    case 'generarCodigo':

      $numero = mt_rand(100000, 999999);
      $digitos = strval($numero);

      $datosEnviar = [
        "correoOrTelefono"   => $_POST["correoOrTelefono"],
        "codigoSix"          => $digitos
      ];

      // enviamos el codigo al correo
      enviarEmail($_POST["correoOrTelefono"], $digitos);

      echo json_encode($usuario->generarCodigo($datosEnviar));

      break;
    
    case 'buscarPorCorreoTelefono':
      $datosEnviar = [
        "correoTelefono" => $_POST["correoTelefono"]];
        echo json_encode($usuario -> buscarCorreoTelefono($datosEnviar));
      break;
    case 'cambiarClaveAcesso':
      // $claveEncriptadaN = sha1($_POST['claveacesso']);
      $claveEncriptadaN = password_hash($_POST['claveacesso'], PASSWORD_DEFAULT);

      $datosEnviar = [
        'correoOrTelefono' => $_POST["correoOrTelefono"],
        // 'claveacesso'       => $_POST['claveacesso']
        'claveacesso'       => $claveEncriptadaN
      ];

      $datosCodigoNull = [
        'correoOrTelefono' => $_POST["correoOrTelefono"]
      ];

      $usuario -> cambiarCodigoNull($datosCodigoNull);

      echo json_encode($usuario -> cambiarClave($datosEnviar));
      break;

      default:
      break;
  }
}

if (isset($_GET['operacion'])) {
  if ($_GET['operacion'] == 'destroy') {
    session_destroy();
    session_unset();

    header("Location:../");
  }
}
