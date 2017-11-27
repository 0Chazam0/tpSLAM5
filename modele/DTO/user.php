<?php

class Users
{
  private   $lesUsers;

  function __construct($lesUsers)
  {
    $this->lesUsers = $lesUsers;
  }

  public function getLesUsers()
  {
    return $this->lesUsers;
  }

  public function setLesUsers($value)
  {
    $this->lesUsers = $value;
  }

  public function chercher($TheEmail)
  {
    foreach ($this->lesUsers as $unUser)
    {
      if ($unUser->getEmail() == $TheEmail)
      {
        return $unUser;
      }
    }
    return null;
  }

}


/**
 * User
 */
class User
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
