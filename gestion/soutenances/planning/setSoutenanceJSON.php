<?php

/**
 * Page setSoutenanceJSON.php
 * Utilisation : page pour enregistrer une soutenance
 *		 page appelée par planifier_compresse.js
 * Accès : restreint par authentification HTTP
 */

include_once("../../../classes/bdd/connec.inc");

include_once('../../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level3');

// Format de la réponse
header("Content-type:text/plain; charset=utf-8");

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Récupérer l'objet datesoutenance
$date = new DateTime($data["start_date"]);
$filtre = new Filtre(new FiltreNumeric("jour", $date->format('d')),
		     new Filtre(new FiltreNumeric("mois", $date->format('m')),
			        new FiltreNumeric("annee",$date->format('Y')), "AND"), "AND");
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

	// Modification de la convention ou du contrat associé si nécessaire
	$result = TRUE;
	if ($data['id'] != $id) {
		if ($data['idconvention']) {
		    $convention = Convention::getConvention($data['idconvention']);
		    $convention->setIdSoutenance($id);
		    $result = Convention_BDD::sauvegarder($convention);
		}
		else if ($data['idcontrat']) {
		    $contrat = Contrat::getContrat($data['idcontrat']);
		    $contrat->setIdSoutenance($id);
		    $result = Contrat_BDD::sauvegarder($contrat);
		}
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
	    // La convention ou le contrat est mis-à-jour automatiquement
	    // du fait des contraintes d'intégrité
	    Convocation_BDD::supprimer($idconvocation);
	} else {
	    // Renvoie l'id de la soutenance
	    print($id);
	}
} else {
	print(0);
}

?>