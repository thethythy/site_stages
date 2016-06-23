<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");
include_once($chemin . "moteur/FiltreString.php");

include_once($chemin . "ihm/Etudiant_IHM.php");
include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Contact_BDD.php");
include_once($chemin . "moteur/Contact.php");

include_once($chemin . "bdd/Convention_BDD.php");
include_once($chemin . "moteur/Convention.php");

include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

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

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Si une recherche a été effectuée
if ((isset($_POST['rech'])) || (isset($_GET['id']))) {
    $annee = $_POST['annee'];
    $parcours = $_POST['parcours'];
    $filiere = $_POST['filiere'];
} else {
    if (!isset($_POST['annee']))
	$annee = Promotion_BDD::getLastAnnee();
    else
	$annee = $_POST['annee'];

    if (!isset($_POST['parcours'])) {
	$tabParcours = Parcours::listerParcours();
	$parcours = $tabParcours[0]->getIdentifiantBDD();
    } else
	$parcours = $_POST['parcours'];

    if (!isset($_POST['filiere'])) {
	$tabFilieres = Filiere::listerFilieres();
	$filiere = $tabFilieres[0]->getIdentifiantBDD();
    } else
	$filiere = $_POST['filiere'];
}

$filtres = array();
array_push($filtres, new FiltreString("anneeuniversitaire", $annee));
array_push($filtres, new FiltreString("idparcours", $parcours));
array_push($filtres, new FiltreString("idfiliere", $filiere));

$nbFiltres = sizeof($filtres);
$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
    // Récupération des étudiants n'ayant pas de convention
    $tabEtuSansConv = array();

    for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
	if ($tabEtudiants[$i]->getConvention($annee) == null)
	    array_push($tabEtuSansConv, $tabEtudiants[$i]);
    }

    // Affichage des étudiants sans conventions
    Etudiant_IHM::afficherListeEtudiantsSansConventions($tabPromos[0][0], $tabEtuSansConv);

} else {
    echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.<br/></center>";
}

?>