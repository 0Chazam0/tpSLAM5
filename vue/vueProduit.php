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
        echo $_SESSION['leFormPlanier'];
       ?>

    </div>

    <footer>
        <?php include 'bas.php' ;?>
    </footer>
  </div>
