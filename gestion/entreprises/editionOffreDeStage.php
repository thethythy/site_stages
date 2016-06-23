<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/moteur/Filtre.php");
include_once("../../classes/moteur/FiltreString.php");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/OffreDeStage_IHM.php");
include_once("../../classes/moteur/OffreDeStage.php");
include_once("../../classes/bdd/OffreDeStage_BDD.php");

include_once("../../classes/bdd/Filiere_BDD.php");
include_once("../../classes/moteur/Filiere.php");

include_once("../../classes/moteur/Entreprise.php");
include_once("../../classes/bdd/Entreprise_BDD.php");

include_once("../../classes/moteur/Contact.php");
include_once("../../classes/bdd/Contact_BDD.php");

include_once("../../classes/bdd/Competence_BDD.php");
include_once("../../classes/moteur/Competence.php");

include_once("../../classes/bdd/Parcours_BDD.php");
include_once("../../classes/moteur/Parcours.php");

include_once("../../classes/bdd/Promotion_BDD.php");
include_once("../../classes/moteur/Promotion.php");

include_once("../../classes/moteur/FluxRSS.php");

function envoyerNotifications($contact, $idOffreDeStage) {
    global $emailResponsable;
    global $baseSite;

    if (!isset($_POST['annee']))
	$annee = Promotion_BDD::getLastAnnee();
    else
	$annee = $_POST['annee'];

    // ------------------------------------------------
    // Envoie d'un mail de notification à l'entreprise
    $expediteur = $emailResponsable;
    $reponse = $emailResponsable;
    $headers = "From: $expediteur\nReply-to: $reponse\nCc: $expediteur\n";
    $headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
    $headers .= "Content-Transfer-Encoding: 8bit";

    $msg = "Bonjour,<br/><br/>
	    Ceci est un message automatique.<br/>
	    Votre offre de stage a été diffusée à nos étudiants.<br/>
	    Vous pouvez la consulter à l'adresse suivante :<br/>
	    <a href=" . $baseSite . "/stagiaire/visualiserOffre.php?id=" . $idOffreDeStage . ">" . $baseSite . "stagiaire/visualiserOffre.php?id=" . $idOffreDeStage . "</a><br/><br/>
	    Cordialement,<br/><br/>
	    Le responsable des stages<br/>
	    Département Informatique<br/>
	    Université du Maine";
    mail($contact->getEmail(), 'Votre offre de stage', $msg, $headers);
    echo "<p>Un email de notification a été envoyé à l'entreprise.</p>";

    // ----------------------------------------------------------
    // Envoie d'un mail de notification aux promotions concernées
    $offreDeStage = offreDeStage::getOffreDeStage($idOffreDeStage);
    $destinataire = "";

    $tabFiliere = $offreDeStage->getListeProfilSouhaite();
    for ($i = 0; $i < sizeof($tabFiliere); $i++) {
	$tabParcours = $offreDeStage->getThemes();
	for ($j = 0; $j < sizeof($tabParcours); $j++) {
	    $promotion = Promotion::getPromotionFromParcoursAndFiliere($annee, $tabFiliere[$i]->getIdentifiantBDD(), $tabParcours[$j]->getIdentifiantBDD());
	    if ($destinataire == "")
		$destinataire = $promotion->getEmailPromotion();
	    else
		$destinataire .= "," . $promotion->getEmailPromotion();
	}
    }

    $msg = "Bonjour,<br/><br/>
	    Ceci est un message automatique.<br/>
	    Une nouvelle offre de stage est disponible sur le site Web des stages.<br/>
	    Vous pouvez directement la consulter à l'adresse suivante :<br/>
	    <a href='" . $baseSite . "/stagiaire/visualiserOffre.php?id=" . $idOffreDeStage . "'>'" . $baseSite . "stagiaire/visualiserOffre.php?id=" . $idOffreDeStage . "</a><br/><br/>
	    Thierry Lemeunier<br>
	    Responsable des stages<br>";
    mail($destinataire, 'Site des stages : nouvelle offre sur le site', $msg, $headers);
    echo "<p>Un email de notification a été envoyé aux étudiants concernés.</p>";

    // ------------------------------------------------
    // Mise à jour du flux RSS
    // Création initiale du flux si nécessaire
    if (!FluxRSS::existe())
	FluxRSS::initialise();

    // Création d'une nouvelle news
    $title = "Nouvelle offre de stage";
    $link = $baseSite . "/stagiaire/visualiserOffre.php?id=" . $idOffreDeStage;
    $timestamp = time();
    $contents = htmlspecialchars($offreDeStage->getTitre(), ENT_QUOTES, 'UTF-8');
    $author = $emailResponsable . " (Thierry Lemeunier)";
    FluxRSS::miseAJour($title, $link, $timestamp, $contents, $author);
    echo "<p>Le flux RSS a été mis à jour.</p>";
}

