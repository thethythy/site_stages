
/**
* Script statistiques.js
* Utilisation : incorporé à statistiquesStages.php
*		 création puis envoi des requêtes Ajax traitées par statistiquesStagesData.php
*		 mise en forme et affichage des réponses
*/

/* global LoadData, Chart */

Chart.defaults.global.legend.display = false;

// -----------------------------------------------------------------------------
// Création des éléments de la vue

var donneNomsSeries = function(data) {
  var nom_series = "";

  if (data['nbSerie'] === 1) {
    nom_series = '_' + data['s1']['filiere'] + '-' + data['s1']['parcours'];
  }
  else
  for (var i = 1; i < data['nbSerie']; i++) {
    var filiere_parcours = data['s'+i]['filiere'] + '-' + data['s'+i]['parcours'];
    if (-1 === nom_series.indexOf(filiere_parcours)) {
      nom_series += '_' + filiere_parcours;
    }
  }

  return nom_series;
};

var afficherNomPromotions = function(data, padding) {
  var promotions = "<br/>";

  for (var i = 1; i <= data['nbSerie']; i++) {
    var annee_deb = data["s"+i]["annee"];
    var annee_fin = annee_deb + 1;
    var periode = " " + annee_deb + "-" + annee_fin;
    if (annee_deb === '')
    periode = '';
    var nom = data["s"+i]['filiere'] + " "+ data["s"+i]['parcours'] + periode;

    if (i === 1) {
      promotions += "<section id='section_gauche'><h2 style='color:LightSkyBlue'>" + nom + "</h2></section>";
    } else {
      if (i === data['nbSerie']) {
        promotions += "<section id='section_droite' style='margin-left:" + padding + "px'><h2 style='color:LightSkyBlue'>" + nom + "</h2></section>";
      } else {
        promotions += "<section id='section_centre' style='margin-left:" + padding + "px'><h2 style='color:LightSkyBlue'>" + nom + "</h2></section>";
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

var afficherLegendeCanvas = function(nom, prefixe, data, taille, padding) {
  var element = "";

  element += "<p style='font-size:16px;font-weight: bold;color:grey'>" + nom + "</p>";

  for (var i = 1; i <= data['nbSerie']; i++) {
    if (i === 1) {
      element += "<section id='section_gauche'>";
    } else {
      if (i === data['nbSerie']) {
        element += "<section id='section_droite' style='margin-left:" + padding + "px'>";
      } else {
        element += "<section id='section_centre' style='margin-left:" + padding + "px'>";
      }
    }

    element += afficheTable(prefixe, data["s"+i][nom]);
    element += "</br>";
    element += "<canvas id=" + donneNomCanvas(prefixe, data, i) + " width=" + taille + " height="+ taille +"></canvas>";
    element += "</br>";
    element += "</section>";
  }

  return element;
};

// -----------------------------------------------------------------------------
// Création de la vue

var createView = function(data) {
  var element = document.getElementById("data");
  var taille = 150;
  element.innerHTML = "";

  // Ecart entre séries
  var padding = 0;
  if (data['nbSerie'] > 1)
  padding = (1024 - taille * data['nbSerie']) / (data['nbSerie'] - 1);

  // Lien vers le fichier
  var annee_deb = data['annee_deb'];
  var annee_fin = data['annee_fin'] + 1;
  var periode = annee_deb + "-" + annee_fin;
  var nom_fichier = "statistiques_" + periode + donneNomsSeries(data) + ".xlsx";
  element.innerHTML += "<a href=http://info-stages.univ-lemans.fr/documents/statistiques/"+nom_fichier+">Lien sur le fichier Excel</a><br/>";

  // Afficher les titres
  element.innerHTML += "<br/><p style='font-size: 24px;font-weight:bold;color:#910'>P&eacute;riode " + periode + "</p>";
  element.innerHTML += afficherNomPromotions(data, padding);

  // Canvas partie 'Lieu du stage'
  element.innerHTML += "<div style='border-bottom : 1px solid #555;padding-bottom:10px'>";
  element.innerHTML += afficherLegendeCanvas('Lieu du stage', "l", data, taille, padding);
  element.innerHTML += "</div>";

  // Canvas partie 'Thème de stage'
  element.innerHTML += "<div style='border-bottom : 1px solid #555;padding-bottom:10px'>";
  element.innerHTML += afficherLegendeCanvas('Thème du stage', "t", data, taille, padding);
  element.innerHTML += "</div>";

  // Canvas partie 'Type d'entreprise'
  element.innerHTML += "<div style='border-bottom : 1px solid #555;padding-bottom:10px'>";
  element.innerHTML += afficherLegendeCanvas("Type d'entreprise", "e", data, taille, padding);
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

var loadData = function(annee_deb, annee_fin, filiere, parcours, offre) {
  var data_request = new XMLHttpRequest();
  data_request.open('GET', 'statistiquesStagesData.php?annee_deb=' + annee_deb + '&annee_fin=' + annee_fin +'&filiere=' + filiere + '&parcours=' + parcours + '&offre=' + offre, true);
  data_request.setRequestHeader('Content-type', 'application/json; charset=utf-8');
  data_request.onreadystatechange = function () {
    if (data_request.readyState === 4 && data_request.status === 200) {
      if (data_request.responseText !== '') {
        // Récupération des données
        console.log(data_request.responseText);

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
  var annee_deb = document.getElementById('annee_deb').value;
  var annee_fin = document.getElementById('annee_fin').value;
  var filiere = document.getElementById('filiere').value;
  var parcours = document.getElementById('parcours').value;
  var offre = document.getElementById('offre').value;

  if (annee_deb !== '' && annee_fin !== '') {
    if (annee_deb > annee_fin) {
      var temp = annee_deb;
      annee_deb = annee_fin;
      annee_fin = temp;
    }

    if (filiere !== '' && parcours !== '') {
      loadData(annee_deb, annee_fin, filiere, parcours, offre);
    }
  }
};

