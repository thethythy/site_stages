
var compteur = 0; // Compteur des compétences ajoutées

function ajout_competence() {
    var child1 = document.createTextNode("Nom : ");
    var child2 = document.createElement("input");
    var child3 = document.createElement("br");
    child2.setAttribute("type", 'text');
    child2.setAttribute("name", 'competence_ajout' + compteur);
    document.getElementById('ajout_competence').appendChild(child1);
    document.getElementById('ajout_competence').appendChild(child2);
    document.getElementById('ajout_competence').appendChild(child3);
    compteur++;
}

/**
 * Permet de changer le titre et de faire apparaitre les éléments selon le type d'offre
 */
function swap_offre(){
    var title = document.getElementById('title');
    var altRad = 	document.getElementById('radioAlternance');
    var divContrat = document.getElementById('divTypeContrat');
    var dureeStage = document.getElementById('dureeStage');
    var dureeAlt = document.getElementById('dureeAlt');
    var siret = document.getElementById('thSiret');
    if(altRad.checked){
	title.innerHTML = "Offre d'alternance";
	dureeStage.style.display = 'none';
	dureeAlt.style.display = 'block';
	divContrat.style.display = '';
	siret.innerHTML = 'SIRET (*) : ';
    } else {
	title.innerHTML = "Offre de stage";
	dureeAlt.style.display = 'none';
	dureeStage.style.display = 'block';
	divContrat.style.display  = 'none';
	siret.innerHTML = 'SIRET :';
    }
}

/** @class
 * Liste popup d'options possibles pour un champ de saisie
 * @constructor
 * @param source : élément HTML (champ de saisie) associe a la liste
 * @param {function} validationFunction : fonction a exécutée en cas de validation
 */
function PopupList(source, validationFunction) {
    /** Element div contenant les options @type HTMLElement */
    this.list = document.createElement("div");
    document.body.appendChild(this.list);
    /** Rang de l'option selectionnee (-1 au depart) @type int*/
    this.index = -1;
    /** Element (champ de saisie) auquel la popup est rattachee
     * @type HTMLElement */
    this.source = source;
    // Initialiser
    this.setLayout();
    this.hide();
    this.setBehaviour(validationFunction);
}

PopupList.prototype = {
	/** Initialiser la popup de suggestion */
	setLayout: function() {
	    // Donner au div l'apparence d'une popup
	    this.list.style.background = "Window";
	    this.list.style.border = "solid 1px WindowText";
	    this.list.style.padding = "2px";
	    // La positionner juste sous le champ de saisie
	    this.list.style.position = "absolute";
	    this.list.style.left = Element.getLeft(this.source) + "px";
	    this.list.style.top = (Element.getTop(this.source) + this.source.offsetHeight) + "px";
	},
	
	/** Supprimer toutes les options et masquer la popup */
	clear: function() {
	    this.list.style.display = "none";
	    this.list.innerHTML = "";
	    this.index = -1;
	    this.values = [];
	},

	/** Afficher la popup si elle a des options */
	display: function() {
	    if (this.list.childNodes.length > 0) {
		this.list.style.display = "block";
	    }
	},

	/** Cacher la popup */
	hide: function() {
	    this.list.style.display = "none";
	},
	
	/** La liste est-elle visible
	 * @type Boolean */
	isVisible: function() {
	    return this.list.style.display != "none";
	},
	
	/** Remplacer les options
	 * @param values tableau des nouvelles valeurs */
	setOptions: function(values) {
	    this.clear();
	    if (values.length > 0) {
		var div;
		// Les proposer, s'il y en a
		for (i = 0 ; i < values.length ; i++) {
		    div = document.createElement("div");
		    div.innerHTML = values[i].nom + " (" + values[i].adresse + " " + values[i].codepostal + " " + values[i].ville + ")";
		    this.list.appendChild(div);
		    // Memoriser dans l'element div son rang
		    div.setAttribute("index", i);
		    div.className = "option";
		}
		this.display();
		this.values = values; // Mémorise pour quand on valide
	    }
	},

	/** Faire reagir la popup aux mouseout, mouseover et clic.<br/>
	 * mouseover met en surbrillance l'option ayant la souris.<br/>
	 * mouveout la remet a l'etat initial.<br/>
	 * clic fait disparaitre la popup et met la valeur de l'option
	 * dans la source.
	 */
	setBehaviour: function(validationFunction) {
	    // Garder l'objet courant pour les on... des options
	    var current = this;
	    this.list.onmouseover = function(event) {
		var target = Event.target(event);
		if (target.className == "option") {
		    current.go(target.getAttribute("index"));
		    Event.stopPropagation(event);
		}
	    }
	    this.list.onmouseout = function(event) {
		current.go(-1);
	    }
	    this.list.onclick = function(event) {
		// Mettre à jour le champs édite
		current.source.value = current.values[current.index].nom;
		// Propager éventuellement la validation
		if (validationFunction)
		    validationFunction(current.values[current.index]);
		// Effacer la liste : les options ne sont plus a jour
		current.clear();
		// Redonner le focus au champ de saisie
		current.source.focus();
	    }
	},

	/** Aller a l'option d'indice index, et la mettre en surbrillance.<br/>
	 * Assure que index est dans les bornes ou bien vaut -1 :
	 * this.index vaudra <br/>
	 * index si 0 <= index < nombre d'options
	 * (this.list.childNodes.length),<br/>
	 * -1 si index < 0 et <br/>
	 * nombre d'options -1 si index >= nombre d'options */
	go: function(index) {
	    var divs = this.list.childNodes;
	    // Deselectionner le div selectionne
	    if (-1 < this.index && this.index < divs.length) {
		divs[this.index].style.background = "Window";
		divs[this.index].style.color = "WindowText";
	    }
	    // Mettre a jour l'index
	    if (-1 < index && index < divs.length) {
		this.index = index;
	    }
	    else if (index <= -1) {
		this.index = -1;
	    }
	    else {
		this.index = divs.length - 1;
	    }
	    // Mettre en surbrillance l'element selectionne s'il y en a un
	    if (this.index != -1) {
		divs[this.index].style.background = "Highlight";
		divs[this.index].style.color = "HighlightText";
	    }
	},
	
	/** Valeur courante de la liste.<br/>
	 * Chaine vide si pas d'option selectionnee
	 * @type String */
	getValue: function() {
	    return (0 <= this.index && this.index < this.list.childNodes.length)
		    ? this.list.childNodes[this.index].innerHTML
		    : "";
	},
	
	/** Nombre d'options de la liste @type int */
	getLength: function() {
	    return this.list.childNodes.length;
	}
};

