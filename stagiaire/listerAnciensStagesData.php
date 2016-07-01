<?php

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$chemin = "../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");

include_once($chemin . "ihm/Stage_IHM.php");

include_once($chemin . "bdd/Contact_BDD.php");
include_once($chemin . "moteur/Contact.php");

include_once($chemin . "bdd/Convention_BDD.php");
include_once($chemin . "moteur/Convention.php");

include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Parrain_BDD.php");
include_once($chemin . "moteur/Parrain.php");

include_once($chemin . "bdd/Soutenance_BDD.php");
include_once($chemin . "moteur/Soutenance.php");

if (!headers_sent())
    header("Content-type:text/html; charset=utf-8");

$filtres = array();

// Si pas d'année sélectionnée
if (!isset($_POST['annee'])) {
    $annee = Promotion_BDD::getLastAnnee();
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
}

// Si une recherche sur l'année est demandée
if (isset($_POST['annee']) && $_POST['annee'] != "") {
    $annee = $_POST['annee'];
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
}

// Si une recherche sur le parcours est demandée
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

$filtre = $filtres[0];
for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
    // Récupération des étudiants ayant une convention
    $tabEtuWithConv = array();
    for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
	if ($tabEtudiants[$i]->getConvention($annee) != null)
	    array_push($tabEtuWithConv, $tabEtudiants[$i]);
    }

    // Si il y a au moins un étudiant avec une convention
    if (sizeof($tabEtuWithConv) > 0) {
	// Affichage des stages des étudiants
	Stage_IHM::afficherListeAncienStages($tabEtuWithConv, $annee);
    } else {
	echo "Aucun stage n'a été trouvé.";
    }
} else {
    echo "Aucune promotion ne correspond à ces critères de recherche.";
}

?>