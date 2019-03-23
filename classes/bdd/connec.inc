<?php

// ----------------------------------------------------------------------------
// Vérification de l'autorisation

global $access_control_target;
global $type_etudiant;

if (isset($access_control_target)) {
  // Vérifier si on arrive de l'alternance ou des stages
  if(isset($type_etudiant)){
    // Nettoyer l'url
    $type_etudiant = str_replace("/","",$type_etudiant);
    $type_etudiant = str_replace("index.php","",$type_etudiant);
    // Si on vient de l'alternance, on a accès à tout le site.
    if($type_etudiant === "alternant"){
      // Pas de cookie -> Envoyer la demande de clef
      if(!isset($_COOKIE['site_stages_depinfo_alternant'])){
        include_once('../access_control.php');
        die();
      } else { //Cookie existe
        // Récupérer le digest de la clef du cookie
        $HClef1 = $_COOKIE['site_stages_depinfo_alternant'];
        // Récupérer le digest du fichier
        $json = json_decode(file_get_contents('../documents/demon/clef.json'));
        $HClef2 = $json->alternant;

        //Si la clef n'est pas bonne -> Renvoyer la demande de clef.
        if (!hash_equals($HClef1, $HClef2)) {
          include_once('../access_control.php');
          die();
        }
      }
    } else { // On vient des stages
      if(!isset($_COOKIE['site_stages_depinfo_alternant']) && !isset($_COOKIE['site_stages_depinfo_stagiaire'])){
        // Pas de cookie stage / alternance -> Envoyer la demande de clef
        include_once('../access_control.php');
        die();
      } else { //Cookie existe
        $json = json_decode(file_get_contents('../documents/demon/clef.json'));
        // Récupérer le digest de la clef du cookie
        if(isset($_COOKIE['site_stages_depinfo_alternant'])){
          $HClef1 = $_COOKIE['site_stages_depinfo_alternant'];
          // Récupérer le digest du fichier
          $HClef2 = $json->alternant;

        } else {
          $HClef1 = $_COOKIE['site_stages_depinfo_stagiaire'];
          // Récupérer le digest du fichier
          $HClef2 = $json->stagiaire;
        }


        //Si la clef n'est pas bonne -> Renvoyer la demande de clef.
        if (!hash_equals($HClef1, $HClef2)) {
          include_once('../access_control.php');
          die();
        }
      }
    }
  }
}

  // ----------------------------------------------------------------------------
  // Connection à la base de données et déclaration des tables

  include_once("stages.inc");

  $tab1 = 'relation_promotion_datesoutenance';
  $tab2 = 'competence';
  $tab3 = 'contact';
  $tab4 = 'convention';
  $tab5 = 'datesoutenance';
  $tab6 = 'entreprise';
  $tab7 = 'profilsouhaite_offredestage';
  $tab8 = 'theme_offredestage';
  $tab9 = 'etudiant';
  $tab10 = 'filiere';
  $tab11 = 'relation_competence_offredestage';
  $tab12 = 'offredestage';
  $tab13 = 'parcours';
  $tab14 = 'parrain';
  $tab15 = 'promotion';
  $tab16 = 'salle_soutenance';
  $tab17 = 'soutenances';
  $tab18 = 'sujetdestage';
  $tab19 = 'relation_promotion_etudiant_convention';
  $tab20 = 'couleur';
  $tab21 = 'taches';
  $tab22 = 'type_entreprise';
  $tab23 = 'theme_destage';
  $tab24 = 'convocation';
  $tab25 = 'attribution';
  $tab26 = 'profilsouhaite_offredalternance';
  $tab27 = 'theme_offredalternance';
  $tab28 = 'relation_competence_offredalternance';
  $tab29 = 'offredalternance';
  $tab30 = 'candidature_alternance';
  $tab31 = 'contrat';
  $tab32 = 'relation_promotion_etudiant_contrat';



  function deconnexion() {
    global $db;
    $db->close();
  }

  // ----------------------------------------------------------------------------
  // Préventions contre les injections SQL

  function filterParameters($param) {
    global $db;

    // Est-ce que le paramètre est un tableau ?
    if (is_array($param)) {
      // Alors parcourir le tableau
      foreach ($param as $key => $value) {
        // Es-ce que la valeur est elle-même un tableau
        if (is_array($param[$key]))
        // Alors appel récursif
        $param[$key] = filterParameters($param[$key]);

        // Est-ce que le paramètre est une chaîne ?
        if (is_string($param[$key]))
        // Alors échaper le paramètre
        $param[$key] = $db->real_escape_string($param[$key]);
      }
    }

    // Est-ce que le paramètre est une chaîne ?
    if (is_string($param))
    // Alors échaper le paramètre
    $param = $db->real_escape_string($param);

    // Retourne le paramètre échappé
    return $param;
  }

  // Prévention contre les injection SQL dans les variables POST
  foreach ($_POST as $key => $value) {
    $_POST[$key] = filterParameters($value);
  }

  // Prévention contre les injection SQL dans les variables GET
  foreach ($_GET as $key => $value) {
    $_GET[$key] = filterParameters($value);
  }

  // Prévention contre les injection SQL dans les variables COOKIES
  foreach ($_COOKIE as $key => $value) {
    $_COOKIE[$key] = filterParameters($value);
  }

  // Prévention contre les injection SQL dans les variables SESSION
  if(isset($_SESSION)) {
    foreach ($_SESSION as $key => $value) {
      $_SESSION[$key] = filterParameters($value);
    }
  }

  // Prévention contre les injection SQL dans les variables FILES
  foreach ($_FILES as $key => $value) {
    $_FILES[$key] = filterParameters($value);
  }

  // ----------------------------------------------------------------------------
  // Variables globales

  $emailResponsable = "";
  $baseSite = "http://testvirtualhost/";

  ?>
