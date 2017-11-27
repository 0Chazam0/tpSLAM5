<?php

class Responsables
{
  private   $lesResponsables;

  function __construct($lesResponsables)
  {
    $this->lesResponsables = $lesResponsables;
  }

  public function getLesResponsables()
  {
    return $this->lesResponsables;
  }

  public function setLesResponsables($value)
  {
    $this->lesResponsables = $value;
  }

  public function chercher($TheEmail)
  {
    foreach ($this->lesResponsables as $unResponsable)
    {
      if ($unResponsable->getEmail() == $TheEmail)
      {
        return $unResponsable;
      }
    }
    return null;
  }

}


/**
 * Responsable
 */
class Responsable
{
  private   $email;
  private   $nom;
  private   $prenom;
  private   $mdp;

  function __construct($pemail, $pnom, $pprenom, $pmdp)
  {
    $this->email = $pemail;
    $this->nom = $pnom;
    $this->prenom = $pprenom;
    $this->mdp = $pmdp;
  }

  public function getEmail(){
    return $this->email;
  }

  public function setEmail($value){
    $this->email = $value;
  }

  public function getNom(){
    return $this->nom;
  }

  public function setNom($value){
    $this->nom = $value;
  }

  public function getPrenom(){
    return $this->prenom;
  }

  public function setPrenom($value){
    $this->prenom = $value;
  }

  public function getMdp(){
    return $this->mdp;
  }

  public function setMdp($value){
    $this->mdp = $value;
  }


}


 ?>
