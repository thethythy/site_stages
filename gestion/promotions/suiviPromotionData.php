<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Convention.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
	header("Content-type: text/html; charset=iso-8859-15");

// Prise en compte des paramètres
$filtres = array();

if (!isset($_POST['annee']) && is_numeric($_POST['annee']))
	$annee = Promotion_BDD::getLastAnnee();
else
	$annee = $_POST['annee'];

array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));

if (isset($_POST['parcours']) && is_numeric($_POST['parcours']) && $_POST['parcours'] != '*' && $_POST['parcours'] != '') {
	$parcours = $_POST['parcours'];
	array_push($filtres, new FiltreNumeric("idparcours", $parcours));
}

if (isset($_POST['filiere']) && is_numeric($_POST['filiere']) && $_POST['filiere'] != '*' && $_POST['filiere'] != '') {
	$filiere = $_POST['filiere'];
	array_push($filtres, new FiltreNumeric("idfiliere", $filiere));
}

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabPromos = Promotion_BDD::getListePromotions($filtre);
$tabEtudiants = Promotion::listerEtudiants($filtre);

if (sizeof($tabPromos) > 0) {

	if (sizeof($tabEtudiants) > 0) {
		?>
		<form method="POST">
			<table>
				<tr id="entete">
					<td width="30%">Etudiant</td>
					<td width="70%" align="center">Statut</td>
				</tr>
		<?php

		$nbEtudiants = sizeof($tabEtudiants);
		$nbAlters = 0;
		$nbRechs = 0;
		$nbConvSignees = 0;
		$nbConvEnCours = 0;
		$nbDesPistes = 0;
		$nbRiens = 0;
		$nbIndefinis = 0;

		for ($i = 0 ; $i < $nbEtudiants; $i++) {
			$idEtu = $tabEtudiants[$i]->getIdentifiantBDD();
			$statut = $tabEtudiants[$i]->getCodeEtudiant();

			switch ($statut) {
			    case "":
			    case "0":
				$nbIndefinis++;
				break;
			    case "1":
				$nbRiens++;
				break;
			    case "2":
				$nbDesPistes++;
				break;
			    case "3":
				$nbConvEnCours++;
				break;
			    case "4":
				$nbConvSignees++;
				break;
			    case "5":
				$nbAlters++;
				break;
			    case "6":
				$nbRechs++;
				break;
			    default:
				break;
			}

			?>
				<tr id="ligne<?php echo $i%2; ?>">
					<td>
						<?php echo $tabEtudiants[$i]->getNom()." ".$tabEtudiants[$i]->getPrenom(); ?>
					</td>
					<td align="center">
						<select name="<?php echo "statut[$idEtu]"; ?>">
							<option value="0" <?php if ($statut == "0" || $statut == "") echo "selected"; ?> >Indéfini</option>
							<option value="1" <?php if ($statut == "1") echo "selected"; ?> >Rien</option>
							<option value="2" <?php if ($statut == "2") echo "selected"; ?> >Des pistes</option>
							<option value="3" <?php if ($statut == "3") echo "selected"; ?> >En signature</option>
							<option value="4" <?php if ($statut == "4") echo "selected"; ?> >Signée</option>
							<option value="5" <?php if ($statut == "5") echo "selected"; ?> >Alternant</option>
							<option value="6" <?php if ($statut == "6") echo "selected"; ?> >Recherche</option>
						</select>
					</td>
				</tr>
			<?php
		}
		?>
				<tr id='entete2'>
					<td align="center">
						Total : <?php echo $nbEtudiants; ?>
					</td>
					<td align="center">
						Indéfini : <?php echo $nbIndefinis; ?>&nbsp;&nbsp;&nbsp;
						Rien : <?php echo $nbRiens; ?>&nbsp;&nbsp;&nbsp;
						Des pistes : <?php echo $nbDesPistes; ?>&nbsp;&nbsp;&nbsp
						En cours : <?php echo $nbConvEnCours; ?>&nbsp;&nbsp;&nbsp
						Signées : <?php echo $nbConvSignees; ?>&nbsp;&nbsp;&nbsp
						Alternants : <?php echo $nbAlters; ?>&nbsp;&nbsp;&nbsp;
						Recherche : <?php echo $nbRechs; ?>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
			<table align="center">
				<tr>
					<td align=center>
						<input type=submit name=valider value="Valider les modifications"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type=submit name=reset value="Tout réinitialiser"/>
					</td>
				</tr>
			</table>

			<input type="hidden" name="annee" value="<?php echo $annee; ?>"/>
			<input type="hidden" name="filiere" value="<?php echo $filiere; ?>"/>
			<input type="hidden" name="parcours" value="<?php echo $parcours; ?>"/>

		</form>
	<?php
	} else {
		echo "<br/><center>Aucun étudiant n'est dans cette promotion.<center/><br/>";
	}
} else {
	echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.<center/><br/>";
}


?>