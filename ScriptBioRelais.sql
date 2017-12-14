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
   DESCRIPTIF CHAR(54) NULL  ,
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
   NOM CHAR(32) NULL  ,
   TYPEPRODUIT CHAR(32) NOT NULL
   , PRIMARY KEY (CODE)
 )
 comment = "";

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
('samuel.belondrade@gmail.com', '', '', ''),
('pro1@bio.fr', NULL, NULL, NULL),
('Admin@modo.com', NULL, NULL, NULL);

INSERT INTO `biorelaisbdd`.`client` (`EMAIL`, `NOM`, `PRENOM`, `MDP`) VALUES
('beuquila.jeremy@gmail.com', 'beuquila', 'jeremy', 'beuquila'),
('romain.da-ros@laposte.net', 'daros', 'Romain', 'daros'),
('samuel.belondrade@gmail.com', 'belondrade', 'Samuel', 'belondrade');

INSERT INTO `biorelaisbdd`.`producteur` (`EMAIL`, `NOM`, `ADRESSE`,`DESCRIPTIF`, `PRENOM`, `MDP`) VALUES
('pro1@bio.fr', 'Producteur', '5 lieu dit des abricots','Ferme','Bob', 'boby');

INSERT INTO `biorelaisbdd`.`responsable` (`EMAIL`, `NOM`, `PRENOM`, `MDP`) VALUES
('Admin@modo.com', 'modo', 'admin', 'admin');


INSERT INTO `ville` (`NOM`, `CODEPOSTAL`) VALUES
('Bordeaux','33000'),
('Talence','33000'),
('Pessac','33000'),
('Lormont','33000'),
('Cenon','33000'),
('Merignac','33000');

INSERT INTO `typeproduit` (`CODE`, `LIBELLE`) VALUES
('LEG', 'légumes'),
('FRT', 'fruits'),
('POI', 'poisson'),
('VAD', 'viande'),
('BOU', 'boulangerie'),
('PAT', 'pâtisserie');

INSERT INTO `produit` (`CODE`, `NOM`, `TYPEPRODUIT`) VALUES
('TOM', 'tomate', 'LEG'),
('COURG', 'courgette', 'LEG'),
('CAR', 'carotte', 'LEG'),
('ABR', 'abricot', 'FRT'),
('POM', 'pomme', 'FRT'),
('FRI', 'fraise', 'FRT'),
('COK', 'Cookies', 'PAT'),
('BRN', 'Brownie', 'PAT'),
('AGN', 'Agneau', 'VAD'),
('ANA', 'Ananas', 'FRT'),
('BGT', 'Baguette', 'BOU'),
('BAR', 'Bar', 'POI'),
('BOE', 'Boeuf', 'VAD'),
('BRO', 'Brocoli', 'LEG'),
('CAB', 'Cabillaud', 'POI'),
('CAS', 'Cassis', 'FRT'),
('CEL', 'Celeri', 'LEG'),
('CER', 'Cerise', 'FRT'),
('CHO', 'Chocolatine', 'PAT'),
('CHF', 'Choux fleur', 'LEG'),
('CIT', 'Citrouille', 'LEG'),
('CRA', 'Crabe', 'POI'),
('CRE', 'Crepes', 'PAT'),
('CRV', 'Crevette', 'POI'),
('CRO', 'Croissant', 'PAT'),
('DBG', 'Demi baguette', 'BOU'),
('FRA', 'Framboise', 'FRT'),
('HAR', 'Haricot', 'LEG'),
('LIT', 'Litchi', 'FRT'),
('MAI', 'Mais', 'LEG'),
('MER', 'Merlu', 'POI'),
('OIG', 'Oignon', 'LEG'),
('PAR', 'Pain aux raisins', 'PAT'),
('PAC', 'Pain aux cereales', 'BOU'),
('PBL', 'Pain blanc', 'BOU'),
('PBR', 'Pain brioche', 'BOU'),
('PRD', 'Pain rond', 'BOU'),
('PEC', 'Peche', 'FRT'),
('POI', 'Poire', 'FRT'),
('PDT', 'Pomme de terre', 'LEG'),
('POU', 'Poulet', 'VAD'),
('PRN', 'prune', 'FRT'),
('RAD', 'radi', 'LEG'),
('RAI', 'raie', 'POI'),
('RDP', 'Roti de porc', 'VAD'),
('SAU', 'Saucisse', 'VAD'),
('SAUC', 'Saucisson', 'VAD'),
('THO', 'thon', 'POI'),
('TRU', 'truite', 'POI');

INSERT INTO `vendre` (`CODE`, `NUMSEMAINE`, `PRIX`,`QUANTITE`) VALUES
('MER', 'S1', '5.6','18'),
('BRN', 'S1', '4.9','12'),
('CRE', 'S1', '2.8','16'),
('DBG', 'S1', '1','21'),
('BGT', 'S1', '4.9','0'),
('BRO', 'S1', '6.3','7'),
('CIT', 'S1', '5.7','24'),
('POM', 'S1', '6.3','0'),
('CEL', 'S1', '3.3','22'),
('PAC', 'S1', '2','4'),
('PEC', 'S1', '3.4','45'),
('RAD', 'S1', '3.2','46'),
('PAR', 'S1', '2.1','84'),
('ANA', 'S1', '1.5','42'),
('FRA', 'S1', '5.2','4'),
('BAR', 'S1', '5.5','6'),
('FRI', 'S1', '2.3','45'),
('AGN', 'S1', '4.7','2'),
('CHF', 'S1', '8.6','35'),
('OIG', 'S1', '2.7','6'),
('COURG', 'S1', '1.6','78');


CREATE USER 'biobio'@'%' IDENTIFIED BY 'bio';GRANT SELECT, INSERT, UPDATE, DELETE ON *.* TO 'biobio'@'%' IDENTIFIED BY 'bio' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;GRANT ALL PRIVILEGES ON `BiorelaisBDD`.* TO 'biobio'@'%';
