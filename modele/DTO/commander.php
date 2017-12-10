<?php

class Commanders
{
  private   $lesCommanders;

  function __construct($lesCommanders)
  {
    $this->lesCommanders = $lesCommanders;
  }

  public function getLesCommanders()
  {
    return $this->lesCommanders;
  }

  public function setLesCommanders($value)
  {
    $this->lesCommanders = $value;
  }

  public function chercher($TheNumComm)
  {
    foreach ($this->lesCommanders as $unCommander)
    {
      if ($unCommander->getNumCommander() == $TheNumComm)
      {
        return $unCommander;
      }
    }
    return null;
  }

}


/**
 * Commander
 */
class Commander
{
  private   $numCommander;
  private   $code;
  private   $qte;

  function __construct($pnumCommander, $pcode, $pqte)
  {
    $this->numCommander = $pnumCommander;
    $this->code = $pcode;
    $this->qte = $pqte;
  }

  public function getNumCommander(){
    return $this->numCommander;
  }

  public function setNumCommander($value){
    $this->numCommander = $value;
  }

  public function getcode(){
    return $this->code;
  }

  public function setcode($value){
    $this->code = $value;
  }

  public function getqte(){
    return $this->qte;
  }

  public function setqte($value){
    $this->qte = $value;
  }
}


 ?>
