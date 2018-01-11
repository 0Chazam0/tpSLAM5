<?php
class DBConnex extends PDO{
    
    private static $instance;
    
    public static function getInstance(){
        if ( !self::$instance ){
            self::$instance = new DBConnex();
        }
        return self::$instance;
    }
    
    function __construct(){
        try {
            parent::__construct(Param::$dsn ,Param::$user, Param::$pass);
        } catch (Exception $e) {
            echo $e->getMessage();
            die("Impossible de se connecter. " );
        }
    }
    
}
	

class ProjetsDAO{
	
    public static function lesProjets(){
		$result = array();
		$sql = "select * from projets" ;
		$requetePrepa = DBConnex::getInstance()->prepare($sql);
		$requetePrepa->execute();
		$listeProjets = $requetePrepa->fetchAll(PDO::FETCH_ASSOC);
		return $listeProjets;
		return $result;
	}

	
	public static function unProjet(Projet $unProjet){
	    $unProjet = null;
	    $sql = "select * from projets where idProjet = :idProjet" ;
	    $requetePrepa = DBConnex::getInstance()->prepare($sql);
	    $requetePrepa->bindParam("idProjet", $unProjet->getIdProjet());
	    $requetePrepa->execute();
	    $projet = $requetePrepa->fetch(PDO::FETCH_ASSOC);
	    if(!empty($projet)){
	        $unProjet = new Projet();
	        $unProjet->hydrate($projet);
	    }
	    return $unProjet;
	}
	
	
	
	public static function ajouterProjet(Projet $unProjet){
        $sql = "insert into projets (nomProjet , dureeProjet , dateDebutProjet, dateFinProjet)
			    values (:nomProjet , :dureeProjet , :dateDebutProjet, :dateFinProjet)";
        $requetePrepa = DBConnex::getInstance()->prepare($sql);
        $requetePrepa->bindParam("nomProjet", $unProjet->getNomProjet());
        $requetePrepa->bindParam("dureeProjet", $unProjet->getDureeProjet());
        $requetePrepa->bindParam("dateDebutProjet", $unProjet->getDateDebutProjet());
        $requetePrepa->bindParam("dateFinProjet", $unProjet->getDateFinProjet());
        $requetePrepa->execute();
        return  DBConnex::getInstance()->lastInsertId();
	    
	}

}

