<?php
$_SESSION['dernierePage'] = "Produit";
$_SESSION['prixTotal'] = 0;
if(!isset($_SESSION['nbProduitPanier'])){
$_SESSION['nbProduitPanier']= 0;
}
$_SESSION['ListeProduits'] = new Produits(ProduitDAO::selectListeProduit($_SESSION['typeProduitSelected']));
$_SESSION['lesFormsProduit'] = null;





/*----------------------------------------------------------*/
/*--------Ajouter un Produit au panier (liste de Produit en obj)-----*/
/*----------------------------------------------------------*/

$leProduit = new Produit("","","","","","","","","");

foreach ($_SESSION['ListeProduits']->getLesProduits() as $OBJ)
{
	if(isset($_POST[$OBJ->getCode()])) {
    ProduitDAO::updateQteProduit($OBJ);
		$leProduit->__construct($OBJ->getCode(),$OBJ->getNom(),$OBJ->getCodeTypeProduit());
		$_SESSION['lesProduits'][] =	serialize($leProduit);
		var_dump($_SESSION['lesProduits']);
		$_SESSION['nbProduitPanier']+=1;
	}
}
if ($_SESSION['nbProduitPanier']>0)
{
	foreach ($_SESSION['lesProduits'] as $OBJ)
	{
		$lesProduits[] = unserialize($OBJ);
	}
	$_SESSION['lePanier'] = new Produits($lesProduits);

}
/*----------------------------------------------------------*/
/*--------FORMULAIRE d' un Produit  et ses carac----*/
/*----------------------------------------------------------*/
foreach ($_SESSION['ListeProduits']->getLesProduits() as $OBJ){

  $correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $OBJ->getNom());
  $correct = strtolower($correct);
  $correct = 'image/'.$correct;
  $formProduit = new Formulaire("POST","index.php","formProduit","produitthis");
  $formProduit->ajouterComposantLigne($formProduit->creerInputImage('imgProduit', 'imgProduit', $correct));
  $formProduit->ajouterComposantTab();
  $formProduit->ajouterComposantLigne($formProduit->creerLabelFor(ucfirst($OBJ->getNom()),"nomProduit"));
  $formProduit->ajouterComposantTab();
  if(ProduitDAO::estEnVente($OBJ,date("Y-m-d"))==1){
    $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerLabelFor("Prix : ","lblprixProd"),
                                        $formProduit->creerLabelFor(ProduitDAO::LePrixProduit($OBJ,date("Y-m-d"))."€",'prixProd'),0));
    $formProduit->ajouterComposantTab();
    $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerLabelFor("Quantité : ","lblQteProd"),
                                        $formProduit->creerLabelFor(ProduitDAO::LaQteProduit($OBJ,date("Y-m-d")),'QteProd'),0));
		if (!isset($_SESSION['typeIdentite']) || $_SESSION['typeIdentite'] == 'C'){
    	$formProduit->ajouterComposantLigne($formProduit->creerInputSubmitPanier($OBJ->getCode(),"ajoutCommande-btn"," Ajouter au panier "));
		}
  }
  elseif (ProduitDAO::estEnVente($OBJ,date("Y-m-d"))==0) {
    $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerInputImage2('imgCarton', 'imgCarton', "image\carton.jpg"),
                                                                        $formProduit->creerLabelFor(" Rupture de stock ","lblRupture"),0));
  }
  else{
    $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerInputImage2('imgTime', 'imgTime', "image\itime.jpg"),
                                        $formProduit->creerLabelFor(" Pas en vente cette semaine ","lblRupture"),0));
  }
  $formProduit->ajouterComposantTab();
  $formProduit->creerFormulaire();
  $_SESSION['lesFormsProduit'] .= $formProduit->afficherFormulaire();

}


if (!isset($_SESSION['typeIdentite']) || $_SESSION['typeIdentite'] == 'C'){
	$formPanier = new Formulaire("POST","index.php","formPanier","panierthis");

	$formPanier->ajouterComposantLigne($formPanier->concactComposants($formPanier->creerInputImage2('imgPanier', 'imgPanier', "image\panier.jpg"),
	                                                                  $formPanier->creerLabelFor('Votre Panier', 'lblPanier'),0));
	$formPanier->ajouterComposantTab();

	//Condition si le panier est remplit
	if($_SESSION['nbProduitPanier']>0){
		foreach ($_SESSION['lePanier']->getLesProduits() as $OBJ)
		{
		 	$formPanier->ajouterComposantLigne($formPanier->concactComposants($formPanier->creerLabelFor(ucfirst($OBJ->getNom()),"nomP"),
	                                       $formPanier->concactComposants($formPanier->creerLabelFor('x1','nbProduit'),
	                                       $formPanier->concactComposants($formPanier->creerLabelFor(ProduitDAO::LePrixProduit($OBJ,date("Y-m-d"))."€",'prixP'),
	                                       $formPanier->creerInputSubmit($OBJ->getCode(),'supprProduit',"X"),0),0),0));
			$formPanier->ajouterComposantTab();
			$_SESSION['prixTotal'] += ProduitDAO::LePrixProduit($OBJ,date("Y-m-d"));
		}
		$formPanier->ajouterComposantTab();
	}
	//Condition si le panier est vide
	else{
		$formPanier->ajouterComposantLigne($formPanier->creerLabelFor("Le panier est vide","lblVide"));
		$formPanier->ajouterComposantTab();
	}

	$formPanier->ajouterComposantLigne($formPanier->concactComposants($formPanier->creerLabelFor("Total : ","lbltotal"),$formPanier->creerLabelFor($_SESSION['prixTotal']."€","prixTotal"),0));
	$formPanier->ajouterComposantTab();
	if ($_SESSION['nbProduitPanier']>0){
	  $formPanier->ajouterComposantLigne($formPanier->creerInputSubmit('validerCommande','validerCommande',"Valider votre commande"));
	}
	$formPanier->ajouterComposantTab();

	$formPanier->creerFormulaire();
	$_SESSION['leFormPlanier'] = $formPanier->afficherFormulaire();
}

include "vue/vueProduit.php";
 ?>
