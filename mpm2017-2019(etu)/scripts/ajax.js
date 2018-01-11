


function afficherProjets(xhttp) {
	let listeProjets = JSON.parse(xhttp.responseText);
	for(let projet of listeProjets){
		ajouterProjet(projet.nomProjet);
	}
}


function AjouterProjetPHP(xhttp) {
	if(xhttp.responseText > 0){
		
	}
	else{
		alert ("Ajout impossible");
	}
}




function reponseAjax(method, url, uneFonction , data) {
  var xhttp;
  xhttp=new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    	uneFonction(this);
    }
 };
  xhttp.open(method, url, true);
  if(method == 'post'){
	  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  }
  xhttp.send(data);
}





