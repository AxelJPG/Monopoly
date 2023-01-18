<?php
require_once "../Controllers/Actions.php";

$Actions = new Actions();

$show = false;

if (isset($_POST["enviar"])) {
  $name = trim($_POST["name-player"], " ");

  $jugadores = $Actions->NroJugadores();

  if ($jugadores == 0) {
    $Actions->CreateBanck();
  }

  if ($jugadores < 7) {
    if ($Actions->ValidarDatos($name, $jugadores)) {
      $Actions->NewJugador($name);
      $id = $Actions->GetPlayerId($name);
      header("location: ./PerfilPlayers.php?item=" . $id["id"]);
    } else {
      $show = true;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel='icon' href='../Assets/monopoly.png'>
  <link rel="stylesheet" href="../Styles/UserRegistration.css">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel='apple-touch-icon' href='../Assets/monopoly.png'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>Registro</title>
</head>

<body>
  <header class="pt-5">
    <h1 class="m-0 text-center">App Banck Monopoly</h1>
  </header>

  <form action="" method="post" autocomplete="off">
    <div class="container formContent">
      <?php if ($show) { ?>
        <div class="alert alert-danger ms-5 me-5 text-center" role="alert">
          Nombre ya registrado intente nuevamente
        </div>
      <?php } ?>
      <div class="item1">
        <h5 for="name" class="form-label">Name Player</h5>
        <input type="text" class="form-control" name="name-player" required>
      </div>
      <div class="row">
        <div class="col actions-btn">
          <button type="submit" class="btn btn-success bg bg-gradient" name="enviar">Add Player</button>
        </div>
      </div>
    </div>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>