PopupList.prototype.constructor = PopupList;

/** @class
 * Creer une suggestion de saisie pour un champ textuel
 */
function Suggest() {}

Suggest.prototype = {
    /** Initialisation, utilisable dans les types descendants
     * @param idField : id du champ de saisie
     * @param {function} validationFunction (optionnel) : fonction à exécutée si validation 
     * @param maxSuggestNumber (optionnel) : nombre maximal de resultats a afficher (defaut : 10) */
    init: function(idField, validationFunction, maxSuggestNumber) {
	/** Le champ de saisie @type HTMLInputElement */
	this.source = document.getElementById(idField);
	/** Nombre maximum de valeurs suggerées @type int */
	this.maxSuggestNumber = (maxSuggestNumber) ? maxSuggestNumber : 10;
	// Verifier la validité des paramètres
	this.check(idField);
	/** La zone de suggestion @type PopupList */
	this.popup = new PopupList(this.source, validationFunction);
	/** Valeur saisie par l'utilisateur @type String */
	this.inputValue = "";
	this.setBehaviour();
    },

    /** Vérifier que les paramètres sont valides */
    check: function(idField) {
	// Verifier qu'il y a bien une saisie a suggerer
	if (this.source == null) {
	    Log.error("Element with id '" + idField + "' not found");
	}
	if (isNaN(parseInt(this.maxSuggestNumber)) || parseInt(this.maxSuggestNumber) <= 0) {
	    Log.error("Max suggest number for '" + idField + "' not positive (" + this.maxSuggestNumber + ")");
	}
    },

    /** Récuperer les options et les faire afficher
     * (méthode abstraite) */
    setOptions: function() {
	Log.error("setOptions is abstract, must be implemented");
    },

    /** Définir les réactions du champ de saisie */
    setBehaviour: function() {
	// Desactiver la completion automatique du navigateur
	this.source.setAttribute("autocomplete", "off");
	// Stocker l'objet courant ...
	var suggest = this;
	// ... car dans la fonction ci-dessous, this est
	// le champ de saisie (this.source) qui a genere l'evenement
	this.source.onkeyup = function(aEvent) {
	    suggest.onkeyup(aEvent);
	};
	// Gerer l'evenement keydown qui est lance AVANT keyup,
	// or si on fait ENTER, par defaut le formulaire est soumis :
	// on ne peut pas bloquer cela dans onkeyup
	this.source.onkeydown = function(aEvent) {
	    suggest.onkeydown(aEvent);
	}
	this.source.onblur = function() {
	    // Masquer la popup seulement si la souris n'y est pas
	    // Comme le mouseout est declenche avant le clic ou le tab
	    // qui fait perdre le focus, il n'y a plus de div selectionne
	    if (suggest.popup.index == -1) {
		suggest.popup.hide();
	    }
	};
    },

    /** Réaction à keydown */
    onkeydown: function(aEvent) {
	var event = Event.event(aEvent);
	switch (event.keyCode) {
	    case Keys.ESCAPE:
		this.popup.hide();
		break;
	    // S'il y a une suggestion, l'efface
	    // s'il n'y en a pas (ou plus), soumet le formulaire
	    case Keys.ENTER:
		if (this.popup.isVisible()) {
		    Event.preventDefault(event);
		    this.popup.clear();
		}
		break;
	    case Keys.TAB:
		this.popup.clear();
		break;
	    case Keys.DOWN:
		this.goAndGet(this.popup.index + 1);
		break;
	    case Keys.UP:
		this.goAndGet(this.popup.index - 1);
		break;
	    case Keys.PAGE_UP:
		this.goAndGet((this.popup.getLength() > 0) ? 0 : -1);
		break;
	    case Keys.PAGE_DOWN:
		this.goAndGet(this.popup.getLength() - 1);
		break;
	    default:
		break;
	}
    },

    /** Aller à la suggestion d'indice index
     * et mettre sa valeur dans le champ de saisie */
    goAndGet: function(index) {
	this.popup.go(index);
	if (-1 < this.popup.index) {
	    this.source.value = this.popup.getValue();
	}
	else {
	    this.source.value = this.inputValue;
	}
    },

    /** Réaction à la saisie (onkeyup) dans le champ */
    onkeyup: function(aEvent) {
	// L'evenement selon W3 ou IE
	switch (Event.event(aEvent).keyCode) {
	    // Ne rien faire pour les touches de navigation
	    // qui sont prises en compte par keydown
	    case Keys.DOWN: case Keys.UP: case Keys.PAGE_UP:
	    case Keys.HOME: case Keys.PAGE_DOWN: case Keys.END:
	    case Keys.ENTER: case Keys.ESCAPE:
		break;
	    default:
		// Memoriser la saisie
		this.inputValue = this.source.value;
		// Mettre a jour la liste
		this.setOptions();
	}
    },
}

