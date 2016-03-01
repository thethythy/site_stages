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

IHM_Generale::header("Ajouter un", "Type d'entreprise", "../../",$tabLiens );
TypeEntreprise_IHM::afficherFormulaireSaisie();

function save(){
	if(isset($_POST['type'])) {
		if($_POST['type'] != "") {

			$tabDonnees = array();

			$type=$_POST['type'];
			array_push($tabDonnees,$type);
			$couleur=$_POST['idCouleur'];
			array_push($tabDonnees,$couleur);
			TypeEntreprise::saisirDonneesType($tabDonnees);
			printf("<p>Le nouveau type d'entreprise a été enregistré ! </p>");
		}
		else {
			IHM_Generale::erreur("Vous devez saisir des informations !");
		}
	}
}

save();
deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>