<?php
$_SESSION['dernierePage'] = "Producteur";
$_SESSION['listeTypeProduitProducteurs'] = new TypeProduits(TypeProduitDAO::selectListeTypeProduitProducteur());
/*----------------------------------------------------------*/
/*--------Affichage  des restaurants selon leur type-----*/
/*----------------------------------------------------------*/
if(isset($_GET['TypeProduitProducteur'])){
	$_SESSION['TypeProduitProducteur']= $_GET['TypeProduitProducteur'];
}
else
{
	if(!isset($_SESSION['TypeProduitProducteur'])){
		$_SESSION['TypeProduitProducteur']="All";
	}
}

/*----------------------------------------------------------*/
/*--------Affichage type resto-----*/
/*----------------------------------------------------------*/
$menuTypeProduitProducteur = new menu("menuTypeProduitProducteur");

$menuTypeProduitProducteur->ajouterComposant($menuTypeProduitProducteur->creerItemLien("All" ,"Tous les types"));
foreach ($_SESSION['listeTypeProduitProducteurs']->getLesTypeProduitProducteurs() as $uneTypeProduitProducteur){
	$menuTypeProduitProducteur->ajouterComposant($menuTypeProduitProducteur->creerItemLien($uneTypeProduitProducteur->getCodeT() ,$uneTypeProduitProducteur->getLibelle()));
}
$lemenuTypeProduitProducteurs = $menuTypeProduitProducteur->creerMenuType('TypeProduitProducteur',$_SESSION['TypeProduitProducteur']);


/*----------------------------------------------------------*/
/*--------creation des forms des restaurants du restaurateur choisit pour tous les types-----*/
/*----------------------------------------------------------*/
if ($_SESSION['TypeProduitProducteur']=="All"){
  foreach ($_SESSION['listeRestos']->getLesRestos() as $OBJ)
  {
    foreach ($_SESSION['listeRestosRestaurateur'] as $OBJ2)
    {
    if ($OBJ->getId() == $OBJ2['IDR']){
			$compteurResto +=1;
      $correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $OBJ->getNom());
      $correct = strtolower($correct);
      $correct = 'image/'.$correct;

      $formResto = new Formulaire("POST","index.php","formResto","restothis");
      $formResto->ajouterComposantLigne($formResto->creerInputImage('imgResto', 'imgResto', $correct));
			$formResto->ajouterComposantTab();
      $formResto->ajouterComposantLigne($formResto->concactComposants($formResto->creerLabelFor($OBJ->getNom(),"nomResto"),$formResto->creerLabelFor($OBJ->getNumAdr()." ".$OBJ->getRueAdr() ." ". $OBJ->getCP(),'adrResto'),2));
      $formResto->ajouterComposantLigne($formResto->creerInputSubmitHidden("idRestoRestaurateur","idRestoRestaurateur",$OBJ->getId()));
      $formResto->ajouterComposantTab();
      $formResto->creerFormulaire();
      $_SESSION['lesFormsResto'] .= $formResto->afficherFormulaire();
    }
  }
}
}
/*----------------------------------------------------------*/
/*--------creation des forms des restaurants du restaurateur choisit pour le type choisit-----*/
/*----------------------------------------------------------*/
else {
	foreach ($_SESSION['listeRestos']->getLesRestos() as $OBJ)
	{
    foreach ($_SESSION['listeRestosRestaurateur'] as $OBJ2)
    {
    if ($OBJ->getId() == $OBJ2['IDR']){
			if ($OBJ->getCodeT()==$_SESSION['TypeProduitProducteur']){
				$compteurResto +=1;
				$correct = preg_replace('#[\\/\'" éàâäêçèë]#', "", $OBJ->getNom());
				$correct = strtolower($correct);
				$correct = 'image/'.$correct;

				$formResto = new Formulaire("POST","index.php","formResto","restothis");
				$formResto->ajouterComposantLigne($formResto->creerInputImage('imgResto', 'imgResto', $correct));
				$formResto->ajouterComposantLigne($formResto->concactComposants($formResto->creerLabelFor($OBJ->getNom(),"nomResto"),$formResto->creerLabelFor($OBJ->getNumAdr()." ".$OBJ->getRueAdr() ." ". $OBJ->getCP(),'adrResto'),2));
				$formResto->ajouterComposantLigne($formResto->creerInputSubmitHidden("idRestoRestaurateur","idRestoRestaurateur",$OBJ->getId()  ));
				$formResto->ajouterComposantTab();
				$formResto->creerFormulaire();
				$_SESSION['lesFormsResto'] .= $formResto->afficherFormulaire();
			}
		}
	}
}
}




include "vue/vueProducteur.php";
 ?>
