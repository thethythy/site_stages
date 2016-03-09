<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/OffreDeStage_BDD.php");
include_once($chemin."ihm/OffreDeStage_IHM.php");
include_once($chemin."moteur/OffreDeStage.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Entreprise.php");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreSuperieur.php");
include_once($chemin."moteur/FiltreInferieur.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."bdd/Competence_BDD.php");
include_once($chemin."moteur/Competence.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
	header("Content-type: text/html; charset=utf-8");

// Prise en compte des paramètres
$filtres = array();

// Si une recherche sur le nom de l'entreprise est demandée
if (isset($_POST['nom']) && $_POST['nom'] != "")
	array_push($filtres, new FiltreString("nom", "%".$_POST['nom']."%"));

// Si une recherche sur le code postal est demandée
if (isset($_POST['cp']) && $_POST['cp'] != "")
	array_push($filtres, new FiltreString("codepostal", $_POST['cp']."%"));

// Si une recherche sur la ville est demandée
if (isset($_POST['ville']) && $_POST['ville'] != "")
	array_push($filtres, new FiltreString("ville", $_POST['ville']."%"));

	// Si une recherche sur le pays est demandée
if (isset($_POST['pays']) && $_POST['pays'] != "")
	array_push($filtres, new FiltreString("pays", $_POST['pays']."%"));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
	array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

// Si une recherche sur le parcours est demandé
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
	array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

// Si une recherche sur la filiere est demandée
if (isset($_POST['competence']) && $_POST['competence'] != '*')
	array_push($filtres, new FiltreNumeric("idcompetence", $_POST['competence']));

// Si une recherche sur la duree est demandée
if (isset($_POST['duree']) &&  $_POST['duree'] != '*') {
		array_push($filtres, new FiltreInferieur("dureemin", $_POST['duree']));
		array_push($filtres, new FiltreSuperieur("dureemax", $_POST['duree']));
}

if (sizeof($filtres) > 0) {
	$filtre = $filtres[0];
	for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");
} else
	$filtre = "";

$tabOffreDeStages = OffreDeStage::getListeOffreDeStage($filtre);

// Si il y a au moins une offre de stage à traiter
if (sizeof($tabOffreDeStages) > 0) {
	// Affichage des entreprises correspondants aux critères de recherches
	echo "<br/>";
	$cpt = 0;
	$enteteAffichee = false;

	for ($i = 0; $i < sizeof($tabOffreDeStages); $i++) {
		if (!$tabOffreDeStages[$i]->estVisible()) {
			if (!$enteteAffichee) {
				$enteteAffichee = true;
				?>
					<p>Voici la liste des offres de stage qui restent à traiter :</p>
					<table width="100%">
						<tr id="entete">
							<td width="30%">Titre</td>
							<td width="35%">Entreprise</td>
							<td width="13%">Diplôme</td>
							<td width="13%">Spécialité</td>
							<td align="center" width="9%">A Valider</td>
						</tr>
				<?php
			}
			?>
				<tr id="ligne<?php echo $cpt%2; $cpt++; ?>">
					<td><?php echo $tabOffreDeStages[$i]->getTitre(); ?></td>
					<td><?php
							$entreprise = $tabOffreDeStages[$i]->getEntreprise();
							echo $entreprise->getNom();
						?>
					</td>
					<td><?php
							$profil = $tabOffreDeStages[$i]->getListeProfilSouhaite();
							for ($j = 0; $j < sizeof($profil); $j++) {
								if ($j == (sizeof($profil)-1)) {
									echo $profil[$j]->getNom();
								} else {
									echo $profil[$j]->getNom()." / ";
								}
							}
						?>
					</td>
					<td><?php
							$themes = $tabOffreDeStages[$i]->getThemes();
							for ($j = 0; $j < sizeof($themes); $j++) {
								if ($j == (sizeof($themes)-1)) {
									echo $themes[$j]->getNom();
								} else {
									echo $themes[$j]->getNom()." / ";
								}
							}
						?>
					</td>
					<td align="center">
						<a href="./editionOffreDeStage.php?id=<?php echo $tabOffreDeStages[$i]->getIdentifiantBDD(); ?>">
							<img src="../../images/search.png">
						</a>
					</td>
				</tr>
			<?php
		}
	}

	if ($cpt == 0) {
		echo "<p>Toutes les offres de stages ont été validées.</p>";
	}

	?>

	<table width="100%">
		<tr id="entete">
			<td width="30%">Titre</td>
			<td width="35%">Entreprise</td>
			<td width="13%">Diplôme</td>
			<td width="13%">Spécialité</td>
			<td align="center" width="9%">Visualiser</td>
		</tr>

		<?php
			$cpt = 0;
			echo "<p>Voici la liste des offres de stage disponibles sur le site des stages : </p>";
			for ($i = 0; $i < sizeof($tabOffreDeStages); $i++) {
				if ($tabOffreDeStages[$i]->estVisible()) {
					?>
						<tr id="ligne<?php echo $cpt%2; $cpt++; ?>">
							<td><?php echo $tabOffreDeStages[$i]->getTitre(); ?></td>
							<td><?php
									$entreprise = $tabOffreDeStages[$i]->getEntreprise();
									echo $entreprise->getNom();
								?>
							</td>
							<td><?php
									$profil = $tabOffreDeStages[$i]->getListeProfilSouhaite();
									for ($j = 0; $j < sizeof($profil); $j++) {
										if ($j == (sizeof($profil)-1)) {
											echo $profil[$j]->getNom();
										} else {
											echo $profil[$j]->getNom()." / ";
										}
									}
								?>
							</td>
							<td><?php
									$themes = $tabOffreDeStages[$i]->getThemes();
									for ($j = 0; $j < sizeof($themes); $j++) {
										if ($j == (sizeof($themes)-1)) {
											echo $themes[$j]->getNom();
										} else {
											echo $themes[$j]->getNom()." / ";
										}
									}
								?>
							</td>
							<td align="center">
								<a href="./editionOffreDeStage.php?id=<?php	echo $tabOffreDeStages[$i]->getIdentifiantBDD(); ?>">
									<img src="../../images/search.png">
								</a>
							</td>
						</tr>
					<?php
				}
			}
		?>

	</table>
	<br/>

<?php

} else {
	echo "<br/><center>Aucune offre de stage ne correspond aux critères de recherche.<center/><br/>";
}

?>