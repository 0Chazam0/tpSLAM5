<?php
function __autoload($class) {
	$fichier = '../../modele/dto/' . lcfirst($class) . '.php';
	if(is_file($fichier) && is_readable($fichier)){
		require_once $fichier;
	}
}
