<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."moteur/ThemeDeStage.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Saisir un", "theme de stage", "../../",$tabLiens);

// Si un ajout a été effectué
if(isset($_POST['add'])){
	extract($_POST);
	
	if ($theme == "") {
		ThemeDeStage_IHM::afficherFormulaireSaisie("");
		IHM_Generale::erreur("Le nom du thème est obligatoires !");
	} else {
		$newThemeDeStage = new ThemeDeStage("", $theme);
		?>
			<table align="center">
				<tr>
					<td colspan="2" align="center">
						Ajout du nouveau thème <?php echo $theme; ?> réalisée avec succès.
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
	}
}else{
	ThemeDeStage_IHM::afficherFormulaireSaisie("");
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");


/* Fonction Save à faire surement .... */

?>