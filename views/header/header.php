<?php
session_start(); // Crea o hereda la sessión

// Perfiles de usuario = CONTROL DE ACCESO
$permisos = [
  "Supervisor" =>  ["index", "roles", "usuarios", "ventas", "reportes", "productos", "catalogo"],
  "Analista" =>  ["index", "roles", "usuarios", "ventas", "reportes", "productos"],
  "Desarrollador" =>  ["index", "roles", "usuarios", "ventas", "reportes", "productos", "catalogo"],
  "Editor" =>  ["index", "roles", "usuarios", "ventas", "reportes", "productos"],
  "Administrador" =>  ["index", "roles", "usuarios", "ventas", "reportes", "productos", "catalogo"],
  "Moderador" =>  ["index", "roles", "usuarios", "ventas", "reportes", "productos", "catalogo"],
  "Invitado" =>  ["index", "productos"],
  "Ventas" =>  ["index", "productos", "usuarios", "productos"],
];


if (!isset($_SESSION["status"]) || $_SESSION["status"] == false) {
  # code...
  echo "<h1>Acesso denegado</h1>";
  echo "<a href='../../index.php'>Iniciar Sessión</a>";
  exit();
}
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="../index/index.php">SENATI</a>
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">

        <?php
        $listaOpciones = $permisos[$_SESSION["rol"]];

        //  Lista de los modulo que tiene de acceso
        foreach ($listaOpciones as $opciones) {

          if ($opciones != "index") {
            # code...
            echo "
            <li class='nav-item'>
              <a class='nav-link style='text-transform: capitalize'' href='../{$opciones}/listar.php'>{$opciones}</a>
            </li>
            ";
          }
        }
        ?>

        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $_SESSION["apellidos"] ?>
              (<?= $_SESSION["rol"] ?>)
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownId">
              <a class="dropdown-item" href="../../controllers/usuario.controller.php?operacion=destroy">Cerrar Sessión</a>
              <a class="dropdown-item" href="#">Cambiar contraseña</a>
            </div>
          </li>
        </ul>
    </div>
  </div>
  </div>
</nav>

<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
</script>


<?php
$url = $_SERVER['REQUEST_URI'];
$arregloURL = explode("/", $url);

$vistaActual = $arregloURL[count($arregloURL) - 1];

//  Devemos verificar si la lista actual se encuentra dentro de la opciones
$permitido = false;
foreach ($listaOpciones as $opciones) {
  if ($opciones . ".php" == $vistaActual) {
    # code...
    $permitido = true;
  }
}

if (!$permisos) {
  # code...
  echo "
    <div>
    <h3>Acceso Denegado</h3>
    <hr>
    <p>Ud. no cueta con los permisos suficiente</p>
    </div>
    ";
  exit();
}


?>