function verifier() {
    if (isset($_POST['titre'])) {
	extract($_POST);
	if ($titre != "" && $sujet != "" && $nom_entreprise != "" &&
	    $adresse != "" && $ville != "" && $codePostal != "" &&
	    $pays != "" && $nom_contact != "" && $prenom_contact != "" &&
	    $tel_contact != "" && $email_contact != "") {

	    $tabDonnees = array();
	    //identifiant
	    array_push($tabDonnees, $idOffreDeStage);
	    //sujet
	    array_push($tabDonnees, $sujet);
	    //titre
	    array_push($tabDonnees, $titre);
	    //liste des environnements
	    $listeEnvironnements = "";
	    if (isset($environnementMac)) {
		$listeEnvironnements = $listeEnvironnements . "mac;";
	    }
	    if (isset($environnementWin)) {
		$listeEnvironnements = $listeEnvironnements . "win;";
	    }
	    if (isset($environnementUnix)) {
		$listeEnvironnements = $listeEnvironnements . "unix;";
	    }
	    array_push($tabDonnees, $listeEnvironnements);
	    //Theme
	    $tabParcours = Parcours::listerParcours();
	    $tabThemes = array();
	    for ($i = 0; $i < sizeof($tabParcours); $i++) {
		$ident = $tabParcours[$i]->getIdentifiantBDD();
		if (isset($_POST['parcours' . $ident])) {
		    array_push($tabThemes, $_POST['parcours' . $ident]);
		}
	    }
	    array_push($tabDonnees, $tabThemes);
	    //Profils
	    $tabFilieres = Filiere::listerFilieres();
	    $tabProfils = array();
	    for ($i = 0; $i < sizeof($tabFilieres); $i++) {
		$ident = $tabFilieres[$i]->getIdentifiantBDD();
		if (isset($_POST['filiere' . $ident])) {
		    array_push($tabProfils, $_POST['filiere' . $ident]);
		}
	    }
	    array_push($tabDonnees, $tabProfils);
	    //DureeMin
	    array_push($tabDonnees, $dureeMin);
	    //DureeMax
	    array_push($tabDonnees, $dureeMax);
	    //Indemnites
	    array_push($tabDonnees, $indemnites);
	    //Remarques
	    array_push($tabDonnees, $rmq);

	    //estVisible
	    if (isset($_POST['valider']))
		array_push($tabDonnees, true);

	    //Competences
	    $tabCompetences = Competence::listerCompetences();
	    $competences = array();
	    for ($i = 1; $i <= sizeof($tabCompetences); $i++) {
		if (isset($_POST['competence' . $i])) {
		    array_push($competences, $_POST['competence' . $i]);
		}
	    }
	    if ($compteur_competence) {//On ajoute les compétences
		for ($i = 0; $i < $compteur_competence; $i++) {
		    $nouvelleCompetence = new Competence("", $_POST['competence_ajout' . $i]);
		    $idCompetence = Competence_BDD::sauvegarder($nouvelleCompetence);
		    array_push($competences, $idCompetence);
		}
	    }
	    array_push($tabDonnees, $competences);
	    //MaitreDeStage
	    $filtreNom = new FiltreString("nom", $nom_entreprise);
	    $filtreVille = new FiltreString("ville", $ville);
	    $filtre = new Filtre($filtreNom, $filtreVille, "AND");
	    $entreprise = Entreprise::getListeEntreprises($filtre);

	    if (sizeof($entreprise) == 1) { //On récupère les informations sur l'entreprise
		$idEntreprise = $entreprise[0]->getIdentifiantBDD();
		$filtreNom = new FiltreString("nomcontact", $nom_contact);
		$filtrePrenom = new FiltreString("prenomcontact", $prenom_contact);
		$filtreTel = new FiltreString("telephone", $tel_contact);
		$filtre = new Filtre($filtreNom, $filtrePrenom, "AND");
		$filtre = new Filtre($filtre, $filtreTel, "AND");
		$contact = Contact::getListeContacts($filtre);
		if (sizeof($contact) == 1) { //On récupère les informations sur le contact
		    $idContact = $contact[0]->getIdentifiantBDD();
		} else {//On enregistre le contact dans la base de données
		    $nouveauContact = new Contact("", $nom_contact, $prenom_contact, $tel_contact, $fax_contact, $email_contact, $idEntreprise);
		    $idContact = Contact_BDD::sauvegarder($nouveauContact);
		}
	    } else {//On enregistre l'entreprise dans la base de données
		$nouvelleEntreprise = new Entreprise("", $nom_entreprise, $adresse, $codePostal, $ville, $pays, $email_entreprise);
		$idEntreprise = Entreprise_BDD::sauvegarder($nouvelleEntreprise);
		$nouveauContact = new Contact("", $nom_contact, $prenom_contact, $tel_contact, $fax_contact, $email_contact, $idEntreprise);
		$idContact = Contact_BDD::sauvegarder($nouveauContact);
	    }
	    array_push($tabDonnees, $idContact);

	    if (isset($_POST['valider'])) {
		$idOffreDeStage = OffreDeStage::modifierDonnees($tabDonnees);
		$contact = Contact::getContact($idContact);
		if (!$_POST['estVisible'])
		    envoyerNotifications($contact, $idOffreDeStage);
		echo "<p>L'offre de stage a été enregistrée !</p><p><a href='./listeDesOffreDeStage.php'>Retour</a></p>";
	    }else if (isset($_POST['cancel'])) {
		OffreDeStage::supprimerDonnees($tabDonnees[0]);
		echo "<p>L'offre de stage a été supprimée de la base de données !</p><p><a href='./listeDesOffreDeStage.php'>Retour</a></p>";
	    }
	} else {
	    IHM_Generale::erreur("Vous devez saisir tous les champs marqués d'une * !");
	    OffreDeStage_IHM::afficherFormulaireModification();
	}
    } else {
	OffreDeStage_IHM::afficherFormulaireModification();
    }
}

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Edition d'une", "offre de stage", "../../", $tabLiens);

verifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>