<?php

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$chemin = "../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");
include_once($chemin . 'moteur/Utils.php');

include_once($chemin . "ihm/Stage_IHM.php");

include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "bdd/ThemeDeStage_BDD.php");
include_once($chemin . "moteur/ThemeDeStage.php");

include_once($chemin . "bdd/TypeEntreprise_BDD.php");
include_once($chemin . "moteur/TypeEntreprise.php");

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