<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/Salle_IHM.php");
include_once("../../classes/bdd/Salle_BDD.php");
include_once("../../classes/moteur/Salle.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Saisie d'une ", "salle", "../../", $tabLiens);

function save() {
    if (isset($_POST['nom'])) {
	if ($_POST['nom'] != "") {
	    $tabDonnees = array();
	    array_push($tabDonnees, $_POST['nom']);
	    Salle::saisirDonneesSalle($tabDonnees);
	    printf("<p>La nouvelle salle a été enregistrée ! </p>");
	} else {
	    IHM_Generale::erreur("Vous devez saisir des informations !");
	}
    }
}

save();
Salle_IHM::afficherFormulaireSaisie();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>