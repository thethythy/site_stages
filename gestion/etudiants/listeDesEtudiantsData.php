<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");

include_once($chemin . "ihm/Etudiant_IHM.php");
include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

$filtres = array();

// Si pas d'année sélectionnée
if (!isset($_POST['annee'])) {
    $annee = Promotion_BDD::getLastAnnee();
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
} else {
    $annee = $_POST['annee'];
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));
}

if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
    // Si il y a au moins un étudiant
    if (sizeof($tabEtudiants) > 0) {
	// Affichage des étudiants correspondants aux critères de recherches
	Etudiant_IHM::afficherListeEtudiants($annee, $tabEtudiants);
    } else {
	echo "<br/><center>Aucun étudiant n'a été trouvé.</center><br/>";
    }
} else {
    echo "<br/><center>Aucune promotion ne correspond aux critères de recherche.</center><br/>";
}
?>