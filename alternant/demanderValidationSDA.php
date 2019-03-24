<?php

/**
 * Page demanderValidationSDS.php
 * Utilisation : page de demande de validation d'un sujet d'alternance
 * Dépendance(s) : demanderValidationSDSData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Alternant');

IHM_Generale::header("Demander la validation", "d'un sujet d'alternance'", "../", $tabLiens);

//Envoie d'un mail de notification au responsable des alternances
function envoyerNotification() {
    global $emailResponsable;
    global $baseSite;

    $headers = 'Content-Type: text/html; charset=utf-8' . "\n";
    $headers .= 'Content-Transfer-Encoding: 8bit' . "\n";
    $headers .= 'From: ' . $emailResponsable . "\n";
    $headers .= 'Reply-To: ' . $emailResponsable . "\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    $msg = "Un nouveau sujet d'alternance' a été soumis.<br/>Vous pouvez le visualisez <a href='" . $baseSite . "gestion/etudiants/gestionSujetDeStage.php'>ici</a>";
    mail($emailResponsable, 'Site des stages : Demande de validation !', $msg, $headers);
}

//Fonction pour copier le fichier sur le serveur
function depotSujet($identifiant) {

    $nomFichier = "";
    $erreur = false;
    $etudiant = Etudiant::getEtudiant($identifiant);
    $file = $_FILES['uploadSujet']['name'];
    $size = $_FILES['uploadSujet']['size'];

    $filename = explode(".", $_FILES['uploadSujet']['name']);
    if (sizeof($filename) != 0)
	$extension = $filename[sizeof($filename) - 1];

    if ($file && ($extension == "pdf" || $extension == "doc" || $extension == "odt" || $extension == "docx" || $extension == "txt")) {
	$file_size_max = 20000000; //en bytes

	$store_dir = "../documents/sujetsDAlternances/";

	$accept_overwrite = true;

	$nomFichier = $etudiant->getIdentifiantBDD() . "_" . $etudiant->getNom() . "_" . $etudiant->getPrenom() . "_" . date('j-m-Y_H\Hi\m\i\ns') . "." . $extension;

	if ($size > $file_size_max) {
	    IHM_Generale::erreur("Désolé, votre fichier est trop volumineux !");
	    $erreur = true;
	    printf("<div><a href='../stagiaire/depot_doc.php'>Retour</a></div>");
	} else if (file_exists($store_dir . $_FILES['uploadSujet']['name']) && ($accept_overwrite)) {
	    unlink($store_dir . $_FILES['uploadSujet']['name']);
	    if (!@move_uploaded_file($_FILES['uploadSujet']['tmp_name'], $store_dir . $nomFichier)) {
		echo "Désolé, le dépôt a échoué !";
	    }
	} else if (!@move_uploaded_file($_FILES['uploadSujet']['tmp_name'], $store_dir . $nomFichier)) {
	    $erreur = true;
	    IHM_Generale::erreur("Le dépôt de fichier a échoué !");
	} else {
	    echo "<p>Votre sujet est bien enregistré !!!</p>";
	}
    } else {
	IHM_Generale::erreur("Soit aucun sujet d'alternance est donné soit l'extension du fichier n'est pas acceptée !!");
    }

    if ($erreur) {
	$nomFichier = "";
    }
    return $nomFichier;
}

$traitement = false; // Flag de traitement ou pas

if (isset($_POST['idetudiant']) && $_POST['idetudiant'] != -1) {
    $tabDonnees = array();
    // identifiant etudiant
    array_push($tabDonnees, $_POST['idetudiant']);
    //identifiant promotion de l'étudiant pour l'année sélectionnée
    $etudiant = Etudiant::getEtudiant($_POST['idetudiant']);
    $promotion = $etudiant->getPromotion($_POST['annee']);
    array_push($tabDonnees, $promotion->getIdentifiantBDD());
    // description
    if (isset($_FILES['uploadSujet']['name']) && $_FILES['uploadSujet']['name'] != "") { //si un fichier est envoyé
	$filename = depotSujet($_POST['idetudiant']);
	if ($filename != "") {
	    array_push($tabDonnees, $filename);
	    SujetDeStage::saisirDonnees($tabDonnees);
	    envoyerNotification();
	    echo "<p>Votre demande de validation a été envoyée.</p>";
	    $traitement = true;
	}
    } else if (isset($_POST['desc']) && $_POST['desc'] != "") {
	array_push($tabDonnees, $_POST['desc']);
	SujetDeStage::saisirDonnees($tabDonnees);
	envoyerNotification();
	echo "<p>Votre demande de validation a été envoyée.</p>";
	$traitement = true;
    } else {
	IHM_Generale::erreur("Vous devez soit saisir une description soit déposer un fichier avant de soumettre votre sujet !");
    }
}

if (!$traitement) {
    // Affichage du formulaire de filtrage
    Promotion_IHM::afficherFormulaireRecherche("demanderValidationSDSData.php", false, true);

    // Affichage des données
    echo "<div id='data'>\n";
    include_once("demanderValidationSDAData.php");
    echo "\n</div>";
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>