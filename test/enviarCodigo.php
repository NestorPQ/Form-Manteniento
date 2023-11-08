<?php

//Load Composer's autoloader
require_once '../test/email.php';

?>


<!doctype html>
<html lang="es">

<head>
  <title>enviarCodigo</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <div class="container">
    <div class="row">

      <h1 class="text-center mb-3 mt-4">Introduce tu correo</h1>
      <form action="" id="form-codigo">

        <div class="input input-lg mb-3">
          <input type="text" class="form-control" id="correoRecuperar" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary" id="enviar-codigo">Enviar el codigo</button>
        </div>

      </form>

    </div>
  </div>



  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script>
    function $(id){
      return document.querySelector(id);
    }

    $("#form-codigo").addEventListener("submit", (event) => {
      event.preventDefault();
      
      const parametros = new FormData();
      parametros.append("operacion", "generarCodigo");
      parametros.append("correoOrTelefono", $("#correoRecuperar").value);

      const correo  = $("#correoRecuperar").value;
      fetch(`../controllers/usuario.controller.php`, {
        method: 'POST',
        body: parametros
      }).
      then(respuesta => respuesta.json()).
      then(
        data => {
          console.log(data);

          $("#correoRecuperar").value = '';
          alert("Codigo Generado");
          window.location.href = `restablecer_contrasena.php?correo=${correo}`;
        }
      ).
      catch(e => {
          console.log(e)
        }
      );
    })
  </script>

</body>

</html>