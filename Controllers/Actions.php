<?php
require_once "../Config/Conection.php";
class Actions
{
  private $AccessDB;

  public function __construct()
  {
    $this->AccessDB = Conectar::Conexion();
  }

  public function Reiniciar()
  {
    $this->AccessDB->query("call resetBanck()");
  }

  //Extrae el numero de jugadores registrado.
  public function NroJugadores()
  {
    $sql = $this->AccessDB->query("select count(*) from players")->fetch_assoc();
    return $sql["count(*)"];
  }

  //Crea e inicializa los valores del banco.
  public function CreateBanck()
  {
    $this->AccessDB->query("insert into players values (null, 'Banck', '#138913', 20580)");
    // $this->AccessDB->query("insert into players values (null, 'Banck', 'green', 205800)");
  }

  //Valida que los datos del jugador no estes registrados.
  public function ValidarDatos($name, $jugadores)
  {
    $resp = true;

    $sql = $this->AccessDB->query("select name from players");
    while ($row = $sql->fetch_assoc()) {
      $datos[] = $row;
    }

    for ($i = 0; $i < $jugadores; $i++) {

      if ($name == $datos[$i]["name"]) {
        return $resp = false;
      }
    }

    return $resp;
  }

  //Crea un nuevo usuario
  public function NewJugador($name)
  {
    $this->AccessDB->query("insert into players values (null, '$name', '#024581', 0)");
  }

  //Lista los datos de todos los usuarios
  public function GetPlayers()
  {
    $sql = $this->AccessDB->query("select * from players");
    while ($row = $sql->fetch_assoc()) {
      $Datos[] = $row;
    }

    return $Datos;
  }

  //Lista los nombres de los jugadores actuales
  public function GetPlayersName($id)
  {
    $sql = $this->AccessDB->query("select name, id from players where id != $id");
    while ($row = $sql->fetch_assoc()) {
      $Datos[] = $row;
    }

    return $Datos;
  }

  //Extrae el id de un jugador en especifico
  public function GetPlayerId($name)
  {
    return $this->AccessDB->query("select id from players where name = '$name'")->fetch_assoc();
  }

  //Inicializa el dinero del banco y lo reparte entre los jugadores
  public function InitBanck()
  {
    $cont = 2;
    $montoJugador = 1500;
    $montoInitBanck = 20580;

    // $montoJugador = 15000;
    // $montoInitBanck = 205800;


    $jugadores = $this->NroJugadores() - 1;

    $montoJugadores = $montoJugador * $jugadores;
    $newMontoBanck = $montoInitBanck - $montoJugadores;

    $this->AccessDB->query("update players set monto=$newMontoBanck where id = 1");

    while ($cont <= $jugadores + 1) {
      $this->AccessDB->query("update players set monto=$montoJugador where id=$cont");
      $cont++;
    }
  }

  //Extrae los datos de un jugador en especifico
  public function GetPlayer($id)
  {
    return $this->AccessDB->query("select * from players where id=$id")->fetch_assoc();
  }

  //Transfiere los datos al usuario destino
  public function TransferirMoney($idStaff, $montoStaff, $idDestiny, $montoDestiny)
  {

    echo $idDestiny;

    $newMontoStaff = $montoStaff - $montoDestiny;

    // //resta al que envia
    $this->AccessDB->query("update players set monto = $newMontoStaff where id = $idStaff");

    // //obtiene el monto actual de del que recibe
    $response = $this->AccessDB->query("select monto from players where id = $idDestiny")->fetch_assoc();

    echo $response["monto"];

    // se añade la nueva cantidad al que recibe
    $newMontoDestiny = $response["monto"] + $montoDestiny;

    $this->AccessDB->query("update players set monto = $newMontoDestiny where id = $idDestiny");
  }

  //Registra los datos de transferencia
  public function RegisterTransfers($id, $idreceives, $monto)
  {
    //nombre de la persona que recibe (enviadas)
    $response = $this->AccessDB->query("select name from players where id = $idreceives")->fetch_assoc();
    $namereceives = $response["name"];

    //resgistro de transferencia enviada
    $this->AccessDB->query("insert into transferencias_enviadas values ($id, '$namereceives', $monto, now())");
  }

