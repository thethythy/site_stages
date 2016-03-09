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

// Pr�cisons l'encodage des donn�es si cela n'est pas d�j� fait
if (!headers_sent())
	header("Content-type: text/html; charset=iso-8859-15");

// Cr�ation du filtre de recherche

$filtres = array();

// S�lection d'une ann�e
if (!isset($_POST['annee'])) 
	// Si pas d'ann�e s�lectionn�e
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", Promotion_BDD::getLastAnnee()));
else
	// Si une recherche sur l'ann�e est demand�e
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));

// S�lection d'un parcours 
if($_POST['parcours'] != '*')
	array_push($filtres, new FiltreString("idparcours", $_POST['parcours']));
	
// S�lection d'une fili�re
if($_POST['filiere'] != '*')
	array_push($filtres, new FiltreString("idfiliere", $_POST['filiere']));

$filtre = $filtres[0];

for ( $i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

// Recherche des promotions correspondant aux crit�res
$tabPromos = Promotion_BDD::getListePromotions($filtre);

// Est-ce qu'il y a des promotions qui suit les crit�res ?
if (sizeof($tabPromos) > 0) {
	
	// R�cup�ration des entreprises
	$tabEntreprises = Entreprise::getListeEntreprises("");
	
	// Est-ce qu'il y a des entreprises ?
	if (sizeof($tabEntreprises) > 0) {
		// En-t�te du tableau
		echo "<table>
					<tr id='entete'>
						<td width='100%'>Etiquette entreprise</td>
					</tr>";
		$j = 0;
		
		for ($k=0; $k < sizeof($tabEntreprises); $k++) {
			
			// R�cup�ration des contacts
			$tabContacts = $tabEntreprises[$k]->listeDeContacts();
			
			// Pour tous les contacts class�s par ordre alphab�tique
			for ($i=0; $i < sizeof($tabContacts); $i++) {
		
				// Le contact courant
				$contact = $tabContacts[$i];
		
				// Est-ce que le contact est li�e � une convention qui suit les crit�res ?
				if (Convention_BDD::existe2($contact->getIdentifiantBDD(), $filtre)) {
			
					// L'entreprise qui correspond au contact qui suit les crit�res de recherche
					$entreprise = $tabEntreprises[$k];
		
					// Affichage de l'�tiquette
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
		echo "<br/><p>Aucune entreprise n'a �t� trouv�e</p><br/>";
	}
} else {
	echo "<br/><p>Aucune promotion ne correspond � ces crit�res de recherche.</p><br/>";
}

?>