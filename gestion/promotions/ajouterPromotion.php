<?php

/**
 * Page ajouterPromotion.php
 * Utilisation : page de création d'une nouvelle promotion d'étudiants
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Ajouter une", "promotion", "../../", $tabLiens);

// Si un ajout a été effectué
if (isset($_POST['add'])) {
    extract($_POST);

    if (preg_match("/^[0-9]{4}$/", $annee) == 1) {

	if (($email != "") && Utils::VerifierAdresseMail($email)) {

	    if ($parcours2 != "") {
		$newParcours = new Parcours("", $parcours2);
		$parcours = Parcours_BDD::sauvegarder($newParcours);
	    } else {
		$parcours = $parcours1;
	    }

	    if ($filiere2 != "") {
		$newFiliere = new Filiere("", $filiere2);
		$filiere = Filiere_BDD::sauvegarder($newFiliere);
	    } else {
		$filiere = $filiere1;
	    }

	    if ($filiere3 != "NULL") {
		$oFiliere = Filiere::getFiliere($filiere);
		$oFiliere->setIdFiliereSuivante($filiere3);
	    }

	    $newPromotion = new Promotion("", $annee, $parcours, $filiere, $email);

	    // Si la promotion que l'on veut créer n'existe pas déjà
	    if (Promotion_BDD::existe($newPromotion) == false) {
		$promo = Promotion_BDD::sauvegarder($newPromotion);
		if ($filiere3 != "NULL") Filiere_BDD::sauvegarder($oFiliere);
		Promotion_IHM::afficherFormulaireAjoutOK($promo);
	    } else {
		Promotion_IHM::afficherFormulaireAjout();
		IHM_Generale::erreur("Cette promotion existe déjà !");
	    }
	} else {
	    Promotion_IHM::afficherFormulaireAjout();
	    IHM_Generale::erreur("Il faut donner une adresse email valide !");
	}
    } else {
	Promotion_IHM::afficherFormulaireAjout();
	IHM_Generale::erreur("L'année n'est pas valide ! (Exemple : " . date("Y") . ")");
    }
} else {
    Promotion_IHM::afficherFormulaireAjout();
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>