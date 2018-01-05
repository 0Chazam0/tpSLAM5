<?php
/*----------------------------------------------------------*/
/*--------Déclaration variable session----------------------*/
/*----------------------------------------------------------*/
$_SESSION['dernierePage'] = "Commande";
if (!isset(  $_SESSION['lePanier'])) {
  $_SESSION['lePanier'] = new Produits(array());
}
else{
  $_SESSION['lePanier'] = unserialize(serialize($_SESSION['lePanier']));
}
$formCommande = new Formulaire("POST","index.php","formCommande","commandethis");

/*----------------------------------------------------------*/
/*--------Création du form de confirmation avant de commander-----*/
/*----------------------------------------------------------*/
$formCommande->ajouterComposantLigne($formCommande->creerLabelFor('Votre commande : ', 'lblcommande'));

$formCommande->ajouterComposantTab();

$formCommande->ajouterComposantLigne($formCommande->creerLabelFor('Les Produits : ', 'lesProduits'));
$formCommande->ajouterComposantTab();

// On ajoute les Produits du panier
foreach ($_SESSION['lePanier']->getLesProduits() as $OBJ){
  $formCommande->ajouterComposantLigne($formCommande->concactComposants($formCommande->creerLabelFor(ucfirst($OBJ->getNom()), 'nomProduitCommande'),
                                       $formCommande->concactComposants($formCommande->creerLabelFor("x".$OBJ->getQte(), 'qtProduitCommande'),
                                       $formCommande->creerLabelFor(ProduitDAO::LePrixProduit($OBJ,date("Y-m-d"))*$OBJ->getQte()."€", 'prixProduitCommande'),0),0));
$formCommande->ajouterComposantTab();
}
$formCommande->ajouterComposantLigne($formCommande->concactComposants($formCommande->creerLabelFor('Montant : ', 'lblmontant'),
                                     $formCommande->creerLabelFor($_SESSION['prixTotal']."€", 'leMontant'),0));
$formCommande->ajouterComposantTab();

$formCommande->ajouterComposantLigne($formCommande->creerInputSubmit('confirmCommande','confirmCommande',"Confirmer la commande"));
$formCommande->ajouterComposantTab();
$formCommande->creerFormulaire();
$_SESSION['leformCommande'] = $formCommande->afficherFormulaire();


/*----------------------------------------------------------*/
/*--------Ajout des informations dans la bdd (table commande et quantite) + création d'objet -----*/
/*----------------------------------------------------------*/
// Condition respectée quand on utilise le btn confirmCommande
if (isset($_POST['confirmCommande'])){
  if (isset($_SESSION['EstEnModif'])) {
    CommandeDAO::updateValiderEtatCommande($_SESSION['NumComModif']);
    unset($_SESSION['NumComModif']);
    unset($_SESSION['lePanier']);
    unset($_SESSION['EstEnModif']);
  }
  else{
    CommandeDAO::updateValiderEtatCommande($_SESSION['compteurCommande']);
    unset($_SESSION['compteurCommande']);
    unset($_SESSION['lePanier']);
  }
}
if (isset($_POST['validerModifCommande'])) {
  unset($_SESSION['lePanier']);
}
if (isset($_POST['validerCommande'])) {
  unset($_SESSION['lePanier']);
}
/*--------------------------------------------------------------------------*/
 include 'vue/vueCommande.php' ;

?>
