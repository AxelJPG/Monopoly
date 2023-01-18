<?php
require_once "../Controllers/Actions.php";

$Actions = new Actions();

//Datos del jugador
$id = $_GET["item"];
$datos = $Actions->GetPlayer($id);
//Lista de colores de las propiedades
$listColors = $Actions->GetColors();
//Lista de nombre de los demas jugadores
$datosPlayers = $Actions->GetPlayersName($id);
//Lista de propiedades del jugador
$propertys = $Actions->ListPropertys($datos["name"]);
// Valida la visivilidad de ciertas etiquetas
$IfBanck = ($id == 1) ? true : false;
$Bancarrota = ($datos["monto"] == 0) ? true : false;

//Lista la propiedades por color
if (isset($_POST["color"])) {
  $propertys = ($_POST["color"] == 'null')
    ? $Actions->ListPropertys($datos["name"])
    : $Actions->ListPropertysPlayer($datos["name"], $_POST["color"]);
}
//Transferencia De Dinero
if (isset($_POST["enviar"])) {
  $idDestiny = $_POST["jugador"];
  $montoDestiny = $_POST["cantidad"];
  $Actions->TransferirMoney($datos["id"], $datos["monto"], $idDestiny, $montoDestiny);
  header("location: " . $_SERVER["PHP_SELF"] . "?item=" . $datos["id"]);
}
//Transferecia de propiedades
if (isset($_POST["propertyTransfer"])) {
  $Actions->TransferirProperty($_POST["propiedad"], $_POST["jugador"]);
  header("location: " . $_SERVER["PHP_SELF"] . "?item=" . $datos["id"]);
}
//Envia 200 a un jugador especifico
if (isset($_POST["Go"])) {
  $Actions->Go($_POST["jugador"]);
  header("location: " . $_SERVER["PHP_SELF"] . "?item=" . $datos["id"]);
}

// echo "<pre>";
// print_r($listColors);
//
// if () {
//   # code...
// }

//Numero de jugadores actuales
// $jugadores = $Actions->NroJugadores();
//Datos de transferencia del jugador
// $datosTransfer = $Actions->GetTransfer($datos["id"]);
//Lista de utilidades del jugador
// $utilities = $Actions->ListUtilitiesPlayer($datos["name"]);


// //Envia 200 a un jugador especifico
// if (isset($_POST["Go"])) {
//   $Actions->Go($_POST["idGo"]);
//   header("location: " . $_SERVER["PHP_SELF"] . "?item=" . $datos["id"]);
// }



// if (isset($_POST["utilitiesTransfer"])) {
//   $Actions->TransferirUtility($_POST["playerTransf"], $_POST["idproperty"]);
//   header("location: " . $_SERVER["PHP_SELF"] . "?item=" . $datos["id"]);
// }

// //Etita el color de la interfaz
// if (isset($_POST["EditColor"])) {
// $Actions->EditColor($datos["id"], $_POST["Color"]);
// header("location: " . $_SERVER["PHP_SELF"] . "?item=" . $datos["id"]);
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="../Assets/monopoly.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="apple-touch-icon" href="../Assets/monopoly.png">
  <link rel="stylesheet" href="../Styles/PerfilPlayers.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Selecciones Su Perfil</title>

  <!-- CSS Bootstrap -->
  <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
  <!-- CSS Swiper"s -->
  <link rel="stylesheet" href="../Swiper/css/swiper-bundle.min.css">
  <!-- CSS Animation Icon -->
  <link rel="stylesheet" href="../BoxIcon/boxicons.min.css">

</head>

