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
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Contact_IHM.php");
include_once($chemin."ihm/Convention_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
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
include_once($chemin."moteur/ThemeDeStage.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
	header("Content-type: text/html; charset=utf-8");

// Prise en compte des paramètres
$filtres = array();

if (!isset($_POST['annee']))
	$annee = Promotion_BDD::getLastAnnee();
else
	$annee = $_POST['annee'];

array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
	
if (isset($_POST['parcours']) && $_POST['parcours'] != '*' && $_POST['parcours'] != '') {
	$parcours = $_POST['parcours'];
	array_push($filtres, new FiltreNumeric("idparcours", $parcours));
}
	
if (isset($_POST['filiere']) && $_POST['filiere'] != '*' && $_POST['filiere'] != '') {
	$filiere = $_POST['filiere'];
	array_push($filtres, new FiltreNumeric("idfiliere", $filiere));
}
	
$filtre = $filtres[0];
	
for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);

// Si un ajout a été effectué
if (isset($_POST['add'])) {
	extract($_POST);
	
	//Ajout de ', $themeStage' -----------------------------------------------------------------------------------------------------
	$newConvention = new Convention("", $sujet, 0, 0, $idPar, $idExam, $idEtu, "NULL", $idCont, $themeStage);
	
	// Si la convention que l'on veut créer n'existe pas déjà
	if (Convention_BDD::existe($newConvention, $annee) == false) {
		
		// Sauvegarde de la convention
		$idConv = Convention_BDD::sauvegarder($newConvention);

		// Mise à jour du lien promotion /étudiant / convention
		if (isset($filiere) && isset($parcours)) {
			$promotion = Promotion::getPromotionFromParcoursAndFiliere($annee, $filiere, $parcours);
			Etudiant_BDD::ajouterConvention($idEtu, $idConv, $promotion->getIdentifiantBDD());
		}
		
		?>
			<table align="center">
				<tr>
					<td align="center">
						Création de la convention réalisée avec succès.
					</td>
				</tr>
				<tr>
					<td width="100%" align="center">
						<form method=post action="../">
							<input type="submit" value="Retourner au menu"/>
						</form>
					</td>
				</tr>
			</table>
		<?php
	} else {
		Convention_IHM::afficherFormulaireSaisie("", $tabEtudiants, $annee, $parcours, $filiere);
		IHM_Generale::erreur("Cet étudiant à déjà une convention pour l'année sélectionnée !");
	}
} else {
	Convention_IHM::afficherFormulaireSaisie("", $tabEtudiants, $annee, $parcours, $filiere);
}

?>