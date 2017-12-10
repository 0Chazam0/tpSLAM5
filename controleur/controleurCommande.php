<?php
/*----------------------------------------------------------*/
/*--------Déclaration variable session----------------------*/
/*----------------------------------------------------------*/
$_SESSION['dernierePage'] = "Commande";

foreach ($_SESSION['lesProduits'] as $OBJ) {
  $lesProduits[] = unserialize($OBJ);
}
$_SESSION['lePanier'] = new Produits($lesProduits);
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
  $formCommande->ajouterComposantLigne($formCommande->concactComposants($formCommande->creerLabelFor($OBJ->getNom(), 'nomProduitCommande'),
                                       $formCommande->concactComposants($formCommande->creerLabelFor('x1 : ', 'qtProduitCommande'),
                                       $formCommande->creerLabelFor(ProduitDAO::LePrixProduit($OBJ,date("Y-m-d"))."€", 'prixProduitCommande'),0),0));
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
if (isset($_POST['confirmCommande'])) {

  $txt = "<div id='fin'>Nous vous remercions de votre commande <br><br> Merci à bientôt </div>";
  $pdf = new Formulaire('post','index.php','pdf','pdf');
  $pdf->ajouterComposantLigne($pdf->creerInputSubmit('pdf','pdf','Afficher le pdf'));
  $pdf->ajouterComposantLigne($pdf->creerInputSubmitHidden('confirmCommande','confirmCommande',''));
  $pdf->ajouterComposantTab();
  $lepdf = $pdf->creerFormulaireNewOnglet();
  $lepdf = $pdf->afficherFormulaire();
  $numeroCommande = 1;
  $_SESSION['listeCommande'] = new Commandes(CommandeDAO::selectListeCommande());
  // recuperer le num de la prochaine commande
  foreach ($_SESSION['listeCommande']->getLesCommandes() as $OBJ)
  {
    $idC = substr($OBJ->getNumCommande(), 1) ;
    if ($numeroCommande < $idC) {
      $numeroCommande = substr($OBJ->getNumCommande(), 1);
    }
  }

  $_SESSION['compteurCommande']= "C".($numeroCommande+1);
  CommandeDAO::ajouterUneCommande($_SESSION['compteurCommande'], $_SESSION['identite'][0],date("Y-m-d"),"V");
  foreach ($_SESSION['lePanier']->getLesProduits() as $OBJ)
	{
    CommandeDAO::ajouterProduitCommande($OBJ->getCode(),$_SESSION['compteurCommande'],1);
  }
}


/*--------------------------------------------------------------------------*/
 include 'vue/vueCommande.php' ;

?>
