<?php
class Conectar
{
  public static function Conexion()
  {
    $AccessDB = new mysqli('localhost', 'root', '', 'banck_monopoly');
    return $AccessDB;
  }
}
