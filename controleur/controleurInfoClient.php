<?php

$menuProfil = new menu("menuProfil");
$menuProfil->ajouterComposant($menuProfil->creerItemLien('Profil','Profil'));
if ($_SESSION['typeIdentite'] == 'C') {
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('Historique','Historique'));
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
if ($_SESSION['menuProfil'] == "Moderateur") {
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

if ($_SESSION['menuProfil'] == "Historique") {

}
$photoProfil = new Formulaire('post','index.php','photoProfil','photoProfil');
//$photoProfil->ajouterComposantLigne($photoProfil->creerInputImageProfil('photoProfil','photoDProfil',"image/" . $_SESSION['identite'][0]));
$photoProfil->ajouterComposantLigne($photoProfil->creerInputSubmit('deconnexion','deconnexion','Deconnecter'));
$photoProfil->ajouterComposantTab();
$laPhotoProfil = $photoProfil->creerFormulaire();
$laPhotoProfil = $photoProfil->afficherFormulaire();
$contentProfil=$formProfil->creerFormulaire();
$contentProfil=  '<nav class = "conteneurProfil">'. $formProfil->afficherFormulaire() . '</nav>';

include "vue/vueProfil.php";
 ?>
