<div class="conteneur">
  <header>
      <?php include 'haut.php' ;?>
  </header>

    <div id='corpsProd'>
      <div class='gauche'>
  			<nav class="sidenav">
  				<h3 class="titreListe">Les produits de <?php  echo ucfirst($_SESSION['identite'][1]);?></h3>
  				<ul>
  					<?php
              echo $menuDetailProducteur;
  					 ?>
  				</ul>
  			</nav>
  		</div>
  		<div class='droite'>
        <?php
  			//echo $_SESSION['lesFormsResto'];
      	?>
      </div>
    </div>
    <footer>
        <?php include 'bas.php' ;?>
    </footer>
</div>
