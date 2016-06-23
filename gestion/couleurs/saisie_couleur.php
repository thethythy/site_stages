<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/Couleur_IHM.php");
include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Saisie d'une ", "couleur", "../../", $tabLiens);

function save() {
    if (isset($_POST['nomCouleur'])) {
	if ($_POST['nomCouleur'] != "" && $_POST['codeHexa'] != "") {
	    $tabDonnees = array();

	    array_push($tabDonnees, $_POST['nomCouleur']);
	    array_push($tabDonnees, ltrim($_POST['codeHexa'], "#"));

	    Couleur::saisirDonneesCouleur($tabDonnees);
	    printf("<p>La nouvelle couleur a été enregistrée ! </p>");
	} else {
	    IHM_Generale::erreur("Vous devez saisir des informations !");
	}
    }
}

save();
Couleur_IHM::afficherFormulaireSaisie();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>