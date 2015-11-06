// ------------------------------------------------------------------------------------------
// La ligne de log
function Logger(idlogline) {
	// La ligne compl�te
	this.loglinehtml = document.getElementById(idlogline);
	// Pr�paration de la structure
	if (this.loglinehtml) this.setStructure();
}

// Le prototyype de la ligne de log
Logger.prototype = {
	/** Cr�ation de la structure */
	setStructure : function() {
		// Le nombre de conventions
		this.nbconv = 0;
		// Le nombre de soutenances
		this.nbsout = 0;
		// Le message
		this.message= "";
		// La ligne vide
		this.loglinehtml.innerHTML = "";
	},

	/** Modification du nombre de conventions */
	setNbConv : function(nbconv) {
		this.nbconv = nbconv;
		this.maj();
	},

	/** Retourne le nombre de conventions */
	getNbConv : function() {
		return this.nbconv;
	},

	/** Modification du nombre de soutenances */
	setNbSout : function(nbsout) {
		this.nbsout = nbsout;
		this.maj();
	},

	/** Retourne le nombre de soutenances */
	getNbSout : function() {
		return this.nbsout;
	},

	/** Modification du message */
	setMessage : function(message, isappend) {
		this.message = isappend ? this.message + " " + message  : message;
		this.maj();
	},

	/** Mise � jour du logger puis effacement automatique du message apr�s 5 secondes */
	maj : function() {
		this.loglinehtml.innerHTML = "Conventions : " + this.nbconv + "   Soutenances : " + this.nbsout;
		if (this.message != "") {
			this.loglinehtml.innerHTML += "<br/>" + this.message;
			window.setTimeout("logger.clear()", 5000);
		}
	},

	/** Efface uniquement le message */
	clear : function() {
		this.setMessage("");
	},

	/** Remise � z�ro du composant */
	reset : function() {
		this.setStructure();
	}
}

Logger.prototype.constructor = Logger;
logger = new Logger('logline');

// ------------------------------------------------------------------------------------------
// L'arborescence
tree = new dhtmlXTreeObject('dhtmlxtree', '100%', '100%', 0);
tree.setSkin('dhx_skyblue');
tree.enableDragAndDrop(true);
tree.attachEvent("onDrag", function() {return false;});
tree.setImagePath('../../classes/ihm/dhtmlxtree/imgs/csh_yellowbooks/');

// Pour compter et mettre � jour le nombre de conventions
tree.attachEvent("onXLE", function(tree,id) {
	logger.setNbConv(tree.getAllChildless().split(',').length);
});

// Retourne le temps de soutenance selon l'id de la filiere
var getDureeSoutenanceFiliere = function(id) {
	for (var i = 0; i < temps_soutenances.length; i++) {
		if (temps_soutenances[i].key == id) return temps_soutenances[i].temps;
	}
	return 30;
};

// Pour faire ressortir la soutenance correspond � une convention s�lectionn�e
tree.setOnClickHandler(function(id) {
	// S�lection de la soutenance et d�s�lection de l'ancienne
	var idsoutenance = tree.getUserData(id,"idsoutenance");
	scheduler.myDeselect(idsoutenance);
	if (idsoutenance) scheduler.mySelect(idsoutenance);

	// Calcul de la dur�e d'une soutenance de la filiere
	var idfiliere = id.split('_')[1];
	var duree = getDureeSoutenanceFiliere(idfiliere);
	scheduler.config.event_duration = duree;
});

// ------------------------------------------------------------------------------------------
// Le planning

// Fonction pour le formatage des heures
var format_heure=scheduler.date.date_to_str("%H:%i");

// Les journ�es commencent � 8h et finissent � 18h
scheduler.config.first_hour = 8;
scheduler.config.last_hour = 18;

// Format des dates dans les �v�nements XML
scheduler.config.xml_date = "%Y-%m-%d %H:%i";

// Format d'affichage des journ�es
scheduler.config.day_date = "%D %d %M %Y";

// Taille en pixel d'une heure
scheduler.config.hour_size_px = 60;

// Hauteur minimale d'un �v�nement
scheduler.xy.min_event_height = 0;

// Longueur de l'echelle des heures
scheduler.xy.scale_width = 40;

// Affichage d'une animation lors d'un chargement en cours
scheduler.config.show_loading = true;

// D�lai avant affichage des tooltips
dhtmlXTooltip.config.timeout_to_display = 10;

