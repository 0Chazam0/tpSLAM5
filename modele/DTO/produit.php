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
  private   $codeTypeProduit;

  function __construct($pcode, $pnom, $pcodeTypeProduit)
  {
    $this->code = $pcode;
    $this->nom = $pnom;
    $this->codeTypeProduit = $pcodeTypeProduit;
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


  public function getCodeTypeProduit(){
    return $this->codeTypeProduit;
  }

  public function setCodeTypeProduit($value){
    $this->codeTypeProduit = $value;
  }


}

 ?>
