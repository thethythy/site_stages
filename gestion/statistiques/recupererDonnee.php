<?php

$chemin = '../../classes/';

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");

include_once($chemin."ihm/Entreprise_IHM.php");
include_once($chemin."ihm/Etudiant_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."ihm/IHM_Generale.php");

include_once($chemin."moteur/Entreprise.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Statistiques');
IHM_Generale::header("Statistiques", "entreprises", "../../", $tabLiens);

$etudiant = Etudiant::getListeEtudiants("2015");
$tabEtudiants = Promotion::listerEtudiants("");
/* recuperation des donnees entreprises */
$tabEntreprises = Entreprise::getListeEntreprises("");
//$parrain = $convention->getParrain();

/* recuperation des donnees etudiants */
//$contact = $convention->getContact();
//$filiere = $promotion->getFiliere();
//$parcours = $promotion->getParcours();

/* recuperation des donnees soutenance */


/* recuperation des donnees stage */
//$convention = $etudiant->getConvention($promotion->getAnneeUniversitaire());
echo "<div id='data'>\n";
$mans = 0;
$sarthe = 0;
$region = 0;
$france = 0;
$monde = 0;

if(sizeof($tabEntreprises)>0){
	// Affichage des entreprises correspondants aux critères de recherches
	for($i=0; $i<sizeof($tabEntreprises); $i++){
		$nom = $tabEntreprises[$i]->getNom();	
		$adresse = $tabEntreprises[$i]->getAdresse();	
		$codepostal = $tabEntreprises[$i]->getCodePostal();
		$ville = strtolower($tabEntreprises[$i]->getVille());
		$pays = strtolower($tabEntreprises[$i]->getPays());	
		$email = $tabEntreprises[$i]->getEmail();
		$dep = $codepostal[0].$codepostal[1];
		$deps = array("53","85","49","44");

		if(strstr($ville, "mans") && ($codepostal == "72000" || $codepostal == "72100") ) {
			$mans++;
		}
		else if($dep == "72"  && strstr($pays, "france")  && ($codepostal != "72000" || $codepostal != "72100") ) {
			$sarthe++;
		}
		else if(in_array($dep, $deps) && strstr($pays, "france")) {
			$region++;
		}
		else if(strstr($pays, "france")) {
			$france++;
		}
		else {
			$monde++;
		}


		/*?><br/>
		<?php	echo $tabEntreprises[$i]->getNom();	?> <br/>
		<?php	echo $tabEntreprises[$i]->getAdresse();	?> <br/>
		<?php	echo $tabEntreprises[$i]->getCodePostal();	?> <br/>
		<?php	echo $tabEntreprises[$i]->getVille();	?> <br/>
		<?php	echo $tabEntreprises[$i]->getPays();	?> <br/>
		<?php	echo $tabEntreprises[$i]->getEmail();	?> <br/>
		<?php	echo $dep;	?> <br/>
		<?php*/
	}

}
echo "\n</div>";



?>