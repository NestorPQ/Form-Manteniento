<!doctype html>
<html lang="es">

<head>
  <title>Form-Caracteristica</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-body">
            <h1 class="text-center">Agregar Catarteristicas al producto</h1>
            <form  autocomplete="off" id="form-caracte">
              <div class="mb-3">
                <label for="caracteristica" class="form-label">Caracteristica:</label>
                <input type="text" class="form-control" id="caracteristica" required>
              </div>
              <div class="mb-3">
                <label for="valor" class="form-label">Valor:</label>
                <input type="text" class="form-control" id="valor" required>
              </div>
              <button type="submit" class="btn btn-primary" id="guardar-caracteristica">Agregar Caracteristica</button>
            </form>
          </div>
        </div>
      </div>
      <a href="#" class="mt-5" onclick="history.back(); return false;">
        <button type="button" class="btn btn-primary"> <-- Volver</button>
      </a>
    </div>
  </div>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

<script>
  document.addEventListener("DOMContentLoaded", () => {

    function $(id) {
      return document.querySelector(id)
    }

    //  Obtnemos el ID de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    //  Método para registrar imagenes 
    function agregarCaracteristica() {
      const parametros = new FormData();
      parametros.append("operacion", "agregarCaracteristica");
      parametros.append("idproducto", productId);
      parametros.append("caracteristica", $("#caracteristica").value);
      parametros.append("valor", $("#valor").value);


      fetch('../../controllers/producto.controller.php', {
          method: "POST",
          body: parametros
        })
        .then(response => response.json())
        .then(datos => {
          // console.log(datos);
          // console.log(parametros);
          $("#form-caracte").reset();
          // if (datos.idproducto > 0) {
          //   // alert(`Imagen agregada con ID: ${datos.idproducto}`);
          //   $("#form-caracte").reset();
          // }
        })
        .catch(e => {
          console.error(e);
        });
    }

    //  Detener el SUBMIT
    $("#form-caracte").addEventListener("submit", (event) => {
      event.preventDefault();

      if (confirm("¿Estas seguro de Guardar?")) {
        agregarCaracteristica();
        // console.log(productId);
      }
    });

  });
</script>

</html>