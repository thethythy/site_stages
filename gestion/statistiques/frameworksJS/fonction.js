
/** Afficher un message dans une boîte d'alerte */
Log = {
	error: function(msg) {
		alert("Error : \n" + msg);
	}
}
*/
function LoadData(sources, adresseData, action) {
	// Les id des éléments HTML à l'origine de la demande de chargement
	this.idSources = sources;
	// La page à charger
	this.url = adresseData;
	// L'action qui provoque le chargement
	this.action = action;
	// Mise en place du comportement
	this.setBehaviour();
	// Requete HTTP XMLHttpRequest 
	this.request = this.getRequest();
}

LoadData.prototype = {
	// Assignation de l'action
	setBehaviour: function() {
		for (i=0 ; i < this.idSources.length; i++) {
			switch(this.action) {
				case "onchange" :
					var composantJS = this;
					document.getElementById(this.idSources[i]).onchange = function() {
						composantJS.load();
					}
					break;
				case "onkeyup" :
					var composantJS = this;
					document.getElementById(this.idSources[i]).onkeyup = function(aEvent) {
						composantJS.onkeyup(aEvent);
					}
					break;
				default:
					break;
			}
		}
	},
	
	// Recuperer la requete existante ou une nouvelle si elle vaut null
	getRequest: function() {
		var result = this.request;
		if (result == null) {
			if (window.XMLHttpRequest) {
				// Navigateur compatible Mozilla
				result = new XMLHttpRequest();
			} else if (window.ActiveXObject) {
				// Internet Explorer sous Windows
				result = new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		return result;
	},
	
	// Chargement de la page
	load: function() {
		// Annuler la requete precedente qui ne sert plus a rien
		if (this.resquest != null)
			try {
				this.request.abort();
				document.getElementById("data").style.cursor = 'default';
			} catch (exc) {}
		// Construire une nouvelle requête et l'envoyer
		this.request = this.getRequest() ;
		if (this.request != null) {
			// Constituer le corps de la requete (la chaine de requete)
			var corps = "";
			for (i=0 ; i < this.idSources.length; i++) {
				var value = document.getElementById(this.idSources[i]).value;
				corps += "&" + this.idSources[i] + "=" + encodeURIComponent(value);
			}
			try {
				// Ouvrir une connexion asynchrone
				this.request.open("POST", this.url, true);
				// Positionner une en-tete indispensable quand les parametres sont passes par POST
				this.request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				// Traitement a effectuer quand l'etat de la requete changera
				var composantJS = this;
				this.request.onreadystatechange = function() {
					try {
						if (composantJS.request.readyState == 4 && composantJS.request.status == 200) {
							document.getElementById("data").innerHTML = composantJS.request.responseText;
							document.getElementById("data").style.cursor = 'default';
						}
					} catch (exc) {
						document.getElementById("data").style.cursor = 'default';
						Log.error(exc);
					}
				}
				// Lancer la requete
				this.request.send(corps);
				document.getElementById("data").style.cursor = 'progress';
			} catch (exc) {
				Log.error(exc);
			}
		}
	},
	
	
	 
}

LoadData.prototype.constructor = LoadData;