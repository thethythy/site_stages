<?php

/**
 * Page depot_doc.php
 * Utilisation : page de dépôt d'un document
 * Dépendance(s) : depot_docData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Stagiaire');

IHM_Generale::header("Dépôt de", "documents", "../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("depot_docData.php", false);

//Envoie d'un mail de notification au parrain et au responsable
function envoyerNotification($oEtudiant, $annee, $idFiliere, $idParcours, $idParrain, $nomFichier, $typedocument) {
    global $emailResponsable;
    global $baseSite;

    $oParrain = Parrain::getParrain($idParrain);

    $oPromotion = Promotion::getPromotionFromParcoursAndFiliere($annee, $idFiliere, $idParcours);
    $oConvention = Convention::getConventionFromEtudiantAndPromotion($oEtudiant->getIdentifiantBDD(), $oPromotion->getIdentifiantBDD());

    $headers = 'Content-Type: text/html; charset=utf-8'. "\n";
    $headers .= 'Content-Transfer-Encoding: 8bit' . "\n";
    $headers .= 'From: ' . $emailResponsable . "\n";
    $headers .= 'Reply-To: ' . $emailResponsable . "\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    $msg = "Ceci est un message automatique concernant le suivi de stage.<br/>
		Un $typedocument a été déposé sur le site des stages.<br/>
		<br/>
		Etudiant : " . $oEtudiant->getNom() . " " . $oEtudiant->getPrenom() . "<br/>
		Diplôme : " . $oPromotion->getFiliere()->getNom() . " " . $oPromotion->getParcours()->getNom() . "<br/>
		Entreprise : " . $oConvention->getContact()->getEntreprise()->getNom() . "<br/>
		Document : $typedocument <a href='" . $baseSite . "documents/" . $nomFichier . "'>accessible ici</a><br/>
		<br/>
		Bonne lecture<br/>
		Le responsable des stages";

    mail($oParrain->getEmail() . "," . $emailResponsable . "," . $oEtudiant->getEmailInstitutionel(), "Site des stages : $typedocument déposé", $msg, $headers);
}

//Fonction pour copier un document sur le serveur
function depotDocument($etudiant, $annee, $filiere, $repertoire) {
    $nomFichier = "";
    $erreur = false;

    if ($repertoire == "rapports") {
	$file = $_FILES['uploadRapport']['name'];
	$size = $_FILES['uploadRapport']['size'];
	$filename = explode(".", $_FILES['uploadRapport']['name']);
	$tmp_name = $_FILES['uploadRapport']['tmp_name'];
    } else {
	$file = $_FILES['uploadResume']['name'];
	$size = $_FILES['uploadResume']['size'];
	$filename = explode(".", $_FILES['uploadResume']['name']);
	$tmp_name = $_FILES['uploadResume']['tmp_name'];
    }

    if (sizeof($filename) != 0)
	$extension = $filename[sizeof($filename) - 1];

    if ($file && ($extension == "pdf" || $extension == "doc" || $extension == "docx")) {
	$file_size_max = 20000000; //en bytes

	$store_dir = "../documents/" . $repertoire . "/";

	$accept_overwrite = true;

	$nomFiliere = Filiere::getFiliere($filiere)->getNom();
	$annees = ($annee - 2000) . ($annee - 2000 + 1);

	$nomFichier = $etudiant->getIdentifiantBDD() . "_" . $nomFiliere . "_" . Utils::removeaccents($etudiant->getNom()) . "_" . Utils::removeaccents($etudiant->getPrenom()) . "_" . $annees . "." . $extension;

	if ($size > $file_size_max) {
	    IHM_Generale::erreur("Désolé, votre fichier est trop volumineux (supérieur à 20 Mo) !");
	    $erreur = true;
	} else if (file_exists($store_dir . $nomFichier) && ($accept_overwrite)) {
	    unlink($store_dir . $nomFichier);
	    if (!move_uploaded_file($tmp_name, $store_dir . $nomFichier)) {
		$erreur = true;
		IHM_Generale::erreur("Désolé mais le dépôt a échoué !");
	    }
	} else if (!move_uploaded_file($tmp_name, $store_dir . $nomFichier)) {
	    $erreur = true;
	    IHM_Generale::erreur("Le dépôt de fichier a échoué !");
	}
    } else {
	IHM_Generale::erreur("Vous n'avez donné aucun nom de fichier ou l'extension n'est peut-être pas acceptée !!");
    }

    if ($erreur) {
	$nomFichier = "";
    }

    return $nomFichier;
}

// Affichage des données
echo "<div id='data'>\n";
include_once("depot_docData.php");
echo "\n</div>";

// Vérification sélection d'un étudiant
if (isset($_POST['idEtudiant']) && $_POST['idEtudiant'] == -1) {
    IHM_Generale::erreur("Vous devez sélectionner un nom d'étudiant !");
}

// Dépôt d'un rapport
if (isset($_POST['submitRapport']) && $_POST['idEtudiant'] != -1) {
    if (isset($_FILES['uploadRapport']['name']) && $_FILES['uploadRapport']['name'] != "") { //si un fichier est envoyé
	$etudiant = Etudiant::getEtudiant($_POST['idEtudiant']);
	$filename = depotDocument($etudiant, $_POST['annee'], $_POST['filiere'], "rapports");
	if ($filename != "") {
	    $oPromotion = Promotion::getPromotionFromParcoursAndFiliere($_POST['annee'], $_POST['filiere'], $_POST['parcours']);
	    $oConvention = Convention::getConventionFromEtudiantAndPromotion($_POST['idEtudiant'], $oPromotion->getIdentifiantBDD());
	    $idParrain = $oConvention->getIdParrain();
	    $chemin = "rapports/" . $filename;
	    envoyerNotification($etudiant, $_POST['annee'], $_POST['filiere'], $_POST['parcours'], $idParrain, $chemin, "rapport de stage");
	    echo "<p>Votre rapport de stage a été enregistré et votre référent a été informé de ce dépôt.</p>";
	}
    } else {
	IHM_Generale::erreur("Vous devez spécifier un fichier !");
    }
}

// Dépôt d'un résumé
if (isset($_POST['submitResume']) && $_POST['idEtudiant'] != -1) {
    if (isset($_FILES['uploadResume']['name']) && $_FILES['uploadResume']['name'] != "") { //si un fichier est envoyé
	$etudiant = Etudiant::getEtudiant($_POST['idEtudiant']);
	$filename = depotDocument($etudiant, $_POST['annee'], $_POST['filiere'], "resumes");
	if ($filename != "") {
	    $oPromotion = Promotion::getPromotionFromParcoursAndFiliere($_POST['annee'], $_POST['filiere'], $_POST['parcours']);
	    $oConvention = Convention::getConventionFromEtudiantAndPromotion($_POST['idEtudiant'], $oPromotion->getIdentifiantBDD());
	    $idParrain = $oConvention->getIdParrain();
	    $chemin = "resumes/" . $filename;
	    envoyerNotification($etudiant, $_POST['annee'], $_POST['filiere'], $_POST['parcours'], $idParrain, $chemin, "résumé de stage");
	    echo "<p>Votre résumé de stage a été enregistré et votre référent a été informé de ce dépôt.</p>";
	}
    } else {
	IHM_Generale::erreur("Vous devez spécifier un fichier !");
    }
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>