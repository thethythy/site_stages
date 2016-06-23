<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/ThemeDeStage_IHM.php");
include_once($chemin . "bdd/ThemeDeStage_BDD.php");
include_once($chemin . "moteur/ThemeDeStage.php");

include_once($chemin . "bdd/Couleur_BDD.php");
include_once($chemin . "moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Ajouter un", "thème de stage", "../../", $tabLiens);
ThemeDeStage_IHM::afficherFormulaireSaisie();

function save() {
    if (isset($_POST['theme'])) {
	if ($_POST['theme'] != "") {
	    $tabDonnees = array();
	    array_push($tabDonnees, $_POST['theme']);
	    array_push($tabDonnees, $_POST['idCouleur']);

	    ThemeDeStage::saisirDonneesTheme($tabDonnees);
	    printf("<p>Le nouveau thème de stage a été enregistré !</p>");
	} else {
	    IHM_Generale::erreur("Vous devez saisir des informations !");
	}
    }
}

save();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>