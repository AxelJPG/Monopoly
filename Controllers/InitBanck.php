<?php
require_once "Actions.php";

$Actions = new Actions();

if (isset($_GET["item"])) {
  $Actions->InitBanck();
  $refresh = "/Monopoly/Pages/PerfilPlayers.php?item=" . $_GET["item"];
  header("location: $refresh");
}
