<!doctype html>
<html lang="es">

<head>
  <title>Data Sheet</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <style>
    /* Aplicar estilos personalizados para reducir el espacio en la tabla */
    .table-sm td,
    .table-sm th {
      padding: 0.25rem;
      /* Reducir el relleno (padding) de las celdas */
    }

    .table-sm {
      margin-bottom: 0;
      /* Reducir el margen inferior de la tabla */
    }
  </style>

</head>

<body>

  <?php
  require_once "../header/header.php";
  ?>

  <div class="container">
    <h1 class="text-center mt-5">Nombre y características del producto</h1>
    <hr>
    <br>
    <h5><strong>ID del producto: </strong><span id="productoId"></span></h5>
    <h5><strong>Nombre del producto: </strong><span id="productoNombre"></span></h5>


    <h4 class="mt-4">Características:</h4>
    <div id="especificaciones-producto" class="row row-cols-1 row-cols-md-3 g-2">
      <!-- Las tarjetas se agregarán aquí -->
    </div>

    <div id="sin-productos" class="alert alert-warning mt-4 p-2">
      <h4>Sin características</h4>
    </div>

    <div class="card mb-4 mt-3">
      <div class="table-responsive">
        <table class="table table-bordered table-sm table-striped">
          <tbody id="tabla-caracteristicas">
            <!-- Las características se cargarán aquí -->
          </tbody>
        </table>
      </div>
    </div>

    <a href="form-caracteristicas.php?id=<?php echo $_GET['id']; ?>">
      <button type="button" class="btn btn-primary">Agregar Especificaciones</button>
    </a>

    <h4 class="mt-4">Galeria de imagenes:</h4>
    <div id="galeria-imagenes" class="row row-cols-1 row-cols-md-3 g-4">
      <!-- Las tarjetas se agregarán aquí -->
    </div>


    <div id="sin-foto" class="alert alert-warning mt-3">
      <h4>Sin Fotos</h4>
    </div>
    <a href="form-fotos.php?id=<?php echo $_GET['id']; ?>">
      <button type="button" class="btn btn-primary">Agregar Fotos</button>
    </a>


    <!-- Modal Body -->
    <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- <h5 class="modal-title" id="modalTitleId">Modal title</h5> -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img style="width: 100%;" src="" alt="" id="visor">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Cerrar</button>
            <!-- <button type="button" class="btn btn-primary">Save</button> -->
          </div>
        </div>
      </div>
    </div>




  </div>

  <script>
    // const modalVisor = new bootstrap.Modal(document.getElementById('modal-visor'));

    function $(id) {
      return document.querySelector(id);
    }
    // Obtén el ID del producto de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productoId = urlParams.get('id');
    const productoNombre = urlParams.get('nombre');

    // Verifica si se proporcionó un ID de producto válido
    if (productoId) {
      // Muestra el ID del producto en el documento
      document.getElementById('productoId').textContent = productoId;
      document.getElementById('productoNombre').textContent = productoNombre;
    } else {
      document.getElementById('productoId').textContent = 'ID de producto no válido';
      document.getElementById('productoNombre').textContent = 'Nombre de producto no válido';
    }



    function obtenerImagenesGaleria() {
      const galeriaImagenes = document.getElementById('galeria-imagenes');
      const mensajeSinImagen = $("#sin-foto");
      const parametros = new FormData();
      parametros.append('operacion', 'listarImagenes');
      parametros.append('idproducto', productoId);

      fetch(`../../controllers/producto.controller.php`, {
          method: 'POST',
          body: parametros
        })
        .then(response => response.json())
        .then(data => {
          // console.log(data)
          // Comprueba si hay imágenes
          if (data.length > 0) {
            galeriaImagenes.innerHTML = ''; // Borra el contenido existente

            // Recorre las imágenes y crea tarjetas (cards) para mostrarlas
            data.forEach(imagen => {
              // console.log(imagen);
              // Crea una tarjeta (card) de Bootstrap
              const card = document.createElement('div');
              card.classList.add('col');

              // Crea la estructura de la tarjeta
              card.innerHTML = `
            <div class="card">
              <a href="#" >
                <img src="../../images/images-producto/${imagen.imagen}" class="card-img-top linkImagen" alt="Imagen de la galería" data-url="${imagen.imagen}">
              </a>
            </div>
          `;

              galeriaImagenes.appendChild(card);
            });
            mensajeSinImagen.classList.add("d-none");

          } else {
            // galeriaImagenes.innerHTML = 'Sin imágenes en la galería';
          }
        })
        .catch(error => {
          console.error('Error al obtener imágenes: ', error);
          galeriaImagenes.innerHTML = 'Error al cargar las imágenes';
        });
    }

    function obtenerCaracteristicasProducto() {
      const tablaCaracteristicas = document.getElementById('tabla-caracteristicas');
      const mensajeSinCaracteristicas = $("#sin-productos");

      const parametros = new FormData();
      parametros.append('operacion', 'listarCaracteristica');
      parametros.append('idproducto', productoId);

      // Realiza una solicitud para obtener las características del producto
      fetch(`../../controllers/producto.controller.php?productoId=${productoId}`, {
          method: "POST",
          body: parametros
        })
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            // Si hay características, crea filas en la tabla
            data.forEach(caracteristica => {
              const row = document.createElement('tr');
              row.innerHTML = `
                <td>${caracteristica.caracteristica}</td>
                <td>${caracteristica.valor}</td>
              `;
              tablaCaracteristicas.appendChild(row);
            });

            mensajeSinCaracteristicas.classList.add("d-none");
          } else {
            mensajeSinCaracteristicas.classList.remove("d-none");
          }
        })
        .catch(error => {
          console.error('Error al obtener características: ', error);
          mensajeSinCaracteristicas.classList.remove("d-none");
        });
    }

    const galeriaImagenes = document.getElementById('galeria-imagenes');
    // Agrega un manejador de eventos a las imágenes
    galeriaImagenes.addEventListener("click", (event) => {
      if (event.target.classList.contains("linkImagen")) {
        const ruta = event.target.dataset.url;
        const visor = document.querySelector("#visor");

        if (ruta) {
          // Verificar si la ruta de la imagen existe antes de asignarla al atributo "src"
          fetch(`../../images/images-producto/${ruta}`)
            .then((response) => {
              console.log(ruta);
              if (response.status === 200) {
                // Si la ruta existe, establece la imagen en el modal
                visor.setAttribute("src", `../../images/images-producto/${ruta}`);
              } else {
                // Si la ruta no existe, muestra "SIN FOTO"
                visor.setAttribute("src", "../../images/image-default.png"); // Limpia cualquier imagen anterior
                visor.textContent = "SIN FOTO";
              }
            })
            .catch((error) => {
              console.error(error);
            });
        } else {
          // Si no hay ruta de imagen, muestra "SIN FOTO"
          visor.setAttribute("src", "../../images/image-default.png");
          visor.textContent = "SIN FOTO";
        }

        // Abre el modal
        const myModal = new bootstrap.Modal(document.getElementById('miModal'));
        myModal.show();
      }
    });

    obtenerCaracteristicasProducto();

    // Llama a la función para obtener y mostrar las imágenes
    obtenerImagenesGaleria();
  </script>
</body>

</html>