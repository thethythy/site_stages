<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Contact.php");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Entreprise.php");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Convention.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Promotion_IHM.php");

header ("Content-type:text/html; charset=utf-8");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
	header("Content-type: text/html; charset=iso-8859-15");

// Création du filtre de recherche

$filtres = array();

// Sélection d'une année
if (!isset($_POST['annee'])) 
	// Si pas d'année sélectionnée
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", Promotion_BDD::getLastAnnee()));
else
	// Si une recherche sur l'année est demandée
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));

// Sélection d'un parcours 
if($_POST['parcours'] != '*')
	array_push($filtres, new FiltreString("idparcours", $_POST['parcours']));
	
// Sélection d'une filière
if($_POST['filiere'] != '*')
	array_push($filtres, new FiltreString("idfiliere", $_POST['filiere']));

$filtre = $filtres[0];

for ( $i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

// Recherche des promotions correspondant aux critères
$tabPromos = Promotion_BDD::getListePromotions($filtre);

// Est-ce qu'il y a des promotions qui suit les critères ?
if (sizeof($tabPromos) > 0) {
	
	// Récupération des entreprises
	$tabEntreprises = Entreprise::getListeEntreprises("");
	
	// Est-ce qu'il y a des entreprises ?
	if (sizeof($tabEntreprises) > 0) {
		// En-tête du tableau
		echo "<table>
					<tr id='entete'>
						<td width='100%'>Etiquette entreprise</td>
					</tr>";
		$j = 0;
		
		for ($k=0; $k < sizeof($tabEntreprises); $k++) {
			
			// Récupération des contacts
			$tabContacts = $tabEntreprises[$k]->listeDeContacts();
			
			// Pour tous les contacts classés par ordre alphabétique
			for ($i=0; $i < sizeof($tabContacts); $i++) {
		
				// Le contact courant
				$contact = $tabContacts[$i];
		
				// Est-ce que le contact est liée à une convention qui suit les critères ?
				if (Convention_BDD::existe2($contact->getIdentifiantBDD(), $filtre)) {
			
					// L'entreprise qui correspond au contact qui suit les critères de recherche
					$entreprise = $tabEntreprises[$k];
		
					// Affichage de l'étiquette
					?>
					<tr id="ligne<?php echo $j%2; ?>">
						<td>
							<br/>
							<?php echo $contact->getPrenom()." ".$contact->getNom(); ?><br/>
							<?php echo $entreprise->getNom(); ?><br/>
							<?php echo $entreprise->getAdresse(); ?><br/>
							<?php echo $entreprise->getCodePostal()." "; ?><?php echo $entreprise->getVille(); ?><br/>
							<br/>
						</td>
					</tr>
					<?php
					$j++; // Pour l'affichage alternatif
				}
			}
		}
		
		echo "</table>";
		
	} else {
		echo "<br/><p>Aucune entreprise n'a été trouvée</p><br/>";
	}
} else {
	echo "<br/><p>Aucune promotion ne correspond à ces critères de recherche.</p><br/>";
}

?>