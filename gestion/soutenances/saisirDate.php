<?php 
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/DateSoutenance_BDD.php");
include_once("../../classes/moteur/DateSoutenance.php");
include_once("../../classes/bdd/Promotion_BDD.php");
include_once("../../classes/moteur/Promotion.php");
include_once("../../classes/bdd/Filiere_BDD.php");
include_once("../../classes/moteur/Filiere.php");
include_once("../../classes/bdd/Parcours_BDD.php");
include_once("../../classes/moteur/Parcours.php");
include_once("../../classes/ihm/IHM_Generale.php");
include_once("../../classes/ihm/DateSoutenance_IHM.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Saisie d'une ", "date", "../../",$tabLiens);

function save(){
    if (isset($_POST['date'])) {
        if ($_POST['date'] != "") {	
            $tabDonnees = array();
		
            $date = explode("-", $_POST['date']);
        
            array_push($tabDonnees,$date[2]);
            array_push($tabDonnees,$date[1]);
            array_push($tabDonnees,$date[0]);
            array_push($tabDonnees,$_POST['promo']);
	
            DateSoutenance::saisirDonneesDateSoutenance($tabDonnees);
            printf("<p>La nouvelle date a été enregistrée ! </p>");
        } else{
            IHM_Generale::erreur("Vous devez saisir des informations !");
        }
    }	
}

save();
DateSoutenance_IHM::afficherFormulaireSaisie();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>