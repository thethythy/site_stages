<?php

$chemin = "../classes/";

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
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Contact_IHM.php");
include_once($chemin."ihm/Convention_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
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

header ("Content-type:text/html; charset=utf-8");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('index.php', 'Stagiaire');
IHM_Generale::header("Liste des", "anciens stages", "../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("listerAnciensStagesData.php", true);

// Affichage des données
echo "<br/>\n";
echo "<br/>\n";
echo "<div id='data'>\n";
include_once("listerAnciensStagesData.php");
echo "\n</div>";

?>

<br/>
<br/>

<table align="center">
	<tr>
		<td width="100%" align="center">
			<form method=post action="index.php">
				<input type="submit" value="Retour"/>
			</form>
		</td>
	</tr>
</table>

<?php

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>