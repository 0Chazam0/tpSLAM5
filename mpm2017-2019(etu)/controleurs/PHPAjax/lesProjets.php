<?php
require_once '../../configs/param.php';
require_once '../../modele/dao.php';
require_once '../../fonctions/autoload.php';
require_once '../../modele/traits/hydrate.php';
require_once '../../modele/traits/json.php';

$listeProjets = new Projets(ProjetsDAO::lesProjets());

$tabProjets = json_encode(ProjetsDAO::lesProjets());

print_r($tabProjets);