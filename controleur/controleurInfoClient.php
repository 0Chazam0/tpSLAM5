<?php
if (isset($_POST['nom'])
		&& isset($_POST['prenom'])
		){
			if ($_SESSION['typeIdentite'] == 'P') {
				if (isset($_POST['adresse'])
						&& isset($_POST['descriptif'])
						){
						}
			}
			else {
				UserDAO::modifierClient($_SESSION['identite'], $_POST['nom'], $_POST['prenom']);
				if (UserDAO::modifierClient($_SESSION['identite'], $_POST['nom'], $_POST['prenom']) == true) {
					$_SESSION['identite'][2] = $_POST['nom'];
					$_SESSION['identite'][3] = $_POST['prenom'];
				}
			}
    echo '<script type="text/javascript">';
    echo 'window.location.href = "index.php?menuPrincipal='.$_SESSION['dernierePage'].'";';
    echo '</script>';
	}

$menuProfil = new menu("menuProfil");
$menuProfil->ajouterComposant($menuProfil->creerItemLien('Profil','Profil'));
if ($_SESSION['typeIdentite'] == 'R') {
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('Responsable','Responsable'));
}
if ($_SESSION['typeIdentite'] == 'P') {
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('Producteur','Producteur'));
}
if ($_SESSION['typeIdentite'] == 'C') {
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('Historique','Historique'));
	$menuProfil->ajouterComposant($menuProfil->creerItemLien('Modifier','Modifier'));
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

if ($_SESSION['menuProfil'] == "Historique") {

}

if ($_SESSION['menuProfil'] == "Modifier") {
	$formProfil->ajouterComposantLigne($formProfil->creerInputTextePattern('nom', 'nom', '', $_SESSION['identite'][2], 1, 'entrez votre Nom', '[a-zA-Z]{3,20}'));
	$formProfil->ajouterComposantTab();
	$formProfil->ajouterComposantLigne($formProfil->creerInputTextePattern('prenom', 'prenom', '', $_SESSION['identite'][3], 1, 'entrez votre Prénom', '[a-zA-Z]{3,20}'));
	$formProfil->ajouterComposantTab();
	if ($_SESSION['typeIdentite'] == 'P') {
		$formProfil->ajouterComposantLigne($formProfil->creerInputTextePattern('adresse', 'adresse', $_SESSION['identite'][4], 1, 'entrez votre Adresse', '[a-zA-Z0-9]{3,20}'));
		$formProfil->ajouterComposantTab();
		$formProfil->ajouterComposantLigne($formProfil->creerInputTextePattern('descriptif', 'descriptif', $_SESSION['identite'][5], 1, 'entrez votre Descriptif', '[a-zA-Z0-9]{10,52}'));
		$formProfil->ajouterComposantTab();
	}
	$formProfil->ajouterComposantLigne($formProfil->creerInputSubmit('ModifierClient','ModifierClient','Changer vos informations'));
	$formProfil->ajouterComposantTab();
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
