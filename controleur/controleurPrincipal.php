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
require_once 'modele\DTO\commander.php';
require_once 'modele\DTO\producteur.php';
require_once 'modele\DTO\produit.php';
require_once 'modele\DTO\typeProduit.php';
require_once 'modele\DTO\user.php';

/*----------------------------------------------------------*/
/*--------Header-----------------------------------------*/
/*----------------------------------------------------------*/
if (!isset($_SESSION['typeIdentite']) || $_SESSION['typeIdentite'] == 'C' ){
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
}




	elseif (isset($_SESSION['typeIdentite']) && $_SESSION['typeIdentite'] == 'R' ) {
		$_SESSION['TypeMenuResponsable']= null;
		$theMenuType=null;
		if(isset($_GET['TypeMenuResponsable'])){
		  $_SESSION['TypeMenuResponsable']= $_GET['TypeMenuResponsable'];
		  $_SESSION['TypeMenuResponsableSelected'] = $_GET['TypeMenuResponsable'];
		}
		else
		{
		  if(!isset($_SESSION['TypeMenuResponsable'])){
		    if(isset($_SESSION['TypeMenuResponsableSelected'])){
		    $_SESSION['TypeMenuResponsable']=$_SESSION['TypeMenuResponsableSelected'] ;
		  }
		  }

		}

		$menuTypeMenuResponsable = new menu("menuTypeProd");
		$menuTypeMenuResponsable->ajouterComposant($menuTypeMenuResponsable->creerItemLien("EC","Espace connecté"));
		$menuTypeMenuResponsable->ajouterComposant($menuTypeMenuResponsable->creerItemLien("ER","Espace responsable"));

		$theMenuType .= $menuTypeMenuResponsable->creerMenuType("TypeMenuResponsable",$_SESSION['TypeMenuResponsable']);

	}

	elseif (isset($_SESSION['typeIdentite']) && $_SESSION['typeIdentite'] == 'P' ) {
		$_SESSION['TypeMenuProducteur']= null;
		$theMenuType=null;
		if(isset($_GET['TypeMenuProducteur'])){
		  $_SESSION['TypeMenuProducteur']= $_GET['TypeMenuProducteur'];
		  $_SESSION['TypeMenuProducteurSelected'] = $_GET['TypeMenuProducteur'];
		}
		else
		{
		  if(!isset($_SESSION['TypeMenuProducteur'])){
		    if(isset($_SESSION['TypeMenuProducteurSelected'])){
		    $_SESSION['TypeMenuProducteur']=$_SESSION['TypeMenuProducteurSelected'] ;
		  }
		  }

		}




		$menuTypeMenuProducteur = new menu("menuTypeProd");
		$menuTypeMenuProducteur->ajouterComposant($menuTypeMenuProducteur->creerItemLien("EC","Espace connecté"));
		$menuTypeMenuProducteur->ajouterComposant($menuTypeMenuProducteur->creerItemLien("EP","Espace producteur"));
		$theMenuType .= $menuTypeMenuProducteur->creerMenuType("TypeMenuProducteur",$_SESSION['TypeMenuProducteur']);


}

/*----------------------------------------------------------*/
/*--------Passage des commandes validées à distribuées au bout de 7j(jour mini pour que toutes les commandes de la semaine précédente soient distribuées)-------*/
/*----------------------------------------------------------*/

$_SESSION['listeCommande'] = new Commandes(CommandeDAO::selectListeCommande());
// recuperer le num de la prochaine commande
if(sizeof($_SESSION['listeCommande']->getLesCommandes())>0){
	foreach ($_SESSION['listeCommande']->getLesCommandes() as $OBJ)
	{
		$dateNow= new datetime (date("Y-m-d")) ;
		$dateCom= new datetime ($OBJ->getDateCommande());

		$diff = date_diff($dateNow,$dateCom);
		if(abs($diff->format('%R%a'))>7){
		 	CommandeDAO::updateDistribuerEtatCommande($OBJ->getNumCommande());
		 }
	}
}
/*----------------------------------------------------------*/
/*--------session du menu principal avec produit si le menu a été selectionné-------*/
/*----------------------------------------------------------*/
if (isset($_SESSION['typeProduitSelected'])) {
	$_SESSION['menuPrincipal'] = 'Produit';
}


if(isset($_SESSION['identite']) && $_SESSION['typeIdentite']="C"){
	$_SESSION['listeCommandeCli'] =new commandes(CommandeDAO::selectListeCommandeEC($_SESSION['identite'][0]));
	// recuperer le num de la prochaine commande
	if(sizeof($_SESSION['listeCommandeCli']->getLesCommandes())>0){
		foreach ($_SESSION['listeCommandeCli']->getLesCommandes() as $OBJ){
			if (isset($_POST["M".$OBJ->getNumCommande()])) {
				$_SESSION['lePanier'] = new Produits(array());
				$lesProduits = new Commanders(CommanderDAO::produitsCommande($OBJ->getNumCommande()));
				foreach ($lesProduits->getLesCommanders() as $OBJ2) {
					$leProd = ProduitDAO::leProduit($OBJ2->getcode());
					$leProd->setQte($OBJ2->getqte());
					$_SESSION['lePanier']->ajouterProduit($leProd);
				}
			$_SESSION['typeProduitSelected']= NULL;
			$_SESSION['EstEnModif'] = true;
			$_SESSION['NumComModif'] = $OBJ->getNumCommande();
			$_SESSION['menuPrincipal'] = 'Produit';
		}
	}
}
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


if (isset($_SESSION['identite']))
{
	$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien('InfoClient',"Bienvenue : " . $_SESSION['identite'][3]));

}
else
{
	$menuPrincipal->ajouterComposant($menuPrincipal->creerItemLien('Connexion',"Connexion"));
}

