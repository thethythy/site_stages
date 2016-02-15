<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/TypeEntreprise_BDD.php");
include_once("../../classes/ihm/IHM_Generale.php");
include_once("../../classes/ihm/TypeEntreprise_IHM.php");
include_once("../../classes/moteur/TypeEntreprise.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Ajouter/Supprimer des", "Types d'entreprise", "../../",$tabLiens );

function save(){
	if (isset($_POST['idtypeentreprise']) && $_POST['idtypeentreprise'] != "") {
		$nom=$_POST['idtypeentreprise'];
		//$tmp = new TypeEntreprise("",$nom);
		$nouveauType = new TypeEntreprise("",/*sizeof($tmp->getListeTypeEntreprise()),*/$nom);
		//echo "nouveauType=".$nouveauType->getTypeEntreprise($nom)->getType();
		echo "Ici gestion TypeEntreprise : ".$nouveauType->getIdentifiantBDD().", ".$nouveauType->getType();
		TypeEntreprise_BDD::sauvegarder($nouveauType);
	}
	if (isset($_POST['typeentreprise']) && $_POST['typeentreprise'] != -1) {
		$nom = $_POST['typeentreprise'];
		//echo "nom=".$nom;
		TypeEntreprise::supprimerTypeEntreprise($nom);
	}

}

save();

TypeEntreprise_IHM::afficherFormulaireSaisie();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>