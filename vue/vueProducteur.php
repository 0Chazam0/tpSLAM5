<div class="conteneur">
  <header>
      <?php include 'haut.php' ;?>
  </header>

    <div id='corpsProd'>
      <div class='gaucheRP'>
  			<nav class="sidenavRP">
  				<h3 class="titreListe">Les produits de <?php  echo ucfirst($_SESSION['identite'][2]);?></h3>
  				<ul>
  					<?php
              echo $menuDetailProducteur;
  					 ?>
  				</ul>
  			</nav>
  		</div>
    </div>
    <div class='droiteRP'>
      <?php
        echo $_SESSION['lesFormsProduit'];
      ?>
    </div>
    <footer>
        <?php include 'bas.php' ;?>
    </footer>
</div>
