<div class="conteneur">

<header>
  <?php include 'haut.php' ;?>
</header>
<body>
  <div id='corpsResponsable'>
  <?php
    echo $menu;
    echo $formResp->afficherFormulaire();
   ?>
 </div>
</body>

<footer>
    <?php include 'bas.php' ;?>
</footer>

</div>
