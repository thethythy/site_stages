<?php
header ('Content-type:text/html; charset=utf-8');
$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."bdd/Soutenance_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Contact_IHM.php");
include_once($chemin."ihm/Convention_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."moteur/Convention.php");
include_once($chemin."moteur/Entreprise.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Parrain.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Soutenance.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Modifier/Supprimer une", "convention", "../../", $tabLiens);

if ((isset($_GET['id'])) && (isset($_GET['promo']))) {
	// Nécéssaire pour que dans le formulaire de recherche, on resélectionne les valeurs précédement sélectionnées
	$promo = Promotion::getPromotion($_GET['promo']);
	$filiere = $promo->getFiliere();
	$parcours = $promo->getParcours();
	$_POST['annee'] = $promo->getAnneeUniversitaire();
	$_POST['parcours'] = $parcours->getIdentifiantBDD();
	$_POST['filiere'] = $filiere->getIdentifiantBDD();
	
	// Suppression de l'étudiant
	Convention::supprimerConvention($_GET['id'], $_GET['promo']);
}
	
Promotion_IHM::afficherFormulaireRecherche("modifierListeConventionsData.php", false);

// Affichage des données
echo "<div id='data'>\n";
include_once("modifierListeConventionsData.php");
echo "\n</div>";

?>
	<br/><br/>
	
	<table align="center">
		<tr>
			<td width="100%" align="center">
				<form method=post action="../">
					<input type="submit" value="Retourner au menu"/>
				</form>
			</td>
		</tr>
	</table>

<?php

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>