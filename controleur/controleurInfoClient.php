<?php
unset($_SESSION['typeProduitSelected']);
if (isset($_POST['nom'])
		&& isset($_POST['prenom'])
		){
			if ($_SESSION['typeIdentite'] == 'P') {
				if (isset($_POST['adresse'])
						&& isset($_POST['descriptif'])
						){
								UserDAO::modifierProducteur($_SESSION['identite'], $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['descriptif']);
								if (UserDAO::modifierProducteur($_SESSION['identite'], $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['descriptif'])  == true) {
									$_SESSION['identite'][2] = $_POST['nom'];
									$_SESSION['identite'][3] = $_POST['prenom'];
									$_SESSION['identite'][4] = $_POST['adresse'];
									$_SESSION['identite'][5] = $_POST['descriptif'];
								}
						}
			}
			else {
				UserDAO::modifierClient($_SESSION['identite'], $_POST['nom'], $_POST['prenom']);
				if (UserDAO::modifierClient($_SESSION['identite'], $_POST['nom'], $_POST['prenom']) == true) {
					$_SESSION['identite'][2] = $_POST['nom'];
					$_SESSION['identite'][3] = $_POST['prenom'];
				}
			}
	}

$menuProfil = new menu("menuProfil");
$menuProfil->ajouterComposant($menuProfil->creerItemLien('Profil','Profil'));
$menuProfil->ajouterComposant($menuProfil->creerItemLien('Modifier','Modifier'));
if ($_SESSION['typeIdentite'] == 'R') {
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('Responsable','Responsable'));
}
if ($_SESSION['typeIdentite'] == 'P') {
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('HistoriqueEC','Historique commandes en cours'));
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('HistoriqueV','Historique commandes validées'));
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('HistoriqueD','Historique commandes distribuées'));
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('Producteur','Producteur'));
}
if ($_SESSION['typeIdentite'] == 'C') {
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('HistoriqueEC','Historique commandes en cours'));
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('HistoriqueV','Historique commandes validées'));
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('HistoriqueD','Historique commandes distribuées'));
}

$leMenuProfil = $menuProfil->creerMenu("menuProfil");

if(isset($_GET['menuProfil'])){
	$_SESSION['menuProfil']= $_GET['menuProfil'];
}
else
{
	if(!isset($_SESSION['menuProfil'])){
		$_SESSION['menuProfil']="Profil";
	}
}

$formProfil = new Formulaire('post','index.php','formProfil','formProfil');
if ($_SESSION['menuProfil'] == "Responsable") {
	$formProfil->ajouterComposantLigne($formProfil->creerInputSubmit('redirectionResponsable','redirectionResponsable','Votre espace Responsable'));
	$formProfil->ajouterComposantTab();
}

if ($_SESSION['menuProfil'] == "Producteur") {
	$formProfil->ajouterComposantLigne($formProfil->creerInputSubmit('redirectionProducteur','redirectionProducteur','Votre espace Producteur'));
	$formProfil->ajouterComposantTab();

}

if ($_SESSION['menuProfil'] == "Profil") {
	$formProfil->ajouterComposantLigne($formProfil->creerLabelFor($_SESSION['identite'][2],'nom'));
	$formProfil->ajouterComposantTab();
	$formProfil->ajouterComposantLigne($formProfil->creerLabelFor($_SESSION['identite'][3],'prenom'));
	$formProfil->ajouterComposantTab();
	$formProfil->ajouterComposantLigne($formProfil->creerInputSubmit('mdpChange','mdpChange','Changer de mot de passe'));
	$formProfil->ajouterComposantTab();
}



if ($_SESSION['menuProfil'] == "Modifier") {
	$formProfil->ajouterComposantLigne($formProfil->creerInputTextePattern('nom', 'nom', '', $_SESSION['identite'][2], 1, 'entrez votre Nom', '[\sa-zA-Z]{3,20}'));
	$formProfil->ajouterComposantTab();
	$formProfil->ajouterComposantLigne($formProfil->creerInputTextePattern('prenom', 'prenom', '', $_SESSION['identite'][3], 1, 'entrez votre Prénom', '[a-zA-Z]{3,20}'));
	$formProfil->ajouterComposantTab();
	if ($_SESSION['typeIdentite'] == 'P') {
		$formProfil->ajouterComposantLigne($formProfil->creerInputTextePattern('adresse', 'adresse', '', $_SESSION['identite'][4], 1, 'entrez votre Adresse', '[\sa-zA-Z0-9]{3,32}'));
		$formProfil->ajouterComposantTab();
		$formProfil->ajouterComposantLigne($formProfil->creerInputTextePattern('descriptif', 'descriptif', '', $_SESSION['identite'][5], 1, 'entrez votre Descriptif', '[\sa-zA-Z0-9]{10,52}'));
		$formProfil->ajouterComposantTab();
	}
	$formProfil->ajouterComposantLigne($formProfil->creerInputSubmit('ModifierClient','ModifierClient','Changer vos informations'));
	$formProfil->ajouterComposantTab();
}

