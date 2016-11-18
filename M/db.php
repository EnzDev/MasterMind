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

   public function afficher(){ return $this->chaine; }

 }


 // Exception relative à un probleme de connexion
 class ConnexionException extends MonException{}

 // Exception relative à un probleme d'accès à une table
 class TableAccesException extends MonException{}

 // User doesnt exist in table
 class UserInvalidException extends MonException{}


 // Classe qui gère les accès à la base de données

 class DB{
 private $connexion;

 // Constructeur de la classe
 // remplacer X par les informations qui vous concernent

   public function __construct(){
    try{
       $chaine="mysql:host=localhost;dbname=E155122L";
       $this->connexion = new PDO($chaine,"E155122L","E155122L");
       $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      }
     catch(PDOException $e){
       $exception=new ConnexionException("problème de connection à la base");
       throw $exception;
     }
   }




 // A développer
 // méthode qui permet de se deconnecter de la base
 public function deconnexion(){ $this->connexion=null; }


 //A développer
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
    
    $statement=$this->connexion->query("SELECT motDePasse FROM joueurs WHERE pseudo=\"".$user."\";");

     while($ligne=$statement->fetch()){ $password=$ligne['motDePasse']; }
     if (!isset($password)) { throw new UserInvalidException("Pseudo invalide"); } // devrais être check avant
     return $password;

   }catch(PDOException $e){
     throw new TableAccesException("problème avec la table pseudonyme");
   }
 }

}


?>
