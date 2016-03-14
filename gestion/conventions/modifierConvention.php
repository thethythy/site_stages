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
include_once($chemin."bdd/Couleur_BDD.php");
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
include_once($chemin."moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Modifier une ", "convention", "../../", $tabLiens);

$oConv = Convention::getConvention($_GET['id']);

$oPromo = Promotion::getPromotion($_GET['promo']);

$oFiliere = $oPromo->getFiliere();
$oParcours = $oPromo->getParcours();

<<<<<<< HEAD
// Si un modification a été effectué
=======
// Si un modification a ?t? effectu?
>>>>>>> francisque
if (isset($_POST['edit'])) {
	extract($_POST);

	if(isset($sujet))
		$oConv->setSujetDeStage($sujet);
	if(isset($idTheme))
		$oConv->setIdTheme($idTheme);

	$oConv->setIdParrain($idPar);
	$oConv->setIdExaminateur($idExam);
	$oConv->setIdContact($idCont);

	$idConv = Convention_BDD::sauvegarder($oConv);

	$oEtu = $oConv->getEtudiant();

<<<<<<< HEAD
	echo "Les informations sur la convention de ".$oEtu->getNom()." ".$oEtu->getPrenom()." ont été mises à jour.";
=======
	echo "Les informations sur la convention de ".$oEtu->getNom()." ".$oEtu->getPrenom()." ont ?t? mises ? jour.";
>>>>>>> francisque

	?>
		<table>
			<tr>
				<td width="50%" align="center">
					<form method=post action="modifierListeConventions.php">
						<input type="hidden" value="1" name="rech"/>
						<input type="hidden" value="<?php echo $oPromo->getAnneeUniversitaire(); ?>" name="annee"/>
						<input type="hidden" value="<?php echo $oFiliere->getIdentifiantBDD(); ?>" name="filiere"/>
						<input type="hidden" value="<?php echo $oParcours->getIdentifiantBDD(); ?>" name="parcours"/>
<<<<<<< HEAD
						<input type="submit" value="Retourner à la liste"/>
=======
						<input type="submit" value="Retourner ? la liste"/>
>>>>>>> francisque
					</form>
				</td>
				<td width="50%" align="center">
					<form method=post action="../">
						<input type="submit" value="Retourner au menu"/>
					</form>
				</td>
			</tr>
		</table>
	<?php
} else {
	Convention_IHM::afficherFormulaireSaisie($oConv, array(), $oPromo->getAnneeUniversitaire(), $oParcours->getIdentifiantBDD(), $oFiliere->getIdentifiantBDD());
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>