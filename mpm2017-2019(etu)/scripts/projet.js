class Projet{
	constructor( nom, duree, dateDeb, dataFin ) { 
		this.nomProjet = nom;
		this.dureeProjet = duree; 
		this.dateDebutProjet = dateDeb; 
		this.dateFinProjet = dataFin; 
		this.taches = [];
	}
}

Projet.prototype.ajouterTache = function(tache) {
	this.taches.push(tache);
}


class Tache {
    constructor( nom, duree) { 
    	this.nomTache = nom;
    	this.dureeTache = duree; 
    }

}
