<!doctype html>
<html lang="es">

<head>
  <title>Usuarios</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <?php
  require_once "../header/header.php";
  ?>
  <div class="container mt-3">
    <div class="alert alert-info" role="alert">
      <h4>APP STORE</h4>
      <div>LISTA USUARIOS</div>
    </div>

    <table class="table table-sm table-striped" id="tabla-usuarios">
      <colgroup>
        <col width="5%"> <!-- # -->
        <col width="10%"> <!-- Nombre -->
        <col width="30%"> <!-- Email -->
        <col width="15%"> <!-- Nacionalidad -->
        <col width="15%"> <!-- Rol -->
        <col width="10%"> <!-- Avatar -->
        <col width="15%"> <!-- Comandos -->
      </colgroup>
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Nacionalidad</th>
          <th>Rol</th>
          <th>Avatar</th>
          <th>Comandos</th>
        </tr>
      </thead>
      <tbody>
        <!-- DATOS CARGADOS DE FORMA ASINCRONA -->
      </tbody>
    </table>


  </div> <!-- ./container -->



  <!-- Modal Body -->
  <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
  <div class="modal fade" id="modal-visor" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info text-light">
          <h5 class="modal-title" id="modalTitleId">Nombre del usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img style="width: 100%;" src="" alt="" id="visor">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>


  <?php
  require_once "registrar.php";
  ?>





  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script>
    // Agregar esta línea para inicializar el modal
    const modalVisor = new bootstrap.Modal(document.getElementById('modal-visor'));

    document.addEventListener("DOMContentLoaded", () => {
      //  Objetoa para referencias a la tabla HTML
      const tabla = document.querySelector("#tabla-usuarios tbody");

      //  Mostrar los datos en la tabla
      function listarUsuarios() {
        const parametros = new FormData();
        parametros.append("operacion", "listar");

        fetch(
            `../../controllers/usuario.controller.php`, {
              method: 'POST',
              body: parametros
            })
          .then(respuesta => respuesta.json())
          .then(datosRecibido => {
            //  Recorremos cada fila del arreglo
            let numFila = 1;
            tabla.innerHTML = '';
            datosRecibido.forEach(registro => {
              let nuevaFila = '';

              //  Llenamos cada celda
              nuevaFila = `
            <tr>
                <td>${numFila}</td>
                <td>${registro.nombres}</td>
                <td>${registro.email}</td>
                <td>${registro.nacionalidad}</td>
                <td>${registro.rol}</td>
                <td>
                  <a href='#' class="linkFoto" data-url="${registro.avatar}" data-nombre="${registro.nombres}" >Ver</a>
                </td>
                <td>
                  <button data-idusuario="${registro.idusuario}" class='btn btn-danger btn-sm eliminar' type='button'>Eliminar</button>
                  <button data-idusuario="${registro.idusuario}" class='btn btn-warning btn-sm editar' type='button'>Editar</button>
                </td>
              </tr>
            
            `;

              tabla.innerHTML += nuevaFila;
              numFila++;
            });

          })
          .catch(e => {
            console.error(e)
          });
      }

      tabla.addEventListener("click", (event) => {
        if (event.target.classList.contains("linkFoto")) {
          const ruta = event.target.dataset.url;
          const nombre = event.target.dataset.nombre;

          const visor = document.querySelector("#visor");

          // document.querySelector("#visor").setAttribute("src", `../../images/users/${ruta}`);
          // document.querySelector("#modalTitleId").innerHTML = nombre;

          if (ruta) {
            // Verificar si la ruta de la imagen existe antes de asignarla al atributo "src"
            fetch(`../../images/users/${ruta}`)
              .then((response) => {
                if (response.status === 200) {
                  // Si la ruta existe, establece la imagen en el modal
                  visor.setAttribute("src", `../../images/users/${ruta}`);
                } else {
                  // Si la ruta no existe, muestra "SIN FOTO"
                  visor.setAttribute("src", ""); // Limpia cualquier imagen anterior
                  visor.textContent = "SIN FOTO";
                }
              })
              .catch((error) => {
                console.error(error);
              });
          } else {
            // Si no hay ruta de imagen, muestra "SIN FOTO"
            visor.setAttribute("src", "");
            visor.textContent = "SIN FOTO";
          }

          document.querySelector("#modalTitleId").innerHTML = nombre;

          modalVisor.toggle();
          console.log(event);
        }

        if (event.target.classList.contains("eliminar")) {
          const idusuario = event.target.dataset.idusuario;
          const parametros = new FormData;

          parametros.append("operacion", "eliminar");
          parametros.append("idusuario", idusuario);

          if (confirm("¿Estás seguro de eliminar?")) {
            fetch(`../../controllers/usuario.controller.php`, {
                method: "POST",
                body: parametros
              })
              .then(respuesta => respuesta.text())
              .then(datos => {
                console.log(datos);
                listarUsuarios();
              })
              .catch(e => {
                console.error(e);
              });
          }
        }

        if (event.target.classList.contains("editar")) {
          console.log("Proceso de edición");
        }
      })


      listarUsuarios();
    });
  </script>

</body>

</html>