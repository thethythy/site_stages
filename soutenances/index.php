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
		<td>Période</td>
		<td>Date début</td>
		<td>Date fin</td>
		<td>Durée</td>
		<td>Soutenance</td>
	</tr>

	<tr class="ligne0">
		<td>Master 1</td>
		<td>avril à juin</td>
		<td>6 avril 2020</td>
		<td>26 juin 2020</td>
		<td>3 mois<br/>
		(12 sem.)</td>
		<td>29 juin 2020</td>
	</tr>

	<tr class="ligne1">
		<td>Master 2 AFD</td>
		<td>mars à août</td>
		<td>2 mars 2020</td>
		<td>14 août 2020</td>
		<td>6 mois<br>
		(24 sem.)</td>
		<td>27 août 2020</td>
	</tr>

	<tr class="ligne0">
		<td>Master 2 ATAL</td>
		<td>janvier à juin</td>
		<td>27 janvier 2020</td>
		<td>10 juillet 2020</td>
		<td>6 mois<br>
		(24 sem.)</td>
		<td>10 juillet 2020</td>
	</tr>

</table>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>