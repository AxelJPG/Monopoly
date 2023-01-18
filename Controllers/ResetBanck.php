<?php
require_once "Actions.php";

$Actions = new Actions();

if (isset($_GET["item"])) {
  $Actions->Reiniciar();
  header("location: /Monopoly/");
}
