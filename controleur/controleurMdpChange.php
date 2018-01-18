<?php
//changement de mdp
if (isset($_POST['inscrmdpPrec']) && isset($_POST['inscrmdp']) && isset($_POST['inscrmdpconf'])) {
  if ($_POST['inscrmdpPrec'] == $_SESSION['identite'][1]) {
    if ($_POST['inscrmdp'] == $_POST['inscrmdpconf']) {
        UserDAO::changeMDP($_SESSION['identite'][0],$_SESSION['typeIdentite'],$_POST['inscrmdp']);
        $_SESSION['identite'][1] = $_POST['inscrmdp'];
        $_SESSION['menuPrincipal']="Accueil";
        echo '<script type="text/javascript">';
        echo 'window.location.href = "index.php?menuPrincipal='.$_SESSION['dernierePage'].'";';
        echo '</script>';
    }
  }
}

//formulaire pour changement de mdp
$formChange = new Formulaire('post','index.php','formChange','formChange');
$formChange->ajouterComposantLigne($formChange->creerInputPassPattern('inscrmdpPrec', 'inscrmdpPrec', '','',1,'saisir précédent mot de passe', '[a-zA-Z0-9]{4,20}' ));
$formChange->ajouterComposantTab();
$formChange->ajouterComposantLigne($formChange->creerInputPassPattern('inscrmdp', 'inscrmdp', '','',1,'saisir votre nouveau mot de passe', '[a-zA-Z0-9]{4,20}' ));
$formChange->ajouterComposantTab();
$formChange->ajouterComposantLigne($formChange->creerInputPassPattern('inscrmdpconf', 'inscrmdpconf', '','',1,'confirmer votre nouveau mot de passe','[a-zA-Z0-9]{4,20}' ));
$formChange->ajouterComposantTab();
$formChange->ajouterComposantLigne($formChange->creerInputSubmit('changValid', 'changValid', "Changer mot de passe"));
$formChange->ajouterComposantTab();
$formChangeAff = $formChange->creerFormulaire();
$formChangeAff = $formChange->afficherFormulaire();
include "vue/vueMdpChange.php"; ?>
