<?php

include_once("../classes/bdd/connec.inc");
include_once("../classes/ihm/IHM_Generale.php");
include_once("../classes/moteur/Filtre.php");
include_once("../classes/moteur/FiltreString.php");

include_once("../classes/ihm/OffreDeStage_IHM.php");
include_once("../classes/bdd/OffreDeStage_BDD.php");
include_once("../classes/moteur/OffreDeStage.php");

include_once("../classes/bdd/Filiere_BDD.php");
include_once("../classes/moteur/Filiere.php");

include_once("../classes/bdd/Entreprise_BDD.php");
include_once("../classes/moteur/Entreprise.php");

include_once("../classes/bdd/Contact_BDD.php");
include_once("../classes/moteur/Contact.php");

include_once("../classes/bdd/Competence_BDD.php");
include_once("../classes/moteur/Competence.php");

include_once("../classes/bdd/Parcours_BDD.php");
include_once("../classes/moteur/Parcours.php");

include_once("../classes/bdd/TypeEntreprise_BDD.php");
include_once("../classes/moteur/TypeEntreprise.php");

function verifier(){
    if (isset($_POST['titre'])) {
	extract($_POST);
	if ($titre!="" && $sujet!="" && $nom_entreprise!="" && $adresse!="" &&
	    $ville!="" && $codePostal!="" && is_numeric($codePostal) &&
	    $pays!="" && $nom_contact!="" && $prenom_contact!="" &&
	    $tel_contact!="" && $email_contact!="") {

	    $tabDonnees = array();

	    //sujet
	    array_push($tabDonnees, $sujet);

	    //titre
	    array_push($tabDonnees, $titre);

	    //liste des environnements
	    $listeEnvironnements = "";
	    if (isset($environnementMac)) {
		$listeEnvironnements = $listeEnvironnements."mac;";
	    }
	    if (isset($environnementWin)) {
		$listeEnvironnements = $listeEnvironnements."win;";
	    }
	    if (isset($environnementUnix)) {
	    	$listeEnvironnements =$listeEnvironnements."unix;";
	    }
	    array_push($tabDonnees, $listeEnvironnements);

	    //Theme
	    $tabParcours = Parcours::listerParcours();
	    $tabThemes = array();
	    for ($i=1; $i<=sizeof($tabParcours); $i++) {
		if (isset($_POST['parcours'.$i])) {
		    array_push($tabThemes, $_POST['parcours'.$i]);
		}
	    }
	    array_push($tabDonnees, $tabThemes);

	    //Profils
	    $tabFilieres = Filiere::listerFilieres();
	    $tabProfils = array();
	    for ($i=1; $i <= sizeof($tabFilieres); $i++) {
		if(isset($_POST['filiere'.$i])){
		    array_push($tabProfils, $_POST['filiere'.$i]);
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

	    //Competences
	    $tabCompetences = Competence::listerCompetences();
	    $competences = array();
	    for ($i=1; $i<=sizeof($tabCompetences); $i++) {
		if (isset($_POST['competence'.$i])) {
		    array_push($competences, $_POST['competence'.$i]);
		}
	    }
	    if (isset($_POST['competence_ajout0'])) {
		//On ajoute les nouvelles compétences
		$i = 0;
		do {
		    if ($_POST['competence_ajout'.$i] != "") {
			$nouvelleCompetence = new Competence("", $_POST['competence_ajout'.$i]);
			$idCompetence = Competence_BDD::sauvegarder($nouvelleCompetence);
			array_push($competences, $idCompetence);
		    }
		    $i++;
		} while (isset($_POST['competence_ajout'.$i]));
	    }
	    array_push($tabDonnees, $competences);

	    //MaitreDeStage
	    $filtreNom = new FiltreString("nom", $nom_entreprise);
	    $filtreVille = new FiltreString("ville", $ville);
	    $filtre = new Filtre($filtreNom, $filtreVille, "AND");
	    $entreprise = Entreprise::getListeEntreprises($filtre);

	    if (sizeof($entreprise) == 1) {
		// On récupère les informations sur l'entreprise
		$idEntreprise=$entreprise[0]->getIdentifiantBDD();
		$filtreNom = new FiltreString("nomcontact", $nom_contact);
		$filtrePrenom = new FiltreString("prenomcontact", $prenom_contact);
		$filtreTel = new FiltreString("telephone", $tel_contact);
		$filtre = new Filtre($filtreNom, $filtrePrenom, "AND");
		$filtre = new Filtre($filtre, $filtreTel, "AND");
		$contact = Contact::getListeContacts($filtre);
		if (sizeof($contact) == 1) {
		    // On récupère les informations sur le contact
		    $idContact = $contact[0]->getIdentifiantBDD();
		} else {
		    // On enregistre le contact dans la base de données
		    $nouveauContact = new Contact("", $nom_contact, $prenom_contact, $tel_contact, $fax_contact, $email_contact, $idEntreprise);
		    $idContact = Contact_BDD::sauvegarder($nouveauContact);
		}
	    } else {
		// On enregistre l'entreprise et le contact dans la base de données
		if ($email_entreprise == "") $email_entreprise = $email_contact;
		$nouvelleEntreprise = new Entreprise("", $nom_entreprise, $adresse, $codePostal, $ville, $pays, $email_entreprise, "");
		$idEntreprise = Entreprise_BDD::sauvegarder($nouvelleEntreprise);
		$nouveauContact = new Contact("", $nom_contact, $prenom_contact, $tel_contact, $fax_contact, $email_contact, $idEntreprise);
		$idContact = Contact_BDD::sauvegarder($nouveauContact);
	    }
	    array_push($tabDonnees, $idContact);

	    $idOffreDeStage = OffreDeStage::saisirDonnees($tabDonnees);

	    //Envoie d'un mail de notification au responsable des stages
	    global $emailResponsable;
	    global $baseSite;

	    $headers ='Content-Type:  text/html; charset="utf-8"'."\n";
	    $headers .='Content-Transfer-Encoding: 8bit'."\n";
	    $headers .= 'From: '.$emailResponsable."\n";
	    $headers .= 'Reply-To: '.$emailResponsable."\n";
	    $headers .= 'X-Mailer: PHP/'.phpversion();

	    $msg = "Une nouvelle offre de stage a été ajoutée.<br/>Vous pouvez la visualisez <a href=".$baseSite."gestion/entreprises/editionOffreDeStage.php?id=".$idOffreDeStage.">ici</a>";
	    mail($emailResponsable, 'Site des stages : nouvelle offre de stage !', $msg, $headers);
	    echo "<p>Votre annonce a bien été enregistrée !</p><p>Après validation par le responsable des stages, un mail de confirmation de diffusion vous sera envoyé.</p><p><a href='../index.php'>Retour</a></p>";
	} else {
	    IHM_Generale::erreur("Vous devez saisir tous les champs marqués d'une * !");
	    OffreDeStage_IHM::afficherFormulaireSaisie();
	}
    } else {
	OffreDeStage_IHM::afficherFormulaireSaisie();
    }
}

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Entreprise');

IHM_Generale::header("Dépôt d'une", "offre de stage", "../", $tabLiens);

verifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>