<?php //définition du formulaire
if (isset($_POST['Email']) && isset($_POST['mdp'])) {
  $unUserC = UserDAO::unUserC($_POST['Email']);
  $unUserP = UserDAO::unUserP($_POST['Email']);
  $unUserR = UserDAO::unUserR($_POST['Email']);
  if ($unUserC != NULL) {
    $unUser = $unUserC;
    $unUserType = 'C';
  }
  elseif ($unUserP != NULL) {
    $unUser = $unUserP;
    $unUserType = 'P';
  }
  elseif ($unUserR != NULL) {
    $unUser = $unUserR;
    $unUserType = 'R';
  }
   if ($unUser != '') {
    if ($unUser[1]==$_POST['mdp'] ) {
      $_SESSION['identite'] = $unUser;
      $_SESSION['typeIdentite'] = $unUserType;
      $_SESSION['menuPrincipal']=$_SESSION['dernierePage'];
            $_SESSION['menuPrincipal']="Accueil";
            echo '<script type="text/javascript">';
            echo 'window.location.href = "index.php?menuPrincipal='.$_SESSION['dernierePage'].'";';
            echo '</script>';
          }
        }
      }
      if (isset($_POST['Email'])) {
        $ident = $_POST['Email'];
      }
      else {
        $ident = '';
      }

      $formConnexion = new Formulaire('post','index.php','formConnexion','formConnexion');
      $formConnexion->ajouterComposantLigne($formConnexion->creerInputTextePattern('Email', 'Email', '',$ident,1,'saisir votre mail', '[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})' ));
      $formConnexion->ajouterComposantTab();
      $formConnexion->ajouterComposantLigne($formConnexion->creerInputPassPattern('mdp', 'mdp', '','',1,'saisir votre mot de passe','[a-zA-Z0-9]{4,20}' ));
      $formConnexion->ajouterComposantTab();
      $formConnexion->ajouterComposantLigne($formConnexion->creerInputSubmit('Valconnexion', 'Valconnexion', "Connexion"));
      $formConnexion->ajouterComposantTab();
      $contentConnex=$formConnexion->ajouterComposantTab();
      $contentConnex=$formConnexion->creerFormulaire();

      $formInscriptionV = new Formulaire('post','index.php','formInscriptionV','formInscriptionV');
      $formInscriptionV->ajouterComposantLigne($formInscriptionV->creerInputSubmit('inscrValid', 'inscrValid', "Pas encore de compte ?"));
      $formInscriptionV->ajouterComposantTab();
      $contentInscrV=$formInscriptionV->ajouterComposantTab();
      $contentInscrV=$formInscriptionV->creerFormulaire();

      $formOublie = new Formulaire('post','index.php','formOublie','formOublie');
      $formOublie->ajouterComposantLigne($formOublie->creerInputSubmit('mdpOublie', 'mdpOublie', "Mot de passe oublié ?"));
      $formOublie->ajouterComposantTab();
      $contentOublie=$formOublie->ajouterComposantTab();
      $contentOublie=$formOublie->creerFormulaire();

include "vue/vueConnexion.php";
