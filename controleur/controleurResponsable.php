<?php
// $menu = '<table>';
// $menu .= '<tr>';
// $menu .= '<th><a href="index.php?menuPrincipal=Responsable&c=1">Enregistrer un nouveau producteur</a></th>';
// $menu .= '<th><a href="index.php?menuPrincipal=Responsable&c=2">Enregistrer une nouvelle vente</a></th>';
// $menu .= '<th><a href="index.php?menuPrincipal=Responsable&c=3">Enregistrer une nouvelle categorie de produits</a></th>';
// $menu .= '<th><a href="index.php?menuPrincipal=Responsable&c=4">Autoriser/bloquer l\'autorisation de saisie des producteurs pour une vente</a></th>';
// $menu .= '<th><a href="index.php?menuPrincipal=Responsable&c=5">Autoriser/bloquer l\'autorisation de commander</a></th>';
// $menu .= '<th><a href="index.php?menuPrincipal=Responsable&c=0">Changer le mot de passe</a></th>';
// $menu .= '</tr>';
// $menu .= '</table>';

$formResp = new Formulaire("POST","index.php?menuPrincipal=Responsable&c=1","formResp","responable");
if (isset($_POST['nomProduc'])){
  if ($_POST['mdpProduc'] == $_POST['reMdpProduc']){
    ResponsableDAO::insertNewProducteur($_POST['nomProduc'], $_POST['prenomProduc'], $_POST['emailProduc'], $_POST['adresseProduc'], "descrip", $_POST['mdpProduc']);
    echo "ok";
  }
  else{
    echo "mdp incorrect";
  }
}
elseif (isset($_POST['dateDebutProduc'])) {
  ResponsableDAO::insertDate($_POST['dateDebutProduc'],$_POST['dateFinProduc'],$_POST['dateDebutVente'],$_POST['dateFinVente']);
}
elseif (isset($_POST['codeType'])) {
  echo "okokokokokoko";
  ResponsableDAO::insertTypeProduit($_POST['codeType'], $_POST['libelleType']);
}
if (!isset($_GET['c']) || $_GET['c'] == 1){
// -->Enregistrer un nouveau producteur.
  $formResp->ajouterComposantLigne($formResp->creerA("Nom:<br/>"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("nomProduc", "nomProduc", 0, 0, 1, 0, 0));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Prenom:"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("prenomProduc", "prenomProduc", 0, 0, 1, 0, 0));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Email:"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("emailProduc", "emailProduc", 0, 0, 1, 0, 0));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Adresse:"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("adresseProduc", "adresseProduc", 0, 0, 1, 0, 0));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Descriptif:"));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Mot de passe:"));
  $formResp->ajouterComposantLigne($formResp->creerInputPassPattern("mdpProduc", "mdpProduc", 0, 0, 1, 0, 0));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Confirmez le mot de passe:"));
  $formResp->ajouterComposantLigne($formResp->creerInputPassPattern("reMdpProduc", "reMdpProduc", 0, 0, 1, 0, 0));
  $formResp->ajouterComposantTab();
}
// -->Créer une nouvelle vente.
elseif ($_GET['c'] == 2) {
  $formResp->ajouterComposantLigne($formResp->creerA("Date saisie producteur:"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("dateDebutProduc", "dateDebutProduc", 0, date('Y-m-d'), 1, 0, 0));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Date fin saisie producteur:"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("dateFinProduc", "dateFinProduc", 0, date('Y-m-d'), 1, 0, 0));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Date début vente:"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("dateDebutVente", "dateDebutVente", 0, date('Y-m-d'), 1, 0, 0));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Date fin de la vente:"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("dateFinVente", "dateFinVente", 0, date('Y-m-d'), 1, 0, 0));
  $formResp->ajouterComposantTab();
}

// ->Ajouter une nouvelle catégorie de produits.
elseif ($_GET['c'] == 3) {
  $formResp->ajouterComposantLigne($formResp->creerA("Code du nouveau type produit:"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("codeType", "codeType", 0, 0, 1, 0, 0));
  $formResp->ajouterComposantTab();
  $formResp->ajouterComposantLigne($formResp->creerA("Libellé du nouveau type produit:"));
  $formResp->ajouterComposantLigne($formResp->creerInputTexte("libelleType", "libelleType", 0, 0, 1, 0, 0));
  $formResp->ajouterComposantTab();
}

// -->Ouvrir/fermer l'autorisation de saisie des producteurs pour une nouvelle vente.
elseif ($_GET['c'] == 4) {

}

// -->Ouvrir/fermer l'autorisation la saisie des commandes pour une nouvelle vente.
elseif ($_GET['c'] == 5) {

}
$formResp->ajouterComposantLigne($formResp->creerInputSubmit("enregistrer", "enregistrer", "Enregistrer"));
$formResp->ajouterComposantTab();
$formResp->creerFormulaire();

require_once "vue/vueResponsable.php";
 ?>
