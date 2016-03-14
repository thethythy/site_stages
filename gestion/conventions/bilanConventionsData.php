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
	
	if (sizeof($tabEtudiants) > 0) {
		?>
			<table>
				<tr id="entete">
					<td width="80%">Etudiant</td>
					<td width="20%" align="center">Convention</td>
				</tr>
		<?php
		
		$nbConventions = 0;
		$nbEtudiants = sizeof($tabEtudiants);
		
		for ($i = 0 ; $i < $nbEtudiants; $i++) {
			$conv = $tabEtudiants[$i]->getConvention($annee);
			
			?>	
				<tr id="ligne<?php echo $i%2; ?>">
					<td>
						<?php echo $tabEtudiants[$i]->getNom()." ".$tabEtudiants[$i]->getPrenom(); ?>
					</td>
					<td align="center">
						<?php
							if ($tabEtudiants[$i]->getConvention($annee) != null) {
								$nbConventions++;
								echo "<img src='../../images/action_check.png' />";
							} else
								echo "<img src='../../images/action_remove.png' />";
						?>
					</td>
				</tr>
			<?php
		}
		?>
			<tr id='entete'>
				<td colspan="2" align="center">
					Total : <?php echo $nbConventions." / ".$nbEtudiants; ?>
				</td>
			</tr>
		</table>
		<?php
	} else {
		echo "<br/><center>Aucun étudiant n'est dans cette promotion.<center/><br/>";
	}
} else {
	echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.<center/><br/>";
}
?>