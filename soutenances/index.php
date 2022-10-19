<?php

/**
 * Page index.php
 * Utilisation : page principale d'accès aux plannings
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Soutenances');

IHM_Generale::header("Planning ", " des soutenances", "../", $tabLiens);

IHM_Menu::menuSoutenance();

?>

<table style="width: 699px;">
	<tr id="entete">
		<td>Diplôme</td>
		<td>Date début</td>
		<td>Date fin</td>
		<td>Durée</td>
		<td>Soutenance</td>
	</tr>

	<tr class="ligne0">
		<td>Master 1</td>
		<td>10 avril 2023</td>
		<td>30 juin 2023</td>
		<td>3 mois (12 sem.)</td>
		<td>3 juillet 2023</td>
	</tr>

	<tr class="ligne1">
		<td>Master 2</td>
		<td>27 février 2023</td>
		<td>11 août 2023</td>
		<td>6 mois (24 sem.)</td>
		<td>28 août 2023</td>
	</tr>
</table>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>