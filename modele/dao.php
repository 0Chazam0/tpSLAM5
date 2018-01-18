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

	public static function modifierClient($unClient, $newNom, $newPrenom){
		$sql = "update client set NOM = '".$newNom."', PRENOM = '".$newPrenom."' WHERE EMAIL = '".$unClient[0]."'";
			try {
				DBConnex::getInstance()->queryFetchFirstRow($sql);
				return true;
			} catch (Exception $e) {
				return false;
			}
	}

	public static function modifierProducteur($unProd, $newNom, $newPrenom, $newAdresse, $newDescriptif){
		$sql = "update producteur set NOM = '".$newNom.
		"', PRENOM = '".$newPrenom.
		"', ADRESSE = '".$newAdresse.
		"', DESCRIPTIF = '".$newDescriptif.
		"' WHERE EMAIL = '".$unProd[0]."'";
		try {
			DBConnex::getInstance()->queryFetchFirstRow($sql);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	public static function ajouterUnClient($unClient){
		$sql="Insert into user(EMAIL, MDP, NOM, PRENOM) VALUES ('";
		$sql .= $unClient->getEmail() . "',NULL,NULL,NULL)";
		DBConnex::getInstance()->queryFetchFirstRow($sql);
		$sql = "Insert into client (EMAIL, MDP, NOM, PRENOM) VALUES ('";
		$sql .= $unClient->getEmail() . "','";
		$sql.= $unClient->getMdp() . "','";
		$sql.= $unClient->getNom() . "','";
		$sql.= $unClient->getPrenom() . "')";
		DBConnex::getInstance()->queryFetchFirstRow($sql);
	}

	public function delUser($table, $IDU)
	{
	  $sql = "DELETE FROM " . $table . " WHERE IDU = '" . $IDU . "';";

	}

	public function changeMDP($unIdUser,$typeUser, $nvMDP){
		if($typeUser == 'C'){
			$table = 'client';
		}
		elseif ($typeUser == 'P') {
			$table = 'producteur';
		}
		elseif ($typeUser == 'R') {
			$table = 'responsable';
		}
		$sql = "UPDATE " . $table . " set MDP = '" . $nvMDP ."' WHERE EMAIL = '" . $unIdUser . "'";
		echo $sql;
		DBConnex::getInstance()->queryFetchFirstRow($sql);
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
        $produit = new Produit($produit['CODE'], $produit['NOM'],$produit['TYPEPRODUIT'],$produit['UNITE'],1);
        $result[] = $produit;
      }
    }
    return $result;
  }
	public static function selectListeProduitAll()
  {
    $result = array();
    $sql = "SELECT * FROM  	produit ;";
    $liste = DBConnex::getInstance()->queryFetchAll($sql);
    if (count($liste) > 0)
    {
      foreach ($liste as $produit)
      {
        $produit = new Produit($produit['CODE'], $produit['NOM'],$produit['TYPEPRODUIT'],$produit['UNITE'],1);
        $result[] = $produit;
      }
    }
    return $result;
  }

	public static function leProduit($code)
	{
		$result = array();
		$sql = "SELECT * FROM  	produit where code='" . $code . "';";
		$liste = DBConnex::getInstance()->queryFetchFirstRow($sql);

		$result = new Produit($liste[0], $liste[1],$liste[2],$liste[3],1);

		return $result;
	}

	public static function estEnVente($produit,$date)
  {
		$end = 2;
    $result = array();
    $sql = "SELECT v.code,v.quantite, s.numsemaine FROM vendre as v, semaine as s where s.numsemaine = v.numsemaine and s.dateDebutAchat<= '$date' and s.dateFinAchat>='$date' and  v.code='" . $produit->getCode() . "';";
    $liste = DBConnex::getInstance()->queryFetchAll($sql);
    if (count($liste) > 0)
    {
      foreach ($liste as $leproduit)
      {
				if($produit->getCode() == $leproduit['code'] ){
					if($leproduit['quantite']>0){
 						$end = 1;
					}
					else{
						$end = 0;
					}
				}
      }
    }
    return $end;
  }

	public static function LePrixProduitCode($produit,$date)
	{
		$result = array();
		$sql = "SELECT v.prix FROM vendre as v, semaine as s where s.numsemaine = v.numsemaine and s.dateDebutAchat<= '$date' and s.dateFinAchat>='$date' and  v.code='" . $produit . "';";
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
	public static function LePrixProduit($produit,$date)
  {
    $result = array();
		$sql = "SELECT v.prix FROM vendre as v, semaine as s where s.numsemaine = v.numsemaine and s.dateDebutAchat<= '$date' and s.dateFinAchat>='$date' and  v.code='" . $produit->getCode() . "';";

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

	public static function LaQteProduit($produit,$date)
	{
		$result = array();
		$sql = "SELECT v.quantite FROM vendre as v, semaine as s where s.numsemaine = v.numsemaine and s.dateDebutAchat<= '$date' and s.dateFinAchat>='$date' and  v.code='" . $produit->getCode() . "';";
		$liste = DBConnex::getInstance()->queryFetchAll($sql);
		if (count($liste) > 0)
		{
			foreach ($liste as $leproduit)
			{
				return $leproduit['quantite'];
			}
		}
		return 0;
	}

	public static function LeNumSemaine($date)
	{
		$sql = "SELECT NUMSEMAINE  FROM semaine  where  dateDebutAchat<= '$date' and dateFinAchat>='$date' ;";
		$numS = DBConnex::getInstance()->queryFetchFirstRow($sql);
		return $numS[0];

	}

	public static function updateQteProduit($produit)
	{
		$qte = ProduitDAO::LaQteProduit($produit,date("Y-m-d"));
		if($qte >0){
			$qte-=1;
		}
		else{
			$qte=0;
		}
	  $sql = "UPDATE vendre SET 	QUANTITE = '" . $qte . "' ";
		$sql .= " WHERE CODE = '" . $produit->getCode() . "' AND NUMSEMAINE= '" . ProduitDAO::LeNumSemaine(date("Y-m-d")) . "';";
		return DBConnex::getInstance()->exec($sql);
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
			$result = null;
		}
		return $result;
	}



	public static function selectListeCommandeEC($emailCli)
	{
		$sql = "SELECT * FROM commande WHERE ETAT='EC' and EMAIL='".$emailCli."'";
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
			$result = null;
		}
		return $result;
	}



	public static function selectListeCommandeV($emailCli)
	{
		$sql = "SELECT * FROM commande WHERE ETAT='V' and EMAIL='".$emailCli."'";
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
			$result = null;
		}
		return $result;
	}



	public static function selectListeCommandeD($emailCli)
	{
		$sql = "SELECT * FROM commande WHERE ETAT='D' and EMAIL='".$emailCli."'" ;
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
			$result = null;
		}
		return $result;
	}

	public static function selectListeCommandeProdVal($emailProd)
	{
		$sql = "SELECT C.EMAIL, C.DATECOMMANDE, C.NUMCOMMANDE,Com.QUANTITE, P.NOM, P.UNITE FROM commande as C, commander as Com, vendre as V, produit as P WHERE P.CODE = V.CODE and P.CODE = Com.CODE and C.NUMCOMMANDE = Com.NUMCOMMANDE and C.ETAT='V' and V.EMAIL='".$emailProd."'";
		echo $sql;
		$liste = DBConnex::getInstance()->queryFetchAll($sql);

		return $liste;
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
	public static function updateValiderEtatCommande($numCommande){
		$sql="UPDATE commande SET ETAT = 'V' WHERE NUMCOMMANDE='".$numCommande."'";
		DBConnex::getInstance()->exec($sql);
	}
	public static function updateDistribuerEtatCommande($numCommande){
		$sql="UPDATE commande SET ETAT = 'D' WHERE NUMCOMMANDE='".$numCommande."' AND ETAT='V'";
		DBConnex::getInstance()->exec($sql);
	}
	public static function deleteCommande($numCommande){
		$sql="DELETE FROM commande WHERE NUMCOMMANDE='".$numCommande."'";
		DBConnex::getInstance()->exec($sql);
	}
}
class ProducteurDAO{
	public static function estEnVenteProducteur($produit,$date,$email)
	{
		$end = 2;
		$result = array();
		$sql = "SELECT v.code,v.quantite, s.numsemaine FROM vendre as v, semaine as s where s.numsemaine = v.numsemaine and s.dateDebutAchat<= '$date' and s.dateFinAchat>='$date' and v.email='".$email."' and v.code='" . $produit->getCode() . "';";
		$liste = DBConnex::getInstance()->queryFetchAll($sql);
		if (count($liste) > 0)
		{
			foreach ($liste as $leproduit)
			{
				if($produit->getCode() == $leproduit['code'] ){
					if($leproduit['quantite']>0){
						$end = 1;
					}
				}
			}
		}
		return $end;
	}

