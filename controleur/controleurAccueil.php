<?php
$_SESSION['dernierePage'] = "Accueil";



$menuAccueil = new menu("menuAccueil");
$menuAccueil->ajouterComposant($menuAccueil->creerItemLien('','Livraison à un point relais'));
$menuAccueil->ajouterComposant($menuAccueil->creerItemLien('','Des promotions à gagner'));
$menuAccueil->ajouterComposant($menuAccueil->creerItemLien('','Des produits de qualité'));
$leMenu = $menuAccueil->creerMenu("menuAccueil");





include "vue/vueAccueil.php";
 ?>