// Retourne le nom de la salle � partir de son id
var getNomSalle = function(id) {
	for (var i = 0; i < salles.length; i++) {
		if (salles[i].key == id) return salles[i].label;
	}
	return "ind�fini";
}

// Format d'affichage des tooltips
scheduler.templates.tooltip_text = function(start,end,event) {
	var salle = event.idsalle ? getNomSalle(event.idsalle) : "ind�fini";
	var huisclos = event.ahuisclos == 1 ? "oui" : "non";
	return "<b>Etudiant :</b> " + event.details + "<br/><b>R�f�rent :</b> " + event.parrain + "<br/><b>Examinateur :</b> " + event.examinateur + "<br/><b>Entreprise :</b> " + event.entreprise + "<br/><b>Salle :</b> " + salle + "<br/><b>Huis clos :</b> " + huisclos + "<br/><b>D�but :</b> " + format_heure(start) + "<br/><b>Fin :</b> " + format_heure(end);
};

// Fonction pour remettre l'ent�te par d�faut du planning
scheduler.do_default_dhx_cal_navline = function() {
	// Ent�te par d�faut du planning
	document.getElementById('identpourajax').innerHTML =
		"<div class='dhx_cal_prev_button' style='display:none;'>&nbsp;</div>\
		 <div class='dhx_cal_next_button' style='display:none;'>&nbsp;</div>\
		 <div class='dhx_cal_today_button' style='display:none;'></div>\
		 <div class='dhx_cal_date' style='display:none;'></div>\
		 <div class='dhx_cal_tab' name='day_tab' style='right:204px; display:none;'></div>\
		 <div class='dhx_cal_tab' name='week_tab' style='right:140px; display:none;'></div>\
		 <div class='dhx_cal_tab' name='month_tab' style='right:76px; display:none;'></div>";
};

// Fonction pour compter le nombre de soutenances
scheduler.attachEvent("onEventLoading", function(event_object) {
	logger.setNbSout(logger.getNbSout() + 1);
	return true;
});

// Fonction pour formater les heures
scheduler.templates.hour_scale = function(date){
	html="";
	for (var i=0; i < 20; i++) {
		date = scheduler.date.add(date,15,"minute");
		html += "<div style='height:20px;line-height:20px;'>" + format_heure(date) + "</div>";
	}
	return html;
};

// Modification de l'�dition d'�v�nements
scheduler.xy.menu_width = 0;
scheduler.config.details_on_dblclick = true;
scheduler.config.details_on_create = true;

// Fonction qui test si un �l�ment est contenu dans un tableau
var contains = function(a, obj) {
    for (var j = 0; j < a.length; j++) {
        if (a[j] == obj) {
            return true;
        }
    }
    return false;
}

// Fonction qui retourne un tableau des salles libres
// Dans la liste, on garde la salle de la soutenance s�lectionn�e
scheduler.getSallesLibres = function() {
	// R�cup�rer l'�v�nement �dit�
	var ev = this.getEvent(tree.getUserData(tree.getSelectedItemId(), "idsoutenance"));
	// R�cup�rer tous les �v�nements ayant lieu durant la soutenance
	var evs = this.getEvents(ev.start_date, ev.end_date);

	var id_salles_occupees = [];
	var id_salles_libres = [];

	// Parcours des �v�nements trouv�s et recherche des salles occup�es
	for (var i = 0; i < evs.length; i++) {
		if (evs[i].id != ev.id) id_salles_occupees.push(evs[i].idsalle);
	}

	// Parcours des salles et garder que les salles libres
	for (i = 0; i < salles.length; i++) {
		if (! contains(id_salles_occupees, salles[i].key)) id_salles_libres.push(salles[i].key);
	}

	return id_salles_libres;
};

