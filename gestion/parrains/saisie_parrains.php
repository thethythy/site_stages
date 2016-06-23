<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/Parrain_IHM.php");
include_once("../../classes/bdd/Parrain_BDD.php");
include_once("../../classes/moteur/Parrain.php");

include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Saisie d'un ", "référent", "../../", $tabLiens);

function save() {
    if (isset($_POST['nomParrain'])) {
	if ($_POST['nomParrain'] != "" && $_POST['prenomParrain'] != "") {
	    $tabDonnees = array();

	    array_push($tabDonnees, $_POST['nomParrain']);
	    array_push($tabDonnees, $_POST['prenomParrain']);
	    array_push($tabDonnees, $_POST['emailParrain']);
	    array_push($tabDonnees, $_POST['idCouleur']);

	    Parrain::saisirDonneesParrain($tabDonnees);
	    printf("<p>Le nouveau référent a été enregistré ! </p>");
	} else {
	    IHM_Generale::erreur("Vous devez saisir des informations !");
	}
    }
}

save();
Parrain_IHM::afficherFormulaireSaisie();

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>