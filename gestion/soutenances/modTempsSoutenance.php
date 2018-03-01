<?php

/**
 * Page modTempsSoutenance.php
 * Utilisation : page pour modifier le temps de soutenance d'une filière
 *		 page accessible depuis modifierTempsSoutenance.php
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier une ", "durée par diplôme", "../../", $tabLiens);

function modifier() {
    if ($_POST['id'] != -1) {
	$filiere = Filiere::getFiliere($_POST['id']);
	$filiere->setTempsSoutenance($_POST['duree']);
	Filiere_BDD::sauvegarder($filiere);
	printf("La durée a été modifiée ! ");
    } else {
	IHM_Generale::erreur("Vous devez sélectionner un diplôme !");
    }
}

modifier();
printf("<p><a href='../../gestion/soutenances/modifierTempsSoutenance.php'>Retour</a></p>");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>