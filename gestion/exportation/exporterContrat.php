<?php

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');
// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

$oContrat = Contrat::getContrat($_GET['id']);
$oPromo = Promotion::getPromotion($_GET['promo']);
$oFiliere = $oPromo->getFiliere();
$oParcours = $oPromo->getParcours();
$etudiant = $oContrat->getEtudiant();
$entreprise = $oContrat -> getEntreprise();
$referent = $oContrat -> getContact();

header('Content-Encoding: UTF-8');
header("Content-Type: text/csv; charset=utf-8");
header("Content-disposition: attachment; filename=".$etudiant->getPrenom()."_".$etudiant->getNom()."_suivi.csv");

$list = array (
array("NB","Société","Titre","Nom",	"Prénom",	"Fonction",	"Adresse1",	"Adresse2",	"Code_postal",	"Ville",	"E-mail",	"Tel.",	"Prénom étudiant",	"Nom étudiant",	"E-mail etudiant",	"CONTRAT",	"Demande de prise en charge",	"Convention",	"Copie du contrat", "Début du contrat",	"Fin du contrat",	"Nb d'heures",	"Taux en Euro",	"Droits Universitaires",	"TOTAL en Euro"),
array("",$entreprise->getNom(),"",$referent->getNom(),$referent->getPrenom(),"",$entreprise->getAdresse(),"",$entreprise->getCodePostal(),$entreprise->getVille(),$referent->getEmail(),$referent->getTelephone(),$etudiant->getPrenom(),$etudiant->getNom(),$etudiant->getEmailInstitutionel())
);



$fp = fopen('PHP://output', "w");
foreach($list as $fields):
    fputcsv($fp, $fields);
endforeach;
fclose($fp);






?>
