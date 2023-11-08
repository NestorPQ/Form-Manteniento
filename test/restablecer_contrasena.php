<!doctype html>
<html lang="en">

<head>
  <title>Codigo de verificación</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <div class="container">
    <div class="row">

      <h1 class="text-center mb-3 mt-4">Introduce el codigo enviado a tu correo</h1>
      <form action="" id="form-codigo">

        <div class="input input-lg mb-3">
          <input type="text" class="form-control" id="correoRecuperar" maxlength="6" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-success" id="enviar-codigo">verificar codigo</button>
        </div>

      </form>

    </div>
  </div>
  <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script>
    function $(id) {
      return document.querySelector(id);
    }

    $("#form-codigo").addEventListener("submit", (event) => {
      event.preventDefault();

      //  Obtnemos el ID de la URL
      const urlParams = new URLSearchParams(window.location.search);
      const userEmail = urlParams.get('correo');
      const codigoUser = $("#correoRecuperar").value;

      const parametro = new FormData();
      parametro.append("operacion", "buscarPorCorreoTelefono");
      // parametro.append("correoTelefono", $("#correoRecuperar").value);
      parametro.append("correoTelefono", userEmail);
      // alert(userEmail);

      fetch(`../controllers/usuario.controller.php`, {
        method: "POST",
        body: parametro
      }).
      then(response => response.json()).
      then(data => {
        data.forEach(element => {
          // console.log(element.codigo);

          if (codigoUser == element.codigo) {
            alert("Los codigo coinciden");
            window.location.href = `recover_password.php?correo=${userEmail}`;
            $("#correoRecuperar").value = '';

          } else {
            alert("Los codigo no coinciden");
            $("#correoRecuperar").value = '';
          }
        });

      }).
      catch(e => {
        console.log(e);
      });

    });
  </script>
</body>

</html>