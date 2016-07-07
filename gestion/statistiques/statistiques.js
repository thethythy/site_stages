/* global LoadData, Chart */

Chart.defaults.global.legend.display = false;

// -----------------------------------------------------------------------------
// Création des éléments de la vue

var afficherNomPromotions = function(data) {
    var promotions = "";

    for (var i = 1; i <= data['nbSerie']; i++) {
	var nom = data["s"+i]['filiere'] + " "+ data["s"+i]['parcours'];

	if (i === 1) {
	    promotions += "<section id='section_gauche'><h2 style='color:LightSkyBlue'>" + nom + "</h2></section>";
	} else {
	    if (i === data['nbSerie']) {
		promotions += "<section style='padding-left:7%' id='section_droite'><h2 style='color:LightSkyBlue'>" + nom + "</h2></section>";
	    } else {
		promotions += "<section style='padding-left:7%' id='section_centre'><h2 style='color:LightSkyBlue'>" + nom + "</h2></section>";
	    }
	}
    }

    return promotions;
};

var donneNomCanvas = function(prefixe, data, i) {
    return prefixe.toUpperCase() + data["s"+i]['filiere'] + data["s"+i]['parcours'] + "S" + i;
};

var afficheTable = function(prefixe, data) {
    var somme = data['somme'];
    var tableLieu = "<table>";

    var taille = 0;
    if (prefixe === "l")
	taille = data['nbLieu'];
    if (prefixe === "t")
	taille = data['nbTheme'];
    if (prefixe === "e")
	taille = data['nbType'];

    for (var i = 1; i <= taille; i++) {
	tableLieu += "<tr>";
	tableLieu += "<td bgcolor=" + data[prefixe+i]['couleur'] + "></td>";
	tableLieu += "<td > " + data[prefixe+i]['nom'] + " </td>";
	tableLieu += "<td>" + Math.round(data[prefixe+i]['nombre'] / somme * 100) + " %</td>";
	tableLieu += "</tr>";
    }

    return tableLieu + "</table>";
};

var donneData = function(prefixe, data) {
    var somme = data['somme'];

    var taille = 0;
    if (prefixe === "l")
	taille = data['nbLieu'];
    if (prefixe === "t")
	taille = data['nbTheme'];
    if (prefixe === "e")
	taille = data['nbType'];

    var labels = [];
    var backgroundColor = [];
    var dataSet = [];

    for (var i = 1; i <= taille; i++) {
	labels.push(data[prefixe+i]['nom'] + " : " + Math.round(data[prefixe+i]['nombre'] / somme * 100) + " %");
	dataSet.push(data[prefixe+i]['nombre']);
	backgroundColor.push(data[prefixe+i]['couleur']);
    }

    return {labels: labels, datasets: [ { data: dataSet, backgroundColor: backgroundColor } ]};
};

var afficherLegendeCanvas = function(nom, prefixe, data, taille) {
    var element = "";

    element += "<p style='font-size:16px;font-weight: bold;color:grey'>" + nom + "</p>";

    for (var i = 1; i <= data['nbSerie']; i++) {
	if (i === 1) {
	    element += "<section id='section_gauche'>";
	} else {
	    if (i === data['nbSerie']) {
		element += "<section id='section_droite'>";
	    } else {
		element += "<section id='section_centre'>";
	    }
	}

	element += afficheTable(prefixe, data["s"+i][nom]);
	element += "</br></br>";
	element += "<canvas id=" + donneNomCanvas(prefixe, data, i) + " width=" + taille + " height="+ taille +"></canvas>";
	element += "</section>";
    }

    return element;
};

// -----------------------------------------------------------------------------
// Création de la vue

var createView = function(data) {
    var element = document.getElementById("data");
    var taille = 192;
    element.innerHTML = "";

    var annee = data['annee'];
    element.innerHTML += "<br/><p style='font-size: 24px;font-weight:bold;color:#910'>Ann&eacute;e " + annee + "-" + (annee + 1) + "</p>";
    element.innerHTML += afficherNomPromotions(data);

    // Canvas partie 'Lieu du stage'
    element.innerHTML += "<div style='border-bottom : 1px solid #555;padding-bottom:10px'>";
    element.innerHTML += afficherLegendeCanvas('Lieu du stage', "l", data, taille);
    element.innerHTML += "</div>";

    // Canvas partie 'Thème de stage'
    element.innerHTML += "<div style='border-bottom : 1px solid #555;padding-bottom:10px'>";
    element.innerHTML += afficherLegendeCanvas('Thème du stage', "t", data, taille);
    element.innerHTML += "</div>";

    // Canvas partie 'Type d'entreprise'
    element.innerHTML += "<div style='border-bottom : 1px solid #555;padding-bottom:10px'>";
    element.innerHTML += afficherLegendeCanvas("Type d'entreprise", "e", data, taille);
    element.innerHTML += "</div>";

    // Créer les graphiques
    for (var i = 1; i <= data['nbSerie']; i++ ) {
	var ctx = document.getElementById(donneNomCanvas("l", data, i)).getContext("2d");
	var dataLieu = donneData("l", data["s"+i]['Lieu du stage']);
	new Chart(ctx, { type: "doughnut", data: dataLieu, animation:{ animateScale:true } });

	ctx = document.getElementById(donneNomCanvas("t", data, i)).getContext("2d");
	var dataTheme = donneData("t", data["s"+i]['Thème du stage']);
	new Chart(ctx, { type: "doughnut", data: dataTheme, animation:{ animateScale:true } });

	ctx = document.getElementById(donneNomCanvas("e", data, i)).getContext("2d");
	var dataType = donneData("e", data["s"+i]["Type d'entreprise"]);
	new Chart(ctx, { type: "doughnut", data: dataType, animation:{ animateScale:true } });
    }

};

// -----------------------------------------------------------------------------
// Requête Ajax

var loadData = function(annee, filiere, parcours) {
    var data_request = new XMLHttpRequest();
    data_request.open('GET', 'statistiquesStagesData.php?annee=' + annee + '&filiere=' + filiere + '&parcours=' + parcours, true);
    data_request.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    data_request.onreadystatechange = function () {
	if (data_request.readyState === 4 && data_request.status === 200) {
	    if (data_request.responseText !== '') {
		// Récupération des données
		data = JSON.parse(data_request.responseText);
		// Création des vues
		createView(data);
		document.getElementById("content-wrap").style.cursor = 'default';
	    } else {
		// Pas de réponse
		document.getElementById('data').innerHTML = 'Aucune donnée reçue du serveur !';
		document.getElementById("content-wrap").style.cursor = 'default';
	    }
	}
    };
    document.getElementById("content-wrap").style.cursor = 'progress';
    data_request.send();
};

// -----------------------------------------------------------------------------
// La sélection de l'année/filière/parcours entraîne la modification des données
// Surcharge de la fonction définie dans la classe LoadData

LoadData.prototype.load = function() {
    var annee = document.getElementById('annee').value;
    var filiere = document.getElementById('filiere').value;
    var parcours = document.getElementById('parcours').value;
    if (annee !== '' && filiere !== '' && parcours !== '') {
	loadData(annee, filiere, parcours);
    }
};