	public static function selectListeProducteur()
	{
		$sql = "SELECT * FROM producteur ";
		$liste = DBConnex::getInstance()->queryFetchAll($sql);
		if (count($liste) > 0)
			{
				foreach ($liste as $prod)
				{
					$unProducteur = new Producteur(	$prod['EMAIL'] ,	$prod['NOM'] ,	$prod['ADRESSE'] , 	$prod['DESCRIPTIF'] ,	$prod['PRENOM'] ,$prod['MDP']);
					$result[] = $unProducteur;
				}
			}
			else{
				$result = null;
			}
			return $result;

	}

	public static function ajouterVente($email,$OBJ,$numS,$qte,$prix){
		$sql = "INSERT INTO VENDRE VALUES('".$email."','".$OBJ->getCode()."','".$numS."','".$prix."','".$qte."')";
		DBConnex::getInstance()->exec($sql);
	}
	public static function modifVente($email,$OBJ,$numS,$prix,$qte){
		$sql="UPDATE VENDRE SET prix='".$prix."',quantite='".$qte."' WHERE numsemaine='".$numS."' AND EMAIL='".$email."' AND CODE='".$OBJ->getCode()."'";
		DBConnex::getInstance()->exec($sql);
	}
	public static function supprimerVente($email,$OBJ,$nums){
		$sql="DELETE FROM VENDRE WHERE EMAIL='".$email."' AND CODE='".$OBJ->getCode()."'  AND NUMSEMAINE='".$nums."'";
		DBConnex::getInstance()->exec($sql);
	}
}

