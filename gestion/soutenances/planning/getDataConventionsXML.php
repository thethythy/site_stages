<?php

/**
 * Page getDataConventionsXML.php
 * Utilisation : page pour obtenir une flux XML des conventions
 *		 page appelée par planifier_compresse.js
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");
include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");
include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."moteur/Couleur.php");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."moteur/Entreprise.php");

// Format de la réponse
header("Content-type:text/xml; charset=utf-8");

// Début du flux XML
print("<?xml version='1.0' encoding='utf-8' ?>\n");
print("<tree id='0'>\n");

// Récupération des promotions de l'année sélectionnée
if (isset($_GET["annee"])) $annee = $_GET["annee"]; else $annee = Promotion_BDD::getLastAnnee();
$filtre_annee = new FiltreNumeric("anneeuniversitaire", $annee);
$tabPromos = Promotion::listerPromotions($filtre_annee);

if (sizeof($tabPromos) > 0) {

	for ($i = 0; $i < sizeof($tabPromos); $i++) {

		// Récupération des étudiants par promotion de l'année sélectionnée
		$filtres = array();
		array_push($filtres, $filtre_annee);

		$parcours = $tabPromos[$i]->getParcours();
		array_push($filtres, new FiltreNumeric("idparcours", $parcours->getIdentifiantBDD()));

		$filiere = $tabPromos[$i]->getFiliere();
		array_push($filtres, new FiltreNumeric("idfiliere", $filiere->getIdentifiantBDD()));

		$filtre = $filtres[0];
		for ($j = 1; $j < sizeof($filtres); $j++)
			$filtre = new Filtre($filtre, $filtres[$j], "AND");

		$tabEtudiants = Promotion::listerEtudiants($filtre);

		// Récupération des étudiants ayant une convention
		$tabEtuWithConv = array();

		for ($k = 0; $k < sizeof($tabEtudiants); $k++) {
			if ($tabEtudiants[$k]->getConvention($annee) != null)
				array_push($tabEtuWithConv, $tabEtudiants[$k]);
		}

		// S'il y a des conventions alors les ajouter au flux
		if (sizeof($tabEtuWithConv) > 0) {
			$idpromotion = $tabPromos[$i]->getIdentifiantBDD();
			$nom_parcours_filiere = $filiere->getNom()." ".$parcours->getNom();
			print("\t<item id='".$idpromotion."' text='".$nom_parcours_filiere."' child='1'>\n\t\t<userdata name='idpromotion'>".$idpromotion."</userdata>\n");

			for ($l = 0; $l < sizeof($tabEtuWithConv) ; $l++) {
				$nom_prenom = $tabEtuWithConv[$l]->getNom()." ".$tabEtuWithConv[$l]->getPrenom();
				$nom_prenom_style = $nom_prenom;
				$convention = $tabEtuWithConv[$l]->getConvention($annee);
				$couleur = $convention->getParrain()->getCouleur();

				$parrain = $convention->getParrain();
				$nom_prenom_parrain = $parrain->getNom()." ".$parrain->getPrenom();

				$examinateur = $convention->getExaminateur();
				$nom_prenom_examinateur = $examinateur->getNom()." ".$examinateur->getPrenom();

				$style = "aCol='#".$couleur->getCode()."' sCol='#".$couleur->getCode()."'";

				if ($convention->getIdSoutenance())
					$nom_prenom_style = "&lt;i&gt;".$nom_prenom."&lt;/i&gt;";

				$tooltip = "tooltip='Etudiant : ".$nom_prenom." R&#233;f&#233;rent : ".$nom_prenom_parrain."'";

				$contact = $convention->getContact();
				$nom_lieu_entreprise = $contact->getEntreprise()->getNom()." (".$contact->getEntreprise()->getVille().")";

				$iditemtree = $idpromotion."_".$filiere->getIdentifiantBDD()."_".$convention->getIdentifiantBDD();

				print("\t\t<item id='".$iditemtree."' text='".$nom_prenom_style."' ".$style." ".$tooltip.">\n
							\t\t\t<userdata name='idconvention'>".$convention->getIdentifiantBDD()."</userdata>\n
							\t\t\t<userdata name='nom_prenom_etudiant'>".$nom_prenom."</userdata>\n

							\t\t\t<userdata name='idparrain'>".$parrain->getIdentifiantBDD()."</userdata>\n
							\t\t\t<userdata name='nom_prenom_parrain'>".$nom_prenom_parrain."</userdata>\n
							\t\t\t<userdata name='couleur_parrain'>#".$couleur->getCode()."</userdata>\n

							\t\t\t<userdata name='idexaminateur'>".$examinateur->getIdentifiantBDD()."</userdata>\n
							\t\t\t<userdata name='nom_prenom_examinateur'>".$nom_prenom_examinateur."</userdata>\n

							\t\t\t<userdata name='idcontact'>".$contact->getIdentifiantBDD()."</userdata>\n
							\t\t\t<userdata name='nom_entreprise'>".$nom_lieu_entreprise."</userdata>\n

							\t\t\t<userdata name='idsoutenance'>".$convention->getIdSoutenance()."</userdata>\n
						\t\t</item>\n");
			}

			// Fin de l'item parcours
			print("\t</item>\n");

		}
	}
}

// Fin du flux XML
print("</tree>\n");

?>