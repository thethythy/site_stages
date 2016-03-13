<?php

$chemin = "../classes/";

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
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Parrain.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Soutenance.php");

header ("Content-type:text/html; charset=utf-8");

$filtres = array();

// Si pas d'année sélectionnée
if (!isset($_POST['annee'])) {
	$annee = Promotion_BDD::getLastAnnee();
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
}

// Si une recherche sur l'année est demandée
if (isset($_POST['annee']) && $_POST['annee'] != "") {
	$annee = $_POST['annee'];
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
}

// Si une recherche sur le parcours est demandé
if ($_POST['parcours'] != '*')
	array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));
	
// Si une recherche sur la filiere est demandée
if ($_POST['filiere'] != '*')
	array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

$filtre = $filtres[0];
for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);

$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
	// Récupération des étudiants ayant une convention
	$tabEtuWithConv = array();
	
	for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
		if ($tabEtudiants[$i]->getConvention($annee) != null)
			array_push($tabEtuWithConv, $tabEtudiants[$i]);
	}
	
	// Si il y a au moins un étudiant avec une convention
	if (sizeof($tabEtuWithConv) > 0) {
		// Affichage des stages des étudiants
		
		echo "<table>
				<tr id='entete'>
					<td width='35%'>Entreprise</td>
					<td width='35%'>Contact</td>
					<td width='30%'>Stagiaire</td>
				</tr>";
		
		for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
			$promotion = $tabEtuWithConv[$i]->getPromotion($annee);
			$promo_parcours = $promotion->getParcours();
			$promo_filiere = $promotion->getFiliere();
			$conv = $tabEtuWithConv[$i]->getConvention($annee);
			$contact = $conv->getContact();
			$entreprise = $contact->getEntreprise();
			
			?>
				<tr id="ligne<?php echo $i%2; ?>">
					<td>
						<br/>
						<?php echo $entreprise->getNom(); ?> <br/>
						<?php echo $entreprise->getAdresse(); ?> <br/>
						<?php echo $entreprise->getCodePostal()." "; ?>
						<?php echo $entreprise->getVille(); ?> <br/>
						<?php echo $entreprise->getPays(); ?>
						<br/><br/>
					</td>
					<td>
						<?php
							echo $contact->getNom()." ".$contact->getPrenom()."<br/>";
							
							if ($contact->getTelephone() != "")
								echo "Tel : ".$contact->getTelephone()."<br/>";
							
							if ($contact->getTelecopie() != "")
								echo "Fax : ".$contact->getTelecopie()."<br/>";
							
							if ($contact->getEmail() != "")
								echo "Email : ".$contact->getEmail();
						?>
					</td>
					<td>
						<table>
							<tr>
								<td colspan="2">
									<?php
										echo "Etudiant en ".$promo_filiere->getNom()." ".$promo_parcours->getNom()."<br/>";
									?>
								</td>
							</tr>
							
							<tr>
								<td width="50%">
									Résumé :
								</td>
								<td width="50%">
									<a href="./ficheDeStage.php?annee=<?php echo $annee; ?>&parcours=<?php echo $parcours; ?>&filiere=<?php echo $filiere; ?>&idEtu=<?php echo $tabEtuWithConv[$i]->getIdentifiantBDD(); ?>&idPromo=<?php echo $promotion->getIdentifiantBDD(); ?>" target="_blank">
										<img src="../images/resume.png" />
									</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php
		}
		echo "</table>";
	} else {
		echo "Aucun stage n'a été trouvé.";
	}
} else {
	echo "Aucune promotion ne correspond à ces critères de recherche.";
}

?>