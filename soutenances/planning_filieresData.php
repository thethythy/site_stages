<?php

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."bdd/Salle_BDD.php");
include_once($chemin."moteur/Salle.php");
include_once($chemin."bdd/DateSoutenance_BDD.php");
include_once($chemin."moteur/DateSoutenance.php");
include_once($chemin."bdd/Soutenance_BDD.php");
include_once($chemin."moteur/Soutenance.php");
include_once($chemin."bdd/SujetDeStage_BDD.php");
include_once($chemin."moteur/SujetDeStage.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/Utils.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Menu.php");

header ("Content-type:text/html; charset=utf-8");

if (!isset($_POST['promotion'])) {
	if (date('n')>=10) $annee = date('Y');
	else $annee = date('Y')-1;
	//$annee = 2010; // Pour tester
				
	// Liste promotion de l'année
	$filtrePromotion = new FiltreNumeric('anneeuniversitaire', $annee);
	$tabPromotion = Promotion::listerPromotions($filtrePromotion);
	$promotion = $tabPromotion[0];
	
} else {
	$promotion = Promotion::getPromotion($_POST['promotion']);
}

if (isset($promotion)) {
	$annee = $promotion->getAnneeUniversitaire();

	$enteteTableau ="
		<table>
		<tr id='entete'>
			<td rowspan='2' style='width: 85px;'>Horaires</td>
			<td rowspan='2' style='width: 160px;'>Nom prénom</td>
			<td rowspan='2' style='width: 50px;'>Fiche de stage</td>
			<td colspan='2'>Jury</td>
			<td rowspan='2' style='width: 75px;'>Salle</td>
		</tr>
		<tr id='entete'>
			<td style='width: 110px;'>Référent</td>
			<td style='width: 110px;'>Examinateur</td>
		</tr>
	";
	$finTableau = "</table>";
	echo '<table>';

	// Listes conventions
	$filtreConvention = new FiltreNumeric($tab19.'.idpromotion', $promotion->getIdentifiantBDD());
	// Listes conventions
	$listeConvention = Convention::getListeConvention($filtreConvention);
	
	// Tri des conventions selon l'heure de passage
	usort($listeConvention, array("Convention", "compareHeureSoutenance"));
	
	// Pour chaque date soutenance
	$filtreDateSoutenance = new FiltreNumeric('annee', $annee+1);
	$listeDateSoutenance = DateSoutenance::listerDateSoutenance($filtreDateSoutenance);
	$k = 0;
	foreach ($listeDateSoutenance as $dateActuelle) {
		
		$i = 0; $j = 0;
		// Pour chaque convention
		foreach ($listeConvention as $convention) {
			$soutenance = $convention->getSoutenance();
			// On test s'il y a une soutenance associee a la date
			if ($soutenance->getIdentifiantBDD()!=0 && $soutenance->getSalle()->getIdentifiantBDD()!=0) {
				if ($soutenance->getDateSoutenance()->getIdentifiantBDD()==$dateActuelle->getIdentifiantBDD()) {
					if ($j==0) {
						echo $finTableau;
						echo '<h2> Le '.$dateActuelle->getJour().' '.Utils::numToMois($dateActuelle->getMois()).' '.$dateActuelle->getAnnee().'</h2>';
						echo $enteteTableau;
					}
					$j++; $k++;
					$nomSalle = ($soutenance->getSalle()->getIdentifiantBDD()!=0) ? $soutenance->getSalle()->getNom() : "Non attribuée";
					$etudiant = $convention->getEtudiant();
					$parcours = $promotion->getParcours();
					$filiere = $promotion->getFiliere();
					$parrain = $convention->getParrain();
					$examinateur = $convention->getExaminateur();
					
					// Gestion horaires
					$tempsSoutenance = $filiere->getTempsSoutenance();
					$heureDebut = $soutenance->getHeureDebut();
					$minuteDebut = $soutenance->getMinuteDebut();
					$heureFin = $heureDebut;
					$minuteFin = ($minuteDebut + $tempsSoutenance);
					if ($minuteFin>59) {
						$minuteFin-=60;
						$heureFin++;
					}
					$minuteDebut = ($minuteDebut!=0) ? $minuteDebut : "00";
					$minuteFin = ($minuteFin!=0) ? $minuteFin : "00";
					
					// Incrementation
					$i=($i+1)%2;
					
					// Affichage
					echo "
						<tr id='ligne".$i."'>
							<td>".$heureDebut."h".$minuteDebut." / ".$heureFin."h".$minuteFin."</td>
							<td>".strtoupper($etudiant->getNom())." ".$etudiant->getPrenom()."</td>
							<td><a href='fichedestage.php?idEtu=".$etudiant->getIdentifiantBDD()."&idPromo=".$promotion->getIdentifiantBDD()."' target='_blank'><img src='../images/resume.png' alt='Résumé'/></a></td>
							<td>".strtoupper($parrain->getNom())." ".$parrain->getPrenom()."
							<td>".strtoupper($examinateur->getNom())." ".$examinateur->getPrenom()."
							<td>".$nomSalle."</td>
						</tr>
					";
				}
			}
		}
	}
	echo $finTableau;
	
	// S'il n'y a pas de conventions
	if ($k == 0)
		echo "<br/><center>Il n'y a pas de soutenance associée à cette promotion.</center>";

} else
	echo "<br/><center>Veuillez sélectionner une promotion.</center>";

?>