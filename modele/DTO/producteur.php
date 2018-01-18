<?php

class Producteurs
{
  private $lesProducteurs;

  function __construct($lesProducteurs)
  {
    $this->lesProducteurs = $lesProducteurs;
  }

  public function getLesProducteurs()
  {
    return $this->lesProducteurs;
  }

  public function setLesProducteurs($value)
  {
    $this->lesProducteurs = $value;
  }



  public function chercher($TheEmail)
  {
    foreach ($this->lesProducteurs as $unProducteur)
    {
      if ($unProducteur->getEmail() == $TheEmail)
      {
        return $unProducteur;
      }
    }
    return null;
  }

}

/**
 * Producteur
 */
class Producteur
{

  private   $email;
  private   $nom;
  private   $prenom;
  private   $mdp;
  private   $adresse;
  private   $descriptif;

  function __construct($pemail,  $pnom, $padresse , $pdescriptif, $pprenom, $pmdp)
  {
    $this->email = $pemail;
    $this->nom = $pnom;
    $this->prenom = $pprenom;
    $this->mdp = $pmdp;
    $this->adresse = $padresse;
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

 ?>
