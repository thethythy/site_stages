<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Convention.php");

// ---------------------
// Contrôleur de la page

// Demande remise à l'état par défaut du statut des étudiants de la promotion
if (   isset($_POST['reset'])
    && isset($_POST['annee']) && is_numeric($_POST['annee'])
    && isset($_POST['filiere']) && is_numeric($_POST['filiere'])
    && isset($_POST['parcours']) && is_numeric($_POST['parcours'])) {

	// Prise en compte des paramètres
	$filtres = array();

	array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));
	array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));
	array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

	$filtre = $filtres[0];

	for ($i = 1; $i < sizeof($filtres); $i++)
		$filtre = new Filtre($filtre, $filtres[$i], "AND");

	// Reset du statut de tous les étudiants de la promotion
	$tabEtudiants = Promotion::listerEtudiants($filtre);

	foreach ($tabEtudiants as $oEtudiant) {
		$oEtudiant->setCodeEtudiant("0");
		Etudiant_BDD::sauvegarder($oEtudiant, false);
	}
}

// Demande modification du statut des étudiants modifiés
if (isset($_POST['valider']) && isset($_POST['statut'])) {
    foreach ($_POST['statut'] as $key => $value) {
	$oEtudiant = Etudiant::getEtudiant($key);
	$oEtudiant->setCodeEtudiant($value);
	Etudiant_BDD::sauvegarder($oEtudiant, false);
    }
}

// --------------------
// Affichage de la page

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Suivi de la", "promotion", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("suiviPromotionData.php", false);

// Affichage des données
echo "<div id='data'>\n";
include_once("suiviPromotionData.php");
echo "\n</div>";

?>
	<br/>

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

