<!doctype html>
<html lang="es">

<head>
  <title>Cambiar Contraseña</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <div class="container">
    <div class="row">
      <h1 class="text-center mb-3 mt-4">Cambiar Contraseña</h1>
      <form action="" id="form-clave">
        <div class="mb-3">
          <label for="nuevaContrasena" class="form-label">Nueva Contraseña</label>
          <input type="password" class="form-control" id="nuevaContrasena" name="nuevaContrasena" required>
        </div>
        <div class="mb-3">
          <label for="confirmarContrasena" class="form-label">Confirmar Contraseña</label>
          <input type="password" class="form-control" id="confirmarContrasena" name="confirmarContrasena" required>
        </div>
        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
      </form>
    </div>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script src="./funciones.js"></script>
  <script>
    $("#form-clave").addEventListener("submit", (event) => {
      event.preventDefault();

      //  Obtnemos el ID de la URL
      const urlParams = new URLSearchParams(window.location.search);
      const userEmail = urlParams.get('correo');

      const nuevaContra = $("#nuevaContrasena").value;
      const confirContra = $("#confirmarContrasena").value;
      
      if (nuevaContra == confirContra) {
        alert("Las contraseñas son iguales");
        alert(`Y tu correo/telefono es ${userEmail}`);

        const parametros = new FormData();
        parametros.append("operacion","cambiarClaveAcesso");
        parametros.append("claveacesso", $("#nuevaContrasena").value);
        parametros.append("correoOrTelefono", userEmail);


        fetch(`../controllers/usuario.controller.php`, {
          method: "POST",
          body: parametros
        }).
        then(response => response.json()).
        then(data => {
          // console.log(data);       

          window.location.href = `../../appstore/`;

        }).
        catch(e => console.log(e));

      }else{
        alert("Las contraseñas no coinciden");
      }
    });
  </script>
</body>

</html>