<body>
  <header class="d-flex justify-content-between align-items-center px-3 py-2">
    <h1 class="m-0">App Banck Monopoly</h1>

    <button style="background-color: <?php echo $datos["color"] ?>;" type="button" class="btn btn-success text-white bg bg-gradient" data-bs-toggle="modal" data-bs-target="#ModalEditColor">Color</button>
  </header>


  <?php if ($Bancarrota) { ?>
    <div class="alert alert-danger text-center mx-2 mb-2" role="alert">Perdiste estas en vanca rota!</div>
  <?php } ?>

  <!-- <?php if ($IfBanck) { ?>
    <div class="container text-center pb-2">
      <div class="btn-group gap-2" role="group" aria-label="Basic example">
        <button type="button" class="btn bg bg-gradient" style="background-color: <?php echo $datos["color"] ?>;">
          <a class="text-decoration-none text-white" href="../Controllers/InitBanck.php?item=<?php echo $datos["id"] ?>">Iniciar</a>
        </button>
        <button type="button" class="btn btn-danger bg bg-gradient">
          <a class="text-decoration-none text-white" href="../Controllers/ResetBanck.php?item=<?php echo $datos["id"] ?>">Reiniciar</a>
        </button>
        <button type="button" class="btn bg bg-gradient bg bg-gradient" style="background-color: <?php echo $datos["color"] ?>;">
          <a class="text-decoration-none text-white" href="./PropertyCatalog.php?item=<?php echo $datos["id"] ?>">Catalog</a>
        </button>
      </div>
    </div>
  <?php } ?> -->


  <div class="card mb-2 mx-2">
    <div class="card-header bg bg-gradient text-white d-flex justify-content-between py-2" style="background-color: <?php echo $datos["color"]; ?>;">
      <h3 class="m-0"><?php echo $datos["name"]; ?></h3>
      <h3 class="m-0"><?php echo $datos["monto"]; ?></h3>
    </div>
    <div class="card-body p-2 pb-3">

      <!-- transacciones -->
      <form class="d-flex justify-content-center align-items-end gap-3" action="" method="post">
        <div class="col-4">
          <label for="cantidad" class="form-label">Cantidad</label>
          <input type="number" name="cantidad" id="cantidad" class="form-control" required max="<?php echo $datos["monto"] ?>">
        </div>

        <div class="col-4">
          <label for="jugador" class="form-label">Jugador</label>
          <select name="jugador" id="jugador" class="form-select" required>
            <option value="">Select...</option>
            <?php foreach ($datosPlayers as $item) { ?>
              <option value="<?php echo $item["id"] ?>"> <?php echo $item["name"] ?> </option>
            <?php } ?>

          </select>
        </div>

        <button type="submit" class="btn bg bg-gradient text-white" name="enviar" style="background-color: <?php echo $datos["color"] ?>;" <?php echo ($Bancarrota) ? "disabled" : "hola"; ?>>
          Transferir
        </button>
      </form>

      <!-- Go -->
      <?php if ($datos["id"] == 1) { ?>
        <hr class="my-3">

        <form class="d-flex justify-content-center align-items-end gap-2" action="" method="post">
          <div class="col-4">
            <select name="jugador" id="playerTransfGo" class="form-select" required>
              <option value="">Select...</option>
              <?php
              foreach ($datosPlayers as $itemGo) { ?>
                <option value="<?php echo $itemGo["id"] ?>"> <?php echo $itemGo["name"] ?> </option>
              <?php } ?>
            </select>
          </div>

          <button type="submit" name="Go" class="btn text-white bg bg-gradient" style="background-color: <?php echo $datos["color"] ?>;">Go</button>
        </form>
      <?php } ?>
    </div>
  </div>

  <div class="container px-2">
    <div class="card-header text-white py-3 px-3  mb-2 rounded bg bg-gradient d-flex flex-column gap-3" style="background-color:<?php echo $datos["color"] ?>">
      <div class="d-flex justify-content-between">
        <h4 class="m-0">Propiedades</h4>
        <h4 class="m-0"><?php echo ($propertys == null) ? 0 : count($propertys); ?></h4>
      </div>

      <form action="" method="post">
        <div class="d-flex justify-content-between align-items-center">
          <button type="submit" name="color" class="btn bg bg-gradient" style="border-radius: 50%; height: 1.5em; background-color: white;" value="null"></button>
          <?php foreach ($listColors as $item) {
          ?>
            <button class="btn bg bg-gradient bx-flashing" type="submit" name="color" style="border-radius: 50%; height: 1.5em; background-color: <?php echo $item["color"] ?>;" value="<?php echo $item["color"] ?>">
            </button>
          <?php }
          ?>
        </div>
      </form>
    </div>
  </div>

  <div class="container" style="height: 48vh;">
    <div class=" swiper mySwiper">
      <div class="swiper-wrapper">
        <?php if ($propertys != null) { ?>
          <?php foreach ($propertys as $item) { ?>
            <div class="card swiper-slide" style="background-color: aliceblue;">
              <div class="card-header text-center text-white p-3" style="background-color:<?php echo $item["color"] ?>">
                <h5 class="m-0"><?php echo $item["nombre"] ?></h5>
              </div>

              <div class="card-body p-0 d-flex flex-column justify-content-evenly">
                <div class="container text-center">
                  <p class="m-0">Alquier <?php echo $item["alquiler"] ?></p>
                </div>

                <div class="container text-center">
                  <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                    <p class="m-0">Valor con 1 casa</p>
                    <p class="m-0"><?php echo $item["alquiler1"] ?></p>
                  </div>
                  <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                    <p class="m-0">Valor con 2 casa</p>
                    <p class="m-0"><?php echo $item["alquiler2"] ?></p>
                  </div>
                  <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                    <p class="m-0">Valor con 3 casa</p>
                    <p class="m-0"><?php echo $item["alquiler3"] ?></p>
                  </div>
                  <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                    <p class="m-0">Valor con 4 casa</p>
                    <p class="m-0"><?php echo $item["alquiler4"] ?></p>
                  </div>
                  <div class="d-flex justify-content-between align-items-center ps-3 pe-3">
                    <p class="m-0">Valor con Hotel</p>
                    <p class="m-0"><?php echo $item["alquilerH"] ?></p>
                  </div>
                </div>

                <div class="container text-center">
                  <p class="m-0">Valor de propiedades: <?php echo $item["precioP"] ?></p>
                  <p class="m-0">Hipoteca: <?php echo $item["hipoteca"] ?></p>
                </div>

                <div class="container text-center d-flex justify-content-center align-items-center gap-1">
                  <div class="col-4 d-flex justify-content-center align-items-center">
                    <?php if ($item["NroH"] != 0) {  ?>
                      <box-icon name="buildings" type="solid" color="#138225" size="sm"></box-icon>
                    <?php } ?>
                  </div>

                  <div class="col-8 d-flex justify-content-center align-items-center gap-1">
                    <?php for ($i = 0; $i < $item["NroC"]; $i++) { ?>
                      <box-icon name="home-alt-2" type="solid" color="#f90101" size="sm"></box-icon>
                    <?php } ?>
                  </div>
                </div>

                <div class="container text-center">
                  <p class="m-0">Dueño: <?php echo $item["nombre_player"] ?></p>
                </div>

                <div class="container text-center p-0">
                  <div class="btn-group text-center" role="group" aria-label="Basic example">
                    <button type="button" class="btn bg bg-gradient text-white" style="font-size: 12px; background-color: <?php echo $item["color"] ?>" data-bs-toggle="modal" data-bs-target="#transfProperty<?php echo $item["id"] ?>">Transferir</button>
                    <?php if ($IfBanck) { ?>
                      <button type="button" class="btn bg bg-gradient text-white" style="font-size: 12px; background-color: <?php echo $item["color"] ?>" data-bs-toggle="modal" data-bs-target="#Property<?php echo $item["id"] ?>">Propiedades</button>
                      <button type="button" class="btn btn-primary" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#property">Hipotecar</button>
                    <?php } ?>
                  </div>
                </div>

              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>

    <?php if ($propertys != null) { ?>
      <?php foreach ($propertys as $item) { ?>
        <!-- Modal transferir propiedades -->
        <div class="modal fade" id="transfProperty<?php echo $item["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg bg-gradient" style="background-color:<?php echo $item["color"] ?> ;">
                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Transferir (<?php echo $item["nombre"] ?>)</h1>
              </div>
              <div class="modal-body">
                <form class="d-flex justify-content-center align-items-end gap-3" action="" method="post">
                  <div class="col-6">
                    <input type="hidden" name="jugador" value="<?php echo $item["id"] ?>">
                    <label for="propiedad" class="form-label">Nuevo Dueño</label>
                    <select name="propiedad" id="propiedad" class="form-select" required>
                      <option value="">Select...</option>
                      <?php foreach ($datosPlayers as $NamePlayer) { ?>
                        <option value="<?php echo $NamePlayer["name"] ?>"><?php echo $NamePlayer["name"] ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <button type="submit" name="propertyTransfer" class="btn bg bg-gradient text-white" style="background-color:<?php echo $item["color"] ?>">Transferir</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal compra propiedades -->
        <div class="modal fade" id="Property<?php echo $item["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg bg-gradient" style="background-color:<?php echo $item["color"] ?> ;">
                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Transferir (<?php echo $item["nombre"] ?>)</h1>
              </div>
              <div class="modal-body">
                <!-- Action Casas -->
                <form action="" method="post">
                  <h4 class="text-center">Casas</h4>
                  <div class="d-flex flex-column gap-3 align-items-center">

                    <input type="hidden" name="idproperty" value="<?php echo $item["id"] ?>">

                    <div>
                      <div class="form-check form-check-inline">
                        <label class="form-check-label" for="radio0">0</label>
                        <input class="form-check-input" type="radio" name="casas" id="radio0" value="0" required>
                      </div>
                      <div class="form-check form-check-inline">
                        <label class="form-check-label" for="radio1">1</label>
                        <input class="form-check-input" type="radio" name="casas" id="radio1" value="1" required>
                      </div>
                      <div class="form-check form-check-inline">
                        <label class="form-check-label" for="radio2">2</label>
                        <input class="form-check-input" type="radio" name="casas" id="radio2" value="2" required>
                      </div>
                      <div class="form-check form-check-inline">
                        <label class="form-check-label" for="radio3">3</label>
                        <input class="form-check-input" type="radio" name="casas" id="radio3" value="3" required>
                      </div>
                      <div class="form-check form-check-inline">
                        <label class="form-check-label" for="radio4">4</label>
                        <input class="form-check-input" type="radio" name="casas" id="radio4" value="4" required>
                      </div>
                    </div>

                    <button type="submit" name="btmCasas" class="btn bg bg-gradient text-white" style="background-color:<?php echo $item["color"] ?>">Hecho</button>
                  </div>
                </form>

                <hr>

                <!-- Hotel -->
                <form class="d-flex flex-column justify-content-center align-items-center" action="" method="post">
                  <h4 class="">Hotel</h4>

                  <input type="hidden" name="jugador" value="<?php echo $item["id"] ?>">
                  <input type="hidden" name="accion" value="<?php echo (($item["NroH"] == 0)) ? "agregar" : "eliminar"; ?>">
                  <button type="submit" name="<?php ?>" class="btn bg bg-gradient text-white" style="background-color:<?php echo $item["color"] ?>"><?php echo (($item["NroH"] == 0)) ? "Agregar" : "Eliminar"; ?></button>

                </form>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
  </div>


  <!-- <div class="card mt-3 ms-2 me-2 p-2">
    <h3 class=" card-header text-center text-white pt-3 pb-3 bg bg-gradient" style="background-color: <?php echo $datos["color"] ?>;">Transfer History</h3>

    <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
            Transferencias Enviadas
          </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">

            <?php if ($datosTransfer == null) { ?>
              <h6 class="text-danger text-center">No se han realizado transacciones</h6>
            <?php } ?>

            <?php if ($datosTransfer !=  null) { ?>
              <table class="table table-striped text-center" id="TableTransfer">
                <thead>
                  <tr>
                    <th>Recive</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  foreach ($datosTransfer as $item) {
                    $fecha = explode(" ", $item["time_transfers"]);
                    $hora = explode(":", $fecha[1]);
                  ?>

                    <tr>
                      <td><?php echo $item["recive"] ?></td>
                      <td><?php echo $item["transferMonto"] ?></td>
                      <td><?php echo $hora[0] . ":" . $hora[1] ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div> -->


  <!-- Modal Edit color-->
  <div class="modal fade" id="ModalEditColor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg bg-gradient text-white" style="background-color: <?php echo $datos["color"] ?>;">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Color</h1>
        </div>
        <div class="modal-body">
          <form action="" class="d-flex flex-column justify-content-center align-items-center gap-3" method="post">
            <input type="color" name="Color" class="input-color" value="<?php echo $datos["color"] ?>">
        </div>
        <div class="modal-footer">
          <button type="submit" name="EditColor" class="btn text-white bg bg-gradient" style="background-color: <?php echo $datos["color"] ?>;">Cambiar Color</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Script Icon -->
  <script src="../BoxIcon//boxicons.js"></script>
  <!-- Script Bootstrap -->
  <script src="../Bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Script Jquery -->
  <script src="../Jquery/jquery-3.6.3.min.js"></script>
  <!-- Script Swiper -->
  <script src="../Swiper/js/swiper-bundle.min.js"></script>

  <!-- <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> -->

  <script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 1.45,
      spaceBetween: 30,
      freeMode: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  </script>
</body>

</html>