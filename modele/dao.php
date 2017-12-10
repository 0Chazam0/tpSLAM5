<?php
/*----------------------------------------------------------*/
/*--------Class DAO pour la connexion MySql----------*/
/*----------------------------------------------------------*/
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

  public function queryFetchAll($sql){
		$sth  = $this -> query($sql);

		if ( $sth ){
			return $sth -> fetchAll(PDO::FETCH_ASSOC);
		}

		return false;
	}

	public function queryFetchFirstRow($sql){
		$sth    = $this -> query($sql);
		$result    = array();

		if ( $sth ){
			$result  = $sth -> fetch();
		}

		return $result;
	}
}

/*----------------------------------------------------------*/
/*--------Class DAO pour la connexion sur le site(utilisateur)----------*/
/*----------------------------------------------------------*/

class UserDAO{
	public static function unUserC($unEmailUser){
		$sql = "select EMAIL, MDP, NOM, PRENOM from client where EMAIL = '".$unEmailUser."'";
		$user = DBConnex::getInstance()->queryFetchFirstRow($sql);
		return $user;
	}
  public static function unUserP($unEmailUser){
    $sql = "select EMAIL, MDP, NOM, PRENOM, ADRESSE, DESCRIPTIF from producteur where EMAIL = '".$unEmailUser."'";
    $user = DBConnex::getInstance()->queryFetchFirstRow($sql);
    return $user;
  }
  public static function unUserR($unEmailUser){
    $sql = "select EMAIL, MDP, NOM, PRENOM from responsable where EMAIL = '".$unEmailUser."'";
    $user = DBConnex::getInstance()->queryFetchFirstRow($sql);
    return $user;
  }

	public static function ajouterUnClient($unClient){
		$sql="Insert into user(IDU,NOMU,PRENOMU,MAIL,MDP,ADRESSEU) VALUES ('";
		$sql .= $unClient->getId() . "',NULL,NULL,NULL,NULL,NULL)";
		DBConnex::getInstance()->queryFetchFirstRow($sql);
		$sql = "Insert into client (IDU,NOMU,PRENOMU,MAIL,MDP,ADRESSEU) VALUES ('";
		$sql .= $unClient->getId() . "','";
		$sql.= $unClient->getNom() . "','";
		$sql.= $unClient->getPrenom() . "','";
		$sql.= $unClient->getMail() . "','";
		$sql.= $unClient->getMdp() . "','";
		$sql.= $unClient->getAdresse() . "')";
		DBConnex::getInstance()->queryFetchFirstRow($sql);
	}
	public function delUser($table, $IDU)
	{
	  $sql = "DELETE FROM " . $table . " WHERE IDU = '" . $IDU . "';";

	}
}
class TypeProduitDAO{

	public static function selectListeTypeProduit()
  {
    $result = array();
    $sql = "SELECT * FROM  	typeproduit;";
    $liste = DBConnex::getInstance()->queryFetchAll($sql);
    if (count($liste) > 0)
    {
      foreach ($liste as $typeproduit)
      {
        $typeproduit = new TypeProduit($typeproduit['CODE'], $typeproduit['LIBELLE']);
        $result[] = $typeproduit;
      }
    }
    return $result;
  }

}
class ProduitDAO{

	public static function selectListeProduit($typeProduit)
  {
    $result = array();
    $sql = "SELECT * FROM  	produit where typeproduit='" . $typeProduit . "';";
    $liste = DBConnex::getInstance()->queryFetchAll($sql);
    if (count($liste) > 0)
    {
      foreach ($liste as $produit)
      {
        $produit = new Produit($produit['CODE'], $produit['NOM'],$produit['TYPEPRODUIT']);
        $result[] = $produit;
      }
    }
    return $result;
  }

	public static function estEnVente($produit,$date)
  {
		$end = false;
    $result = array();
    $sql = "SELECT v.code, s.numsemaine FROM vendre as v, semaine as s where s.numsemaine = v.numsemaine and s.dated<= '$date' and s.datef>='$date' and  v.code='" . $produit->getCode() . "';";
    $liste = DBConnex::getInstance()->queryFetchAll($sql);
    if (count($liste) > 0)
    {
      foreach ($liste as $leproduit)
      {
				if($produit->getCode() == $leproduit['code'] ){
					$end = true;
				}
      }
    }

    return $end;

  }
	public static function LePrixProduit($produit,$date)
  {
    $result = array();
		$sql = "SELECT v.prix FROM vendre as v, semaine as s where s.numsemaine = v.numsemaine and s.dated<= '$date' and s.datef>='$date' and  v.code='" . $produit->getCode() . "';";
    $liste = DBConnex::getInstance()->queryFetchAll($sql);
		if (count($liste) > 0)
		{
			foreach ($liste as $leproduit)
			{
				return $leproduit['prix'];
			}
		}
		return null;
	}


}

class CommandeDAO{
	public static function selectListeCommande()
	{
		$sql = "SELECT * FROM commande ";
		$liste = DBConnex::getInstance()->queryFetchAll($sql);
		if (count($liste) > 0)
		{
			foreach ($liste as $com)
			{
				$uneCommande = new Commande($com['NUMCOMMANDE'], $com['EMAIL'], $com['DATECOMMANDE'], $com['ETAT']);
				$result[] = $uneCommande;
			}
		}
		else{
			$result = 0;
		}
		return $result;
	}
	public static function ajouterUneCommande($numCommande,$email,$dateCommande,$etat){
		$sql="INSERT INTO commande(NUMCOMMANDE,EMAIL,DATECOMMANDE,ETAT) VALUES ('";
		$sql .= $numCommande . "','";
		$sql.= $email . "','";
		$sql.= $dateCommande . "','";
		$sql.= $etat . "')";
		DBConnex::getInstance()->queryFetchFirstRow($sql);
	}
	public static function ajouterProduitCommande($numCommander,$code,$qte){
		$sql="INSERT INTO commander(CODE,NUMCOMMANDE,QUANTITE) VALUES ('";
		$sql .= $code . "','";
		$sql.= $numCommander . "','";
		$sql.= $qte . "')";
		DBConnex::getInstance()->queryFetchFirstRow($sql);
	}
}
 ?>
