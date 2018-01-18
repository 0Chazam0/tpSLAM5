<?php
/*----------------------------------------------------------*/
/*--------Déclaration variable session----------------------*/
/*----------------------------------------------------------*/
$_SESSION['dernierePage'] = "Producteur";
$_SESSION['lesFormsProduit']=null;
$_SESSION['ListeProduits'] = new Produits(ProduitDAO::selectListeProduitAll());

/*----------------------------------------------------------*/
/*--------Affichage menu de gauche----------------------*/
/*----------------------------------------------------------*/

$menuDetailProducteur = new menu("menuDetailProducteur");
$menuDetailProducteur->ajouterComposant($menuDetailProducteur->creerItemLien('profil','Mon Profil Public'));
$menuDetailProducteur->ajouterComposant($menuDetailProducteur->creerItemLien('update','Gestion de la vente (en cours)'));

$menuDetailProducteur = $menuDetailProducteur->creerMenu("menuDetailProducteur");


/*----------------------------------------------------------*/
/*--------Gestion du menu detail resto selon l'onglet selectionné------------*/
/*----------------------------------------------------------*/
if(isset($_GET['menuDetailProducteur'])){
	$_SESSION['menuDetailProducteur']= $_GET['menuDetailProducteur'];
}
else
{
	if(!isset($_SESSION['menuDetailProducteur'])){
		$_SESSION['menuDetailProducteur']="profil";
	}
}

