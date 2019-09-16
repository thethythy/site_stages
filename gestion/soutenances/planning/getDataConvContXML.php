<?php

/**
 * Page getDataConventionsXML.php
 * Utilisation : page pour obtenir une flux XML des conventions
 *		 page appelée par planifier_compresse.js
 * Accès : restreint par authentification HTTP
 */

include_once("../../../classes/bdd/connec.inc");

include_once('../../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level3');

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

		// Récupération des étudiants ayant une convention ou un contrat
		$tabEtu = array();
		for ($k = 0; $k < sizeof($tabEtudiants); $k++) {
			if ($tabEtudiants[$k]->getConvention($annee) ||
			    $tabEtudiants[$k]->getContrat($annee))
				array_push($tabEtu, $tabEtudiants[$k]);
		}

		// S'il y a des conventions ou des contrats alors les ajouter au flux
		if (sizeof($tabEtu) > 0) {
			$idpromotion = $tabPromos[$i]->getIdentifiantBDD();
			$nom_parcours_filiere = $filiere->getNom()." ".$parcours->getNom();
			print("\t<item id='".$idpromotion."' text='".$nom_parcours_filiere."' child='1'>\n\t\t<userdata name='idpromotion'>".$idpromotion."</userdata>\n");

			for ($l = 0; $l < sizeof($tabEtu) ; $l++) {
				$nom_prenom = $tabEtu[$l]->getNom()." ".$tabEtu[$l]->getPrenom();

				$convention = $tabEtu[$l]->getConvention($annee);
				$idconvention= "";
				$contrat = $tabEtu[$l]->getContrat($annee);
				$idcontrat = "";

				if ($convention) {
				    $convOUcont = $convention;
				    $nom_prenom .= " &#91;STA&#93;";
				    $idconvention = $convention->getIdentifiantBDD();
				}
				else {
				    $convOUcont = $contrat;
				    $nom_prenom .= " &#91;ALT&#93;";
				    $idcontrat = $contrat->getIdentifiantBDD();
				}

				$nom_prenom_style = $nom_prenom;
				$couleur = $convOUcont->getParrain()->getCouleur();

				$parrain = $convOUcont->getParrain();
				$nom_prenom_parrain = $parrain->getNom()." ".$parrain->getPrenom();

				$examinateur = $convOUcont->getExaminateur();
				$nom_prenom_examinateur = $examinateur->getNom()." ".$examinateur->getPrenom();

				$style = "aCol='#".$couleur->getCode()."' sCol='#".$couleur->getCode()."'";

				if ($convOUcont->getIdSoutenance())
					$nom_prenom_style = "&lt;i&gt;".$nom_prenom."&lt;/i&gt;";

				$tooltip = "tooltip='Etudiant : ".$nom_prenom." R&#233;f&#233;rent : ".$nom_prenom_parrain."'";

				$contact = $convOUcont->getContact();
				$nom_lieu_entreprise = htmlspecialchars($contact->getEntreprise()->getNom()." (".$contact->getEntreprise()->getVille().")");

				$iditemtree = $idpromotion."_".$filiere->getIdentifiantBDD()."_".$convOUcont->getIdentifiantBDD();

				print("\t\t<item id='".$iditemtree."' text='".$nom_prenom_style."' ".$style." ".$tooltip.">\n
							\t\t\t<userdata name='idconvention'>".$idconvention."</userdata>\n
							\t\t\t<userdata name='idcontrat'>".$idcontrat."</userdata>\n
							\t\t\t<userdata name='nom_prenom_etudiant'>".$nom_prenom."</userdata>\n

							\t\t\t<userdata name='idparrain'>".$parrain->getIdentifiantBDD()."</userdata>\n
							\t\t\t<userdata name='nom_prenom_parrain'>".$nom_prenom_parrain."</userdata>\n
							\t\t\t<userdata name='couleur_parrain'>#".$couleur->getCode()."</userdata>\n

							\t\t\t<userdata name='idexaminateur'>".$examinateur->getIdentifiantBDD()."</userdata>\n
							\t\t\t<userdata name='nom_prenom_examinateur'>".$nom_prenom_examinateur."</userdata>\n

							\t\t\t<userdata name='idcontact'>".$contact->getIdentifiantBDD()."</userdata>\n
							\t\t\t<userdata name='nom_entreprise'>".$nom_lieu_entreprise."</userdata>\n

							\t\t\t<userdata name='idsoutenance'>".$convOUcont->getIdSoutenance()."</userdata>\n
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