<?php
$_SESSION['dernierePage'] = "Producteur";
if(!isset($_SESSION['nbProduitPanier'])){
$_SESSION['nbProduitPanier']= 0;
}

// $_SESSION['listeProduitProducteurs'] = new Produits(ProducteurDAO::selectListeProduitProducteur($_SESSION['identite'][0],date("Y-m-d")));
// /*----------------------------------------------------------*/
// /*--------FORMULAIRE d' un Produit  et ses carac----*/
// /*----------------------------------------------------------*/
// foreach ($_SESSION['listeProduitProducteurs']->getLesProduits() as $OBJ){
//
//   $correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $OBJ->getNom());
//   $correct = strtolower($correct);
//   $correct = 'image/'.$correct;
//   $formProduit = new Formulaire("POST","index.php","formProduit","produitthis");
//   $formProduit->ajouterComposantLigne($formProduit->creerInputImage('imgProduit', 'imgProduit', $correct));
//   $formProduit->ajouterComposantTab();
//   $formProduit->ajouterComposantLigne($formProduit->creerLabelFor(ucfirst($OBJ->getNom()),"nomProduit"));
//   $formProduit->ajouterComposantTab();
//   if(ProduitDAO::estEnVente($OBJ,date("Y-m-d"))==1){
//     $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerLabelFor("Prix : ","lblprixProd"),
//                                         $formProduit->creerLabelFor(ProduitDAO::LePrixProduit($OBJ,date("Y-m-d"))."€",'prixProd'),0));
//     $formProduit->ajouterComposantTab();
//     $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerLabelFor("Quantité : ","lblQteProd"),
//                                         $formProduit->creerLabelFor(ProduitDAO::LaQteProduit($OBJ,date("Y-m-d")),'QteProd'),0));
// 		if (!isset($_SESSION['typeIdentite']) || $_SESSION['typeIdentite'] == 'C'){
//     	$formProduit->ajouterComposantLigne($formProduit->creerInputSubmitPanier($OBJ->getCode(),"ajoutCommande-btn"," Ajouter au panier "));
// 		}
//   }
//   elseif (ProduitDAO::estEnVente($OBJ,date("Y-m-d"))==0) {
//     $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerInputImage2('imgCarton', 'imgCarton', "image\carton.jpg"),
//                                                                         $formProduit->creerLabelFor(" Rupture de stock ","lblRupture"),0));
//   }
//   else{
//     $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerInputImage2('imgTime', 'imgTime', "image\itime.jpg"),
//                                         $formProduit->creerLabelFor(" Pas en vente cette semaine ","lblRupture"),0));
//   }
//   $formProduit->ajouterComposantTab();
//   $formProduit->creerFormulaire();
//   $_SESSION['lesFormsProduit'] .= $formProduit->afficherFormulaire();
//
// }
include "vue/vueProducteur.php";
 ?>
