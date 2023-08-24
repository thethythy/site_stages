<?php

/**
 * Page index.php
 * Utilisation : page principale des outils pour les référents
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("Conventions et", "référents", "../", $tabLiens);

IHM_Menu::menuParrainage();

?>

<p>Cette partie du site concerne principalement les enseignants-référents.</p>

<p>Elle permet d'une part d'accéder à la liste des enseignants-référents de stages par année, par référent et par diplôme.</p>

<p>Elle permet d'autre part d'accéder à un résumé de la charge des référents par année et par diplôme pour chaque enseignant-référent membre de l'équipe pédagogique du département informatique.
</p>

<p>Elle permet enfin un accès aux rapports de stage de l'année en cours.</p>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>
