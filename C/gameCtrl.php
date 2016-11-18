<?php
require_once __DIR__."/../M/game.php";
require_once __DIR__."/../V/game.php";

if(!isset($_SESSION)){
    session_start();
}

class GameCtl{

    function __construct(){
    if (!isset($_SESSION["game"]) ) {
      $_SESSION["game"] = new Game();
    }
  }

  function launch($new){
    if ($new) {
      $_SESSION["game"] = new Game();
    }
    $test = $_SESSION["game"]->proposition;
    $res = $_SESSION["game"]->results;
    $len = count($test);

    if ($_SESSION["game"]->isTheEnd()){
      $this->doTheEndingThing();
    }

    (new GameView())->launch($test, $res,$len,$_SESSION["game"]->isTheEnd()?$_SESSION["game"]->solution:false,$_SESSION["game"]->getL());
  }

  function play($move){
    print_r($move);

    $assoc = array('red'=>"rouge", 'green'=>"vert", 'blue'=>"bleu", 'orange'=>"orange", 'white'=>"blanc", 'purple'=>"violet", 'pink'=>"fuchsia", 'yellow'=>"jaune");
    foreach ($move as &$m) {
      $m = $assoc[$m];
    }
    $res = $_SESSION["game"]->play($move);
  }


  public function doTheEndingThing(){

  }
}