class CommanderDAO{
	public static function produitsCommande($numC)
	{
		$result = array();
		$sql = "SELECT * FROM  	commander where numcommande='" . $numC . "'";
		$liste = DBConnex::getInstance()->queryFetchAll($sql);
		if (count($liste) > 0)
		{
			foreach ($liste as $produit)
			{
				$produit = new Commander($produit['NUMCOMMANDE'], $produit['CODE'],$produit['QUANTITE']);
				$result[] = $produit;
			}
		}
		return $result;
	}
	public static function deleteProdCommande($numCommande){
		$sql="DELETE FROM commander WHERE NUMCOMMANDE='".$numCommande."'";
		DBConnex::getInstance()->exec($sql);
	}
}


/**
 * responsable
 */
class ResponsableDAO
{
	//		afficher les 20 dernieres ouvertures de vente
	public static function		selectVente(){
		$result = array();
		$sql = "SELECT `NUMSEMAINE`, `DATEDEBUTDEPOT`, `DATEDEBUTACHAT`, `DATEFINACHAT` FROM `semaine` WHERE `DATEDEBUTACHAT` > ". date('Y-m-d') ." ORDER BY `DATEDEBUTDEPOT` DESC LIMIT 20";
		$liste = DBConnex::getInstance()->queryFetchAll($sql);
		if (count($liste) > 0)
		{
			foreach ($liste as $vente){

				$uneCommande = new Semaine($vente['NUMSEMAINE'], $vente['DATEDEBUTDEPOT'], $vente['DATEDEBUTACHAT'], $vente['DATEFINACHAT']);
				$result[] = $uneCommande;
			}
		}
		return $result;
	}

