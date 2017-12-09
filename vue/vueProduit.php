<div class="conteneur">
  <header>
      <?php include 'haut.php' ;?>
  </header>
    <div id='corpsProduit'>
      <?php
        echo $_SESSION['lesFormsProduit'];
      ?>

    </div>
    <div id="panier">
      <?php
      //affiche le panier si il n'y a pas d'utilisateur connecté ou que l'utilisateur n'est pas un restaurateur
      //if (!isset($_SESSION['typeIdentite']) || $_SESSION['typeIdentite'] != 'R'){
        echo $_SESSION['leFormPlanier'];
      //}
       ?>

    </div>

    <footer>
        <?php include 'bas.php' ;?>
    </footer>
  </div>
