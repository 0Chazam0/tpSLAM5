class Formulaire {
	constructor(id, nom, parentDOM , classe) { 
	this.id = id; 
	this.nom = nom;
	this.parentDOM = parentDOM; 
	this.classe = classe;
	}
	
};

Formulaire.prototype.formulaireDOM; 


Formulaire.prototype.creerLabel = function(id , texte , classe) {
	var elementHTML = document.createElement('label');
	elementHTML.className = classe ;
	elementHTML.setAttribute("id",id);
	this.formulaireDOM.appendChild(elementHTML);
	 var labelTexte = document.createTextNode(texte);
	 elementHTML.appendChild(labelTexte);
}

Formulaire.prototype.creerText = function(id , name , classe ) {
	var elementHTML = document.createElement('input');
	elementHTML.className = classe ;
	elementHTML.setAttribute("id",id);
	elementHTML.setAttribute("required",true);
	elementHTML.setAttribute("name",name);
	elementHTML.setAttribute("type","Text");
	this.formulaireDOM.appendChild(elementHTML);	
}


Formulaire.prototype.creerBouton = function(id , name , classe , value, parent) {
	var elementHTML = document.createElement('input');
	elementHTML.className = classe ;
	elementHTML.setAttribute("id",id);
	elementHTML.setAttribute("name",name);
	elementHTML.setAttribute("value",value);
	elementHTML.setAttribute("type","button");
	parent = document.getElementById(parent);
	parent.appendChild(elementHTML);
}


Formulaire.prototype.creerSelect = function(id , name , classe) {
	var elementHTML = document.createElement('select');
	elementHTML.className = classe ;
	elementHTML.setAttribute("id",id);
	elementHTML.setAttribute("name",name);
	this.formulaireDOM.appendChild(elementHTML);	
}


Formulaire.prototype.retourLigne = function() {
	var elementHTML = document.createElement('p');
	this.formulaireDOM.appendChild(elementHTML);
}

Formulaire.prototype.ajouterDiv = function(id ,  classe) {
	var elementHTML = document.createElement('div');
	elementHTML.className = classe ;
	elementHTML.setAttribute("id",id);
	this.formulaireDOM.appendChild(elementHTML);
}



Formulaire.prototype.creerFormulaire = function() {
	var divFormu = document.createElement('div');
	divFormu.setAttribute('id', this.id);
	divFormu.className = this.classe;
	this.parentDOM.appendChild(divFormu);
	
	var formulaire = document.createElement('form');
	formulaire.setAttribute('name', this.nom);
	divFormu.appendChild(formulaire);
	this.formulaireDOM = formulaire;
}






