<?php
$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/TypeEntreprise_IHM.php");
include_once($chemin."moteur/TypeEntreprise.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Ajouter/Supprimer des", "Types d'entreprise", "../../",$tabLiens );

function save(){
	if(isset($_POST['idtypeentreprise'])) {
		if($_POST['idtypeentreprise'] != "") {
			$type=$_POST['idtypeentreprise'];
			TypeEntreprise::saisirDonneesType($type);
			printf("<p>Le nouveau type d'entreprise a été enregistré ! </p>");
		}
		else {
			IHM_Generale::erreur("Vous devez saisir des informations !");
		}
	}
}

save();
TypeEntreprise_IHM::afficherFormulaireSaisie();
deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>