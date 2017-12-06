<div class="conteneur">
  <header>
      <?php include 'haut.php' ;?>
  </header>
    <div id='corpsProduit'>
        <?php
      echo $_SESSION['lesFormsProduit'];
      ?>
    </div>
    <footer>
        <?php include 'bas.php' ;?>
    </footer>
  </div>
