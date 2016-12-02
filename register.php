<?php
require_once __DIR__."/V/home.php";
require_once __DIR__.'/C/authCtrl.php';

if ($_POST["password"] == $_POST["c_password"]) {
   switch ((new AuthCtl())->adduser($_POST["username"],$_POST["password"])) {
     case 0:
       $_SESSION["alert"] = "Compte créé, vous pouvez vous connecter.";
       break;
     case -1:
      $_SESSION["alert"] = "Nom d'utilisateur déjà pris.";
      break;

      default:
       $_SESSION["alert"] = "Something really bad happen.";
       break;
   }
}else {
  $_SESSION["alert"] = "Les mots de passe sont différents.";
}

(new Home())->launch();
