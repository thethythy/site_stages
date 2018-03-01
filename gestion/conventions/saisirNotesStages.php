<?php

/**
 * Page saisirNotesStages.php
 * Utilisation : page pour éditer les notes de stages
 * Dépendance(s) : saisirNotesStagesData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Saisir des", "notes de stages", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("saisirNotesStagesData.php", false);

// Si un enregistrement des notes a été effectuée
if (isset($_POST['save'])) {
    $tabIdConventions = $_POST['idConventions'];

    // Y-a-t-il au moins une note à changer ?
    if ($tabIdConventions != "") {
	$tabIdConv = explode(";", $tabIdConventions);
	for ($i = 0; $i < sizeof($tabIdConv); $i++) {
	    $conv = Convention::getConvention($tabIdConv[$i]);
	    $conv->setNote($_POST['conv' . $tabIdConv[$i]]);
	    Convention_BDD::sauvegarder($conv);
	}
    }
}

// Affichage des données
echo "<div id='data'>\n";
include_once("saisirNotesStagesData.php");
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