<?php

/**
 * Page saisirNotesData.php
 * Utilisation : page retournant un tableau d'édition des notes de soutenances
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Prise en compte des paramètres
$filtres = array();

if (!isset($_POST['annee']))
    $annee = Promotion_BDD::getLastAnnee();
else
    $annee = $_POST['annee'];

array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));

if (isset($_POST['parcours']) && $_POST['parcours'] != '*' && $_POST['parcours'] != '') {
    $parcours = $_POST['parcours'];
    array_push($filtres, new FiltreNumeric("idparcours", $parcours));
}

if (isset($_POST['filiere']) && $_POST['filiere'] != '*' && $_POST['filiere'] != '') {
    $filiere = $_POST['filiere'];
    array_push($filtres, new FiltreNumeric("idfiliere", $filiere));
}

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {

    // Récupération des étudiants ayant une convention
    $tabEtu = array();
    for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
	if ($tabEtudiants[$i]->getConvention($annee) != null)
	    array_push($tabEtu, $tabEtudiants[$i]);
	if ($tabEtudiants[$i]->getContrat($annee) != null)
	    array_push($tabEtu, $tabEtudiants[$i]);
    }

    // Si il y a au moins un étudiant avec une convention
    if (sizeof($tabEtu) > 0) {
	// Affichage des notes des étudiants
	Stage_IHM::afficherListeNotes($annee, $parcours, $filiere, $tabEtu, "saisirNotes.php");
    } else {
	echo "<br/><center>Aucune convention ou contrat  n'a été trouvée.</center><br/>";
    }
} else {
    echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.</center><br/>";
}

?>