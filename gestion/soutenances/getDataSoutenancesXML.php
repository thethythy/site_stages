<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/DateSoutenance_BDD.php");
include_once($chemin."moteur/DateSoutenance.php");

include_once($chemin."bdd/Soutenance_BDD.php");
include_once($chemin."moteur/Soutenance.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");

include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."moteur/Couleur.php");

include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Contact.php");

include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."moteur/Entreprise.php");

include_once($chemin."bdd/Salle_BDD.php");
include_once($chemin."moteur/Salle.php");

// Format de la réponse
header("Content-type:text/xml");

// Début du flux XML
print("<?xml version='1.0' encoding='iso-8859-1' ?>\n");
print("<data>\n");

// Récupération des soutenances de l'année sélectionnée
if (isset($_GET["annee"])) $annee = $_GET["annee"] + 1 ; else $annee = Promotion_BDD::getLastAnnee() + 1;

$tabSoutenances = Soutenance::listerSoutenancesFromAnnee($annee);

if (sizeof($tabSoutenances) > 0) {
	
	for ($i = 0; $i < sizeof($tabSoutenances); $i++) {
		
		// Début de la balise et id de l'événement = id de la soutenance
		print("\t<event id='".$tabSoutenances[$i]->getIdentifiantBDD()."'>\n");
		
		// Début de l'événement
		$heureDebut = $tabSoutenances[$i]->getHeureDebut();
		$minDebut = $tabSoutenances[$i]->getMinuteDebut();
		$jour = $tabSoutenances[$i]->getDateSoutenance()->getJour();
		$mois = $tabSoutenances[$i]->getDateSoutenance()->getMois();
		$date_debut = $annee."-".$mois."-".$jour." ".$heureDebut.":".$minDebut.":00";
		print("\t\t<start_date><![CDATA[".$date_debut."]]></start_date>\n");
		
		// Fin de l'événement
		$convention = Soutenance::getConvention($tabSoutenances[$i]);
		$etudiant = $convention->getEtudiant();
		$promotion = $etudiant->getPromotion($annee - 1);
		$filiere = $promotion->getFiliere();
		$temps_soutenance = $filiere->getTempsSoutenance();
		$date = new DateTime($date_debut);
		$date->modify("+ ".$temps_soutenance." minutes");
		$heureFin = $date->format("H");
		$minFin = $date->format("i");
		$date_fin = $annee."-".$mois."-".$jour." ".$heureFin.":".$minFin.":00";
		print("\t\t<end_date><![CDATA[".$date_fin."]]></end_date>\n");
		
		// Contenu ??
		print("\t\t<text></text>\n");
		
		// Détails
		$prenom_nom_etudiant = $etudiant->getPrenom()." ".$etudiant->getNom();
		print("\t\t<details><![CDATA[".$prenom_nom_etudiant."]]></details>\n");
		
		// Couleur du texte = noir
		print("\t\t<textColor>#000000</textColor>\n");
		
		// Identifiant dans l'arbre
		$iditemtree = $promotion->getIdentifiantBDD()."_". $filiere->getIdentifiantBDD()."_".$convention->getIdentifiantBDD();
		print("\t\t<iditemtree>".$iditemtree."</iditemtree>\n");
		print("\t\t<idconvention>".$convention->getIdentifiantBDD()."</idconvention>\n");
		
		// Parrain
		$nom_prenom_parrain = $convention->getParrain()->getNom()." ".$convention->getParrain()->getPrenom();
		print("\t\t<parrain><![CDATA[".$nom_prenom_parrain."]]></parrain>\n");
		print("\t\t<idparrain>".$convention->getParrain()->getIdentifiantBDD()."</idparrain>\n");
		
		// Couleur de l'événement = celle du parrain
		print("\t\t<color>#".$convention->getParrain()->getCouleur()->getCode()."</color>\n");
		
		// Examinateur
		$examinateur = $convention->getExaminateur();
		$nom_prenom_examinateur = $examinateur->getNom()." ".$examinateur->getPrenom();
		print("\t\t<examinateur><![CDATA[".$nom_prenom_examinateur."]]></examinateur>\n");
		print("\t\t<idexaminateur>".$examinateur->getIdentifiantBDD()."</idexaminateur>\n");
		
		// Entreprise
		$contact = $convention->getContact();
		$nom_lieu_entreprise = $contact->getEntreprise()->getNom()." (".$contact->getEntreprise()->getVille().")";
		print("\t\t<entreprise><![CDATA[".$nom_lieu_entreprise."]]></entreprise>\n");
		print("\t\t<idcontact>".$contact->getIdentifiantBDD()."</idcontact>\n");
		
		// Identifiant de la salle
		print("\t\t<idsalle>".$tabSoutenances[$i]->getSalle()->getIdentifiantBDD()."</idsalle>\n");
		
		// Soutenance à huis clos
		print("\t\t<ahuisclos>".$tabSoutenances[$i]->isAHuitClos()."</ahuisclos>\n");
		
		// Evénement en lecture seulement ?
		if ($annee < (Promotion_BDD::getLastAnnee() + 1)) {
			print("\t\t<readonly>true</readonly>\n");
		}
		
		// Fin de la balise
		print ("\t</event>\n");
	}
}

// Fin du flux XML
print("</data>");

?>