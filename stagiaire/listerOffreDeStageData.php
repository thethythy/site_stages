<?php

$chemin = "../classes/";

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

header ("Content-type:text/html; charset=utf-8");

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

// Si une recherche sur le parcours est demandée
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
	array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

// Si une recherche sur la competence est demandée
if(isset($_POST['competence']) && $_POST['competence'] != '*')
	array_push($filtres, new FiltreNumeric("idcompetence", $_POST['competence']));

// Si une recherche sur la duree est demandée
if (isset($_POST['duree']) && $_POST['duree'] != '*') {
	array_push($filtres, new FiltreInferieur("dureemin", $_POST['duree']));
	array_push($filtres, new FiltreSuperieur("dureemax", $_POST['duree']));
}

$nbFiltres = sizeof($filtres);

if ($nbFiltres >= 2) {
	$filtre = $filtres[0];
	for ($i = 1; $i < sizeof($filtres); $i++)
		$filtre = new Filtre($filtre, $filtres[$i], "AND");
} else if ($nbFiltres == 1){
	$filtre = $filtres[0];
} else {
	$filtre = "";
}

$tabOffreDeStages = OffreDeStage::getListeOffreDeStage($filtre);

// Si il y a au moins une offre de stage
if (sizeof($tabOffreDeStages) > 0) { ?>
	<br/>
	<table width="100%">
		<tr id="entete">
			<td width="30%">Titre</td>
			<td width="35%">Entreprise</td>
			<td width="15%">Diplôme</td>
			<td width="15%">Spécialité</td>
			<td align="center" width="5%">Visualiser</td>
		</tr>

	<?php
		// Affichage des entreprises correspondants aux critères de recherches
		$cpt=0;
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
							<a href="./visualiserOffre.php?id=<?php echo $tabOffreDeStages[$i]->getIdentifiantBDD(); ?>
								&nom=<?php echo "".$_POST['nom'].""; ?>&ville=<?php echo "".$_POST['ville'].""; ?>
								&cp=<?php echo $_POST['cp']; ?>&pays=<?php echo "".$_POST['pays'].""; ?>
								&filiere=<?php echo $_POST['filiere']; ?>&parcours=<?php echo $_POST['parcours']; ?>
								&duree=<?php echo $_POST['duree']; ?>&competence=<?php echo $_POST['competence']; ?>">
							<img src="../images/search.png"></a>
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
	?>
		<br/>
		<p>Aucune offre de stage ne correspond aux critères de recherche.</p>
		<br/>
	<?php
}

?>