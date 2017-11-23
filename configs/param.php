<?php
// Constantes


// Bases de données
define("vote", "", true);
//Définition des variables de connexion
class Param {
	public static $user = 'biobio';
	public static $pass = 'bio';


	public static $dsn = 'mysql:host=127.0.0.1;dbname=BiorelaisBDD;charset=utf8';
	private static $sql = NULL;
	public static function getInstance() {
			if (!self::$sql) {
					self::$sql = new PDO('mysql:host=127.0.0.1;dbname=BiorelaisBDD;charset=utf8', 'biobio', 'bio');
					self::$sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			return self::$sql;
	}

}
?>
