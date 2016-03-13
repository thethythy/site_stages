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
include_once($chemin."moteur/Utils.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
	header("Content-type: text/html; charset=iso-8859-15");

// Si une suppression d'un étudiant ou une modification de l'email a été effectuée
if (isset($_POST['email']) || isset($_GET['id'])) {
	$annee = $_POST['annee'];
	$parcours = $_POST['parcours'];
	$filiere = $_POST['filiere'];
} else {
	if (!isset($_POST['annee']))
		$annee = Promotion_BDD::getLastAnnee();
	else
		$annee = $_POST['annee'];
	
	if (!isset($_POST['parcours'])) {
		$tabParcours = Parcours::listerParcours();
		$parcours = $tabParcours[0]->getIdentifiantBDD();
	} else
		$parcours = $_POST['parcours'];
	
	if (!isset($_POST['filiere'])) {
		$tabFilieres = Filiere::listerFilieres();
		$filiere = $tabFilieres[0]->getIdentifiantBDD();
	} else
		$filiere = $_POST['filiere'];
}

$filtres = array();
array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
array_push($filtres, new FiltreNumeric("idparcours", $parcours));
array_push($filtres, new FiltreNumeric("idfiliere", $filiere));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
	$idPromo = $tabPromos[0][0];
	
	$promotion = Promotion::getPromotion($idPromo);
	$email = $promotion->getEmailPromotion();

	?>
		<br/>
		<form method=post action="modifierPromotion.php">
			<input type="hidden" value="<?php echo $idPromo; ?>" name="promo"/>
			<input type="submit" value="Modifier l'email de la promotion :"/>
			<input type='text' value="<?php if ($email == "") echo "?"; else echo $email; ?>" name='email'>
		</form>
	<?php
	
	// Si il y a au moins un étudiant
	if (sizeof($tabEtudiants) > 0) {
		// Affichage des étudiants correspondants aux critères de recherches
		echo "Nombre d'étudiants de la promotion : ".sizeof($tabEtudiants)."<p/>";
		echo "<table width='75%'>
				<tr id='entete'>
					<td width='55%'>Nom et Prénom</td>
					<td width='10%' align='center'>Modifier</td>
					<td width='10%' align='center'>Supprimer</td>
				</tr>";
		for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
			?>
				<tr id="ligne<?php echo $i%2; ?>">
					<td>
						<?php echo $tabEtudiants[$i]->getNom()." ".$tabEtudiants[$i]->getPrenom(); ?>
					</td>
					<td align="center">
						<a href="modifierEtudiant.php?promo=<?php echo $idPromo; ?>&id=<?php echo $tabEtudiants[$i]->getIdentifiantBDD(); ?>">
							<img src="../../images/reply.png"/>
						</a>
					</td>
					<td align="center">
						<a href="modifierPromotion.php?promo=<?php echo $idPromo; ?>&id=<?php echo $tabEtudiants[$i]->getIdentifiantBDD(); ?>">
							<img src="../../images/action_delete.png"/>
						</a>
					</td>
				</tr>
			<?php
		}
		echo "</table>";
	} else {
		echo "<br/><center>Aucun étudiant n'a été trouvé.</center><br/>";
	}
	?>
	
	<br/>
	
	<table align="center">
		<tr>
			<td width="25%" align="center">
				<form method=post action="ajouterEtudiant.php">
					<input type="hidden" value="<?php echo $idPromo; ?>" name="promo"/>
					<input type="submit" value="Ajouter un nouvel étudiant"/>
				</form>
			</td>
			<td width="25%" align="center">
				<form method=post action="importationEtudiants.php">
					<input type="hidden" value="<?php echo $idPromo; ?>" name="promo"/>
					<input type="submit" value="Importer des étudiants"/>
				</form>
			</td>
			<td width="25%" align="center">
				<form method=post action="modifierPromotion.php">
					<input type="hidden" value="<?php echo $idPromo; ?>" name="delpromo"/>
					<input type="submit" value="Supprimer la promotion"/>
				</form>
			</td>
		</tr>
	</table>
	
	<br/><br/>
	
	<center>
		<form method=post action="../">
			<input type="submit" value="Retourner au menu"/>
		</form>
	</center>
	
	<?php
} else {
	echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.</center><br/>";
}

?>