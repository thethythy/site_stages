<?php

/**
 * Page gestionClef.php
 * Utilisation : page de gestion de la clé d'accès aux parties privées
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// ----------------------------------------------------------------------------
// Contrôleur
if (isset($_POST['genere']) && isset($_POST['clef']) && $_POST['clef'] != '') {
    // Génère le condensat
    $HClef = Clef::calculCondensat($_POST['clef']);

    // Récupérer la valeur du bouton coché : Stagiaire ou Alternant
    $type_etudiant = $_POST['type'];


    // Sauvegarde sur fichier le condensat
    $f = json_decode(file_get_contents('../../documents/demon/clef.json'), true);
    $f[$type_etudiant] = $HClef;
    $f = json_encode($f);
    file_put_contents('../../documents/demon/clef.json', $f);

}

// Récupérer le condensat de la clef
$f = fopen('../../documents/demon/clef_stagiaire', 'r');
$HClef = fread($f, 100);
fclose($f);

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');

IHM_Generale::header("Gestion de la", "clef d'accès", "../../", $tabLiens, "auchargement");

// Vérification de la période pour exécuter cette page
$mois = date('n');

if ($mois == 9 || $mois == 10 || $mois == 1) { // Il faut être entre le 1/09 et le 31/10
    // Afficher formulaire pour définir une clef
    Clef_IHM::afficherFormulaireDefinitionClef($HClef);
} else {
    // Afficher un message d'erreur
    IHM_Generale::erreur("Cette fonctionnalité n'est accessible que durant le mois de septembre et le mois d'octobre.");
    // Afficher un rappel de la clé actuelle
    Clef_IHM::afficherClef($HClef);
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>
