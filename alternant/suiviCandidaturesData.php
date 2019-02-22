<?php

/**
* Page SuiviCandidaturesData.php
* Utilisation : page de traitement Ajax retournant un formulaire de dépôt
* Accès : restreint par cookie
*/


$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

if (!headers_sent())
  header("Content-type: text/html; charset=utf-8");


/* TRAITEMENT DE LA REQUÊTE AJAX */
if(isset($_POST))


$filtresEtu = array();
$filtresOffres = array();

// Si pas d'ann�e s�lectionn�e
if (!isset($_POST['annee'])) {
  $annee = Promotion_BDD::getLastAnnee();
} else {
  $annee = $_POST['annee'];
}
array_push($filtresEtu, new FiltreNumeric("anneeuniversitaire", $annee));

// Si une recherche sur le parcours est demand�
if (!isset($_POST['parcours'])) {
  $tabParcours = Parcours::listerParcours();
  $parcours = $tabParcours[0]->getIdentifiantBDD();
} else {
  $parcours = $_POST['parcours'];
}
array_push($filtresEtu, new FiltreNumeric("idparcours", $parcours));
array_push($filtresOffres, new FiltreNumeric("idparcours", $parcours));

// Si une recherche sur la filiere est demand�e
if (!isset($_POST['filiere'])) {
  $tabFilieres = Filiere::listerFilieres();
  $filiere = $tabFilieres[0]->getIdentifiantBDD();
} else {
  $filiere = $_POST['filiere'];
}
array_push($filtresEtu, new FiltreNumeric("idfiliere", $filiere));
array_push($filtresOffres, new FiltreNumeric("idfiliere", $filiere));

$filtreEtu = $filtresEtu[0];

for ($i = 1; $i < sizeof($filtresEtu); $i++)
$filtreEtu = new Filtre($filtreEtu, $filtresEtu[$i], "AND");

$tabEtu = Promotion::listerEtudiants($filtreEtu);

$filtreOffres = $filtresOffres[0];
for ($i = 1; $i < sizeof($filtresOffres); $i++)
$filtreOffres = new Filtre($filtreOffres, $filtresOffres[$i], "AND");

?>
<script>

function jsonParse(text) {
        console.log(text);
        try {
            var json = JSON.parse(text);
            console.log(json);
        }
        catch(e) {
            return false;
        }
        return json;
    }

function postForm(){



  var id_etu = document.getElementById('idEtudiant').value;
  console.log(id_etu);
  var idEntreprises = document.querySelectorAll('[id^="idEntreprise-"]');
  var idOffres = document.querySelectorAll('[id^="idOffre-"]');
  var idStatuts = document.querySelectorAll('[id^="idStatut-"]');
  var entreprises = [];
  var offres = [];
  var statuts = [];
  var urlEncodeData = 'idetudiant='+id_etu;

  for(var i = 0; i < idEntreprises.length; i++){
    entreprises.push(idEntreprises[i].id);
    entreprises[i] = (entreprises[i].split('-'))[1];

    offres.push(idOffres[i].id);
    offres[i] = (offres[i].split('-'))[1];

    statuts.push(idStatuts[i].id);
    statuts[i] = (statuts[i].split('-'))[1];

    urlEncodeData = urlEncodeData
    + '&' + 'identreprise' + i + '=' + entreprises[i]
    + '&' + 'idoffre'      + i + '=' + offres[i]
    + '&' + 'idstatut'     + i + '=' + statuts[i];
  }

  //Remplacer les espaces, ormalement il n'y en a pas mais au cas où
  urlEncodeData = urlEncodeData.replace(/%20/g, '+');
  xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var json = jsonParse(this.responseText);
            console.log(!json);
            console.log(json.requestStatus);
            if (!json || json.requestStatus !== true) {
                console.log(json.error || 'Something Bad Happened');
                return;
            }
            alert('Is working');
        }
    }

  xhr.open('POST', 'suiviCandidaturesHandler.php', true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(urlEncodeData);
}
</script>
<?php



if (sizeof($tabEtu) == 0){

  echo 'Aucun étudiant ne correspond à cette recherche.';


} else {
  OffreDAlternance_IHM::afficherFormulaireSuivi($tabEtu, $annee, $parcours, $filiere,"listerOffreDeStageSuiviData.php");

  echo "<div id='data1'>\n";
  $tabO = OffreDAlternance::getListeOffreDAlternance($filtreOffres);
  OffreDAlternance_IHM::afficherListeOffresSuivi($tabO);
  echo "\n</div>";

}
?>
