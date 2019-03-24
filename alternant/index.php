<?php

/**
 * Page index.php
 * Utilisation : page principale d'accès aux fonctionnalités des étudiants
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$type_etudiant = $_SERVER['REQUEST_URI'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("Alternant ", "", "../", $tabLiens);

IHM_Menu::menuAlternant();

?>
<p>Cette partie du site concerne principalement les étudiants.</p>
<p>Elle leur permet d'une part d'accéder à une liste des entreprises ayant déjà accueillies des alternants les années précédentes et la liste des contacts dans ces entreprises.</p>
<p>D'autre part, elle donne accès à plusieurs sites d'offres d'alternance.</p>
<p>Les étudiants peuvent y trouver un formulaire de demande de validation de sujet d'alternance, demande qui sera transmise au responsable.</p>
<p>Enfin, ils peuvent déposer les rapports d'alternance et les résumés d'alternance. Ces documents seront ensuite accessibles aux enseignants.</p>
<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>
