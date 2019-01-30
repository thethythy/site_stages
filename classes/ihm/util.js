// Extension des objets DOM Element
// On stocke toutes les methodes dans
if (!window.Element) {
	Element = new Object();
}

Element.getLeft = function(element) {
	var offsetLeft = 0;
	// On cumule les offset de tous les elements englobants
	while (element != null) {
		offsetLeft += element.offsetLeft;
		element = element.offsetParent;
	}
	return offsetLeft;
}

Element.getTop = function(element) {
	var offsetTop = 0;
	// On cumule les offset de tous les elements englobants
	while (element != null) {
		offsetTop += element.offsetTop;
		element = element.offsetParent;
	}
	return offsetTop;
}

Element.setStyle = function(element, style) {
	for (directive in style) {
		element.style[directive] = style[directive];
	}
}

/** Renvoie le tableau des elements de type tagName enfants de element.
  * Si tagName vaut "*", renvoie tous les elements enfants */
Element.getChildElements = function(element, tagName) {
	var result = new Array();
	var name = tagName.toLowerCase();
	for (var i=0 ; i<element.childNodes.length ; i++) {
		var child = element.childNodes[i];
		if (child.nodeType == 1) { // C'est un element
			if (name == "*" || child.nodeName.toLowerCase() == name) {
				result.push(child);
			}
		}
	}
	return result;
}

/** Enleve les noeuds texte vides enfants de l'element */
Element.cleanWhiteSpace = function(element) {
	for (var i = 0; i < element.childNodes.length; i++) {
		var node = element.childNodes[i];
		if (node.nodeType == 3 && !/\S/.test(node.nodeValue)) {
			element.removeChild(node);
		}
	}
}

/** DOM event */
if (!window.Event) {
	Event = new Object();
}

Event.event = function(event) {
	// W3C ou alors IE
	return (event || window.event);
}

Event.target = function(event) {
	return (event) ? event.target : window.event.srcElement ;
}

Event.preventDefault = function(event) {
	var event = event || window.event;
	if (event.preventDefault) { // W3C
		event.preventDefault();
	}
	else { // IE
		event.returnValue = false;
	}
}

Event.stopPropagation = function(event) {
	var event = event || window.event;
	if (event.stopPropagation) {
		event.stopPropagation();
	}
	else {
		event.cancelBubble = true;
	}
}

Keys = {
	TAB: 9,
	ENTER: 13,
	ESCAPE: 27,
	PAGE_UP: 33,
	PAGE_DOWN:34,
	END: 35,
	HOME: 36,
	LEFT: 37,
	UP: 38,
	RIGHT: 39,
	DOWN: 40
}

/** Afficher un message dans une boîte d'alerte */
Log = {
	error: function(msg) {
		alert("Error : \n" + msg);
	}
}

/**
 * Chargement de données dès qu'un type d'action est effectué sur des éléments HTML (sources)
 * Les données sont affichées dans un élément HTML <div id="data"></div>
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
				case "onclick" :
					var composantJS = this;
					document.getElementById(this.idSources[i]).onclick = function(aEvent) {
						composantJS.onclick(aEvent));
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
				document.getElementById("content-wrap").style.cursor = 'default';
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
							document.getElementById("content-wrap").style.cursor = 'default';
						}
					} catch (exc) {
						document.getElementById("content-wrap").style.cursor = 'default';
						Log.error(exc);
					}
				}
				// Lancer la requete
				this.request.send(corps);
				document.getElementById("content-wrap").style.cursor = 'progress';
			} catch (exc) {
				Log.error(exc);
			}
		}
	},

	// Gestion des entrées claviers
	onkeyup: function(aEvent) {
		// L'evenement selon W3 ou IE
		switch (Event.event(aEvent).keyCode) {
			// Ne rien faire pour les touches de navigation
			case Keys.DOWN: case Keys.UP: case Keys.PAGE_UP:
			case Keys.HOME: case Keys.PAGE_DOWN: case Keys.END:
			case Keys.ENTER: case Keys.ESCAPE:
				break;
			default:
				this.load(); // Chargement de la page
		}
	}

}

LoadData.prototype.constructor = LoadData;
