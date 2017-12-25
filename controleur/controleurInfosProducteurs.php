<?php
$_SESSION['dernierePage'] = "InfosProducteurs";
$_SESSION['lesFormsProducteurs'] = null;
$_SESSION['ListeProducteur'] = new Producteurs(ProducteurDAO::selectListeProducteur());

foreach ($_SESSION['ListeProducteur']->getLesProducteurs() as $OBJ){

  $correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $OBJ->getNom());
  $correct = strtolower($correct);
  $correct = 'image/'.$correct;
  $formProducteur = new Formulaire("POST","index.php","formInfosProducteurs","infosProducteursthis");
  $formProducteur->ajouterComposantLigne($formProducteur->creerInputImage('imgProducteur', 'imgProducteur', $correct));
  $formProducteur->ajouterComposantTab();
  $formProducteur->ajouterComposantLigne($formProducteur->concactComposants($formProducteur->creerLabelFor("Dénomination : ","lblnomProducteur"),
                                         $formProducteur->creerLabelFor(ucfirst($OBJ->getNom()),"nomProducteur"),0));
  $formProducteur->ajouterComposantTab();
  $formProducteur->ajouterComposantLigne($formProducteur->concactComposants($formProducteur->creerLabelFor("Adresse : ","lbladresseProducteur"),
                                         $formProducteur->creerLabelFor(ucfirst($OBJ->getAdresse()),"adresseProducteur"),0));
  $formProducteur->ajouterComposantTab();
  $formProducteur->ajouterComposantLigne($formProducteur->concactComposants($formProducteur->creerLabelFor("Description : ","lbldescriptionProducteur"),
                                         $formProducteur->creerLabelFor(ucfirst($OBJ->getDescriptif()),"descriptionProducteur"),0));
  $formProducteur->ajouterComposantTab();
  $formProducteur->creerFormulaire();
  $_SESSION['lesFormsProducteurs'] .= $formProducteur->afficherFormulaire();

}

include "vue/vueInfosProducteurs.php";
 ?>
