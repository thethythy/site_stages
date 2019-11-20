
function jsonParse(text) {
	console.log(text);
	try {
		var json = JSON.parse(text);
		//console.log(json);
	}
	catch(e) {
		return false;
	}
	return json;
}

function populateEtudiant(){
  var id_etu = document.getElementById('idEtudiant').value;
  //console.log(id_etu);
  var idOffres = document.querySelectorAll('[id^="idOffre-"]'); // Récupère tous les éléments du document dont l'id commence par idOffre-
  var idEntreprises = document.querySelectorAll('[id^="idEntreprise-"]'); // Récupère tous les éléments du document dont l'id commence par idEntreprise-
  var idStatuts = document.querySelectorAll('[id^="idStatut-"]'); // Récupère tous les éléments du document dont l'id commence par idStatut-
  var entreprises = [];
  var offres = [];
  var urlEncodeData = 'idetudiant=' + id_etu;
  urlEncodeData = urlEncodeData + '&' + 'length=' + idEntreprises.length;

  for(var i = 0; i < idEntreprises.length; i++){
    offres.push(idOffres[i].id); // Ajoute l'id en fin de tableau
    offres[i] = (offres[i].split('-'))[1]; // Coupe la chaine idOffre-xxx et ne garde que la véritable id de l'offre

    entreprises.push(idEntreprises[i].id); // Ajoute l'id en fin de tableau
    entreprises[i] = (entreprises[i].split('-'))[1]; // Coupe la chaine idOffre-xxx et ne garde que la véritable id de l'offre

    urlEncodeData = urlEncodeData
    + '&' + 'idoffre'      + i + '=' + offres[i]
    + '&' + 'identreprise' + i + '=' + entreprises[i]
  }

  xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var json = jsonParse(this.responseText);
            //console.log("!json (print erreur si false) = "+json)
            if (!json || json.requestStatus !== true) {
                document.getElementById('erreurAjax').innerHTML = (json.error || "Une erreur est survenue.") + "\nVous pouvez réactualiser la page et recommencer.";
                return;
            }
            /* Traitement de la réponse */
            for(var i = 0 ; i < json.length ; i++){
              document.getElementById('idStatut-'+i).value = json[i];
            }
        }
    }

  xhr.open('POST', 'etudiantData.php', true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(urlEncodeData);
}

function postForm(){
  var id_etu = document.getElementById('idEtudiant').value;
  var idOffres = document.querySelectorAll('[id^="idOffre-"]'); // Récupère tous les éléments du document dont l'id commence par idOffre-
  var idEntreprises = document.querySelectorAll('[id^="idEntreprise-"]'); // Récupère tous les éléments du document dont l'id commence par idEntreprise-
  var idStatuts = document.querySelectorAll('[id^="idStatut-"]'); // Récupère tous les éléments du document dont l'id commence par idStatut-
  var entreprises = [];
  var offres = [];
  var statuts = [];
  var urlEncodeData = 'idetudiant=' + id_etu;
  urlEncodeData = urlEncodeData + '&' + 'length=' + idEntreprises.length;

  for(var i = 0; i < idEntreprises.length; i++){
    offres.push(idOffres[i].id); // Ajoute l'id en fin de tableau
    offres[i] = (offres[i].split('-'))[1]; // Coupe la chaine idOffre-xxx et ne garde que la véritable id de l'offre

    entreprises.push(idEntreprises[i].id); // Ajoute l'id en fin de tableau
    entreprises[i] = (entreprises[i].split('-'))[1]; // Coupe la chaine idOffre-xxx et ne garde que la véritable id de l'offre

    statuts.push(idStatuts[i].value); // Ajoute la valeur du statut en fin de tableau

    urlEncodeData = urlEncodeData
    + '&' + 'idoffre'      + i + '=' + offres[i]
    + '&' + 'identreprise' + i + '=' + entreprises[i]
    + '&' + 'statut'       + i + '=' + statuts[i];
  }

  //Remplacer les espaces, normalement il n'y en a pas mais au cas où
  urlEncodeData = urlEncodeData.replace(/%20/g, '+');
  xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var json = jsonParse(this.responseText);
            if (!json || json.requestStatus !== true) {
                document.getElementById('erreurAjax').innerHTML = (json.error || "Une erreur est survenue.") + "\nVous pouvez réactualiser la page et recommencer.";
                return;
            }
	    setTimeout(() => document.getElementById('idSaveButton').innerHTML = "Enregistrer", 3000);
        }
    };

  document.getElementById('idSaveButton').innerHTML = "Enregistrement en cours...";

  xhr.open('POST', 'sauvegardeCandidaturesData.php', true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(urlEncodeData);
}