// Editeur sp�cifique pour la salle : donne uniquement la liste des salles libres
scheduler.form_blocks["my_select"] = {
	render : function(sns) {
		var height = (sns.height || "25") + "px";
		var html = "<div class='dhx_cal_ltext' style='height:" + height + ";'><select style='width:100%;'>";
		for (var i=0; i < sns.options.length; i++)
			html += "<option value='" + sns.options[i].key + "'>" + sns.options[i].label + "</option>";
		html += "</select></div>";
		return html;
	},
	set_value : function(node, value, ev) {
		// Construction d'une liste sp�cifique � partir de la liste des salles libres
		var id_salles_libres = this.getSallesLibres();
		var html = "<select style='width:100%;'>";

		for (var i=0; i < id_salles_libres.length; i++)
			html += "<option value='" + id_salles_libres[i] +"'>" +  getNomSalle(id_salles_libres[i]) + "</option>";

		// Ajout de la valeur �ventuelle pr�c�demment s�lectionn�e
		if (typeof value == "undefined")
			value = id_salles_libres[0];
		if (! contains(id_salles_libres, value))
			html += "<option value='" + value +"'>" +  getNomSalle(value) + "</option>";

		html += "</select>";
		node.innerHTML = html;

		// S�lection d'une valeur
		node.firstChild.value = value || "";
	},
	get_value : function(node, ev) {
		return node.firstChild.value;
	},
	focus : function(node) {
		var a = node.firstChild;if (a.select) a.select();a.focus();
	}
};

// Sections de l'�diteur d'�v�nements
scheduler.locale.labels.section_etudiant = "Etudiant";
scheduler.locale.labels.section_parrain = "R�f�rent";
scheduler.locale.labels.section_examinateur = "Examinateur";
scheduler.locale.labels.section_entreprise = "Entreprise";
scheduler.locale.labels.section_salle = "Salle";
scheduler.locale.labels.section_ahuisclos = "Huis clos";
scheduler.config.lightbox.sections = [
	{name:"etudiant", height:25, type:"textarea", map_to:"details"},
	{name:"parrain", height:25, type:"textarea", map_to:"parrain"},
	{name:"examinateur", height:25, type:"textarea", map_to:"examinateur"},
	{name:"entreprise", height:25, type:"textarea", map_to:"entreprise"},
	{name:"salle", height:25, type:"my_select", map_to:"idsalle", options:salles, focus:true},
	{name:"ahuisclos", height:25, type:"checkbox", checked_value:1, unchecked_value:0, map_to:"ahuisclos"},
	{name:"time", height:72, type:"time", map_to:"auto"}
];

// Zone de texte de l'�diteur en lecteur seule
scheduler.form_blocks.textarea.set_value=function(node,value,ev){
	node.firstChild.value = value || "";
	node.firstChild.disabled = true;
};

// S�lection d'une soutenance dans le planning
scheduler.attachEvent('onClick', function(event_id, native_event_object) {
	this.myDeselect(event_id);
	this.mySelect(event_id);
	tree.focusItem(this.getEvent(event_id).iditemtree);
	tree.selectItem(this.getEvent(event_id).iditemtree,true,false);
	return false;
});

// Titre de la bo�te d'�dition
scheduler.templates.lightbox_header = function(start, end, event){
	return "Modification de la soutenance";
};

// Fonction pour modifier l'apparence d'une soutenance s�lectionn�e
// Le premier argument est l'id de la soutenance recherch�e
scheduler.mySelect = function(idsoutenance) {
	if (scheduler.idSoutenanceAvant != null && scheduler.idSoutenanceAvant == idsoutenance) return;
	var divs = document.getElementsByTagName("div");
	for (var i = 0; i < divs.length; i++) {
		if (divs[i].getAttribute("event_id") == idsoutenance) {
			scheduler.idSoutenanceAvant = idsoutenance;
			scheduler.couleurAvant = divs[i].getElementsByClassName("dhx_title")[0].style.backgroundColor;
			divs[i].getElementsByClassName("dhx_title")[0].style.color = scheduler.couleurAvant;
			divs[i].getElementsByClassName("dhx_title")[0].style.backgroundColor = "#000000";
			return;
		}
	}
};

// Fonction pour modifier l'apparence d'une soutenance qui n'est plus s�lectionn�e
scheduler.myDeselect = function(event_id) {
	if (scheduler.idSoutenanceAvant != null && scheduler.idSoutenanceAvant != event_id) {
		var divs = document.getElementsByTagName("div");
		for (var i = 0; i < divs.length; i++) {
			if (divs[i].getAttribute("event_id") == scheduler.idSoutenanceAvant) {
				divs[i].getElementsByClassName("dhx_title")[0].style.color = "#000000";
				divs[i].getElementsByClassName("dhx_title")[0].style.backgroundColor = scheduler.couleurAvant;
				scheduler.idSoutenanceAvant = null;
				return;
			}
		}
	}
};

