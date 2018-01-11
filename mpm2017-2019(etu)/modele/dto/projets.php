<?php

class Projets{
    private $projets = array();
    
    public function __construct($array){
        if (is_array($array)) {
            $this->projets = $array;
        }
    }
    
    public function getProjets(){
        return $this->projets;
    }
    
    public function chercheProjet($unIdProjet){
        $i = 0;
        while ($unIdProjet != $this->projets[$i]->getId() && $i < count($this->projets)-1){
            $i++;
        }
        if ($unIdProjet == $this->projets[$i]->getId()){
            return $this->projets[$i];
        }
    }
}