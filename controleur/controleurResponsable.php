<?php
// mettre le boutton enregistrer a la fin si les dernieres categ ne sont pas selec.
$autVente = false;

$formResp = new Formulaire("POST","index.php?menuPrincipal=Responsable&c=1","formResp","responable");

// si le post est pour un nouveau producteur
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
// si le post est pour ajouter une date
elseif (isset($_POST['dateDebutProduc'])) {
  try {
    ResponsableDAO::insertDate($_POST['dateDebutProduc'],$_POST['dateDebutVente'],$_POST['dateFinVente']);
    echo '<script>alert("Ajout réussi");</script>';
  } catch (Exception $e) {
    echo '<script>alert("Erreur");</script>';
  }
}
// si le post est pour ajouter un nouveau type produit
elseif (isset($_POST['codeType'])) {
  try {
    ResponsableDAO::insertTypeProduit($_POST['codeType'], $_POST['libelleType']);
    echo '<script>alert("Ajout de '. $_POST['libelleType'] . ' réussi");</script>';
  } catch (Exception $e) {
    echo '<script>alert("Ajout de '. $_POST['libelleType'] . ' non réussi");</script>';
  }
}
// cherche si le post est pour modifier une semaine de vente
else{
  $_SESSION['ListeSemaine'] = new Semaines(ResponsableDAO::selectVente());
  foreach ($_SESSION['ListeSemaine']->getLesSemaines() as $OBJ){
    if (isset($_POST[$OBJ->getNumSemaine()])){
      try {
        // trouver si on ouvre ou ferme la vente
        if ($_POST[$OBJ->getNumSemaine()] == "Ouvrir la vente"){
          ResponsableDAO::updateVente(date('Y-m-d'), $OBJ->getNumSemaine());
        }
        else {
          ResponsableDAO::updateFinVente(date('Y-m-d'), $OBJ->getNumSemaine());
        }
        echo "<script>alert(' ". $OBJ->getNumSemaine() . "')</script>";
        break;
      } catch (Exception $e){
         echo "<script>alert('Erreur');</script>";
      }
    }
  }
}

// -->Enregistrer un nouveau producteur.
if (!isset($_GET['c']) || $_GET['c'] == 1){
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

// -->Demarrer une vente.
elseif ($_GET['c'] == 4) {
  // enleve le boutton enregistrer
  $autVente = true;
  $_SESSION['ListeSemaine'] = new Semaines(ResponsableDAO::selectVente());
  // parcours la liste des ventes et recupere les 20 dernieres semaines
  foreach ($_SESSION['ListeSemaine']->getLesSemaines() as $OBJ) {
    $formResp->ajouterComposantLigne($formResp->creerA($OBJ->getNumSemaine()));
    $formResp->ajouterComposantLigne($formResp->creerInputSubmit($OBJ->getNumSemaine(), $OBJ->getNumSemaine(), "Ouvrir la vente"));
    $formResp->ajouterComposantTab();
  }
}

// -->Fermer une vente.
elseif ($_GET['c'] == 5) {
  // enleve le boutton enregistrer
  $autVente = true;
  $_SESSION['ListeSemaine'] = new Semaines(ResponsableDAO::selectVente());
  // parcours la liste des ventes et recupere les 20 dernieres semaines
  foreach ($_SESSION['ListeSemaine']->getLesSemaines() as $OBJ) {
    $formResp->ajouterComposantLigne($formResp->creerA($OBJ->getNumSemaine()));
    $formResp->ajouterComposantLigne($formResp->creerInputSubmit($OBJ->getNumSemaine(), $OBJ->getNumSemaine(), "Fermer la vente"));
    $formResp->ajouterComposantTab();
  }
}
// avoir le boutton enregistrer
if ($autVente == false){
  $formResp->ajouterComposantLigne($formResp->creerInputSubmit("enregistrer", "enregistrer", "Enregistrer"));
  $formResp->ajouterComposantTab();
}

$formResp->creerFormulaire();

require_once "vue/vueResponsable.php";
 ?>
