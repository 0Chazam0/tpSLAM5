<div class="conteneur">
  <header>
      <?php //include 'haut.php' ;?>
  </header>
    <div id='corpsProduit'>
      <?php
        echo $_SESSION['lesFormsProduit'];
      ?>

    </div>
    <div id="panier">
      <?php
      	if (!isset($_SESSION['typeIdentite']) || $_SESSION['typeIdentite'] == 'C'){
          echo $_SESSION['leFormPlanier'];
        }
       ?>

    </div>

    <footer>
        <?php include 'bas.php' ;?>
    </footer>
  </div>
