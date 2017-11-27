<?php

/**
 * Producteur
 */
class Producteur extends AnotherClass
{

  private   $email;
  private   $nom;
  private   $prenom;
  private   $mdp;
  private   $adresse;
  private   $descriptif;

  function __construct($pemail,  $pnom, $pprenom, $pmdp, $padresse, $pdescriptif)
  {
    $this->email = $pemail;
    $this->nom = $pnom;
    $this->prenom = $pprenom;
    $this->mdp = $pmdp;
    $this->adresse = $adresse;
    $this->descriptif = $pdescriptif;
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

  public function getAdresse(){
    return $this->adresse;
  }

  public function setAdresse($value){
    $this->adresse = $value;
  }

  public function getDescriptif(){
    return $this->descriptif;
  }

  public function setDescriptif($value){
    $this->descriptif = $value;
  }
}
//

 ?>