$leMenuP = $menuPrincipal->creerMenu('menuPrincipal');


/*----------------------------------------------------------*/
/*--------Récupère le controleur Inscription (si la condition est respectée)----------*/
/*----------------------------------------------------------*/
if (isset($_POST['inscrValid'])) {
	$_SESSION['menuPrincipal'] = 'Inscription';
}

/*----------------------------------------------------------*/
/*--------Récupère le controleur Connexion (si la condition est respectée)----------*/
/*----------------------------------------------------------*/
if (isset($_POST['Valconnexion'])) {
	$_SESSION['menuPrincipal'] = 'Connexion';
}

/*----------------------------------------------------------*/
/*--------Récupère le controleur MdpOublie (si la condition est respectée)----------*/
/*----------------------------------------------------------*/
if (isset($_POST['mdpOublie'])) {
	$_SESSION['menuPrincipal'] = 'MdpOublie';
}

/*----------------------------------------------------------*/
/*--------Récupère le controleur MdpOublie (si la condition est respectée)----------*/
/*----------------------------------------------------------*/
if (isset($_POST['mdpChange'])) {
	$_SESSION['menuPrincipal'] = 'MdpChange';
}

/*----------------------------------------------------------*/
/*--------Récupère le controleur MdpOublie (si la condition est respectée)----------*/
/*----------------------------------------------------------*/
if (isset($_POST['changValid'])) {
	$_SESSION['menuPrincipal'] = 'MdpChange';
}

/*----------------------------------------------------------*/
/*--------Récupère le controleur InfoClient (si la condition est respectée)----------*/
/*----------------------------------------------------------*/
if (isset($_POST['ModifierClient'])) {
	$_SESSION['menuPrincipal'] = 'InfoClient';
}
/*----------------------------------------------------------*/
/*--------Récupère le controleur Producteur (si la condition est respectée)----------*/
/*----------------------------------------------------------*/
if (isset($_POST['redirectionProducteur'])) {
	$_SESSION['menuPrincipal'] = 'Producteur';
}

/*----------------------------------------------------------*/
/*--------Récupère le controleur Commande (si la condition est respectée) et si on est connecté----------*/
/*----------------------------------------------------------*/
if (isset($_POST['validerCommande'])){
	if (!isset($_SESSION['identite'])) {
		$_SESSION['menuPrincipal']= 'Connexion';
	}
	else{
		$numeroCommande = 0;
	  $_SESSION['listeCommande'] = new Commandes(CommandeDAO::selectListeCommande());
	  // recuperer le num de la prochaine commande
	    foreach ($_SESSION['listeCommande']->getLesCommandes() as $OBJ)
	    {
	      $idC = substr($OBJ->getNumCommande(), 1) ;
	      if ($numeroCommande < $idC) {
	        $numeroCommande = substr($OBJ->getNumCommande(), 1);
	      }
	    }


	  $_SESSION['compteurCommande']= "C".($numeroCommande+1);
	  CommandeDAO::ajouterUneCommande($_SESSION['compteurCommande'], $_SESSION['identite'][0],date("Y-m-d"),"EC");
		$_SESSION['lePanier'] = unserialize(serialize($_SESSION['lePanier']));
	  foreach ($_SESSION['lePanier']->getLesProduits() as $OBJ)
		{
	    CommandeDAO::ajouterProduitCommande($_SESSION['compteurCommande'],$OBJ->getCode(),$OBJ->getQte());
	  }

		$_SESSION['menuPrincipal']="Commande";
	}
}


if (isset($_POST['validerModifCommande'])){
	if (!isset($_SESSION['identite'])) {
		$_SESSION['menuPrincipal']= 'Connexion';
	}
	else{
		CommanderDAO::deleteProdCommande($_SESSION['NumComModif']);
		CommandeDAO::deleteCommande($_SESSION['NumComModif']);
	  CommandeDAO::ajouterUneCommande($_SESSION['NumComModif'], $_SESSION['identite'][0],date("Y-m-d"),"EC");
		$_SESSION['lePanier'] = unserialize(serialize($_SESSION['lePanier']));
	  foreach ($_SESSION['lePanier']->getLesProduits() as $OBJ)
		{
	    CommandeDAO::ajouterProduitCommande($_SESSION['NumComModif'],$OBJ->getCode(),$OBJ->getQte());
	  }

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
