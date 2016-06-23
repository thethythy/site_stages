<?php
$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "moteur/Utils.php");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Promotion_IHM.php");
include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");


$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/Supprimer une", "promotion", "../../", $tabLiens);

if (isset($_POST['delpromo'])) {
    // Suppression de la promotion
    Promotion::supprimerPromotion($_POST['delpromo']);
    ?>
    Promotion supprimée avec succès.
    <br/><br/>
    <?php
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