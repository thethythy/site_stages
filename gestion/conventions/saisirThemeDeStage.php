<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."moteur/ThemeDeStage.php");


// Si un ajout a été effectué
if (isset($_POST['add'])) {
	extract($_POST);
	
	//Ajout de ', $themeStage' -----------------------------------------------------------------------------------------------------
	$newTheme = new ThemeDeStage("", $sujet, 0, 0, $idPar, $idExam, $idEtu, "NULL", $idCont, $themeStage);
	
	// Si la convention que l'on veut créer n'existe pas déjà
	if (Convention_BDD::existe($newConvention, $annee) == false) {
		
		// Sauvegarde de la convention
		$idConv = Convention_BDD::sauvegarder($newConvention);

		// Mise à jour du lien promotion /étudiant / convention
		if (isset($filiere) && isset($parcours)) {
			$promotion = Promotion::getPromotionFromParcoursAndFiliere($annee, $filiere, $parcours);
			Etudiant_BDD::ajouterConvention($idEtu, $idConv, $promotion->getIdentifiantBDD());
		}
		
		?>
			<table align="center">
				<tr>
					<td align="center">
						Ajout d'un thème de stage réalisé avec succès.
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
	} else {
		Convention_IHM::afficherFormulaireSaisie("", $tabEtudiants, $annee, $parcours, $filiere);
		IHM_Generale::erreur("Cet étudiant à déjà une convention pour l'année sélectionnée !");
	}
} else {
	Convention_IHM::afficherFormulaireSaisie("", $tabEtudiants, $annee, $parcours, $filiere);
}

?>