if ($_SESSION['menuProfil'] == "HistoriqueEC") {
	$_SESSION['comEC']= new commandes(CommandeDAO::selectListeCommandeEC($_SESSION['identite'][0]));
		if (sizeof($_SESSION['comEC']->getLesCommandes())>0){
		foreach ($_SESSION['comEC']->getLesCommandes() as $OBJ) {

			if(isset($_POST['S'.$OBJ->getNumCommande()])){
				CommanderDAO::deleteProdCommande($OBJ->getNumCommande());
				CommandeDAO::deleteCommande($OBJ->getNumCommande());
			}
			else{
				$formProfil->ajouterComposantLigne($formProfil->creerLabelFor("Commande N° ","lblnumeroCommande"));
				$formProfil->ajouterComposantLigne($formProfil->creerLabelFor($OBJ->getNumCommande(),"numeroCommande"));
				$formProfil->ajouterComposantTab();
				$formProfil->ajouterComposantLigne($formProfil->creerLabelFor("Effectuée le ","lbldateCommande"));
				$formProfil->ajouterComposantLigne($formProfil->creerLabelFor($OBJ->getDateCommande(),"dateCommande"));
				$formProfil->ajouterComposantTab();

				$lesProduits = new Commanders(CommanderDAO::produitsCommande($OBJ->getNumCommande()));
				foreach ($lesProduits->getLesCommanders() as $OBJ2) {
					$leProd = ProduitDAO::leProduit($OBJ2->getcode());
					$correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $leProd->getNom());
				  $correct = strtolower($correct);
				  $correct = 'image/'.$correct;
					$formProfil->ajouterComposantLigne($formProfil->creerInputImage('imgProduit','imgProduit',$correct));
					$formProfil->ajouterComposantLigne($formProfil->concactComposants($formProfil->creerLabelFor("Nom du produit : ","lblnameprod"),
																						 $formProfil->concactComposants($formProfil->creerA(ucfirst($leProd->getNom())),
																						 $formProfil->concactComposants($formProfil->creerLabelFor("Prix du produit : ","lblpriceprod"),
																						 $formProfil->concactComposants($formProfil->creerA(ProduitDAO::LePrixProduitCode($leProd->getCode(),$OBJ->getDateCommande()). " €"),
																						 $formProfil->concactComposants($formProfil->creerLabelFor("Quantité du produit : ","lblqteprod"),
																						 $formProfil->creerA($OBJ2->getqte()),0),2),0),2),0));
					$formProfil->ajouterComposantTab();
				}
				$formProfil->ajouterComposantLigne($formProfil->concactComposants($formProfil->creerInputSubmit("M".$OBJ->getNumCommande(),'modifCommande',"Modifier la commande"),
																					 $formProfil->creerInputSubmit("S".$OBJ->getNumCommande(),'supprimerCommande',"Supprimer la commande"),0));
				$formProfil->ajouterComposantTab();
				$formProfil->ajouterComposantLigne($formProfil->creerSep(''));
				$formProfil->ajouterComposantTab();
			}

		}
	}
}
if ($_SESSION['menuProfil'] == "HistoriqueV") {
	$_SESSION['comV']= new commandes(CommandeDAO::selectListeCommandeV($_SESSION['identite'][0]));
	if (sizeof($_SESSION['comV']->getLesCommandes())>0){
		foreach ($_SESSION['comV']->getLesCommandes() as $OBJ) {
			$formProfil->ajouterComposantLigne($formProfil->creerLabelFor("Commande N° ","lblnumeroCommande"));
			$formProfil->ajouterComposantLigne($formProfil->creerLabelFor($OBJ->getNumCommande(),"numeroCommande"));
			$formProfil->ajouterComposantTab();
			$formProfil->ajouterComposantLigne($formProfil->creerLabelFor("Effectuée le ","lbldateCommande"));
			$formProfil->ajouterComposantLigne($formProfil->creerLabelFor($OBJ->getDateCommande(),"dateCommande"));
			$formProfil->ajouterComposantTab();

			$lesProduits = new Commanders(CommanderDAO::produitsCommande($OBJ->getNumCommande()));
			foreach ($lesProduits->getLesCommanders() as $OBJ2) {
				$leProd = ProduitDAO::leProduit($OBJ2->getcode());
				$correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $leProd->getNom());
			  $correct = strtolower($correct);
			  $correct = 'image/'.$correct;
				$formProfil->ajouterComposantLigne($formProfil->creerInputImage('imgProduit','imgProduit',$correct));
				$formProfil->ajouterComposantLigne($formProfil->concactComposants($formProfil->creerLabelFor("Nom du produit : ","lblnameprod"),
																					 $formProfil->concactComposants($formProfil->creerA(ucfirst($leProd->getNom())),
																					 $formProfil->concactComposants($formProfil->creerLabelFor("Prix du produit : ","lblpriceprod"),
																					 $formProfil->concactComposants($formProfil->creerA(ProduitDAO::LePrixProduitCode($leProd->getCode(),$OBJ->getDateCommande()). " €"),
																					 $formProfil->concactComposants($formProfil->creerLabelFor("Quantité du produit : ","lblqteprod"),
																					 $formProfil->creerA($OBJ2->getqte()),0),2),0),2),0));
				$formProfil->ajouterComposantTab();
			}
			$formProfil->ajouterComposantTab();
			$formProfil->ajouterComposantLigne($formProfil->creerSep(''));
			$formProfil->ajouterComposantTab();
		}
	}
}
if ($_SESSION['menuProfil'] == "HistoriqueD") {
	$_SESSION['comD']= new commandes(CommandeDAO::selectListeCommandeD($_SESSION['identite'][0]));
if (sizeof($_SESSION['comD']->getLesCommandes())>0){
		foreach ($_SESSION['comD']->getLesCommandes() as $OBJ) {
			$formProfil->ajouterComposantLigne($formProfil->creerLabelFor("Commande N° ","lblnumeroCommande"));
			$formProfil->ajouterComposantLigne($formProfil->creerLabelFor($OBJ->getNumCommande(),"numeroCommande"));
			$formProfil->ajouterComposantTab();
			$formProfil->ajouterComposantLigne($formProfil->creerLabelFor("Effectuée le ","lbldateCommande"));
			$formProfil->ajouterComposantLigne($formProfil->creerLabelFor($OBJ->getDateCommande(),"dateCommande"));
			$formProfil->ajouterComposantTab();

			$lesProduits = new Commanders(CommanderDAO::produitsCommande($OBJ->getNumCommande()));
			foreach ($lesProduits->getLesCommanders() as $OBJ2) {
				$leProd = ProduitDAO::leProduit($OBJ2->getcode());
				$correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $leProd->getNom());
			  $correct = strtolower($correct);
			  $correct = 'image/'.$correct;
				$formProfil->ajouterComposantLigne($formProfil->creerInputImage('imgProduit','imgProduit',$correct));
				$formProfil->ajouterComposantLigne($formProfil->concactComposants($formProfil->creerLabelFor("Nom du produit : ","lblnameprod"),
																					 $formProfil->concactComposants($formProfil->creerA(ucfirst($leProd->getNom())),
																					 $formProfil->concactComposants($formProfil->creerLabelFor("Prix du produit : ","lblpriceprod"),
																					 $formProfil->concactComposants($formProfil->creerA(ProduitDAO::LePrixProduitCode($leProd->getCode(),$OBJ->getDateCommande()). " €"),
																					 $formProfil->concactComposants($formProfil->creerLabelFor("Quantité du produit : ","lblqteprod"),
																					 $formProfil->creerA($OBJ2->getqte()),0),2),0),2),0));
				$formProfil->ajouterComposantTab();
			}
			$formProfil->ajouterComposantTab();
			$formProfil->ajouterComposantLigne($formProfil->creerSep(''));
			$formProfil->ajouterComposantTab();
		}
	}
}

$photoProfil = new Formulaire('post','index.php','photoProfil','photoProfil');
$photoProfil->ajouterComposantLigne($photoProfil->creerInputImageProfil('photoProfil','photoDProfil',"image/" . $_SESSION['identite'][0]));
$photoProfil->ajouterComposantLigne($photoProfil->creerInputSubmit('deconnexion','deconnexion','Deconnecter'));
$photoProfil->ajouterComposantTab();
$laPhotoProfil = $photoProfil->creerFormulaire();
$laPhotoProfil = $photoProfil->afficherFormulaire();
$contentProfil=$formProfil->creerFormulaire();
$contentProfil=  '<nav class = "conteneurProfil">'. $formProfil->afficherFormulaire() . '</nav>';

include "vue/vueProfil.php";
 ?>
