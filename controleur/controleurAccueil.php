<?php
/*----------------------------------------------------------*/
/*--------Déclaration variable session----------------------*/
/*----------------------------------------------------------*/
$_SESSION['dernierePage'] = "Accueil";

//Affichage du menu accueil (décoration)
$menuAccueil = new menu("menuAccueil");
$menuAccueil->ajouterComposant($menuAccueil->creerItemLien('liv','Livraison à un point relais'));
$menuAccueil->ajouterComposant($menuAccueil->creerItemLien('promo','Des promotions à gagner'));
$menuAccueil->ajouterComposant($menuAccueil->creerItemLien('prod','Des produits de qualité'));
$leMenu = $menuAccueil->creerMenuSwag("menuAccueil");





include "vue/vueAccueil.php";
 ?>
