<?php

/**
 * Page listerOffreDeStageData.php
 * Utilisation : page de traitement Ajax retournant un tableau des offres
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

$filtres = array();

// Si une recherche sur le nom de l'entreprise est demandée
if (isset($_POST['nom']) && $_POST['nom'] != "")
    array_push($filtres, new FiltreString("nom", "%" . $_POST['nom'] . "%"));

// Si une recherche sur le code postal est demandée
if (isset($_POST['cp']) && $_POST['cp'] != "")
    array_push($filtres, new FiltreString("codepostal", $_POST['cp'] . "%"));

// Si une recherche sur la ville est demandée
if (isset($_POST['ville']) && $_POST['ville'] != "")
    array_push($filtres, new FiltreString("ville", $_POST['ville'] . "%"));

// Si une recherche sur le pays est demandée
if (isset($_POST['pays']) && $_POST['pays'] != "")
    array_push($filtres, new FiltreString("pays", $_POST['pays'] . "%"));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

// Si une recherche sur le parcours est demandée
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

// Si une recherche sur la competence est demandée
if (isset($_POST['competence']) && $_POST['competence'] != '*')
    array_push($filtres, new FiltreNumeric("idcompetence", $_POST['competence']));

// Si une recherche sur la duree est demandée
if (isset($_POST['duree']) && $_POST['duree'] != '*') {
    array_push($filtres, new FiltreInferieur("dureemin", $_POST['duree']));
    array_push($filtres, new FiltreSuperieur("dureemax", $_POST['duree']));
}

// Ajout d'un filtre pour limiter aux promotions de l'année en cours
$filtrePromo = array();

$annee = Promotion_BDD::getLastAnnee();
array_push ($filtrePromo, new FiltreNumeric("anneeuniversitaire", $annee));

if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtrePromo, new FiltreNumeric("idfiliere", $_POST['filiere']));

if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtrePromo, new FiltreNumeric("idparcours", $_POST['parcours']));

$filtre = $filtrePromo[0];
for ($i = 1; $i < sizeof($filtrePromo); $i++)
    $filtre = new Filtre($filtre, $filtrePromo[$i], "AND");

$oPromotions = Promotion::listerPromotions($filtre);
if (sizeof($oPromotions) > 0) {
    $filtre = new FiltreNumeric("idpromotion", $oPromotions[0]->getIdentifiantBDD());
    for ($i = 1; $i < sizeof($oPromotions); $i++)
        $filtre = new Filtre($filtre, new FiltreNumeric("idpromotion", $oPromotions[$i]->getIdentifiantBDD()), "OR");
    array_push($filtres, $filtre);
}

// Construction du filtre final

$nbFiltres = sizeof($filtres);

if ($nbFiltres >= 2) {
    $filtre = $filtres[0];
    for ($i = 1; $i < sizeof($filtres); $i++)
	    $filtre = new Filtre($filtre, $filtres[$i], "AND");
} else if ($nbFiltres == 1) {
    $filtre = $filtres[0];
} else {
    $filtre = "";
}

$tabOffreDeStages = OffreDeStage::getListeOffreDeStage($filtre);

// Si il y a au moins une offre de stage
if (sizeof($tabOffreDeStages) > 0) {
    OffreDeStage_IHM::afficherListeOffres($tabOffreDeStages);
} else {
    ?>
    <br/>
	<p>Aucune offre de stage ne correspond aux critères de recherche.</p>
    <br/>
    <?php
}

?>
