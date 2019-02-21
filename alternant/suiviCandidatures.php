<?php

/**
* Page SuiviCandidatures.php
* Utilisation : page d'accès aux offres de stages de l'année en cours
* Dépendance(s) : SuiviCandidaturesData.php --> traitement des requêtes Ajax
* Accès : restreint par cookie
*/

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');



// /**
// * Vérification de la présence de toutes les informations nécessaire
// * pour enregistrer une nouvelle offre de stage dans la base
// * @global string $emailResponsable
// * @global string $baseSite
// */
// function verifier(){
//   if (isset($_POST)) {
//     extract($_POST);
//
//     $tabDonnees = array();
//
//     //sujet
//     array_push($tabDonnees, $sujet);
//
//     //titre
//     array_push($tabDonnees, $titre);
//
//     //liste des environnements
//     $listeEnvironnements = "";
//     if (isset($environnementMac)) {
//       $listeEnvironnements = $listeEnvironnements."mac;";
//     }
//     if (isset($environnementWin)) {
//       $listeEnvironnements = $listeEnvironnements."win;";
//     }
//     if (isset($environnementUnix)) {
//       $listeEnvironnements =$listeEnvironnements."unix;";
//     }
//     array_push($tabDonnees, $listeEnvironnements);
//
//     //Theme
//     $tabParcours = Parcours::listerParcours();
//     $tabThemes = array();
//     for ($i=1; $i<=sizeof($tabParcours); $i++) {
//       if (isset($_POST['parcours'.$i])) {
//         array_push($tabThemes, $_POST['parcours'.$i]);
//       }
//     }
//     array_push($tabDonnees, $tabThemes);
//
//     //Profils
//     $tabFilieres = Filiere::listerFilieres();
//     $tabProfils = array();
//     for ($i=1; $i <= sizeof($tabFilieres); $i++) {
//       if(isset($_POST['filiere'.$i])){
//         array_push($tabProfils, $_POST['filiere'.$i]);
//       }
//     }
//     array_push($tabDonnees, $tabProfils);
//
//     // Ajout durée contrat en fonction de l'aternance ou du stage
//     if(isset($_POST['type']) && $_POST['type'] === 'alternant') {
//       //Duree
//       array_push($tabDonnees, $duree);
//     } else {
//       //DureeMin
//       array_push($tabDonnees, $dureeMin);
//       //DureeMax
//       array_push($tabDonnees, $dureeMax);
//     }
//
//     //Indemnites
//     array_push($tabDonnees, $indemnites);
//
//     //Remarques
//     array_push($tabDonnees, $rmq);
//
//     //Competences
//     $tabCompetences = Competence::listerCompetences();
//     $competences = array();
//
//     for ($i = 1, $j = 0; $j != sizeof($tabCompetences);$i++) {
//       if (Competence::getCompetence($i)) {
//         $j++;
//         if (isset($_POST['competence' . $i])) {
//           array_push($competences, $_POST['competence' . $i]);
//         }
//       }
//     }
//
//     if (isset($_POST['competence_ajout0'])) {
//       //On ajoute les nouvelles compétences
//       $i = 0;
//       do {
//         if ($_POST['competence_ajout'.$i] != "") {
//           $nouvelleCompetence = new Competence("", $_POST['competence_ajout'.$i]);
//           $idCompetence = Competence_BDD::sauvegarder($nouvelleCompetence);
//           array_push($competences, $idCompetence);
//         }
//         $i++;
//       } while (isset($_POST['competence_ajout'.$i]));
//     }
//     array_push($tabDonnees, $competences);
//
//     //MaitreDeStage
//     $filtreNom = new FiltreString("nom", $nom_entreprise);
//     $filtreVille = new FiltreString("ville", $ville);
//     $filtre = new Filtre($filtreNom, $filtreVille, "AND");
//     $entreprise = Entreprise::getListeEntreprises($filtre);
//
//     if (sizeof($entreprise) == 1) {
//       // On récupère les informations sur l'entreprise
//       $idEntreprise=$entreprise[0]->getIdentifiantBDD();
//       $filtreNom = new FiltreString("nomcontact", $nom_contact);
//       $filtrePrenom = new FiltreString("prenomcontact", $prenom_contact);
//       $filtreTel = new FiltreString("telephone", $tel_contact);
//       $filtre = new Filtre($filtreNom, $filtrePrenom, "AND");
//       $filtre = new Filtre($filtre, $filtreTel, "AND");
//       $contact = Contact::getListeContacts($filtre);
//       if (sizeof($contact) == 1) {
//         // On récupère les informations sur le contact
//         $idContact = $contact[0]->getIdentifiantBDD();
//       } else {
//         // On enregistre le contact dans la base de données
//         $nouveauContact = new Contact("0", $nom_contact, $prenom_contact, $tel_contact, $fax_contact, $email_contact, $idEntreprise);
//         $idContact = Contact_BDD::sauvegarder($nouveauContact);
//       }
//     } else {
//       // On enregistre l'entreprise et le contact dans la base de données
//       if ($email_entreprise == "") $email_entreprise = $email_contact;
//       $nouvelleEntreprise = new Entreprise("", $nom_entreprise, $adresse, $codePostal, $ville, $pays, $email_entreprise, NULL, $siret);
//       $idEntreprise = Entreprise_BDD::sauvegarder($nouvelleEntreprise);
//       $nouveauContact = new Contact("", $nom_contact, $prenom_contact, $tel_contact, $fax_contact, $email_contact, $idEntreprise);
//       $idContact = Contact_BDD::sauvegarder($nouveauContact);
//     }
//     array_push($tabDonnees, $idContact);
//
//     if(isset($_POST['type']) && $_POST['type'] === "alternant"){
//       array_push($tabDonnees, $typeContrat);
//       $idOffreDeStage = OffreDAlternance::saisirDonnees($tabDonnees);
//     } else {
//       $idOffreDeStage = OffreDeStage::saisirDonnees($tabDonnees);
//     }
//
//     //Envoie d'un mail de notification au responsable des stages
//     global $emailResponsable;
//     global $baseSite;
//
//     // $headers ='Content-Type:  text/html; charset=utf-8'."\n";
//     // $headers .='Content-Transfer-Encoding: 8bit'."\n";
//     // $headers .= 'From: '.$emailResponsable."\n";
//     // $headers .= 'Reply-To: '.$emailResponsable."\n";
//     // $headers .= 'X-Mailer: PHP/'.phpversion();
//     //
//     // $msg = "Une nouvelle offre de stage a été ajoutée.<br/>Vous pouvez la visualiser <a href=".$baseSite."gestion/entreprises/editionOffreDeStage.php?id=".$idOffreDeStage.">ici</a>";
//     // mail($emailResponsable, 'Site des stages : nouvelle offre de stage !', $msg, $headers);
//     echo "<p>Votre annonce a bien été enregistrée !</p><p>Après validation par le responsable des stages, un mail de confirmation de diffusion vous sera envoyé.</p><p><a href='../index.php'>Retour</a></p>";
//   } else {
//     OffreDeStage_IHM::afficherFormulaireSaisie();
//   }
// }


$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Alternant');

IHM_Generale::header("Suivi des", "candidatures", "../", $tabLiens);
if(isset($_POST)){
  Utils::printLog(print_r($_POST));
}
//Promotion_IHM::afficherFormulaireRecherche("suiviCandidaturesData.php", false, false);

echo "<div id='data'>";
include_once("suiviCandidaturesData.php");
echo "</div><div id=\"Fin Data\"></div>";



deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>
