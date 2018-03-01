<?php

/**
 * Page modifierListeEntreprises.php
 * Utilisation : page pour modifier ou supprimer une entreprise parmi une liste
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/Supprimer une", "entreprise", "../../", $tabLiens);

if (isset($_GET['id'])) {
    // Nécessaire pour que dans le formulaire de recherche, on resélectionne les valeurs précédement sélectionnées
    $_POST['nom'] = $_GET['nom'];
    $_POST['cp'] = $_GET['cp'];
    $_POST['ville'] = $_GET['ville'];
    $_POST['pays'] = $_GET['pays'];

    // Suppression de l'entreprise
    Entreprise::supprimerEntreprise($_GET['id']);
}

Entreprise_IHM::afficherFormulaireRecherche("modifierListeEntreprises.php");

// Si une recherche a été effectuée
if ((isset($_POST['rech'])) || (isset($_GET['id']))) {
    $nom = $_POST['nom'];
    $cp = $_POST['cp'];
    $ville = $_POST['ville'];
    $pays = $_POST['pays'];
} else {
    $nom = $cp = $ville = $pays = "";
}

$filtres = array();

// Si une recherche sur le nom de l'entreprise est demandée
if ($nom != "")
    array_push($filtres, new FiltreString("nom", "%" . $nom . "%"));

// Si une recherche sur le code postal est demandée
if ($cp != "")
    array_push($filtres, new FiltreString("codepostal", $cp . "%"));

// Si une recherche sur la ville est demandée
if ($ville != "")
    array_push($filtres, new FiltreString("ville", $ville . "%"));

// Si une recherche sur le pays est demandée
if ($pays != "")
    array_push($filtres, new FiltreString("pays", $pays . "%"));

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

$tabEntreprises = Entreprise::getListeEntreprises($filtre);

// Si il y a au moins une entreprise
if (sizeof($tabEntreprises) > 0) {
    // Affichage des entreprises correspondants aux critères de recherches
    Entreprise_IHM::afficherListeEntrepriseAEditer($tabEntreprises);
}else {
    echo "Aucune entreprise ne correspond aux critères de recherche.";
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>