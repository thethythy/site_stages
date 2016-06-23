<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Promotion_IHM.php");
include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Contact_BDD.php");
include_once($chemin . "moteur/Contact.php");

include_once($chemin . "bdd/Convention_BDD.php");
include_once($chemin . "moteur/Convention.php");

include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "bdd/Parrain_BDD.php");
include_once($chemin . "moteur/Parrain.php");

include_once($chemin . "bdd/Soutenance_BDD.php");
include_once($chemin . "moteur/Soutenance.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Rattacher des", "résumés", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("rattacherResumesData.php", false);

// Si un enregistrement des résumés a été effectuée
if (isset($_POST['save'])) {
    $tabIdConventions = $_POST['idConventions'];
    if ($tabIdConventions != "") {
	$tabIdConv = explode(";", $tabIdConventions);
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