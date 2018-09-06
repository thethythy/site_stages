<?php

/**
 * Page modifierPromotion.php
 * Utilisation : page d'édition d'une promotion existante
 *		 suppression de la promotion
 *		 ajout ou importation d'étudiant
 *		 suppression d'étudiants
 *		 édition des étudiants
 * Dépendance(s) : modifierPromotionData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/Supprimer une", "promotion", "../../", $tabLiens);

if (isset($_POST['delpromo'])) {
    // Suppression de la promotion
    Promotion::supprimerPromotion($_POST['delpromo']);

    if (Promotion::getPromotion($_POST['delpromo']))
	echo 'Impossible de supprimer cette promotion car des étudiants y sont rattachés.';
    else
	echo 'Promotion supprimée avec succès.';
    echo '<br/><br/>';
} else {

    if (isset($_POST['promo']) && isset($_POST['email']) && Utils::VerifierAdresseMail($_POST['email'])) {
	// Modification de l'email de la promotion
	$promo = Promotion::getPromotion($_POST['promo']);
	$promo->setEmailPromotion($_POST['email']);
	Promotion_BDD::sauvegarder($promo);

	$filiere = $promo->getFiliere();
	$parcours = $promo->getParcours();
	$_POST['annee'] = $promo->getAnneeUniversitaire();
	$_POST['parcours'] = $parcours->getIdentifiantBDD();
	$_POST['filiere'] = $filiere->getIdentifiantBDD();
    }

    if ((isset($_GET['id'])) && (isset($_GET['promo']))) {
	// Nécessaire pour que dans le formulaire de recherche, on resélectionne les valeurs précédement sélectionnées
	$promo = Promotion::getPromotion($_GET['promo']);
	$filiere = $promo->getFiliere();
	$parcours = $promo->getParcours();
	$_POST['annee'] = $promo->getAnneeUniversitaire();
	$_POST['parcours'] = $parcours->getIdentifiantBDD();
	$_POST['filiere'] = $filiere->getIdentifiantBDD();

	// Suppression de l'étudiant
	Etudiant::supprimerEtudiant($_GET['id'], $_GET['promo']);
    }

    // Affichage du formulaire de recherche
    Promotion_IHM::afficherFormulaireRecherche("modifierPromotionData.php", false);

    // Affichage des données
    echo "<div id='data'>\n";
    include_once("modifierPromotionData.php");
    echo "\n</div>";
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>