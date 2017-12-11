<?php
if (isset($_POST['Inscrmail'])
		&& isset($_POST['Inscrnom'])
		&& isset($_POST['Inscrprenom'])
		&& isset($_POST['Inscrmdp'])
		&& isset($_POST['Inscrmdpconf'])
		){
	if ($_POST['Inscrmdp'] == $_POST['Inscrmdpconf']) {
		$leNewClient = new User($_POST['Inscrmail'],$_POST['Inscrnom'],$_POST['Inscrprenom'],$_POST['Inscrmdp']);
		UserDAO::ajouterUnClient($leNewClient);
    $_SESSION['menuPrincipal']=$_SESSION['dernierePage'];
    $_SESSION['menuPrincipal']="Accueil";
    echo '<script type="text/javascript">';
    echo 'window.location.href = "index.php?menuPrincipal='.$_SESSION['dernierePage'].'";';
    echo '</script>';
	}
}
if (isset($_POST['Inscrmail'])) {
	$Inscrmail = $_POST['Inscrmail'];
}
else {
	$Inscrmail = '';
}
if (isset($_POST['Inscrnom'])) {
	$Inscrnom = $_POST['Inscrnom'];
}
else {
	$Inscrnom = '';
}
if (isset($_POST['Inscrprenom'])) {
	$Inscrprenom = $_POST['Inscrprenom'];
}
else {
	$Inscrprenom = '';
}

$formInscription = new Formulaire('post','index.php','formInscription','formInscription');
$formInscription->ajouterComposantLigne($formInscription->creerInputTextePattern('Inscrmail', 'Inscrmail', '',$Inscrmail,1,'saisir votre mail', '[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputTextePattern('Inscrnom', 'Inscrnom', '',$Inscrnom,1,'saisir votre nom', '[a-zA-Z]{3,20}' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputTextePattern('Inscrprenom', 'Inscrprenom', '',$Inscrprenom,1,'saisir votre prenom', '[a-zA-Z]{3,20}' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputPassPattern('Inscrmdp', 'Inscrmdp', '','',1,'saisir votre mot de passe','[a-zA-Z0-9]{4,20}' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputPassPattern('Inscrmdpconf', 'Inscrmdpconf', '','',1,'confirmer votre nouveau mot de passe','[a-zA-Z0-9]{4,20}' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputSubmit('inscrValid', 'inscrValid', "Inscription"));
$contentInscr=$formInscription->ajouterComposantTab();
$contentInscr=$formInscription->creerFormulaire();

  include "vue/vueInscription.php";
 ?>
