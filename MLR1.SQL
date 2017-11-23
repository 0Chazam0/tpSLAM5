DROP DATABASE IF EXISTS BiorelaisBDD;

CREATE DATABASE IF NOT EXISTS BiorelaisBDD;
USE BiorelaisBDD;
# -----------------------------------------------------------------------------
#       TABLE : USER
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS USER
 (
   EMAIL CHAR(25) NOT NULL  ,
   NOM CHAR(15) NULL  ,
   PRENOM CHAR(15) NULL  ,
   MDP CHAR(24) NULL  
   , PRIMARY KEY (EMAIL) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : COMMANDE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS COMMANDE
 (
   NUMCOMMANDE CHAR(32) NOT NULL  ,
   EMAIL CHAR(25) NOT NULL  ,
   DATECOMMANDE DATE NULL  ,
   ETAT CHAR(32) NULL  
   , PRIMARY KEY (NUMCOMMANDE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE COMMANDE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_COMMANDE_CLIENT
     ON COMMANDE (EMAIL ASC);

# -----------------------------------------------------------------------------
#       TABLE : PRODUCTEUR
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS PRODUCTEUR
 (
   EMAIL CHAR(25) NOT NULL  ,
   NOM CHAR(32) NOT NULL  ,
   ADRESSE CHAR(32) NULL  ,
   DESCRIPTIF CHAR(32) NULL  ,
   PRENOM TEXT NULL  ,
   MDP TEXT NULL  
   , PRIMARY KEY (EMAIL) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE PRODUCTEUR
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_PRODUCTEUR_VILLE
     ON PRODUCTEUR (NOM ASC);

# -----------------------------------------------------------------------------
#       TABLE : RESPONSABLE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS RESPONSABLE
 (
   EMAIL CHAR(25) NOT NULL  ,
   NOM TEXT NULL  ,
   PRENOM TEXT NULL  ,
   MDP TEXT NULL  
   , PRIMARY KEY (EMAIL) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : VILLE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS VILLE
 (
   NOM CHAR(32) NOT NULL  ,
   CODEPOSTAL CHAR(5) NULL  
   , PRIMARY KEY (NOM) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : CLIENT
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS CLIENT
 (
   EMAIL CHAR(25) NOT NULL  ,
   NOM TEXT NULL  ,
   PRENOM TEXT NULL  ,
   MDP TEXT NULL  
   , PRIMARY KEY (EMAIL) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : PRODUIT
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS PRODUIT
 (
   CODE CHAR(32) NOT NULL  ,
   EMAIL CHAR(25) NOT NULL  ,
   NOM CHAR(32) NULL  ,
   DESCRIPTIF CHAR(32) NULL  
   , PRIMARY KEY (CODE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE PRODUIT
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_PRODUIT_PRODUCTEUR
     ON PRODUIT (EMAIL ASC);

# -----------------------------------------------------------------------------
#       TABLE : SEMAINE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SEMAINE
 (
   NUMSEMAINE CHAR(32) NOT NULL  ,
   DATED DATE NULL  ,
   DATEF DATE NULL  
   , PRIMARY KEY (NUMSEMAINE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : COMMANDER
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS COMMANDER
 (
   CODE CHAR(32) NOT NULL  ,
   NUMCOMMANDE CHAR(32) NOT NULL  ,
   QUANTITE CHAR(32) NULL  
   , PRIMARY KEY (CODE,NUMCOMMANDE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE COMMANDER
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_COMMANDER_PRODUIT
     ON COMMANDER (CODE ASC);

CREATE  INDEX I_FK_COMMANDER_COMMANDE
     ON COMMANDER (NUMCOMMANDE ASC);

# -----------------------------------------------------------------------------
#       TABLE : VENDRE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS VENDRE
 (
   CODE CHAR(32) NOT NULL  ,
   NUMSEMAINE CHAR(32) NOT NULL  ,
   PRIX CHAR(32) NULL  ,
   QUANTITE CHAR(32) NULL  
   , PRIMARY KEY (CODE,NUMSEMAINE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE VENDRE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_VENDRE_PRODUIT
     ON VENDRE (CODE ASC);

CREATE  INDEX I_FK_VENDRE_SEMAINE
     ON VENDRE (NUMSEMAINE ASC);
	 
# -----------------------------------------------------------------------------
#       TABLE : TYPEPRODUIT
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS TYPEPRODUIT
 (
   CODE CHAR(32) NOT NULL  ,
   LIBELLE CHAR(32) NULL
   , PRIMARY KEY (CODE) 
 ) 
 comment = "";
# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE TYPEPRODUIT
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_TYPE_PRODUIT
     ON TYPEPRODUIT (CODE ASC);


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------

ALTER TABLE TYPEPRODUIT 
  ADD FOREIGN KEY FK_TYPEPRODUIT_PRODUIT (CODE)
      REFERENCES PRODUIT (CODE) ;

ALTER TABLE COMMANDE 
  ADD FOREIGN KEY FK_COMMANDE_CLIENT (EMAIL)
      REFERENCES CLIENT (EMAIL) ;


ALTER TABLE PRODUCTEUR 
  ADD FOREIGN KEY FK_PRODUCTEUR_VILLE (NOM)
      REFERENCES VILLE (NOM) ;


ALTER TABLE PRODUCTEUR 
  ADD FOREIGN KEY FK_PRODUCTEUR_USER (EMAIL)
      REFERENCES USER (EMAIL) ;


ALTER TABLE RESPONSABLE 
  ADD FOREIGN KEY FK_RESPONSABLE_USER (EMAIL)
      REFERENCES USER (EMAIL) ;


ALTER TABLE CLIENT 
  ADD FOREIGN KEY FK_CLIENT_USER (EMAIL)
      REFERENCES USER (EMAIL) ;

	  
ALTER TABLE PRODUIT 
  ADD FOREIGN KEY FK_PRODUIT_PRODUCTEUR (EMAIL)
      REFERENCES PRODUCTEUR (EMAIL) ;


ALTER TABLE COMMANDER 
  ADD FOREIGN KEY FK_COMMANDER_PRODUIT (CODE)
      REFERENCES PRODUIT (CODE) ;


ALTER TABLE COMMANDER 
  ADD FOREIGN KEY FK_COMMANDER_COMMANDE (NUMCOMMANDE)
      REFERENCES COMMANDE (NUMCOMMANDE) ;


ALTER TABLE VENDRE 
  ADD FOREIGN KEY FK_VENDRE_PRODUIT (CODE)
      REFERENCES PRODUIT (CODE) ;


ALTER TABLE VENDRE 
  ADD FOREIGN KEY FK_VENDRE_SEMAINE (NUMSEMAINE)
      REFERENCES SEMAINE (NUMSEMAINE) ;
	  
INSERT INTO `biorelaisbdd`.`user` (`EMAIL`, `NOM`, `PRENOM`, `MDP`) VALUES ('beuquila.jeremy@gmail.com', '', '', ''), 
('romain.daros@gmail.com', '', '', ''),
('samuel.belondrade@gmail.com', '', '', '');
	  
INSERT INTO `biorelaisbdd`.`client` (`EMAIL`, `NOM`, `PRENOM`, `MDP`) VALUES ('beuquila.jeremy@gmail.com', 'beuquila', 'jeremy', 'beuquila'), 
('romain.daros@gmail.com', 'Da ros', 'Romain', 'daros'),
('samuel.belondrade@gmail.com', 'belondrade', 'Samuel', 'belondrade');


	  
CREATE USER 'biobio'@'%' IDENTIFIED BY 'bio';GRANT SELECT, INSERT, UPDATE, DELETE ON *.* TO 'biobio'@'%' IDENTIFIED BY 'bio' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;GRANT ALL PRIVILEGES ON `BiorelaisBDD`.* TO 'biobio'@'%';

