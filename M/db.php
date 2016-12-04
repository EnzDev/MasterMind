<?php

/**
 *
 */
 // Classe generale de definition d'exception
 class MonException extends Exception{
   private $chaine;
   public function __construct($chaine){
     $this->chaine=$chaine;
   }

   public function afficher(){ print_r( $this->chaine ); }

 }


 // Exception relative à un probleme de connexion
 class ConnexionException extends MonException{}

 // Exception relative à un probleme d'accès à une table
 class TableAccesException extends MonException{}

 // User doesnt exist in table
 class UserInvalidException extends MonException{}

 // User doesnt exist in table
 class UserExistException extends MonException{}

 // Classe qui gère les accès à la base de données

 class DB{
 private $connexion;

 // Constructeur de la classe
 // remplacer X par les informations qui vous concernent

   public function __construct(){
    try{
       $chaine="mysql:host=localhost;dbname=e155122l";
       $this->connexion = new PDO($chaine,"root","");
       $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      }
     catch(PDOException $e){
       print_r($e);
       $exception=new ConnexionException("problème de connection à la base");
       throw $exception;
     }
   }





 // méthode qui permet de se deconnecter de la base
 public function deconnexion(){ $this->connexion=null; }



 // utiliser une requête classique
 // méthode qui permet de récupérer les pseudos dans la table pseudo
 // post-condition:
 //retourne un tableau à une dimension qui contient les pseudos.
 // si un problème est rencontré, une exception de type TableAccesException est levée

 public function getPlayers(){
  try{

    $statement=$this->connexion->query("SELECT pseudo from joueurs;");

     while($ligne=$statement->fetch()){ $result[]=$ligne['pseudo']; }
     return($result);

   }catch(PDOException $e){
     throw new TableAccesException("problème avec la table pseudonyme");
   }
 }

 public function getPass($user){
    try{

    $statement=$this->connexion->prepare("SELECT motDePasse FROM joueurs WHERE pseudo=?;");
    $statement->bindParam(1, $user);

    $statement->execute();

     while($ligne=$statement->fetch()){ $password=$ligne['motDePasse']; }
     if (!isset($password)) { throw new UserInvalidException("Pseudo invalide"); } // devrais être check avant
     return $password;

   }catch(PDOException $e){
     throw new TableAccesException("problème avec la table pseudonyme");
   }
 }

 public function addGame($user, $coup, $win=0){
   try{
   	$statement = $this->connexion->prepare("INSERT INTO `parties`(`pseudo`, `partieGagnee`, `nombreCoups`) VALUES (?,?,?);");
   	$statement->bindParam(1, $user);
    $statement->bindParam(2, $win);
    $statement->bindParam(3, $coup);

   	$statement->execute();

   }
   catch(PDOException $e){
       $this->deconnexion();
       throw new TableAccesException("problème avec la table pseudonyme");
  }
 }

 public function getBestGame($user){
   try{
     	$statement = $this->connexion->prepare("SELECT partieGagnee, nombreCoups FROM parties WHERE pseudo=? ORDER BY nombreCoups ASC LIMIT 10;");
     	$statement->bindParam(1, $user);

     	$statement->execute();

     }
     catch(PDOException $e){
         $this->deconnexion();


         throw new TableAccesException("problème avec la table pseudonyme");
    }

 }

 public function addUser($user, $hashPass){
 try{
   if ($user=="") {throw new UserExistException("Le pseudo est déjà pris");  }

   	$statement = $this->connexion->prepare("INSERT INTO `joueurs`(`pseudo`, `motDePasse`) VALUES (?,?);");
   	$statement->bindParam(1, $user);
    $statement->bindParam(2, $hashPass);

   	$statement->execute();

   }
   catch(PDOException $e){
       $this->deconnexion();

       if ($e->getCode() == 23000) {
         throw new UserExistException("Le pseudo est déjà pris");

       }

       throw new TableAccesException("problème avec la table pseudonyme");
  }
 }

 public function avgCoups($user){
   try{
     	$statement = $this->connexion->prepare('SELECT AVG(nombreCoups) from parties where pseudo=? and partieGagnee=1');
      $statement->bindParam(1, $user);

      $statement->execute();

      $result = $statement->fetch()[0];

      if (empty($result)){ return "... "; }
      return $result;

 }catch(PDOException $e){
     $this->deconnexion();


     throw new TableAccesException("problème avec la table pseudonyme");
   }
}


public function leaderBoard(){
  // NOTE : This is a direct implementation...
  try{
    $gameTable = "CREATE TEMPORARY TABLE xG  (SELECT p.pseudo pseudo, COUNT(*) games FROM joueurs j, parties p WHERE j.pseudo=p.pseudo GROUP BY p.pseudo);";
    $winTable  = "CREATE TEMPORARY TABLE xW  (SELECT p.pseudo pseudo, COUNT(*) win   FROM joueurs j, parties p WHERE j.pseudo=p.pseudo AND p.partieGagnee=1 GROUP BY p.pseudo);";
    $averTable = "CREATE TEMPORARY TABLE xV  (SELECT p.pseudo pseudo, AVG(p.nombreCoups) aver FROM joueurs j, parties p where j.pseudo=p.pseudo AND partieGagnee=1 GROUP BY p.pseudo);";
    $joinSel   = "SELECT xG.pseudo, games, win, aver from xG, xW, xV where xG.pseudo=xW.pseudo and xV.pseudo=xW.pseudo ORDER BY win/games DESC, aver ASC LIMIT 10; ";

    $this->connexion->query($gameTable);
    $this->connexion->query($winTable);
    $this->connexion->query($averTable);

    $statement=$this->connexion->query($joinSel);

    return $statement->fetchAll();

    }
    catch(PDOException $e){
        $this->deconnexion();

        throw new TableAccesException("problème de table");
   }


}
}


?>
