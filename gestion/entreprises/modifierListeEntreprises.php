<?php

/**
 * Page modifierListeEntreprises.php
 * Utilisation : page pour modifier ou supprimer une entreprise parmi une liste filtrée
 * Dépendance(s) : modifierListeEntreprisesData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/Supprimer une", "entreprise", "../../", $tabLiens);

// ----------------------------------------------------------------------------
// Contrôleur

if (isset($_GET['id'])) {
    // Nécessaire pour que dans le formulaire de recherche, on resélectionne les valeurs précédement sélectionnées
    $_POST['nom'] = $_GET['nom'];
    $_POST['cp'] = $_GET['cp'];
    $_POST['ville'] = $_GET['ville'];
    $_POST['pays'] = $_GET['pays'];

    // Suppression de l'entreprise
    Entreprise::supprimerEntreprise($_GET['id']);
}

// ----------------------------------------------------------------------------
// Affichage

Entreprise_IHM::afficherFormulaireRecherche("modifierListeEntreprisesData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("modifierListeEntreprisesData.php");
echo "\n</div>";

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>