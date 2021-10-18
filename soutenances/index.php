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
		<td>11 avril 2022</td>
		<td>1 juillet 2022</td>
		<td>3 mois (12 sem.)</td>
		<td>4 juillet 2022</td>
	</tr>

	<tr class="ligne1">
		<td>Master 2 AFD initiaux</td>
		<td>28 février 2022</td>
		<td>12 août 2022</td>
		<td>6 mois (24 sem.)</td>
		<td>29 août 2022</td>
	</tr>

	<tr class="ligne0">
		<td>Master 2 AFD alternants</td>
		<td>28 février 2022</td>
		<td>Fin du contrat</td>
		<td>Jusqu'à fin du contrat</td>
		<td>29 août 2022</td>
	</tr>

	<tr class="ligne1">
		<td>Master 2 ATAL initiaux</td>
		<td>24 janvier 2022</td>
		<td>8 juillet 2022</td>
		<td>6 mois (24 sem.)</td>
		<td>11 juillet 2022</td>
	</tr>

	<tr class="ligne0">
		<td>Master 2 ATAL alternants</td>
		<td>24 janvier 2022</td>
		<td>Fin du contrat</td>
		<td>Jusqu'à fin du contrat</td>
		<td>29 août 2022</td>
	</tr>

</table>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>