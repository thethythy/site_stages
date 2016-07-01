<?php

// Format de la réponse
header("Content-type:text/plain; charset=utf-8");

$input = file_get_contents('php://input');

// Calcul du condensat
include_once("classes/moteur/Clef.php");
$HClef1 = Clef::calculCondensat($input);

// Récupérer le condensat de la clef
$f = fopen('documents/demon/clef', 'r');
$HClef2 = fread($f, 500);
fclose($f);

// Vérifier les deux condensats
if (hash_equals($HClef1, $HClef2)) {
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
    setcookie ('site_stages_depinfo', $HClef1, $time, '/', $domain);

    // Renvoie l'accord
    echo "OK";
}

?>