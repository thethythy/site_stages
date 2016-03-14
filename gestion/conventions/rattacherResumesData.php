<?php
header ('Content-type:text/html; charset=utf-8');
$chemin = "../../classes/";

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

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
	header("Content-type: text/html; charset=iso-8859-15");

// Prise en compte des paramètres
$filtres = array();

if (!isset($_POST['annee']))
	$annee = Promotion_BDD::getLastAnnee();
else
	$annee = $_POST['annee'];

array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));

if (isset($_POST['parcours']) && $_POST['parcours'] != '*' && $_POST['parcours'] != '') {
	$parcours = $_POST['parcours'];
	array_push($filtres, new FiltreNumeric("idparcours", $parcours));
}

if (isset($_POST['filiere']) && $_POST['filiere'] != '*' && $_POST['filiere'] != '') {
	$filiere = $_POST['filiere'];
	array_push($filtres, new FiltreNumeric("idfiliere", $filiere));
}

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
	$idPromo = $tabPromos[0][0];

	// Récupération des étudiants ayant une convention
	$tabEtuWithConv = array();

	for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
		if ($tabEtudiants[$i]->getConvention($annee) != null)
			array_push($tabEtuWithConv, $tabEtudiants[$i]);
	}

	// Si il y a au moins un étudiant avec une convention
	if (sizeof($tabEtuWithConv) > 0) {
		// Affichage des conventions des étudiants

		?>

		<form method=post action="">
			<table>
				<tr id='entete'>
					<td>Etudiant</td>
					<td>Résumé actuelle</td>
					<td width='25%'>Nouveau résumé</td>
				</tr>
		<?php

		$idConventions = "";

		for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
			$conv = $tabEtuWithConv[$i]->getConvention($annee);

			if ($idConventions == "")
				$idConventions = $conv->getIdentifiantBDD();
			else
				$idConventions .= ";".$conv->getIdentifiantBDD();

			?>
				<tr id="ligne<?php echo $i%2; ?>">
					<td>
						<?php echo $tabEtuWithConv[$i]->getNom()." ".$tabEtuWithConv[$i]->getPrenom(); ?>
					</td>
					<td>
						<?php
							echo $conv->getSujetDeStage();
						?>
					</td>
					<td align="center">
						<?php
							$tabRes = Convention::getResumesPossible($tabEtuWithConv[$i]->getIdentifiantBDD(), "../../documents/resumes/");
							if (sizeof($tabRes) == 0) {
								echo "<input style='width: 250px;' name='conv".$conv->getIdentifiantBDD()."' type='text' value='".htmlentities($conv->getSujetDeStage(), ENT_QUOTES, 'iso-8859-1')."'/>";
							} else {
								echo "<select name='conv".$conv->getIdentifiantBDD()."' style='width: 250px;'>";
								echo "<option value=''></option>";
								for ($j = 0; $j < sizeof($tabRes); $j++) {
									if (($conv->getASonResume() == "1") && ($conv->getSujetDeStage() == $tabRes[$j]))
										echo "<option selected value='$tabRes[$j]'>".$tabRes[$j]."</option>";
									else
										echo "<option value='$tabRes[$j]'>".$tabRes[$j]."</option>";
								}

								echo "</select>";
							}
						?>
					</td>
				</tr>
			<?php
		}
		?>
				<tr>
					<td colspan="3" width="100%" align="center">
						<br/><br/>
						<input type="hidden" value="1" name="save" />
						<input type="hidden" value="<?php echo $annee; ?>" name="annee" />
						<input type="hidden" value="<?php echo $parcours; ?>" name="parcours" />
						<input type="hidden" value="<?php echo $filiere; ?>" name="filiere" />
						<input type="hidden" name="idConventions" value="<?php echo $idConventions; ?>" />
						<input type="submit" value="Enregistrer" />
					</td>
				</tr>
			</table>
		</form>
		<?php
	} else {
		echo "<br/><center>Aucune convention n'a été trouvée.</center><br/>";
	}
} else {
	echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.</center><br/>";
}
?>