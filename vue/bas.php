<div class="bas">

  <nav class="menuFooter">
  	<?php
    $_SESSION['ListeProducteur'] = new Producteurs(ProducteurDAO::selectListeProducteur());

    $formFooter = new Formulaire("post","index.php?menuPrincipal=Accueil","formFooter","formFooter");
  

    foreach ($_SESSION['ListeProducteur']->getLesProducteurs() as $OBJ)
    {
      $tableauProducteur[] = $OBJ->getNom();
    }

    if (!isset($_SESSION['typeIdentite']) || $_SESSION['typeIdentite'] == 'C' ){
      $formFooter->ajouterComposantLigne($formFooter->concactComposantsProducteur($formFooter->creerLienP($formFooter->creerLabelFor("Nos Producteurs ","lbltitreFooter")),$tableauProducteur));
    }
    else{
        $formFooter->ajouterComposantLigne($formFooter->concactComposantsProducteur($formFooter->creerLabelFor("Nos Producteurs ","lbltitreFooter"),$tableauProducteur));
    }
    $formFooter->ajouterComposantLigne($formFooter->concactComposants($formFooter->creerLabelFor("Nous Contacter ","lbltitreFooter"),
                                        $formFooter->concactComposants($formFooter->creerLabelFor("- BEUQUILA Jérémy ","liste"),
                                        $formFooter->concactComposants($formFooter->creerLabelFor("- BELONDRADE Samuel ","liste"),
                                        $formFooter->concactComposants($formFooter->creerLabelFor("- DA ROS Romain ","liste"),
                                        $formFooter->concactComposants($formFooter->creerLabelFor("Lycée Gustave Eiffel ","liste"),
                                        $formFooter->concactComposants($formFooter->creerLabelFor("BTS SIO SLAM","liste"),
                                        $formFooter->creerLabelFor("06 05 04 03 02",'liste'),1),1),1),1),1),2));
    $formFooter->ajouterComposantLigne($formFooter->concactComposants($formFooter->creerLabelFor("Partager","lbltitreFooter"),
                                       $formFooter->concactComposants($formFooter->creerInputImage2('imgFooter1', 'imgFooter1',"image/fb.jpg"),
                                       $formFooter->concactComposants($formFooter->creerInputImage2('imgFooter2', 'imgFooter2', "image\insta.jpg"),
                                       $formFooter->concactComposants($formFooter->creerInputImage2('imgFooter1', 'imgFooter1', "image\snap.jpg"),
                                       $formFooter->creerInputImage2('imgFooter2', 'imgFooter2', "image/twitter.jpg"),0),1),0),2));
    $formFooter->ajouterComposantTab();
    $formFooter->creerFormulaire();
  	echo $formFooter->afficherFormulaire();
  	?>
  </nav>

<p id="copy">Copyright © 2017 Bio Relai</p>

</div>