// Prise en compte des �v�nements en lecture seule
function block_readonly(id) {
	if (!id) return true;
	if (scheduler.getEvent(id).readonly) logger.setMessage("Soutenance non modifiable");
	return !scheduler.getEvent(id).readonly;
};
scheduler.attachEvent("onDblClick",block_readonly);

// Fonction pour interdire la cr�ation directe d'un �v�nement dans le planning
// et l'interdiction de d�placer une soutenance en lecture seule
scheduler.attachEvent("onBeforeDrag", function (event_id, mode, native_event_object) {
	// Calcul de la dur�e d'une soutenance de la filiere
	var idfiliere = this.getEvent(event_id).iditemtree.split('_')[1];
	var duree = getDureeSoutenanceFiliere(idfiliere);
	scheduler.config.event_duration = duree;

	if (mode == "create") {
		logger.setMessage("Seule la cr�ation d'une soutenance par drag & drop est autoris�e");
		return false;
	}
	return block_readonly(event_id);
});

var before;

scheduler.attachEvent("onBeforeLightbox",function(id) {
	var ev = scheduler.getEvent(id);
	before = [ev.start_date, ev.end_date];
	return true;
});

// Fonction pour v�rifier les contraintes apr�s modification par �dition
scheduler.attachEvent("onEventChanged",function(id) {
	if (!id) return true;
	var ev = scheduler.getEvent(id);

	if (!this.isConstraintsOK(ev)) {
		if (!before) return false;
		ev.start_date = before[0];
		ev.end_date = before[1];
		ev._timed = this.is_one_day_event(ev);
	} else {
		this.saveSoutenance(ev);
	}

	return true;
});

// Fonction pour v�rifier les contraintes apr�s modification par drag & drop
scheduler.attachEvent("onBeforeEventChanged",function(ev, e, is_new){
	return this.isConstraintsOK(ev);
});

// Fonction pour cr�er une soutenance par drag & drop d'une convention
scheduler.attachEvent("onExternalDragIn", function(id, source, e){
	var event = this.getEvent(id);

	// Interdire si la convention a d�j� une soutenance
	if (tree.getUserData(tree._dragged[0].id, "idsoutenance") != 0) {
		logger.setMessage("Une soutenance existe d�j� pour cette convention");
		return false;
	}

	// L'�tudiant
	event.text = "";
	event.details = tree.getItemText(tree._dragged[0].id);

	// Le lien avec l'arbre et la convention
	event.iditemtree = tree._dragged[0].id;
	event.idconvention = tree._dragged[0].id.split('_')[2];

	// Le r�f�rent
	event.parrain = tree.getUserData(tree._dragged[0].id, "nom_prenom_parrain");
	event.idparrain = tree.getUserData(tree._dragged[0].id, "idparrain");

	// Couleur de l'�v�nement = couleur du r�f�rent
	event.color = tree.getUserData(tree._dragged[0].id, "couleur_parrain");
	event.textColor = "#000000";

	// L'examinateur
	event.examinateur = tree.getUserData(tree._dragged[0].id, "nom_prenom_examinateur");
	event.idexaminateur = tree.getUserData(tree._dragged[0].id, "idexaminateur");

	// L'entreprise
	event.entreprise = tree.getUserData(tree._dragged[0].id, "nom_entreprise");
	event.idcontact = tree.getUserData(tree._dragged[0].id, "idcontact");

	// La salle : ne garder que les salles disponibles (voir l'�diteur sp�cifique)

	// L'heure de fin selon la filiere (voir la s�lection d'une convention dans l'arborescence)

	// Incr�mentation du nombre de soutenance
	logger.setNbSout(logger.getNbSout() + 1);

	// Si les contraintes de placement sont respect�es alors faire le lien avec l'arborescence
	if (this.isConstraintsOK(event)) {
		// Modification de l'arborescence
		tree.setUserData(tree._dragged[0].id, "idsoutenance", id);
		tree.setItemText(tree._dragged[0].id, "<i>" + tree.getItemText(tree._dragged[0].id) + "</i>");

		return true;
	}

	return false;
});

// Fonction pour sauvegarder en base apr�s cr�ation d'une soutenance
scheduler.attachEvent("onEventAdded", function(id, event) {
	this.saveSoutenance(event);
});

