<?php
/**
 * Game model class : define the way of the game works
 */
class Game {
  public $v;
  public $solution;
  public $proposition;
  public $results;

  public $COLORS = array("rouge", "jaune", "vert", "bleu", "orange", "blanc", "violet", "fuchsia");

  function __construct(){
    $this->proposition = array();
    $this->results     = array();
    $this->solution    = array();
    for ($n=0; $n < 4; $n++) {
      $this->solution[$n] = randomElement($this->COLORS);
    }
    $this->v = 10;
    error_log(serialize($this->solution));

  }

  // take an array and return the states
  // 0 : invalid/wrong
  // 1 : missplaced
  // 2 : correct
  public function testACase($testArray){
    $states = array();
    $soluceM = $this->solution;
    foreach ($testArray as $key => $value) {
      $states[$key] = -1;
      if ($value==$this->solution[$key]) {
        // echo $this->solution[$key]." = ".$value."<br>";
        $states[$key] = 2;
        $soluceM[$key] = "modified";
      }
    }
    foreach ($testArray as $key => $value) {
      if ($states[$key] != 2 && in_array($value,$soluceM) ) {
        // echo $value." in ".implode("|",$this->solution)."<br>";
        $states[$key] = 1;
        $soluceM[array_search($value,$soluceM)] = "modified";
      }else if($states[$key] != 2){
        // echo $value." not in ".implode("|",$this->solution)."<br>";
        $states[$key] = 0;
      }
    }
    sort($states,SORT_NUMERIC);
    return array_reverse($states);
  }

  public function hasWin() {
    return in_array(array(2,2,2,2),$this->results);
  }

  /**
  * Consider that $case contain 4 elements that are in the $COLORS
  */
  public function play($case){
    $this->proposition[] = $case;
    // print_r($case);
    $this->results[] = $this->testACase($case);
    // print_r($case);
    return $this->hasWin($case);
  }


  public function isTheEnd(){
    return count($this->proposition)>=$this->v || $this->hasWin() ;
  }

  public function getL(){
    return $this->v;
  }

  public function getCpt(){
    return count($this->proposition);
  }

}


// Function to pick a random element (picked from php.net "sam barrow's functions")
function randomElement(array $array){
    if (count($array) === 0){
        trigger_error('Array is empty.',  E_USER_WARNING);
        return null;
    }

    $rand = mt_rand(0, count($array) - 1);
    $array_keys = array_keys($array);

    return $array[$array_keys[$rand]];
}
