<?php

$chemin = "../../../classes/";

include_once($chemin."bdd/connec.inc");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

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

include_once($chemin."bdd/Convocation_BDD.php");
include_once($chemin."moteur/Convocation.php");

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