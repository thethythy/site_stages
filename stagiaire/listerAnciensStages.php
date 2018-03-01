<?php

/**
 * Page listerAnciensStages.php
 * Utilisation : page d'accès aux stages des années passées
 * Dépendance(s) : listerAnciensStagesData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('index.php', 'Stagiaire');

IHM_Generale::header("Liste des", "anciens stages", "../", $tabLiens);

Stage_IHM::afficherFormulaireRechercheAvancee("listerAnciensStagesData.php");

// Affichage des données
echo "<br/>";
echo "<div id='data'>\n";
include_once("listerAnciensStagesData.php");
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