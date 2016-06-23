<?php

$chemin = "../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");

include_once($chemin . "ihm/SujetDeStage_IHM.php");
include_once($chemin . "bdd/SujetDeStage_BDD.php");
include_once($chemin . "moteur/SujetDeStage.php");

include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

if (!headers_sent())
    header("Content-type:text/html; charset=utf-8");

$filtres = array();

// Si pas d'année sélectionnée
if (!isset($_POST['annee']))
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", Promotion_BDD::getLastAnnee()));

// Si une recherche sur l'année est demandée
if (isset($_POST['annee']) && $_POST['annee'] != "")
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));

// Si une recherche sur le parcours est demandé
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);

if (sizeof($tabEtudiants) > 0)
    SujetDeStage_IHM::afficherDemandeValidation($tabEtudiants);
else {
    ?>
    <br/>
    <p>Aucun étudiant ne correspond aux critères de recherche.</p>
    <br/>
    <?php
}

?>