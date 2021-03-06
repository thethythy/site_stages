<?php

/**
 * Page rattacherResumes.php
 * Utilisation : page pour rattacher les fichiers de résumés aux conventions
 * Dépendance(s) : rattacherResumesData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Rattacher des", "résumés", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("rattacherResumesData.php", false);

// Si un enregistrement des résumés a été effectuée
if (isset($_POST['save'])) {

    // Mise à jour éventuelle des résumés des stagiaires
    if ($_POST['idConventions'] != "") {
	$tabIdConv = explode(";", $_POST['idConventions']);
	for ($i = 0; $i < sizeof($tabIdConv); $i++) {
	    $conv = Convention::getConvention($tabIdConv[$i]);
	    if ($_POST['conv' . $tabIdConv[$i]] != "") {
		if (file_exists("../../documents/resumes/" . $_POST['conv' . $tabIdConv[$i]]))
		    $conv->setASonResume(1);
		$conv->setSujetDeStage($_POST['conv' . $tabIdConv[$i]]);
	    } else {
		$conv->setASonResume(0);
		$conv->setSujetDeStage("Pas de résumé");
	    }
	    Convention_BDD::sauvegarder($conv);
	}
    }

    // Mise à jour éventuelle des résumés des alternants
    if ($_POST['idContrats'] != "") {
	$tabIdCont = explode(";", $_POST['idContrats']);
	for ($i = 0; $i < sizeof($tabIdCont); $i++) {
	    $cont = Contrat::getContrat($tabIdCont[$i]);
	    if ($_POST['cont' . $tabIdCont[$i]] != "") {
		if (file_exists("../../documents/resumes/" . $_POST['cont' . $tabIdCont[$i]]))
		    $cont->setASonResume (1);
		$cont->setSujetDeContrat($_POST['cont' . $tabIdCont[$i]]);
	    } else {
		$cont->setASonResume(0);
		$cont->setSujetDeContrat("Pas de résumé");
	    }
	    Contrat_BDD::sauvegarder($cont);
	}
    }
}

// Affichage des données
echo "<div id='data'>\n";
include_once("rattacherResumesData.php");
echo "\n</div>";

?>

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