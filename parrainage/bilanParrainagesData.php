<?php

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");
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
	
// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
	array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));
	
// Si une recherche sur le parcours est demandé
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
	array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));
	
$nbFiltres = sizeof($filtres);
	
if ($nbFiltres >= 2) {
	$filtre = $filtres[0];
	for ($i=1; $i < sizeof($filtres); $i++)
		$filtre = new Filtre($filtre, $filtres[$i], "AND");
} else if($nbFiltres == 1) {
	$filtre = $filtres[0];
} else {
	$filtre = "";
}
	
$tabPromotions = Promotion::listerPromotions($filtre);
	
// Si une recherche sur le nom du parrain est demandée
if(isset($_POST['nom']) && $_POST['nom'] != '*')
	array_push($filtres, new FiltreNumeric("idparrain", $_POST['nom']));
	
$nbFiltres = sizeof($filtres);
	
if ($nbFiltres >= 2) {
	$filtre = $filtres[0];
	for ($i=1; $i < sizeof($filtres); $i++)
		$filtre = new Filtre($filtre, $filtres[$i], "AND");
} else if($nbFiltres == 1) {
	$filtre = $filtres[0];
} else {
	$filtre = "";
}

$tabConventions = Convention::getListeConvention($filtre);

// Afficher le résultat de la recherche
if (sizeof($tabConventions) > 0 && sizeof($tabPromotions) > 0) {
	
	?>
	<table id="data" width='60%'>
		<tr id="entete">
			<td width="20%">Référent</td>
			<?php
		
			for ($i=0; $i < sizeof($tabPromotions); $i++) {
				echo "<td width='10%'>".$tabPromotions[$i]->getFiliere()->getNom()." ".$tabPromotions[$i]->getParcours()->getNom()."</td>";
			}
			
			echo "<td width='6%'>Total</td><td width='5%'>ICalendar</td></tr>";
			
			$cpt = 0;
			$oldparrain = 0;
			for ($i=0; $i<sizeof($tabConventions); $i++) {
			
				if ($tabConventions[$i]->getIdParrain()!='') {
				
					if (isset($_POST['annee']) && $_POST['annee'] != "")
						$annee = $_POST['annee'];
					else
						$annee = Promotion_BDD::getLastAnnee();
					
					$parrain = $tabConventions[$i]->getParrain();
					$couleur = $parrain->getCouleur();
					
					if ($parrain->getIdentifiantBDD() != $oldparrain) {
						?>
						<tr id="ligne<?php echo $cpt%2; $cpt++; ?>">
							<td>
								<?php
									echo $parrain->getNom()." ".$parrain->getPrenom();
								?>
							</td>
							
							<?php
								$total=0;
								for ($j=0; $j < sizeof($tabPromotions); $j++) {
								
									$filiere = $tabPromotions[$j]->getFiliere();
									$parcours = $tabPromotions[$j]->getParcours();
								
									$nbParrainage = Convention_BDD::compteConvention($annee, $parrain->getIdentifiantBDD(), $filiere->getIdentifiantBDD(), $parcours->getIdentifiantBDD());
									$total = $total + $nbParrainage;
									echo "<td>$nbParrainage</td>";
								}
							?>
							
							<td><?php echo $total; ?></td>
							
							<td>
								<a href='getEnseignantICal.php?id=<?php echo $parrain->getIdentifiantBDD(); ?>'>Export</a>
								<a href='webcal://info-stages.univ-lemans.fr/parrainage/getEnseignantICal.php?id=<?php echo $parrain->getIdentifiantBDD(); ?>'>Abonnement</a>
							</td>
							
						</tr>
						<?php
						$oldparrain = $parrain->getIdentifiantBDD();
					}
				}
			}
			?>
	
	</table>
	
	<br/>
		
	<?php
	
}else{
	?>
		<br/>
		<p>Aucun référent ne correspond aux critères de recherche.</p>
		<br/>
	<?php
}

?>