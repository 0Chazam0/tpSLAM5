<?php
class TypeProduits
{
  private   $lesTypes;

  function __construct($lesTypes)
  {
    $this->lesTypes = $lesTypes;
  }

  public function getLesTypes()
  {
    return $this->lesTypes;
  }

  public function setLesTypes($value)
  {
    $this->lesTypes = $value;
  }

  public function chercher($TheCode)
  {
    foreach ($this->lesTypes as $Type)
    {
      if ($Type->getCode() == $TheCode)
      {
        return $Type;
      }
    }
    return null;
  }

}


/**
 * Type
 */
class TypeProduit
{
  private   $code;
  private   $libelle;


  function __construct($pcode, $plibelle)
  {
    $this->code = $pcode;
    $this->libelle = $plibelle;
  }

  public function getCode()
  {
    return $this->code;
  }

  public function setCode($value)
  {
     $this->code = $value;
  }

  public function getLibelle()
  {
    return $this->libelle;
  }

  public function setLibelle($value)
  {
     $this->libelle = $value;
  }

}


 ?>
