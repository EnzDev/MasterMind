<?php
require_once __DIR__."/../M/db.php";
class AuthCtl{

  private $db;

  function __construct(){
    $this->db=new DB();
  }

  /**
   * return a number defining each case :
   * 0  : SUCCESS
   * -1 : INVALID
   * -2 : NO USER
   */
  function auth($user, $password){
    try {
      $passHashed = $this->db->getPass($user);
    } catch (UserInvalidException $e) {
      return -2; // User doesnt exist
    }
    if (crypt($password,$passHashed)==$passHashed) {
      return 0; // password valid
    }else {
      return -1; // invalid password
    }
  }

}
