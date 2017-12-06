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
	public static function unUserC($unIdUser){
		$sql = "select DISTINCT * from client where MAIL = '".$unIdUser."'";
		$user = DBConnex::getInstance()->queryFetchFirstRow($sql);
		return $user;
	}
  public static function unUserA($unIdUser){
    $sql = "select DISTINCT * from administrateur where MAIL = '".$unIdUser."'";
    $user = DBConnex::getInstance()->queryFetchFirstRow($sql);
    return $user;
  }
  public static function unUserM($unIdUser){
    $sql = "select DISTINCT * from moderateur where MAIL = '".$unIdUser."'";
    $user = DBConnex::getInstance()->queryFetchFirstRow($sql);
    return $user;
  }
  public static function unUserR($unIdUser){
    $sql = "select DISTINCT * from restaurateur where MAIL = '".$unIdUser."'";
    $user = DBConnex::getInstance()->queryFetchFirstRow($sql);
    return $user;
  }
	public static function definirIDU(){
		$sql = "select count(IDU) from client";
		$resu = DBConnex::getInstance()->queryFetchFirstRow($sql);
		return $resu;
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

}
 ?>
