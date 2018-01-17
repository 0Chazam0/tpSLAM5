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
    $result= false;
    foreach ($this->lesProduits as $unProduit)
    {
      if ($unProduit->getCode() == $TheCode)
      {
        $unProduit->setQte($unProduit->getQte()+1);
        $result= true;
      }
    }
    return $result;
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

  public function ajouterProduit($unProduit)
  {
      $this->lesProduits[]=$unProduit;
  }

  public function supprimerProduit($unProduit)
  {
    if (isset($unProduit)){
      $positionProd = array_search($unProduit,$this->lesProduits);
      unset($this->lesProduits[$positionProd]);
    }
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
  private   $unite;
  private   $qte=1;

  function __construct($pcode, $pnom, $pcodeTypeProduit,$punite)
  {
    $this->code = $pcode;
    $this->nom = $pnom;
    $this->codeTypeProduit = $pcodeTypeProduit;
    $this->unite = $punite;
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

  public function getUnite(){
    return $this->unite;
  }

  public function setUnite($value){
    $this->unite = $value;
  }

  public function getQte(){
    return $this->qte;
  }

  public function setQte($value){
    $this->qte = $value;
  }

}

 ?>