/*----------------------------------------------------------*/
/*--------Affichage de la liste des produits----------------------*/
/*----------------------------------------------------------*/
foreach ($_SESSION['ListeProduits']->getLesProduits() as $OBJ) {
	if(isset($_POST['ajouterProdVente'.$OBJ->getNom()])){
		//ajout a la vente du produit
		if(ProducteurDAO::ajouterVente($_SESSION['identite'][0],$OBJ,ProduitDAO::LeNumSemaine(date("Y-m-d")),$_POST['txtqte'],$_POST['txtPrix'])){
		$_SESSION['lesFormsProduit'] =  '<div id="prevenirValiderC">
				Le produit a été correctement ajouté à la vente
			</div>';
		}
	}
	if(isset($_POST['modifProdVente'.$OBJ->getNom()])){
		//modification d'un produit
		if(ProducteurDAO::modifVente($_SESSION['identite'][0],$OBJ,ProduitDAO::LeNumSemaine(date("Y-m-d")),$_POST['txtPrix'],$_POST['txtqte'])){
		$_SESSION['lesFormsProduit'] =  '<div id="prevenirValiderC">
				Le produit a été correctement modifié
			</div>';
		}
	}
	if(isset($_POST['supprimerProdVente'.$OBJ->getNom()])){
		//suppression du produit
	if(ProducteurDAO::supprimerVente($_SESSION['identite'][0],$OBJ,ProduitDAO::LeNumSemaine(date("Y-m-d")))){
		$_SESSION['lesFormsProduit'] =  '<div id="prevenirValiderC">
				Le produit a été correctement supprimé
			</div>';
		}
	}
}
//affichage quand on selectionne l'onglet profil du menu
if ($_SESSION['menuDetailProducteur']== "profil"){
	$correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $_SESSION['identite'][2]);
	$correct = strtolower($correct);
	$correct = 'image/'.$correct;
	$formProducteur = new Formulaire("POST","index.php","formInfosProducteurs","infosProducteursthis");
	$formProducteur->ajouterComposantLigne($formProducteur->creerInputImage('imgProducteur', 'imgProducteur', $correct));
	$formProducteur->ajouterComposantTab();
	$formProducteur->ajouterComposantLigne($formProducteur->concactComposants($formProducteur->creerLabelFor("Dénomination : ","lblnomProducteur"),
																				 $formProducteur->creerLabelFor(ucfirst($_SESSION['identite'][2]),"nomProducteur"),0));
	$formProducteur->ajouterComposantTab();
	$formProducteur->ajouterComposantLigne($formProducteur->concactComposants($formProducteur->creerLabelFor("Adresse : ","lbladresseProducteur"),
																				 $formProducteur->creerLabelFor(ucfirst($_SESSION['identite'][4]),"adresseProducteur"),0));
	$formProducteur->ajouterComposantTab();
	$formProducteur->ajouterComposantLigne($formProducteur->concactComposants($formProducteur->creerLabelFor("Description : ","lbldescriptionProducteur"),
																				 $formProducteur->creerLabelFor(ucfirst($_SESSION['identite'][5]),"descriptionProducteur"),0));
	$formProducteur->ajouterComposantTab();
	$formProducteur->creerFormulaire();
	$_SESSION['lesFormsProduit'] .= $formProducteur->afficherFormulaire();


}
//affichage quand on selectionne l'onglet modifier du menu
if ($_SESSION['menuDetailProducteur']== "update"){

	foreach ($_SESSION['ListeProduits']->getLesProduits() as $OBJ){

	  $correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $OBJ->getNom());
	  $correct = strtolower($correct);
	  $correct = 'image/'.$correct;
	  $formProduit = new Formulaire("POST","index.php","formProduit","produitproducteurthis");
	  $formProduit->ajouterComposantLigne($formProduit->creerInputImage('imgProduit', 'imgProduit', $correct));
	  $formProduit->ajouterComposantTab();
	  $formProduit->ajouterComposantLigne($formProduit->creerLabelFor(ucfirst($OBJ->getNom()),"nomProduit"));
	  $formProduit->ajouterComposantTab();
	  if(ProducteurDAO::estEnVenteProducteur($OBJ,date("Y-m-d"),$_SESSION['identite'][0])==1){
	    $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerLabelFor("Prix : ","lblprixProd"),
	                                        $formProduit->concactComposants($formProduit->creerInputTexte("txtPrix","txtPrix","",ProduitDAO::LePrixProduit($OBJ,date("Y-m-d")),1,""),
	                                        $formProduit->creerLabelFor(" €/ ".$OBJ->getUnite(),"lblprixProd"),0),0));
	    $formProduit->ajouterComposantTab();
	    $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerLabelFor("Quantité en vente : ","lblQteProd"),
	                                        $formProduit->creerInputTexte("txtqte","txtqte","",ProduitDAO::LaQteProduit($OBJ,date("Y-m-d")),1,""),0));
																					$formProduit->ajouterComposantTab();
			$formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerInputSubmit('modifProdVente'.$OBJ->getNom(),'modifProdVente','Modifier la vente'),
																					$formProduit->creerInputSubmit('supprimerProdVente'.$OBJ->getNom(),'supprimerProdVente','Supprimer de la vente'),0));
		}
	  else{
			$formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerLabelFor("Prix : ","lblprixProd"),
																					$formProduit->concactComposants($formProduit->creerInputTexte("txtPrix","txtPrix","","",1,"Entrer votre prix"),
																					$formProduit->creerLabelFor(" €/ ".$OBJ->getUnite(),"lblprixProd"),0),0));
			$formProduit->ajouterComposantTab();
	    $formProduit->ajouterComposantLigne($formProduit->concactComposants($formProduit->creerLabelFor(" Quantité à vendre ","lblQteVente"),
	                                        $formProduit->creerInputTexte("txtqte","txtqte","","",1,"Entrez votre quantité"),0));
			$formProduit->ajouterComposantTab();
			$formProduit->ajouterComposantLigne($formProduit->creerInputSubmit('ajouterProdVente'.$OBJ->getNom(),'ajouterProdVente','Ajouter à la vente'));
		}
	  $formProduit->ajouterComposantTab();
	  $formProduit->creerFormulaire();
	  $_SESSION['lesFormsProduit'] .= $formProduit->afficherFormulaire();
	}
}

include "vue/vueProducteur.php";
 ?>
