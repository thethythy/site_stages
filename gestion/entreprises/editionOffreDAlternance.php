<?php

/**
* Page editionOffreDAlternance.php
* Utilisation : page pour éditer, valider ou supprimer une offre d'alternance
*		page accessible depuis listeDesOffreDAlternance.php
* Accès : restreint par authentification HTTP
*/

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

function envoyerNotifications($contact, $idOffreDAlternance) {
  global $baseSite;

  if (!isset($_POST['annee']))
  $annee = Promotion_BDD::getLastAnnee();
  else
  $annee = $_POST['annee'];

  // ------------------------------------------------
  // Envoie d'un mail de notification à l'entreprise

  $responsable = Responsable::getResponsableFromResponsabilite("alternance");
  $emailResp = $responsable->getEmailresponsable();
  $nomResp = $responsable->getPrenomresponsable() . " " . $responsable->getNomresponsable();
  $titreResp = $responsable->getTitreresponsable();
  $expediteur = $emailResp;
  $reponse = $emailResp;
  $headers = "From: $expediteur\nReply-to: $reponse\nCc: $expediteur\n";
  $headers .= "Content-Type: text/html; charset=utf-8\n";
  $headers .= "Content-Transfer-Encoding: 8bit";

  $msg = "Bonjour,<br/><br/>
    Ceci est un message automatique.<br/>
    Votre offre d'alternance a été diffusée à nos étudiants.<br/>
    Vous pouvez la consulter à l'adresse suivante :<br/>
    <a href=" . $baseSite . "entreprise/visualiserOffre.php?id=" . $idOffreDAlternance . "&type=alt>" . $baseSite . "entreprise/visualiserOffre.php?id=" . $idOffreDAlternance . "&type=alt</a><br/><br/>
    Cordialement,<br/><br/>
    $nomResp<br/>
    $titreResp<br/>
    Département Informatique<br/>
    Université du Maine";
  mail($contact->getEmail(), "Votre offre d'alternance", $msg, $headers);
  echo "<p>Un email de notification a été envoyé à l'entreprise.</p>";

  // ----------------------------------------------------------
  // Envoie d'un mail de notification aux promotions concernées

  $offreDAlternance = OffreDAlternance::getOffreDAlternance($idOffreDAlternance);
  $destinataire = "";

  $tabFiliere = $offreDAlternance->getListeProfilSouhaite();
  for ($i = 0; $i < sizeof($tabFiliere); $i++) {
    $tabParcours = $offreDAlternance->getThemes();
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
  Une nouvelle offre d'alternance est disponible sur le site Web des stages et de l'alternance.<br/>
  Vous pouvez directement la consulter à l'adresse suivante :<br/>
  <a href='" . $baseSite . "/alternant/visualiserOffre.php?id=" . $idOffreDAlternance . "'>'" . $baseSite . "alternant/visualiserOffre.php?id=" . $idOffreDAlternance . "</a><br/><br/>
  $nomResp<br>
  $titreResp<br>";
  mail($destinataire, "Site des stages et de l'alternance : nouvelle offre sur le site", $msg, $headers);
  echo "<p>Un email de notification a été envoyé aux étudiants concernés.</p>";

  // ------------------------------------------------
  // Mise à jour du flux RSS
  // Création initiale du flux si nécessaire
  if (!FluxRSS::existe())
    FluxRSS::initialise();

  // Création d'une nouvelle news
  $title = htmlspecialchars("Nouvelle offre d'alternance", ENT_QUOTES, 'UTF-8');
  $link = $baseSite . "/alternant/visualiserOffre.php?id=" . $idOffreDAlternance;
  $timestamp = time();
  $contents = htmlspecialchars($offreDAlternance->getTitre(), ENT_QUOTES, 'UTF-8');
  $author = $emailResp;
  FluxRSS::miseAJour($title, $link, $timestamp, $contents, $author);
  echo "<p>Le flux RSS a été mis à jour.</p>";
}

function verifier() {
  if (isset($_POST['titre'])) {
    extract($_POST);
    if ($titre != "" && $sujet != "" && $nom_entreprise != "" &&
    $adresse != "" && $ville != "" && $codePostal != "" &&
    $pays != "" && $nom_contact != "" && $prenom_contact != "" &&
    $tel_contact != "" && $email_contact != "" && $siret != "") {

      $tabDonnees = array();

      // Identifiant
      array_push($tabDonnees, $idOffreDAlternance);

      // Sujet
      array_push($tabDonnees, $sujet);

      // Titre
      array_push($tabDonnees, $titre);


      // ----------------------------------------------------------------
      // Theme
      $tabParcours = Parcours::listerParcours();
      $tabThemes = array();
      for ($i = 0; $i < sizeof($tabParcours); $i++) {
        $ident = $tabParcours[$i]->getIdentifiantBDD();
        if (isset($_POST['parcours' . $ident])) {
          array_push($tabThemes, $_POST['parcours' . $ident]);
        }
      }
      array_push($tabDonnees, $tabThemes);

      // ----------------------------------------------------------------
      // Profils
      $tabFilieres = Filiere::listerFilieres();
      $tabProfils = array();
      for ($i = 0; $i < sizeof($tabFilieres); $i++) {
        $ident = $tabFilieres[$i]->getIdentifiantBDD();
        if (isset($_POST['filiere' . $ident])) {
          array_push($tabProfils, $_POST['filiere' . $ident]);
        }
      }
      array_push($tabDonnees, $tabProfils);

      // DureeMin
      array_push($tabDonnees, $duree);

      // Indemnites
      array_push($tabDonnees, $indemnites);

      // Remarques
      array_push($tabDonnees, $rmq);

      // estVisible
      if (isset($_POST['valider']))
      array_push($tabDonnees, true);

      //-----------------------------------------------------------------
      // Competences
      $tabCompetences = Competence::listerCompetences();
      $competences = array();

      // Ancienne compétences
      for ($i = 1, $j = 0; $j != sizeof($tabCompetences);$i++) {
        if (Competence::getCompetence($i)) {
          $j++;
          if (isset($_POST['competence' . $i])) {
            array_push($competences, $_POST['competence' . $i]);
          }
        }
      }

      // Nouvelles compétences
      if ($compteur_competence) {//On ajoute les compétences
        for ($i = 0; $i < $compteur_competence; $i++) {
          $nouvelleCompetence = new Competence("", $_POST['competence_ajout' . $i]);
          $idCompetence = Competence_BDD::sauvegarder($nouvelleCompetence);
          array_push($competences, $idCompetence);
        }
      }

      array_push($tabDonnees, $competences);

      // ----------------------------------------------------------------
      // Entreprise et contact
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
          $nouveauContact = new Contact("", $nom_contact, $prenom_contact, $tel_contact, $email_contact, $idEntreprise);
          $idContact = Contact_BDD::sauvegarder($nouveauContact);
        }
      } else {//On enregistre l'entreprise dans la base de données
        $nouvelleEntreprise = new Entreprise("", $nom_entreprise, $adresse, $codePostal, $ville, $pays, $email_entreprise, NULL);
        $idEntreprise = Entreprise_BDD::sauvegarder($nouvelleEntreprise);
        $nouveauContact = new Contact("", $nom_contact, $prenom_contact, $tel_contact, $email_contact, $idEntreprise);
        $idContact = Contact_BDD::sauvegarder($nouveauContact);
      }
      array_push($tabDonnees, $idContact);

      array_push($tabDonnees, $typeContrat);

      if (isset($_POST['valider'])) {
        $idOffreDAlternance = OffreDAlternance::modifierDonnees($tabDonnees);
        $contact = Contact::getContact($idContact);
        if (!$_POST['estVisible'])
	    envoyerNotifications($contact, $idOffreDAlternance);
        echo "<p>L'offre d'alternance a été enregistrée !</p><p><a href='./listeDesOffreDAlternance.php'>Retour</a></p>";
      } else if (isset($_POST['cancel'])) {
        OffreDAlternance::supprimerDonnees($tabDonnees[0]);
        OffreDalternance::supprimerSuivi($tabDonnees[0]);
        echo "<p>L'offre d'alternance a été supprimée de la base de données !</p><p><a href='./listeDesOffreDAlternance.php'>Retour</a></p>";
      }
    } else {
      IHM_Generale::erreur("Vous devez saisir tous les champs marqués d'une * !");
      OffreDAlternance_IHM::afficherFormulaireModification();
    }
  } else {
    OffreDAlternance_IHM::afficherFormulaireModification();
  }
}

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Edition d'une", "offre d'alternance", "../../", $tabLiens);

verifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>
