<?php

class Produits
{
  private   $lesProduits;

  function __construct($lesProduits)
  {
    $this->lesProduits = $lesProduits;
  }

  public function getLesProduits()
  {
    return $this->lesProduits;
  }

  public function setLesProduits($value)
  {
    $this->lesProduits = $value;
  }

  public function chercherProduit($TheCode)
  {
    foreach ($this->lesProduits as $unProduit)
    {
      if ($unProduit->getEmail() == $TheCode)
      {
        return $unProduit;
      }
    }
    return null;
  }

  public function chercherProduitParLibelle($TheCode)
  {
    $i = 0;
    foreach ($this->lesProduits as $unProduit)
    {
      if ($unProduit->getCodeTypeProduit() == $TheCode)
      {
        $array[$i] = $unProduit;
        $i += 1;
      }
    }
    return $array;
  }

}

/**
 * Produit
 */
class Produit
{
  private   $code;
  private   $nom;
  private   $descriptif;
  private   $codeTypeProduit;
  private   $libelleTypeProduit;

  function __construct($pcode, $pnom, $pdescriptif, $pcodeTypeProduit,
                      $plibelleTypeProduit)
  {
    $this->code = $pcode;
    $this->nom = $pnom;
    $this->descriptif = $pdescriptif;
    $this->codeTypeProduit = $pcodeTypeProduit;
    $this->libelleTypeProduit = $plibelleTypeProduit;
  }

  public function getCode(){
    return $this->code;
  }

  public function setCode($value){
    $this->code = $value;
  }

  public function getNom(){
    return $this->nom;
  }

  public function setNom($value){
    $this->nom = $value;
  }

  public function getDescriptif(){
    return $this->descriptif;
  }

  public function setDescriptif($value){
    $this->descriptif = $value;
  }

  public function getCodeTypeProduit(){
    return $this->codeTypeProduit;
  }

  public function setCodeTypeProduit($value){
    $this->codeTypeProduit = $value;
  }

  public function getLibelleTypeProduit(){
    return $this->libelleTypeProduit;
  }

  public function setLibelleTypeProduit($value){
    $this->libelleTypeProduit = $value;
  }
}

 ?>
