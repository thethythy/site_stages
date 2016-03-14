<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Promotion.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
	header("Content-type: text/html; charset=iso-8859-15");

$filtres = array();

// Si pas d'année sélectionnée
if (!isset($_POST['annee'])) {
	$annee = Promotion_BDD::getLastAnnee();
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
} else {
	$annee = $_POST['annee'];
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));
}

if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
	array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
	array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
	// Si il y a au moins un étudiant
	if (sizeof($tabEtudiants) > 0) {
		// Affichage des étudiants correspondants aux critères de recherches

		echo "Nombre d'étudiants sélectionnés : ".sizeof($tabEtudiants)."<p/>";

		echo "<table>
				<tr id='entete'>
						<td width='40%'>Nom et Prénom</td>
						<td width='40%'>Mail institutionnel</td>
						<td width='10%'>Diplôme</td>
						<td width='10%'>Spécialité</td>
					</tr>";
		for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
			?>
				<tr id="ligne<?php echo $i%2; ?>">
					<td>
						<?php echo $tabEtudiants[$i]->getNom()." ".$tabEtudiants[$i]->getPrenom();	?>
					</td>
					<?php $promo = $tabEtudiants[$i]->getPromotion($annee);	?>
					<td>
						<?php echo $tabEtudiants[$i]->getEmailInstitutionel(); ?>
					</td>
					<td>
						<?php
							$filiere = $promo->getFiliere();
							echo $filiere->getNom();
						?>
					</td>
					<td>
						<?php
							$parcours = $promo->getParcours();
							echo $parcours->getNom();
						?>
					</td>
				</tr>
			<?php
		}
		echo "</table>";
	} else {
		echo "<br/><center>Aucun étudiant n'a été trouvé.</center><br/>";
	}
} else {
	echo "<br/><center>Aucune promotion ne correspond aux critères de recherche.</center><br/>";
}

?>