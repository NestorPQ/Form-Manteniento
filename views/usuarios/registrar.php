<!doctype html>
<html lang="es">

<head>
  <title>Registrar Usuarios</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>

  <div class="container mt-5">

    <form action="" id="form-usuario" autocomplete="off">
      <div class="card">
        <div class="card-header bg-primary text-light">
          REGISTRO DE USUARIOS
        </div>
        <div class="card-body">

          <div class="mb-3">
            <label for="nombres" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombres" required>
          </div>

          <div class="mb-3">
            <label for="apellidos" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellidos" required>
          </div>

          <div class="row">

            <div class="col-md-6 mb-3">
              <label for="idrol" class="form-label">Seleccione su rol: </label>
              <select name="" id="idrol" class="form-select" required>
                <option value="">Seleccione: </option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="idnacionalidad" class="form-label">Seleccione su nacionalidad</label>
              <select name="" id="idnacionalidad" class="form-select" required>
                <option value="">Seleccione: </option>
              </select>
            </div>
            
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" required>
          </div>

          <div class="mb-3">
            <label for="claveacesso" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="claveacesso" required>
          </div>


          <div class="col-md-6 mb-3">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file" class="form-control" id="avatar" accept=".jpg">
          </div>
        </div>

        <div class="card-footer text-end">
          <button class="btn btn-primary btn-sm" id="guardar" type="submit">Registrar Usuario</button>
        </div>
      </div>

    </form>
  </div>
  


  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>


  <script>
    document.addEventListener("DOMContentLoaded", () => {
      function $(id) {
        return document.querySelector(id)
      }

      //  Método para traer y buscar rol
      function getRol() {
        // Datos que enviaremos al controlador
        const parametros = new FormData();
        parametros.append("operacion", "listar");

        // Conexión, el Valor Obtenido, el Proceso, el Error
        fetch(`../../controllers/rol.controller.php`, {
            method: "POST",
            body: parametros
          })
          .then(respuesta => respuesta.json())
          .then(datos => {
            datos.forEach(element => {
              const tagOption = document.createElement("option")
              tagOption.value = element.idrol
              tagOption.innerText = element.rol
              $("#idrol").appendChild(tagOption)
            });
          })
          .catch(e => {
            console.error(e);
          });
      }

      //  Método para traer y buscar la nacionalidad
      //  Método para traer y buscar rol
      function getNacionalidad() {
        // Datos que enviaremos al controlador
        const parametros = new FormData();
        parametros.append("operacion", "listar");

        // Conexión, el Valor Obtenido, el Proceso, el Error
        fetch(`../../controllers/nacionalidad.controller.php`, {
            method: "POST",
            body: parametros
          })
          .then(respuesta => respuesta.json())
          .then(datos => {
            datos.forEach(element => {
              const tagOption = document.createElement("option")
              tagOption.value = element.idnacionalidad
              tagOption.innerText = element.nombrepais
              $("#idnacionalidad").appendChild(tagOption)
            });
          })
          .catch(e => {
            console.error(e);
          });
      }

      function userRegister() {
        const parametros = new FormData();
        parametros.append("operacion", "registrar");
        parametros.append("idrol", $("#idrol").value);
        parametros.append("idnacionalidad", $("#idnacionalidad").value);
        parametros.append("nombres", $("#nombres").value);
        parametros.append("apellidos", $("#apellidos").value);
        parametros.append("email", $("#email").value);
        parametros.append("claveacesso", $("#claveacesso").value);

        parametros.append("avatar", $("#avatar").files[0]);

        fetch('../../controllers/usuario.controller.php', {
            method: "POST",
            body: parametros
          })
          .then(
            respuesta => respuesta.json())
          .then(datos => {
            console.log(datos);
            $("#form-usuario").reset();
            if (datos.idusuario > 0) {
              alert(`Usuario registrado con ID: ${datos.idusuario}`)
              // document.getElementById("form-usuario").reset();
              $("#form-usuario").reset();

            }
          })
          .catch(e => {
            console.error(e);
          })
      }

      $("#form-usuario").addEventListener("submit", (event) => {
        event.preventDefault(); // Stop al Evento

        if (confirm("¿Está seguro de Guardar?")) {
          userRegister();
        }
      });

      getRol();
      getNacionalidad();
    });
  </script>

</body>

</html>