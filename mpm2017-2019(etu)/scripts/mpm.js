
var projets = [];
var projetActif;


/*
 * Ajoute le bouton Créer nouveau projet
 */
function ajouterBoutonNouveauProjet(){
	menuProjets = document.getElementById('menuProjets');
	console.log(menuProjets);
	var inputProjet = document.createElement("input");
	inputProjet.setAttribute("name","btnProjet");
	inputProjet.setAttribute("id","btnProjet");
	inputProjet.setAttribute("type","button");
	inputProjet.setAttribute("value","Créer nouveau projet")
	menuProjets.appendChild(inputProjet);	 
}

/*
*Ajoute un projet à la liste des projets affichés
*/
function ajouterProjet(unNom){
	var radioInput = document.createElement('input');
	radioInput.setAttribute('type', 'radio');
	radioInput.setAttribute('name', 'projets');
	radioInput.setAttribute('id', unMom);
	document.getElementById('listeProjets').appendChild(radioInput);
	var labelRadio = document.createTextNode(unNom);
	document.getElementById('listeProjets').appendChild(labelRadio);
	var br = document.createElement('br');
		document.getElementById('listeProjets').appendChild(br);

}

/*
 * Ajoute le formulaire Ajouter projet
 */
function ajouterFormulaireProjet(unId,unNom,unParent,unStyle){
	
}


/*
 * Ajoute le bouton créer nouvelle tache
 */
function ajouterBoutonTache(){
	
}

/*
 * Ajoute le formulaire Ajouter tâche
 */
function ajouterFormulaireTache(unId,unNom,unParent,unStyle){

}



/*
 * ajoute une nouvelle tâche à la liste des taches
 */
function ajouterTache(unNom){
	
}


window.addEventListener("load", ajouterBoutonNouveauProjet());
window.addEventListener("load", function(){
	var url = "controleurs/PHPAjax/lesProjets.php";
	var data = "";
	reponseAjax('post', url, afficherprojets, data);

});
    
    
    








/***************************************
 * Gestion des évènements
 **************************************/
window.addEventListener("load", function(){
	ajouterBoutonNouveauProjet();	
});

var nouveauProjet = document.getElementById('btnProjet');
nouveauProjet.addEventListener("click", function(){
	ajouterFormulaireProjet('formProjet','formProjet','content','formProjet');
});