  //Lista el resgistro de transferencia de un usuario en especifico
  public function GetTransfer($id)
  {
    $response = $this->AccessDB->query("select count(*) from transferencias_enviadas  where id = $id")->fetch_assoc();

    if ($response["count(*)"] != 0) {
      $sql = $this->AccessDB->query("select * from transferencias_enviadas where id = $id");
      while ($row = $sql->fetch_assoc()) {
        $Datos[] = $row;
      }

      return $Datos;
    }

    return null;
  }

  //Edita el color de perfil del usuario
  public function EditColor($id, $newColor)
  {
    $this->AccessDB->query("update players set color = '$newColor' where id = $id");
  }

  //Lista los datos de las propiedades
  public function GetDatosPropertys()
  {
    $sql = $this->AccessDB->query("select * from propertys");
    while ($row = $sql->fetch_assoc()) {
      $Datos[] = $row;
    }

    return $Datos;
  }

  //Lista los datos de las utilidades
  public function GetDatosUtilities()
  {
    $sql = $this->AccessDB->query("select * from utilities");
    while ($row = $sql->fetch_assoc()) {
      $Datos[] = $row;
    }

    return $Datos;
  }

  //Transferir Propiedad
  public function TransferirProperty($nameDestiny, $idProperty)
  {
    $this->AccessDB->query("update propertys set nombre_player='$nameDestiny' where id=$idProperty");
  }

  //Transferir Utilidad
  public function TransferirUtility($nameDestiny, $idProperty)
  {
    $this->AccessDB->query("update utilities set nombre_player='$nameDestiny' where id=$idProperty");
  }

  public function Go($idDestiny)
  {
    $saldo = $this->AccessDB->query("select monto from players where id=$idDestiny")->fetch_assoc();
    $newSaldo = $saldo["monto"] + 200;
    $this->AccessDB->query("update players set monto=$newSaldo where id=$idDestiny");

    $saldo = $this->AccessDB->query("select monto from players where name='Banck'")->fetch_assoc();
    $newSaldo = $saldo["monto"] - 200;
    $this->AccessDB->query("update players set monto=$newSaldo where name='Banck'");
  }

  //Agrega o elimina casas de una propiedad
  public function ActionsCasas($idproperty, $cantcasas)
  {
    $this->AccessDB->query("update propertys set NroC = $cantcasas where id = $idproperty");
  }

  //Agrega un hotel
  public function CreateHotel($idproperty)
  {
    $this->AccessDB->query("update propertys set NroC = 0 where id = $idproperty");
    $this->AccessDB->query("update propertys set NroH = 1 where id = $idproperty");
  }

  //Elimina un hotel
  public function DeleteHotel($idproperty)
  {
    $this->AccessDB->query("update propertys set NroC = 4 where id = $idproperty");
    $this->AccessDB->query("update propertys set NroH = 0 where id = $idproperty");
  }

  //Lista las propiedades de un jugador
  public function ListPropertys($name)
  {
    $sql = $this->AccessDB->query("select * from propertys where nombre_player = '$name'");
    while ($row = $sql->fetch_assoc()) {
      $Datos[] = $row;
    }

    return (isset($Datos)) ? $Datos : null;
  }

  public function ListPropertysPlayer($name, $color)
  {
    $sql = $this->AccessDB->query("select * from propertys where nombre_player = '$name' and color = '$color'");
    while ($row = $sql->fetch_assoc()) {
      $Datos[] = $row;
    }
    return (isset($Datos)) ? $Datos : null;
  }

  //Lista de colores de la propiedad
  public function GetColors()
  {
    $sql = $this->AccessDB->query("select distinct color from propertys");
    while ($row = $sql->fetch_assoc()) {
      $Datos[] = $row;
    }

    return (isset($Datos)) ? $Datos : null;
  }
}
