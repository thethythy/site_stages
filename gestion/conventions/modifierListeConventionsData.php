<?php

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
	$idPromo = $tabPromos[0][0];
	
	// Récupération des étudiants ayant une convention
	$tabEtuWithConv = array();
	
	for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
		if ($tabEtudiants[$i]->getConvention($annee) != null)
			array_push($tabEtuWithConv, $tabEtudiants[$i]);
	}
		
	// Si il y a au moins un étudiant avec une convention
	if (sizeof($tabEtuWithConv) > 0) {
		// Affichage des conventions des étudiants
		
		echo "<table>
				<tr id='entete'>
						<td width='20%'>Etudiant</td>
						<td width='15%'>Référent</td>
						<td width='15%'>Examinateur</td>
						<td width='15%'>Contact</td>
						<td width='15%'>Entreprise</td>
						<td width='10%' align='center'>Modifier</td>
						<td width='10%' align='center'>Supprimer</td>
					</tr>";
		for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
			$conv = $tabEtuWithConv[$i]->getConvention($annee);
			$parrain = $conv->getParrain();
			$examinateur = $conv->getExaminateur();
			$contact = $conv->getContact();
			$entreprise = $contact->getEntreprise();
			
			?>
				<tr id="ligne<?php echo $i%2; ?>">
					<td>
						<?php echo $tabEtuWithConv[$i]->getNom()." ".$tabEtuWithConv[$i]->getPrenom(); ?>
					</td>
					<td>
						<?php echo $parrain->getNom()." ".$parrain->getPrenom(); ?>
					</td>
					<td>
						<?php echo $examinateur->getNom()." ".$examinateur->getPrenom(); ?>
					</td>
					<td>
						<?php echo $contact->getNom()." ".$contact->getPrenom(); ?>
					</td>
					<td>
						<?php echo $entreprise->getNom(); ?>
					</td>
					<td align="center">
						<a href="modifierConvention.php?promo=<?php echo $idPromo; ?>&id=<?php echo $conv->getIdentifiantBDD(); ?>">
							<img src="../../images/reply.png"/>
						</a>
					</td>
					<td align="center">
						<a href="modifierListeConventions.php?promo=<?php echo $idPromo; ?>&id=<?php echo $conv->getIdentifiantBDD(); ?>">
							<img src="../../images/action_delete.png"/>
						</a>
					</td>
				</tr>
			<?php
		}
		echo "</table>";
	} else {
		echo "<br/><center>Aucune convention n'a été trouvée.</center><br/>";
	}
} else {
	echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.</center><br/>";
}

?>