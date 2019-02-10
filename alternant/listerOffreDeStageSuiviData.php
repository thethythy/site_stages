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

    $offre = "";
    // if (!isset($_POST['offre'])) {
    //     $offre = "";
    // } else {
    //     $offre = $_POST['offre'];
    // }
    // $filtreOffre = new FiltreNumeric("offre", $offre);

  $tabE = OffreDAlternance::getListeOffreDAlternance($offre);
  OffreDAlternance_IHM::afficherListeOffresSuivi($tabE);




?>
