<?php
$_SESSION['dernierePage'] = "Produit";

$_SESSION['ListeProduit'] = new Produits(ProduitDAO::selectListeProduit($_SESSION['typeProduitSelected']));
$_SESSION['lesFormsProduit'] = null;

foreach ($_SESSION['ListeProduit']->getLesProduits() as $OBJ){

  $correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $OBJ->getNom());
  $correct = strtolower($correct);
  $correct = 'image/'.$correct;

  $formProduit = new Formulaire("POST","index.php","formProduit","produitthis");
  $formProduit->ajouterComposantLigne($formProduit->creerInputImage('imgProduit', 'imgProduit', $correct));
  $formProduit->ajouterComposantTab();
  $formProduit->ajouterComposantLigne($formProduit->creerLabelFor(ucfirst($OBJ->getNom()),"nomProduit"));
  $formProduit->ajouterComposantTab();
  if(ProduitDAO::estEnVente($OBJ,date("Y-m-d"))){
    $formProduit->ajouterComposantLigne($formProduit->creerInputSubmitPanier($OBJ->getCode(),"ajoutCommande-btn"," Ajouter au panier "));
  }
  else{
    $formProduit->ajouterComposantLigne($formProduit->creerLabelFor("/!\ Rupture de stock /!\ ","lblRupture"));
  }
  $formProduit->ajouterComposantTab();
  $formProduit->creerFormulaire();
  $_SESSION['lesFormsProduit'] .= $formProduit->afficherFormulaire();

}


include "vue/vueProduit.php";
 ?>
