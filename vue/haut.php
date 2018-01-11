<nav class="menuPrincipal">
	<?php
	$formLogo = new Formulaire("post","index.php?menuPrincipal=Accueil","formLogo","formLogo");
	$formLogo->ajouterComposantLigne($formLogo->creerInputLogo("logo","logo","image\logo3.png"));
	$formLogo->ajouterComposantTab();
	$formLogo->creerFormulaire();

	echo $leMenuP;
	echo $formLogo->afficherFormulaire();




	?>

</nav>
<nav class="menuTypeProduit">
	<?php
	if ((!isset($_SESSION['typeIdentite']) || $_SESSION['typeIdentite'] == 'C') && (!isset($_GET['menuPrincipal']) || $_GET['menuPrincipal'] != "Responsable")){
		echo $theMenuType;
	}
	elseif (isset($_GET['menuPrincipal']) && $_GET['menuPrincipal'] == "Responsable") {
		echo '<div class="choixResponsable">';
		echo $theMenuTypeResp;
		echo '</div>';
	}
	?>
</nav>
