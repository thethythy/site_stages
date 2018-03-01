<?php

/**
 * Page delSoutenanceJSON.php
 * Utilisation : page pour supprimer une soutenance
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

// Récupérer l'id de la soutenance si elle existe
$identifiantBDD = Soutenance::getSoutenance($data['id'])->getIdentifiantBDD();

// Si la soutenance a été trouvée
if ($identifiantBDD != "") {
	// Supprimer la soutenance
	Soutenance_BDD::supprimer($identifiantBDD);

	// Supprimer la convocation associée
	$idConvocation = Convocation::getConvocationFromSoutenance($identifiantBDD);
	Convocation_BDD::supprimer($idConvocation);

	// Modifier la convention
	$convention = Convention::getConvention($data['idconvention']);
	$convention->setIdSoutenance(NULL);
	Convention_BDD::sauvegarder($convention);

	// La suppression s'est bien passée
	print("OK");
} else {
	// Problème à la suppression
	print("KO");
}

?>