<?php

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$chemin = '../classes/';

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Menu.php");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");

include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Soutenances');

IHM_Generale::header("Planning ", " des soutenances", "../", $tabLiens);

Menu::menuSoutenance();

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

	<tr id="ligne0">
		<td>Master 1</td>
		<td>avril à juin</td>
		<td>9 avril 2018</td>
		<td>29 juin 2018</td>
		<td>3 mois<br/>
		(12 sem.)</td>
		<td>2 juillet 2018</td>
	</tr>

	<tr id="ligne1">
		<td>Master 2 AFD</td>
		<td>mars à août</td>
		<td>5 mars 2018</td>
		<td>17 août 2018</td>
		<td>6 mois<br>
		(24 sem.)</td>
		<td>30 août 2018</td>
	</tr>

	<tr id="ligne1">
		<td>Master 2 ATAL</td>
		<td>janvier à juin</td>
		<td>22 janvier 2018</td>
		<td>6 juillet 2018</td>
		<td>6 mois<br>
		(24 sem.)</td>
		<td>9 juillet 2018</td>
	</tr>

</table>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>