<?php

/**
 * Page bilanConventions.php
 * Utilisation : page visualisant par promotion les étudiants ayant une convention
 * Dépendance(s) : bilanConventionsData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Bilan des", "conventions", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("bilanConventionsData.php", false);

// Affichage des données
echo "<div id='data'>\n";
include_once("bilanConventionsData.php");
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