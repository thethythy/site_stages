<?php 
header ('Content-type:text/html; charset=utf-8');
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Parrain_BDD.php");
include_once("../../classes/moteur/Parrain.php");
include_once("../../classes/ihm/IHM_Generale.php");
include_once("../../classes/ihm/Parrain_IHM.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Saisie d'un ", "référent", "../../",$tabLiens);
function save(){
	if(isset($_POST['nomParrain'])) {
		if($_POST['nomParrain'] != "" && $_POST['prenomParrain']!=""){	
			$tabDonnees = array();
					
			$nom=$_POST['nomParrain'];
			array_push($tabDonnees,$nom);
			$prenom=$_POST['prenomParrain'];
			array_push($tabDonnees,$prenom);
			$prenom=$_POST['emailParrain'];
			array_push($tabDonnees,$prenom);
			$couleur=$_POST['idCouleur'];
			array_push($tabDonnees,$couleur);
	
			Parrain::saisirDonneesParrain($tabDonnees);
			printf("<p>Le nouveau référent a été enregistré ! </p>");
		}else{
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