// Fonction pour v�rifier le respect des contraintes de placement d'une soutenance
scheduler.isConstraintsOK = function(sout) {
	// R�cup�rer tous les �v�nements ayant lieu durant la soutenance
	var evs = this.getEvents(sout.start_date, sout.end_date);

	// Flag pour savoir si la comparaison se fait avec elle-m�me
	var soutdejaplacee = false;

	// Parcours des �v�nements trouv�s et v�rification des contraintes
	for (var i = 0; i < evs.length; i++) {

		// La soutenance est-elle d�j� dans la liste des �v�nements
		soutdejaplacee = evs[i].id == sout.id;

		// Le r�f�rent est-il libre ?
		if (!soutdejaplacee && evs[i].idparrain == sout.idparrain || evs[i].idparrain == sout.idexaminateur) {
			logger.setMessage("Le r�f�rent n'est pas libre (" + sout.parrain + ")", true);
			return false;
		}

		// L'examinateur est-il libre ?
		if (!soutdejaplacee && evs[i].idexaminateur == sout.idexaminateur || evs[i].idexaminateur == sout.idparrain) {
			logger.setMessage("L'examinateur n'est pas libre (" + sout.examinateur + ")");
			return false;
		}

		// L'entreprise est-elle libre ?
		if (!soutdejaplacee && evs[i].idcontact == sout.idcontact) {
			logger.setMessage("Le contact n'est pas libre (" + sout.entreprise + ")");
			return false;
		}
	}

	// La dur�e est-elle correcte ?
	var duree_sout = (sout.end_date.getTime() - sout.start_date.getTime()) / 1000 / 60;
	if (duree_sout != scheduler.config.event_duration) {
		logger.setMessage("La dur�e est diff�rente de la dur�e normale (" + scheduler.config.event_duration + ")");
		return false;
	}

	// Une salle est-elle libre ?
	if (evs.length > salles.length && !soutdejaplacee) {
		logger.setMessage("Plus de salle disponible");
		return false;
	}

	return true;
};

// Fonction appell�e quand on annule la cr�ation (et l'�dition) d'une soutenance
scheduler.attachEvent("onEventCancel", function(event_id, is_new_event) {
	if (is_new_event) {
		// Retour � l'affichage original de l'arborescence
		tree.setUserData(tree.getSelectedItemId(), "idsoutenance", 0);
		tree.setItemText(tree.getSelectedItemId(), tree.getUserData(tree.getSelectedItemId(), "nom_prenom_etudiant"));

		// D�cr�menter une soutenance au compteur
		logger.setNbSout(logger.getNbSout() - 1);

		logger.setMessage("Cr�ation annul�e");
	}
});

// Fonction appel�e quand on supprime une soutenance
scheduler.attachEvent("onBeforeEventDelete", function(event_id) {
	// Retour � l'affichage original de l'arborescence
	tree.setUserData(tree.getSelectedItemId(), "idsoutenance", 0);
	tree.setItemText(tree.getSelectedItemId(), tree.getUserData(tree.getSelectedItemId(), "nom_prenom_etudiant"));

	// D�cr�menter une soutenance au compteur
	logger.setNbSout(logger.getNbSout() - 1);

	// Suppression en base
	this.deleteSoutenance(this.getEvent(event_id));

	return true;
});

// Fonction pour modifier le planning selon l'ann�e s�lectionn�e
scheduler.loadPlanning = function(annee) {
	var dates = {};
	var dates_request = new XMLHttpRequest();
	dates_request.open("GET", 'getDatesJSON.php?annee=' + annee, true);
	dates_request.onreadystatechange = function() {
		if (dates_request.readyState == 4 && dates_request.status == 200) {
			// On repart de l'ent�te par d�faut
			scheduler.do_default_dhx_cal_navline();
			// On ajoute les tabulations
			if (dates_request.responseText != '') {
				// R�cup�ration des dates
				dates = JSON.parse(dates_request.responseText);

				// Cr�ation des vues
				var dhx_cal_navline = document.getElementById('identpourajax');
				var taille = 50;
				for (var i=0; i < dates.length; i++) {
					dhx_cal_navline.innerHTML += "<div class='dhx_cal_tab' name='" + dates[i].nom +  "_tab' style='left:" + taille + "px;'></div>";

					eval( 'scheduler.locale.labels.' + dates[i].nom + '_tab = "' + dates[i].nom + '"' ) ;
					eval( 'scheduler.date.' + dates[i].nom + '_start = function(date) { return new Date("' + dates[i].annee + '", "' + dates[i].mois + '", "' + dates[i].jour + '"); }' );
					eval( 'scheduler.date.get_' + dates[i].nom + '_end = function(date) { return scheduler.date.add(date, ' + dates[i].duree + ', "day"); }' );
					eval( 'scheduler.date.add_' + dates[i].nom + ' = function(date, inc) { return null; }' );
					eval( 'scheduler.templates.' + dates[i].nom + '_date = scheduler.templates.week_date' );
					eval( 'scheduler.templates.' + dates[i].nom + '_scale_date = scheduler.templates.week_scale_date' );

					taille += 64;
				}
				// Chargement du nouveau planning
				scheduler.init('dhtmlxscheduler', null, dates[0].nom);
				scheduler.load('getDataSoutenancesXML.php?annee=' + annee);
			} else {
				// Re-chargement du planning
				scheduler.init('dhtmlxscheduler', null, "week");
			}
		}
	}
	dates_request.send();
};

