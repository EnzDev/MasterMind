<?php
require_once __DIR__."/../V/error.php";
require_once __DIR__."/../V/game.php";
require_once __DIR__."/../V/home.php";
require_once __DIR__."/../V/results.php";


require_once __DIR__.'/../C/authCtrl.php';
require_once __DIR__.'/../C/gameCtrl.php';

// session_start();
/**
 *
 */

class router {
  private $authCtl;
  function __construct() {
    $this->authCtl = new AuthCtl();
    $this->gameCtl = new GameCtl();
    $this->db      = new DB();
  }

  public function routerReq()  {
    $doReset = false;
    if (isset($_GET["reset"])) { $doReset = true; }

    if (isset($_POST["username"]) && !empty($_POST["username"])){
      switch ($this->authCtl->auth($_POST["username"],$_POST["password"])) {
        case 0:
          $_SESSION["online"] = true;
          $_SESSION["username"] = $_POST["username"];
          $this->gameCtl->launch($doReset);
          break;
        case -1:
          $_SESSION["alert"] = "Mot de passe invalide, réessayez";
          (new Home())->launch();
          break;
        case -2:
          $_SESSION["alert"] = "Nom d'utilisateur inconnu";
          (new Home())->launch();
          break;
      }
    }elseif (!isset($_SESSION["online"]) || $_SESSION["online"]==false){ (new Home())->launch();
    }elseif ($_SESSION["online"]==true) {
      if (isset($_GET["stat"])) {
        $status = isset($_SESSION["started"]) && $_SESSION["started"]  ? 9 : $this->gameCtl->win();
        (new results())->launch(
          $_SESSION["username"],
          $status,
          $this->db->avgCoups($_SESSION["username"]),
          $this->db->leaderBoard()
        );
      }else{
        if (isset($_POST["play"])) {
          $this->gameCtl->play($_POST["play"]);
        }


        $this->gameCtl->launch($doReset);
      }
    }else { // Not normal...
      (new errorV())->raise("gutten Tag");
    }

  }
}
