<?php

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Parrain.php");
include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Couleur.php");
include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Convention.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Entreprise.php");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");

header ("Content-type:text/html; charset=utf-8");

$filtres = array();

// Si pas d'année sélectionnée
if (!isset($_POST['annee']))
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", Promotion_BDD::getLastAnnee()));

// Si une recherche sur l'année est demandée
if (isset($_POST['annee']) && $_POST['annee'] != "")
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));

// Si une recherche sur le nom du parrain est demandée
if (isset($_POST['nom']) && $_POST['nom'] != '*')
	array_push($filtres, new FiltreNumeric("idparrain", $_POST['nom']));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
	array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

// Si une recherche sur le parcours est demandé
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
	array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

$nbFiltres = sizeof($filtres);

if ($nbFiltres >= 2) {
	$filtre = $filtres[0];
	for ($i = 1; $i < sizeof($filtres); $i++)
		$filtre = new Filtre($filtre, $filtres[$i], "AND");
} else if ($nbFiltres == 1) {
		$filtre = $filtres[0];
} else {
	$filtre = "";
}

$tabConventions = Convention::getListeConvention($filtre);

// Afficher le résultat de la recherche
if (sizeof($tabConventions) > 0) {?>
<br/>
	<table width="100%">
		<tr id="entete">
			<td width="15%">Référent</td>
			<td width="15%">Etudiant</td>
			<td width="15%">Diplôme</td>
			<td width="40%">Entreprise</td>
			<td align="center" width="15%">Sujet de stage</td>
		</tr>

	<?php
	// Affichage des conventions correspondants aux critères de recherches
	$cpt = 0;
	for ($i = 0; $i < sizeof($tabConventions); $i++) {
		if (isset($_POST['annee']) && $_POST['annee'] != "")
			$annee = $_POST['annee'];
		else
		 	$annee = Promotion_BDD::getLastAnnee();
			$etudiant = $tabConventions[$i]->getEtudiant();
			$promotion = $etudiant->getPromotion($annee);
			$filiere = $promotion->getFiliere();
			$parcours = $promotion->getParcours();
		?>
		<tr id="ligne<?php echo $cpt%2; $cpt++; ?>">
			<td>
				<?php
					$parrain = $tabConventions[$i]->getParrain();
					$couleur = $parrain->getCouleur();
					echo $parrain->getNom()." ".$parrain->getPrenom();
				?>
			</td>

			<td><?php echo $etudiant->getNom()." ".$etudiant->getPrenom(); ?></td>

			<td><?php echo $filiere->getNom()." ".$parcours->getNom(); ?></td>

			<td>
				<?php
					$entreprise = $tabConventions[$i]->getEntreprise();
					echo $entreprise->getNom()."<br/>".$entreprise->getAdresse()."<br/>".$entreprise->getCodePostal()." ".$entreprise->getVille();
				?>
			</td>

			<td align="center">
				<a href="./ficheDeStage.php?annee=<?php echo $_POST['annee']; ?>&parcours=<?php echo $_POST['parcours']; ?>&filiere=<?php echo $_POST['filiere']; ?>&nom=<?php echo $_POST['nom']; ?>&idEtu=<?php echo $etudiant->getIdentifiantBDD(); ?>&idPromo=<?php echo $promotion->getIdentifiantBDD(); ?>"  target="_blank">
					<img src="../images/resume.png" />
				</a>
			</td>
		</tr>
		<?php
	}	?>
	</table>
<br/>
<?php }else{
	?>
		<br/>
			<p>Aucun référent ne correspond aux critères de recherche.</p>
		<br/>
	<?php
}

?>