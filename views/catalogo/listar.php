<!DOCTYPE html>
<html lang="es">

<head>
  <title>Catalogo</title>
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
  <div class="container mt-5">
    <h1 class="text-center">Catálogo de productos</h1>

    <div class="alert alert-primary mt-5" role="alert">
      <h4 class="alert-heading">Categorías:</h4>
    </div>

    <select class="form-select form-select-lg mb-3" aria-label="Large select example" id="categorias-catalogo" required>
      <option value="-1">Seleccione una categoría: </option>
    </select>

    <div class="row">
      <div class="col">
        <label for="filtroprecio">Precio Max:</label>
        <input type="number" class="form-control mt-1" placeholder="State" aria-label="State" id="randoPrecio" min="1" max="5" required>
      </div>
      <div class="col d-grid">
        <button type="button" class="btn btn-primary mt-4" id="btnfiltrar">Filtrar precios</button>
      </div>
    </div>

    <div id="sin-productos" class="alert alert-warning mt-3 d-none">
      <h4>Sin productos</h4>
    </div>

    <div class="row" id="productos-catalogo"></div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      function $(id) {
        return document.querySelector(id);
      }

      let dataFiltro = []; // Almacenar todos los productos

      // Método para listar las categorías
      function getCategoriasCatalogo() {
        const parametros = new FormData();
        parametros.append("operacion", "listar");

        fetch(`../../controllers/categoria.controller.php`, {
            method: "POST",
            body: parametros
          })
          .then(respuesta => respuesta.json())
          .then(datos => {
            const categoriasCatalogo = $("#categorias-catalogo");

            datos.forEach(element => {
              const tagOption = document.createElement("option");
              tagOption.value = element.idcategoria;
              tagOption.innerText = element.categoria;
              categoriasCatalogo.appendChild(tagOption);
            });

            // Agregar un controlador de eventos al cambio de selección en el select
            categoriasCatalogo.addEventListener("change", () => {
              const categoriaSeleccionada = categoriasCatalogo.value;
              if (categoriaSeleccionada) {
                // Realizar una solicitud para obtener productos por categoría
                obtenerProductosPorCategoria(categoriaSeleccionada);
              } else {
                // Limpiar la lista de productos si no se selecciona una categoría
                $("#productos-catalogo").innerHTML = "";
              }
            });
          })
          .catch(e => {
            console.error(e);
          });
      }

      function obtenerProductosPorCategoria(categoriaId) {
        const parametros = new FormData();

        parametros.append('operacion', 'filtrar');
        parametros.append('idcategoria', categoriaId);
        const productosCatalogo = $("#productos-catalogo");
        const mensajeSinProdutos = $("#sin-productos");

        fetch(`../../controllers/producto.controller.php`, {
            method: "POST",
            body: parametros
          })
          .then(respuesta => respuesta.json())
          .then(datos => {
            dataFiltro = datos; // Almacena todos los productos

            productosCatalogo.innerHTML = "";

            if (datos.length > 0) {
              renderizarProductos(datos);
              mensajeSinProdutos.classList.add("d-none");
            } else {
              mensajeSinProdutos.classList.remove("d-none");
            }
          })
          .catch(e => {
            console.error(e);
          });
      }

      function obtenerFiltro(precioMaximo) {
        // console.log(precioMaximo);
        if (precioMaximo) {
          const productosFiltrados = dataFiltro.filter(producto => parseFloat(producto.precio) <= precioMaximo);
          renderizarProductos(productosFiltrados);
        } else if (precioMaximo == 0) {
          alert("Introduce un precion mayor a 0");
        } else if (isNaN(precioMaximo)) {
          alert("Introduce un precio valido");

        }
      }

      function renderizarProductos(productos) {
        const productosCatalogo = $("#productos-catalogo");
        productosCatalogo.innerHTML = "";

        productos.forEach(producto => {
          const card = document.createElement("div");
          card.classList.add("card", "col-3", "m-3");

          producto.fotografia = producto.fotografia || "images.jpg";

          card.innerHTML = `
            <a href="dataSheet.php?id=${producto.idproducto}&nombre=${producto.descripcion}">
              <img src="../../images/${producto.fotografia}" class="card-img-top" alt="${producto.descripcion}">
            </a>
            <div class="card-body">
              <h5 class="card-title">${producto.descripcion}</h5>
              <p class="card-text">Precio: <strong>S/.${producto.precio}</strong></p>
              <a href="#" class="btn btn-outline-success btn-sm">Lo quiero</a>
            </div>
          `;
          productosCatalogo.appendChild(card);
        });
      }

      // EVENTOS
      $("#btnfiltrar").addEventListener("click", () => {
        const precio = parseFloat($("#randoPrecio").value);

        obtenerFiltro(precio);
      });

      getCategoriasCatalogo();
      obtenerProductosPorCategoria(-1);
    });
  </script>
</body>

</html>