<?php 
require_once 'modele/traits/hydrate.php';
require_once 'modele/traits/json.php';
require_once 'fonctions/autoload.php';
session_start()?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>mpm 2017-2018</title>
		<style type="text/css">
			@import url(styles/mpm.css);
		</style>
	</head>
	<body>
		<div id='content'>
			<div id='projets'>
				<div id='menuProjets'>
				</div>
				<div id='listeProjets'>
				</div>
			</div>
			<div id='taches'>
			</div>
		</div>
	
		<script src = 'scripts/formulaire.js'></script>
		<script src = 'scripts/projet.js'></script>
		<script src = 'scripts/mpm.js'></script>
		<script src = 'scripts/ajax.js'></script>
	</body>
</html>