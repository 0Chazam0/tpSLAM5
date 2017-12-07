<?php

$formInscription = new Formulaire('post','index.php','formInscription','formInscription');
$formInscription->ajouterComposantLigne($formInscription->creerInputTextePattern('mail', 'mail', '','',1,'saisir votre mail', '[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([_\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputTextePattern('nom', 'nom', '','',1,'saisir votre nom', '[a-zA-Z]{3,20}' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputTextePattern('prenom', 'prenom', '','',1,'saisir votre prenom', '[a-zA-Z]{3,20}' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputPassPattern('mdp', 'mdp', '','',1,'saisir votre mot de passe','[a-zA-Z0-9]{4,20}' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputPassPattern('mdpconf', 'mdpconf', '','',1,'confirmer votre nouveau mot de passe','[a-zA-Z0-9]{4,20}' ));
$formInscription->ajouterComposantTab();
$formInscription->ajouterComposantLigne($formInscription->creerInputSubmit('inscrValid', 'inscrValid', "Inscription"));
$contentInscr=$formInscription->ajouterComposantTab();
$contentInscr=$formInscription->creerFormulaire();

  include "vue/vueInscription.php";
 ?>
