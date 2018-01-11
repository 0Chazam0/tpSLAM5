<?php
$autVente = false;

$formResp = new Formulaire("POST","index.php?menuPrincipal=Responsable&c=1","formResp","responable");
if (isset($_POST['nomProduc'])){
  if ($_POST['mdpProduc'] == $_POST['reMdpProduc']){
    try {
      ResponsableDAO::insertNewProducteur($_POST['nomProduc'], $_POST['prenomProduc'], $_POST['emailProduc'], $_POST['adresseProduc'], "descrip", $_POST['mdpProduc']);
      echo '<script>alert("Ajout de '. $_POST['nomProduc'] . ' réussi");</script>';
    } catch (Exception $e) {
      echo '<script>alert("Erreur");</script>';
    }
  }
  else{
    echo '<script>alert("mdp incorrect");</script>';
  }
}
elseif (isset($_POST['dateDebutProduc'])) {
  try {
    ResponsableDAO::insertDate($_POST['dateDebutProduc'],$_POST['dateDebutVente'],$_POST['dateFinVente']);
    echo '<script>alert("Ajout réussi");</script>';
  } catch (Exception $e) {
    echo '<script>alert("Erreur");</script>';
  }
}
elseif (isset($_POST['codeType'])) {
  try {
    ResponsableDAO::insertTypeProduit($_POST['codeType'], $_POST['libelleType']);
    echo '<script>alert("Ajout de '. $_POST['libelleType'] . ' réussi");</script>';
  } catch (Exception $e) {
    echo '<script>alert("Ajout de '. $_POST['libelleType'] . ' non réussi");</script>';
  }
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
  $autVente = true;
  $vente = array();
  $vente[] = ResponsableDAO::selectVente();
  $i = 0;
  while (isset($vente[0][$i])) {
    $formResp->ajouterComposantLigne($formResp->creerA($vente[0][$i]));
    if ($vente[0][$i]['dateF'] < date('Y-m-d')){
      $formResp->ajouterComposantLigne($formResp->creerInputSubmit($i, $i, "Fermer"));
    }
    else{
      $formResp->ajouterComposantLigne($formResp->creerInputSubmit($i, $i, "Ouvrir"));
    }
    $formResp->ajouterComposantTab();
    echo $i + 1 . "</br>";
    $o = $vente[0][$i];
    print_r($o);
    $i++;
  }
}

// -->Ouvrir/fermer l'autorisation la saisie des commandes pour une nouvelle vente.
elseif ($_GET['c'] == 5) {

}
if ($autVente == false){
  $formResp->ajouterComposantLigne($formResp->creerInputSubmit("enregistrer", "enregistrer", "Enregistrer"));
  $formResp->ajouterComposantTab();
}

$formResp->creerFormulaire();

require_once "vue/vueResponsable.php";
 ?>
