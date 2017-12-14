<div class="conteneur">
  <header>
      <?php include 'haut.php' ;?>
  </header>

    <div id='commande'>
      <?php
      //affiche quand la commande est validée
      if (isset($_POST['confirmCommande'])) {
        $txt = "<div id='fin'>Nous vous remercions de votre commande <br><br> Merci à bientôt </div>";
        $pdf = new Formulaire('post','library/Facture/chargementPDF.php','pdf','pdf');
        $pdf->ajouterComposantLigne($pdf->creerInputSubmit('pdf','pdf','Afficher le pdf'));
        $pdf->ajouterComposantLigne($pdf->creerInputSubmitHidden('confirmCommande','confirmCommande',''));
        $pdf->ajouterComposantTab();
        $lepdf = $pdf->creerFormulaireNewOnglet();
        $lepdf = $pdf->afficherFormulaire();
        echo $txt;
        echo $lepdf;
      }
      ///affiche le form pour valider la commande
      else{
        echo $_SESSION['leformCommande'];
      }

      ?>
    </div>
    <footer>
        <?php include 'bas.php' ;?>
    </footer>
</div>
