<?php

$chemin = "../../../classes/";

include_once($chemin."bdd/connec.inc");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/Convocation_BDD.php");
include_once($chemin."moteur/Convocation.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");

include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Contact.php");

include_once($chemin."bdd/DateSoutenance_BDD.php");
include_once($chemin."moteur/DateSoutenance.php");

include_once($chemin."bdd/Soutenance_BDD.php");
include_once($chemin."moteur/Soutenance.php");

include_once($chemin."bdd/Salle_BDD.php");
include_once($chemin."moteur/Salle.php");

// Format de la réponse
header("Content-type:text/plain; charset=utf-8");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Récupérer l'objet datesoutenance
$date = new DateTime($data["start_date"]);
$filtre = new Filtre(new FiltreNumeric("jour", $date->format('d')), new Filtre(new FiltreNumeric("mois", $date->format('m')), new FiltreNumeric("annee",$date->format('Y')), "AND"), "AND");
$datesSoutenances = DateSoutenance::listerDateSoutenance($filtre);

// Si la date est OK, on peut sauvegarder
if (sizeof($datesSoutenances) == 1) {

	// Récupérer l'id de la soutenance si elle existe
	$identifiantBDD = Soutenance::getSoutenance($data['id'])->getIdentifiantBDD();

	$identifiantDateSoutenance = $datesSoutenances[0]->getIdentifiantBDD();
	$identifiantSalle = $data['idsalle'];
	$heureDebut = $date->format('H');
	$minuteDebut = $date->format('i');
	$aHuitClos = $data['ahuisclos'] == "" ? 0 : $data['ahuisclos'];

	// Créer un objet soutenance
	$soutenance = new Soutenance($identifiantBDD, $identifiantDateSoutenance, $identifiantSalle, $heureDebut, $minuteDebut, $aHuitClos);

	// Sauvegarder l'objet soutenance en base
	$id = Soutenance_BDD::sauvegarder($soutenance);

	// Modification de la convention associée si nécessaire
	$result = TRUE;
	if ($data['id'] != $id) {
		$convention = Convention::getConvention($data['idconvention']);
		$convention->setIdSoutenance($id);
		$result = Convention_BDD::sauvegarder($convention);
	}

	// Création de la convocation liée à la soutenance
	if ($result && $data['id'] != $id) {
	    $oConvocation = new Convocation('', 0, $id);
	    $idconvocation = Convocation_BDD::sauvegarder($oConvocation);
	    if (!$idconvocation)
		$result = FALSE;
	}

	// Vérifie que l'association s'est bien faite
	if (!$result) {
	    // Renvoie 0 = probleme
	    print(0);
	    Soutenance_BDD::supprimer($id);
	    Convocation_BDD::supprimer($idconvocation);
	} else {
	    // Renvoie l'id de la soutenance
	    print($id);
	}
} else {
	print(0);
}

?>