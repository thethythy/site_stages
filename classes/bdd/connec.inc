<?php

// ----------------------------------------------------------------------------
// Vérification de l'autorisation

global $access_control_target;

if (isset($access_control_target)) {
    if (!isset($_COOKIE['site_stages_depinfo'])) {
	include_once('../access_control.php');
	die();
    } else {
	// Récupérer le digest de la clef du cookie
	$HClef1 = $_COOKIE['site_stages_depinfo'];

	// Récupérer le digest du fichier
	$f = fopen('../documents/demon/clef', 'r');
	$HClef2 = fread($f, 500);
	fclose($f);

	if (!hash_equals($HClef1, $HClef2)) {
	    include_once('../access_control.php');
	    die();
	}
    }
}

// ----------------------------------------------------------------------------
// Connection à la base de données et déclaration des tables

include_once("stages.inc");
mysqli_set_charset($db,"utf8");

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

function deconnexion() {
    global $db;
    mysqli_close($db);
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
		$param[$key] = mysqli_real_escape_string($db,$param[$key]);
	}
    }

    // Est-ce que le paramètre est une chaîne ?
    if (is_string($param))
	// Alors échaper le paramètre
	$param = $db->real_escape_string($param);

    // Return the filtered result
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

$emailResponsable = "thierry.lemeunier@univ-lemans.fr";
$baseSite = "http://localhost:8888/";

?>