<?php

class Commandes
{
  private   $lesCommandes;

  function __construct($lesCommandes)
  {
    $this->lesCommandes = $lesCommandes;
  }

  public function getLesCommandes()
  {
    return $this->lesCommandes;
  }

  public function setLesCommandes($value)
  {
    $this->lesCommandes = $value;
  }

  public function chercher($TheNumComm)
  {
    foreach ($this->lesCommandes as $unCommande)
    {
      if ($unCommande->getNumCommande() == $TheNumComm)
      {
        return $unCommande;
      }
    }
    return null;
  }

}


/**
 * Commande
 */
class Commande
{
  private   $numCommande;
  private   $email;
  private   $dateCommande;
  private   $etat;

  function __construct($pnumCommande, $pemail, $pdateCommande, $petat)
  {
    $this->numCommande = $pnumCommande;
    $this->email = $pemail;
    $this->dateCommande = $pdateCommande;
    $this->etat = $petat;
  }

  public function getNumCommande(){
    return $this->numCommande;
  }

  public function setNumCommande($value){
    $this->numCommande = $value;
  }

  public function getEmail(){
    return $this->email;
  }

  public function setEmail($value){
    $this->email = $value;
  }

  public function getDateCommande(){
    return $this->dateCommande;
  }

  public function setDateCommande($value){
    $this->dateCommande = $value;
  }

  public function getEtat(){
    return $this->etat;
  }

  public function setEtat($value){
    $this->etat = $value;
  }
}


 ?>
