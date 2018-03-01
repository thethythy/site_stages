<?php

/**
 * Page getEnseignantICal.php
 * Utilisation : créer puis retourne un flux (le fichier soutenance.ics)
 *		 du planning des soutenances au format ICALENDAR
 * Accès : public (doit être importer sans problème)
 *	   mais le lien n'est que dans la page bilanParrainages.php
 */

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

header("Content-type:text/html; charset=utf-8");

// Récupération de l'id de l'enseignant concerné
if (isset($_GET["id"]))
    $id = $_GET["id"];
else
    $id = "";

// Récupération des soutenances de l'année en cours
$annee = Promotion_BDD::getLastAnnee() + 1;
$tabSoutenances = Soutenance::listerSoutenancesFromAnnee($annee);

$start = "BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//ThierryLemeunier/version 1.1\nDESCRIPTION:";
$end = "END:VCALENDAR";

$data = $start;

if (sizeof($tabSoutenances) > 0) {

    $dejafait = false;

    for ($i = 0; $i < sizeof($tabSoutenances); $i++) {

	$convention = Soutenance::getConvention($tabSoutenances[$i]);

	if ($convention->getIdParrain() == $id || $convention->getIdExaminateur() == $id) {

	    // Titre (à faire une seule fois)
	    $nom_prenom_parrain = $convention->getParrain()->getNom() . " " . $convention->getParrain()->getPrenom();
	    $examinateur = $convention->getExaminateur();
	    $nom_prenom_examinateur = $examinateur->getNom() . " " . $examinateur->getPrenom();

	    if ($id == $convention->getIdParrain()) {
		$nom_prenom = $nom_prenom_parrain;
	    } else {
		$nom_prenom = $nom_prenom_examinateur;
	    }

	    if (!$dejafait) {
		$data .= "Soutenance de " . $nom_prenom . "\n";
		$dejafait = true;
	    }

	    // Début
	    $data .= "BEGIN:VEVENT\n";

	    // Début de l'événement
	    $heureDebut = $tabSoutenances[$i]->getHeureDebut();
	    $minDebut = $tabSoutenances[$i]->getMinuteDebut();
	    $jour = $tabSoutenances[$i]->getDateSoutenance()->getJour();
	    $mois = $tabSoutenances[$i]->getDateSoutenance()->getMois();
	    $date_debut_normal = $annee . "-" . $mois . "-" . $jour . " " . $heureDebut . ":" . $minDebut . ":00";
	    $date = new DateTime($date_debut_normal);
	    $date_debut = $date->format('Ymd\THis');
	    $data .= "DTSTART:" . $date_debut . "\n";

	    // Fin de l'événement
	    $etudiant = $convention->getEtudiant();
	    $promotion = $etudiant->getPromotion($annee - 1);
	    $filiere = $promotion->getFiliere();
	    $temps_soutenance = $filiere->getTempsSoutenance();
	    $date->modify("+ " . $temps_soutenance . " minutes");
	    $date_fin = $date->format('Ymd\THis');
	    $data .= "DTEND:" . $date_fin . "\n";

	    // Résumé
	    $prenom_nom_etudiant = $etudiant->getPrenom() . " " . $etudiant->getNom();
	    $data .= "SUMMARY:Soutenance de " . $prenom_nom_etudiant . "\n";

	    // Salle
	    $data .= "LOCATION:" . $tabSoutenances[$i]->getSalle()->getNom() . "\n";

	    // Description
	    $contact = $convention->getContact();
	    $nom_lieu_entreprise = $contact->getEntreprise()->getNom() . " (" . $contact->getEntreprise()->getVille() . ")";

	    $description = "Etudiant " . $prenom_nom_etudiant . "\\nJury " . $nom_prenom_parrain . " " . $nom_prenom_examinateur . "\\nEntreprise " . $nom_lieu_entreprise;
	    $data .= "DESCRIPTION:" . $description . "\n";

	    // Alarme
	    $data .= "BEGIN:VALARM\n";
	    $data .= "TRIGGER:-PT5M\n";
	    $data .= "DESCRIPTION:" . $description . "\n";
	    $data .= "ACTION:DISPLAY\n";
	    $data .= "END:VALARM\n";

	    // Fin
	    $data .= "END:VEVENT\n";
	}
    }
}

$data .= "\n" . $end;

$filename = "soutenances.ics";
$dir = "./";

// Stockage sur disque
file_put_contents($dir . $filename, $data);

// Envoie du fichier
header("Content-disposition: attachment; filename=$filename");
header("Content-Type: application/force-download");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . filesize($dir . $filename));
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, public");
header("Expires: 0");
readfile($dir . $filename);
?>