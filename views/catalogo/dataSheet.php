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


    <h4 class="mt-4">Caracteristicas:</h4>
    <div id="especificaciones-producto" class="row row-cols-1 row-cols-md-3 g-4">
      <!-- Las tarjetas se agregarán aquí -->
    </div>

    <div id="sin-productos" class="alert alert-warning mt-3">
      <h4>Sin características</h4>
    </div>

    <div class="card">
      <div class="table-responsive">
        <table class="table table-bordered table-sm ">
          <tbody>
            <tr>
              <th>Característica</th>
              <th>Valor</th>
            </tr>
            <tr>
              <td>Marca</td>
              <td>Samsung</td>
            </tr>
            <tr>
              <td>Color</td>
              <td>Plateado</td>
            </tr>
            <tr>
              <td>Peso</td>
              <td>2 kg</td>
            </tr>
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




  </div>

  <script>
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
          // Comprueba si hay imágenes
          if (data.length > 0) {
            galeriaImagenes.innerHTML = ''; // Borra el contenido existente

            // Recorre las imágenes y crea tarjetas (cards) para mostrarlas
            data.forEach(imagen => {
              // Crea una tarjeta (card) de Bootstrap
              const card = document.createElement('div');
              card.classList.add('col');

              // Crea la estructura de la tarjeta
              card.innerHTML = `
            <div class="card">
              <img src="../../images/images-producto/${imagen.imagen}" class="card-img-top" alt="Imagen de la galería">
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

    function obtenerCaracteristicasGaleria() {
      const galeriaImagenes = document.getElementById('especificaciones-producto');
      const mensajeSinImagen = $("#sin-productos");
      const parametros = new FormData();
      parametros.append('operacion', 'listarCaracteristica');
      parametros.append('idproducto', productoId);

    }

    // Llama a la función para obtener y mostrar las imágenes
    obtenerImagenesGaleria();
    obtenerCaracteristicasGaleria();
  </script>
</body>

</html>