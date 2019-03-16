<?php

/**
 * Page listerAnciensContrats.php
 * Utilisation : page d'accès aux contrats des années passées
 * Dépendance(s) : listerAnciensContratsData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('index.php', 'Alternant');

IHM_Generale::header("Liste des", "anciennes alternances", "../", $tabLiens);

Contrat_IHM::afficherFormulaireRechercheAvancee("listerAnciensContratsData.php");

// Affichage des données
echo "<br/>";
echo "<div id='data'>\n";
include_once("listerAnciensContratsData.php");
echo "\n</div>";
?>

<table align="center">
    <tr>
	<td width="100%" align="center">
	    <form method=post action="index.php">
		<input type="submit" value="Retour"/>
	    </form>
	</td>
    </tr>
</table>

<br/><br/>

<?php
deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>
