<?php

// ----------------------------------------------------------------------------
// Variables globales

$emailResponsableStage = "thierry.lemeunier@univ-lemans.fr";
$emailResponsableAlter = "valerie.renault@univ-lemans.fr";
$baseSite = "http://localhost:8888/";

// ----------------------------------------------------------------------------
// Vérification de l'autorisation

global $access_control_target; // Page désirée

if (isset($access_control_target)) {

    // Si pas de cookie alors --> page connexion
    if(!isset($_COOKIE['site_stages_depinfo_alternant']) && !isset($_COOKIE['site_stages_depinfo_stagiaire'])){
        include_once('../access_control.php');
        die();
    }

    // Il existe un cokkie, il faut le contrôler selon la destination désirée
    else {

	// Récupérer les condensats depuis les cookies
	$HClef1_alter = isset($_COOKIE['site_stages_depinfo_alternant']) ? $_COOKIE['site_stages_depinfo_alternant'] : "";
	$HClef1_stagi = isset($_COOKIE['site_stages_depinfo_stagiaire']) ? $_COOKIE['site_stages_depinfo_stagiaire'] : "";

	// Récupérer les condensats dans le fichier
	$condensats = json_decode(file_get_contents('../documents/demon/clef.json'));

	// Récupérer la destination voulue
	$destination = explode("/", str_replace($baseSite, "", $access_control_target))[0];

	// Sélection et comparaison du condensat selon la destination
	$res_comparaison = FALSE;

	if (strcmp($destination, "alternant") == 0) {
	    $res_comparaison = $HClef1_alter && hash_equals($HClef1_alter, $condensats->alternant);
	} else {
	    if (strcmp($destination, "stagiaire") == 0 || strcmp($destination, "parrainage") == 0) {
		$res_comparaison = $HClef1_stagi && hash_equals($HClef1_stagi, $condensats->stagiaire);
	    } else {
		if (strcmp($destination, "soutenances") == 0 || strcmp($destination, "telechargements") == 0) {
		    $res_comparaison = $HClef1_alter && hash_equals($HClef1_alter, $condensats->alternant) ||
				       $HClef1_stagi && hash_equals($HClef1_stagi, $condensats->stagiaire);
		}
	    }
	}

	//Si la clef n'est pas bonne -> Renvoyer la demande de clef
	if (!$res_comparaison) {
	    include_once('../access_control.php');
	    die();
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
  $tab33 = 'sujetdalternance';

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

?>