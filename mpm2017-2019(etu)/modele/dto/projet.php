<?php

class Projet {
    use Hydrate , JsonEncode;
    private $idProjet;
    private $nomProjet;
    private $dureeProjet;
    private $dateDebutProjet;
    private $dateFinProjet;
    private $taches = [];
    
    
    public function __construct($unIdProjet = Null, $unNomProjet = NULL ){
        $this->idProjet = $unIdProjet;
        $this->nomProjet = $unNomProjet;
    }
    
    public function getIdProjet(){
        return $this->idProjet;
    }
    
    public function getNomProjet(){
        return $this->nomProjet;
    }
    
    public function getDureeProjet(){
        return $this->dureeProjet;
    }
    
    public function getDateDebutProjet(){
        return $this->dateDebutProjet;
    }
    
    public function getDateFinProjet(){
        return $this->dateFinProjet;
    }
    
    
    public function getTaches(){
        return $this->taches;
    }
    
    public function setIdProjet($unIdProjet){
        $this->idProjet = $unIdProjet;
    }
    
    public function setNomProjet($unNomProjet){
        $this->nomProjet= $unNomProjet;
    }
    
    
    public function setDureeProjet($uneDureeProjet){
        return $this->dureeProjet = $uneDureeProjet;
    }
    
    public function setDateDebutProjet($uneDateDebutProjet){
        $this->dateDebutProjet = $uneDateDebutProjet;
    }
    
    public function setDateFinProjet($uneDateFinProjet){
        $this->dateFinProjet = $uneDateFinProjet;
    }
    
    
    public function setTaches($desTaches){
        $this->taches = $desTaches;
    }
    
    
    
    
    
}