Suggest.prototype.constructor = Suggest;

/** @class
 * Creer une suggestion de saisie Ajax pour un champ textuel
 * @constructor
 */
function HttpSuggest(idField, getValuesUrl, validationFunction, maxSuggestNumber) {
	/** L'url récuperant les valeurs @type String */
	this.url = getValuesUrl;
	// Preparer l'url pour recevoir les parametres
	if (this.url.indexOf("?") == -1) {
		this.url += "?";
	} else {
		this.url += "&";
	}
	/** Requete HTTP @type XMLHttpRequest */
	this.request = new XMLHttpRequest();
	Suggest.prototype.init.call(this, idField, validationFunction, maxSuggestNumber);
}

HttpSuggest.prototype = new Suggest();

HttpSuggest.prototype.setOptions = function() {
    try {
	// Annuler la requete precedente qui ne sert plus a rien
	this.request.abort();
    }
    catch (exc) {}
    
    try {
	// Si la saisie n'est pas vide
	if (this.source.value !== "") {
	    var url = this.url + "search=" + encodeURIComponent(this.source.value) + "&size=" + this.maxSuggestNumber;
	    this.request.open("GET", url , true);
	    
	    // Garder l'objet courant pour le onreadystatechange
	    var suggest = this;
	    this.request.onreadystatechange = function() {
		try {
		    if (suggest.request.readyState == 4 && suggest.request.status == 200) {
			// Récupération des entreprises
			var entreprises = JSON.parse(suggest.request.responseText);			
			suggest.popup.setOptions(entreprises);
		    }
		}
		catch (exc) {
		    Log.error("exception onreadystatechange");
		}
	    }
	    
	    this.request.send(null);
	
	} else {
	    this.popup.clear(); // La saisie est vide donc on efface la popup
	}
    }
    catch (exc) {
	Log.error(exc);
    }
}

/**
 * Fonction exécutée lors de la validation dans la liste popup
 * 
 * @param {object} entreprise
 */
function setEntreprise(entreprise) {
    document.getElementById("adresse").value = entreprise.adresse;
    document.getElementById("ville").value = entreprise.ville;
    document.getElementById("codepostal").value = entreprise.codepostal;
    document.getElementById("pays").value = entreprise.pays;
    entreprise.email ? document.getElementById("email_entreprise").value = entreprise.email
                     : document.getElementById("email_entreprise").value = "";
    entreprise.siret ? document.getElementById("siret").value = entreprise.siret
                     : document.getElementById("siret").value = "";
}

/**
 * Fonction exécutée au chargement de la page
 */
function auchargement() {
    // Par défault : offre de stage
    var stgRad = document.getElementById('radioStage');
    stgRad.checked = true;
    swap_offre();

    // Mise en place de la suggestion d'édition du nom de l'entreprise
    new HttpSuggest("nom_entreprise", "getEntreprisesJSON.php", setEntreprise);
}


