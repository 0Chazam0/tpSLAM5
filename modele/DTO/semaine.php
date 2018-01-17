<?php

/**
 * Semaines
 */
class Semaines
{
  private   $lesSemaines;

  function __construct($plesSemaines)
  {
    $this->lesSemaines = $plesSemaines;
  }

  public function getLesSemaines()
  {
    return $this->lesSemaines;
  }

  public function setLesSemaines($value)
  {
    $this->lesSemaines = $value;
  }

  public function chercherSemaine($TheCode)
  {
    $result= false;
    foreach ($this->lesSemaines as $uneSemaine)
    {
      if ($uneSemaine->getNumSemaine() == $TheCode)
      {
        $result= $TheCode;
        break;
      }
    }
    return $result;
  }
}

/**
 * Semaine
 */
class Semaine
{
  private   $numSemaine;
  private   $dateD;
  private   $dateDA;
  private   $dateF;

  function __construct($pnumSemaine, $pdateD, $pdateDA, $pdateF)
  {
    $this->numSemaine = $pnumSemaine;
    $this->dateD = $pdateD;
    $this->dateDA = $pdateDA;
    $this->dateF = $pdateF;
  }

  public function getNumSemaine(){
    return $this->numSemaine;
  }

  public function setNumSemaine($value){
    $this->numSemaine = $value;
  }

  public function getDateD(){
    return $this->dateD;
  }

  public function setDateD($value){
    $this->dateD = $value;
  }


  public function getDateDA(){
    return $this->dateDA;
  }

  public function setDateDA($value){
    $this->dateDA = $value;
  }

  public function getDateF(){
    return $this->dateF;
  }

  public function setDateF($value){
    $this->dateF = $value;
  }

}

 ?>
