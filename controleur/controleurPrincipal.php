<?php
if (isset($_POST['deconnexion'])) {
	session_destroy();
	session_start();
}


/*----------------------------------------------------------*/
/*--------inclut les fichiers suivant une seule fois sans erreur----------*/
/*----------------------------------------------------------*/
require_once 'configs/param.php';
require_once 'library/menu.php';
require_once 'library/dispatcher.php';
require_once 'library/formulaire.php';
require_once 'modele/dao.php';


/*----------------------------------------------------------*/
/*--------inclut les fichiers DTO----------*/
/*----------------------------------------------------------*/
require_once 'modele\DTO\commande.php';
require_once 'modele\DTO\producteur.php';
require_once 'modele\DTO\produit.php';
require_once 'modele\DTO\typeProduit.php';
require_once 'modele\DTO\user.php';

/*----------------------------------------------------------*/
/*--------Header-----------------------------------------*/
/*----------------------------------------------------------*/
$_SESSION['TypeProduit']= null;
$theMenuType=null;
	if(isset($_GET['TypeProduit'])){
		$_SESSION['TypeProduit']= $_GET['TypeProduit'];
		$_SESSION['typeProduitSelected'] = $_GET['TypeProduit'];
	}
	else
	{
		if(!isset($_SESSION['TypeProduit'])){
			if(isset($_SESSION['typeProduitSelected'])){
			$_SESSION['TypeProduit']=$_SESSION['typeProduitSelected'] ;
		}
		}

	}

	$_SESSION['ListeTypeProduit'] = new TypeProduits(TypeProduitDAO::selectListeTypeProduit());

	foreach ($_SESSION['ListeTypeProduit']->getLesTypes() as $OBJ){
	$menuTypeProduit = new menu("menuTypeProd");
	$menuTypeProduit->ajouterComposant($menuTypeProduit->creerItemLien($OBJ->getCode(),ucfirst($OBJ->getLibelle())));
	$theMenuType .= $menuTypeProduit->creerMenuType("TypeProduit",$_SESSION['TypeProduit']);

	}


/*----------------------------------------------------------*/
/*--------session du menu principal avec produit si le menu a été selectionné-------*/
/*----------------------------------------------------------*/
if (isset($_SESSION['typeProduitSelected'])) {
	$_SESSION['menuPrincipal'] = 'Produit';
}

/*----------------------------------------------------------*/
/*--------session du menu principal avec accueil par defaut-------*/
/*----------------------------------------------------------*/
if(isset($_GET['menuPrincipal'])){
	$_SESSION['menuPrincipal']= $_GET['menuPrincipal'];
}
else
{
	if(!isset($_SESSION['menuPrincipal'])){
		$_SESSION['menuPrincipal']="Accueil";
	}

}

$menuPrincipal = new Menu("menuP");


if (!isset($_SESSION['identite']))
{
	$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien('Connexion',"Connexion"));
}
else
{
	$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien('InfoClient',"Bienvenue : " . $_SESSION['identite'][3]));
}

$leMenuP = $menuPrincipal->creerMenu('menuPrincipal');


/*----------------------------------------------------------*/
/*--------Récupère le controleur Inscription (si la condition est respectée)----------*/
/*----------------------------------------------------------*/
if (isset($_POST['inscrValid'])) {
	$_SESSION['menuPrincipal'] = 'Inscription';
}

/*----------------------------------------------------------*/
/*--------Récupère le controleur Commande (si la condition est respectée) et si on est connecté----------*/
/*----------------------------------------------------------*/
if (isset($_POST['validerCommande'])){
	if (!isset($_SESSION['identite'])) {
		$_SESSION['menuPrincipal']= 'Connexion';
	}
	else{
		$_SESSION['menuPrincipal']="Commande";
	}
}
if (isset($_POST['confirmCommande'])) {
	$_SESSION['menuPrincipal']="Commande";
}
/*----------------------------------------------------------*/
/*-------Affiche le controleur récupéré----------*/
/*----------------------------------------------------------*/
include_once dispatcher::dispatch($_SESSION['menuPrincipal']);

 ?>
