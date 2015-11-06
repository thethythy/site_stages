<?php
$chemin = '../classes/';
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Menu.php");

include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."bdd/Filiere_BDD.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Soutenances');
IHM_Generale::header("Planning ", " des soutenances", "../", $tabLiens);

Menu::menuSoutenance();
?>

<table style="width: 699px;">
	<tr id="entete">
		<td>Dipl�me</td>
		<td>P�riode</td>
		<td>Date d�but</td>
		<td>Date fin</td>
		<td>Dur�e</td>
		<td>Soutenance</td>
	</tr>

	<tr id="ligne0">
		<td>Master 1</td>
		<td>avril � juin</td>
		<td>7 avril 2015</td>
		<td>26 juin 2015</td>
		<td>3 mois<br/>
		(12 sem.)</td>
		<td>29 juin 2015</td>
	</tr>

	<tr id="ligne1">
		<td>Master 2</td>
		<td>mars � ao�t</td>
		<td>2 mars 2015</td>
		<td>14 ao�t 2015</td>
		<td>6 mois<br>
		(24 sem.)</td>
		<td>31 ao�t 2015</td>
	</tr>
</table>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>