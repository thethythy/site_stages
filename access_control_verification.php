<?php

/**
* Page access_control_verification.php
* Utilisation : contrôle le droit d'accès et si OK renvoie un cookie d'accès
* Accès : public
*/

// Récupération de la cible depuis la session PHP
session_start();
$access_control_target = $_SESSION['$access_control_target'];
$baseSite = $_SESSION['$base_site'];
session_write_close();

// Récupérer les condensats dans le fichier
$condensats = json_decode(file_get_contents('./documents/demon/clef.json'));

// Récupérer la destination voulue
$destination = explode("/", str_replace($baseSite, "", $access_control_target))[0];

// Sélection du condensat attendu selon la destination
$HClef2_alter = "";
$HClef2_stagi = "";

if (strcmp($destination, "alternant") == 0) {
    $HClef2_alter = $condensats->alternant;
    $HClef2_stagi = $condensats->stagiaire;
} else {
    if (strcmp($destination, "stagiaire") == 0 || strcmp($destination, "parrainage") == 0) {
	$HClef2_stagi = $condensats->stagiaire;
    } else {
	if (strcmp($destination, "soutenances") == 0 || strcmp($destination, "telechargements") == 0) {
	    $HClef2_alter = $condensats->alternant;
	    $HClef2_stagi = $condensats->stagiaire;
	}
    }
}

// Format de la réponse
header("Content-type:text/plain; charset=utf-8");

// Drapeau de succès ou d'échec du droit d'accès
$access_rigth = false;

// Calcul du condensat
$input = file_get_contents('php://input');
include_once("classes/moteur/Clef.php");
$HClef1 = Clef::calculCondensat($input);

// Vérifier les deux condensats
$res_comparaison_alter = $HClef2_alter != "" && hash_equals($HClef1, $HClef2_alter);
$res_comparaison_stagi = $HClef2_stagi != "" && hash_equals($HClef1, $HClef2_stagi);

if ($res_comparaison_alter || $res_comparaison_stagi) {
  // La comparaison s'est bien passée

  // Calcul la date d'expiration du cookie
  $month = date('n');
  if ($month >= 9 and $month <= 12) {
    $year = date('Y') + 1; // Expire l'année prochaine
  } else {
    $year = date('Y'); // Expire cette année
  }

  // C'est le 15 septembre de l'année courante ou de l'année prochaine
  $time = mktime(0, 0, 0, 9, 15, $year);

  // Enregistre le cookie
  $domain = substr_count($_SERVER['HTTP_HOST'], 'localhost') > 0 ? 'localhost' : $_SERVER['HTTP_HOST'];
  $type_utilisateur = $res_comparaison_alter ? "alternant" : "stagiaire";
  setcookie ('site_stages_depinfo_'.$type_utilisateur, $HClef1, $time, '/', $domain);

  // Mémorisation du succès
  $access_rigth = true;

  // Renvoie l'accord
  echo "OK";
}

// Journalisation de la tentative d'accès
$message = $access_rigth ? "\nOK | " : "\nKO | ";
$message .= strftime("%F | %H:%M | ", $_SERVER['REQUEST_TIME']);
$message .= $access_control_target . " | ";
$message .= $_SERVER['REMOTE_ADDR'] . " | " . $_SERVER['HTTP_USER_AGENT'];

error_log($message, 3, "./documents/demon/authentification.log");

?>
