<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");
include_once($chemin . "moteur/FiltreString.php");

include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Contact_IHM.php");
include_once($chemin . "bdd/Contact_BDD.php");
include_once($chemin . "moteur/Contact.php");

include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/Supprimer un", "contact", "../../", $tabLiens);

if (isset($_GET['id'])) {
    // Nécéssaire pour que dans le formulaire de recherche, on resélectionne les valeurs précédement sélectionnées
    $_POST['nom'] = $_GET['nom'];
    $_POST['prenom'] = $_GET['prenom'];
    $_POST['tel'] = $_GET['tel'];
    $_POST['fax'] = $_GET['fax'];

    // Suppression du Contact
    Contact::supprimerContact($_GET['id']);
}

Contact_IHM::afficherFormulaireRecherche("modifierListeContacts.php");

// Si une recherche a été effectuée
if ((isset($_POST['rech'])) || (isset($_GET['id']))) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['tel'];
    $fax = $_POST['fax'];
} else {
    $nom = $prenom = $tel = $fax = "";
}

$filtres = array();

// Si une recherche sur le nom du contact est demandée
if ($nom != "")
    array_push($filtres, new FiltreString("nomcontact", $_POST['nom'] . "%"));

// Si une recherche sur le prénom du contact est demandée
if ($prenom != "")
    array_push($filtres, new FiltreString("prenomcontact", $_POST['prenom'] . "%"));

// Si une recherche sur le téléphone est demandée
if ($tel != "")
    array_push($filtres, new FiltreString("telephone", $_POST['tel'] . "%"));

// Si une recherche sur le fax est demandée
if ($fax != "")
    array_push($filtres, new FiltreString("telecopie", $_POST['fax'] . "%"));

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

$tabContacts = Contact::getListeContacts($filtre);

// Si il y a au moins un contact
if (sizeof($tabContacts) > 0) {
    // Affichage des contacts correspondants aux critères de recherches
    Contact_IHM::afficherListeContactsAEditer($tabContacts);
}else {
    echo "Aucun contact ne correspond aux critères de recherche.";
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>