// Calcul des attributs � s�rialiser
scheduler.data_attributes = function(){
	var attrs = [];
	var format = scheduler.templates.xml_format;
	for (var a in this._events) {
		var ev = this._events[a];
		for (var name in ev)
			if (name.substr(0,1) !="_" && name != "text")
				attrs.push([name,((name == "start_date" || name == "end_date")?format:null)]);
		break;
	}
	return attrs;
};

// S�rialisation d'un �v�nement en cha�ne JSON
scheduler.toJSON = function(ev) {
	var json = [];
	var line = [];
	var attrs = this.data_attributes();
	for (var i=0; i < attrs.length; i++)
		line.push(' "' + attrs[i][0] + '":"' + ((attrs[i][1] ? attrs[i][1](ev[attrs[i][0]]) : ev[attrs[i][0]]) || "" ).toString().replace(/\n/g," ") + '" ');
	return "{" + line.join(",") + "}";
};

// Fonction de sauvegarde en base d'une soutenance
scheduler.saveSoutenance = function(ev) {
	var event = ev;
	var save_sout_request = new XMLHttpRequest();
	save_sout_request.open("POST", "setSoutenanceJSON.php", true);
	save_sout_request.setRequestHeader("Content-type", "application/json");
	save_sout_request.onreadystatechange = function() {
		if (save_sout_request.readyState == 4 && save_sout_request.status == 200) {
			if (save_sout_request.responseText != '' && save_sout_request.responseText != 0) {
				// Modification de l'id de l'�v�nement = id de la base
				scheduler.changeEventId(event.id, save_sout_request.responseText);
				scheduler.idSoutenanceAvant = save_sout_request.responseText;
				tree.setUserData(event.iditemtree, "idsoutenance", save_sout_request.responseText);

				logger.setMessage("Soutenance sauvegard�e");
			} else {
			    logger.setMessage("Probl�me cr�ation soutenance en base");
			    scheduler.deleteEvent(event.id);
			}
		}
	}
	save_sout_request.send(this.toJSON(ev));
};

// Fonction de suppression en base d'une soutenance
scheduler.deleteSoutenance = function(ev) {
	var event = ev;
	var del_sout_request = new XMLHttpRequest();
	del_sout_request.open("POST", "delSoutenanceJSON.php", true);
	del_sout_request.setRequestHeader("Content-type", "application/json");
	del_sout_request.onreadystatechange = function() {
		if (del_sout_request.readyState == 4 && del_sout_request.status == 200) {
			if (del_sout_request.responseText == "OK") {
				logger.setMessage("Soutenance supprim�e");
			}
		}
	}
	del_sout_request.send(this.toJSON(ev));
};

// Affichage par d�faut du planning
scheduler.init('dhtmlxscheduler',null,'week');

// ------------------------------------------------------------------------------------------

// La s�lection de l'ann�e entra�ne la modification de l'arborescence et du planning
// Surcharge de la fonction d�finie dans la classe LoadData
LoadData.prototype.load = function() {
	var annee = document.getElementById('annee').value;
	tree.deleteChildItems(0);
	logger.reset();
	if (annee != '') {
		tree.loadXML('getDataConventionsXML.php?annee=' + annee);
		scheduler.loadPlanning(annee);
	} else {
		scheduler.do_default_dhx_cal_navline(document.getElementById('identpourajax'));
		scheduler.clearAll();
		scheduler.init('dhtmlxscheduler',null,'week');
	}
};