	//		afficher les 20 dernieres fermetures de vente
	public static function		selectFinVente(){
		$result = array();
		$sql = "SELECT `NUMSEMAINE`, `DATEDEBUTDEPOT`, `DATEDEBUTACHAT`, `DATEFINACHAT` FROM `semaine` ORDER BY `DATEFINACHAT` DESC LIMIT 20";
		$liste = DBConnex::getInstance()->queryFetchAll($sql);
		if (count($liste) > 0)
		{
			foreach ($liste as $vente){

				$uneCommande = new Semaine($vente['NUMSEMAINE'], $vente['DATEDEBUTDEPOT'], $vente['DATEDEBUTACHAT'], $vente['DATEFINACHAT']);
				$result[] = $uneCommande;
			}
		}
		return $result;
	}


	//		ajouter un nouveau producteur
	public static function		insertNewProducteur($nom, $prenom, $mail, $adresse, $descriptif, $mdp){
		$sql="INSERT INTO producteur(NOM,PRENOM,EMAIL, ADRESSE, DESCRIPTIF, MDP) VALUES ('";
		$sql .= $nom . "','";
		$sql.= $prenom . "','";
		$sql.= $mail . "','";
		$sql.= $adresse . "','";
		$sql.= $descriptif . "','";
		$sql.= $mdp . "')";
		DBConnex::getInstance()->queryFetchFirstRow($sql);
	}

	//		ajouter une nouvelle date
	public static function		insertDate($dateDD, $dateDA, $dateFA){
		$result = array();
		$sql = "SELECT * FROM `semaine` ORDER BY `DATEDEBUTDEPOT` desc limit 1 ";
		$liste = DBConnex::getInstance()->queryFetchAll($sql);
		if (count($liste) > 0)
		{
			foreach ($liste as $produit)
			{
				$result[] = $produit;
			}
		}
		$result = "S". strval(intval(substr($result[0]['NUMSEMAINE'], -3)) + 1);
		$sql="INSERT INTO semaine(NUMSEMAINE,DATEDEBUTDEPOT,DATEDEBUTACHAT, DATEFINACHAT) VALUES ('";
		$sql .= $result . "','";
		$sql.= $dateDD . "','";
		$sql.= $dateDA . "','";
		$sql.= $dateFA . "')";
		DBConnex::getInstance()->queryFetchFirstRow($sql);
	}

	//		ajouter un nouveau type
	public static function		insertTypeProduit($codeType, $nomType){
		$sql="INSERT INTO typeproduit(CODE, LIBELLE) VALUES ('";
		$sql .= $codeType . "','";
		$sql.= $nomType . "')";

		DBConnex::getInstance()->queryFetchFirstRow($sql);
	}

	//		maj vente
	public static function 		updateVente($date, $semaine){
		$sql = "UPDATE semaine set DATEDEBUTACHAT = '" . date('Y-m-d') . "' WHERE NUMSEMAINE = '". $semaine . "'";
		DBConnex::getInstance()->exec($sql);
	}

	//		maj fin vente
	public static function 		updateFinVente($date, $semaine){
		$sql = "UPDATE semaine set DATEFINACHAT = '" . date('Y-m-d') . "' WHERE NUMSEMAINE = '". $semaine . "'";
		DBConnex::getInstance()->exec($sql);
	}

}


 ?>
