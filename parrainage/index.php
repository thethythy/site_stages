<?php 
include_once("../classes/ihm/IHM_Generale.php");
include_once("../classes/ihm/Menu.php");
$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
IHM_Generale::header("Conventions et", "r�f�rents", "../", $tabLiens);
Menu::menuParrainage();
?>
<p>Cette partie du site concerne principalement les enseignants-r�f�rents.</p>

<p>Elle permet d'une part d'acc�der � la liste des enseignants-r�f�rents de stages par ann�e, par r�f�rent et par dipl�me.</p>

<p>Elle permet d'autre part d'acc�der � un r�sum� de la charge des r�f�rents par ann�e et par dipl�me pour chaque enseignant-r�f�rent membre de l'�quipe p�dagogique du d�partement informatique.
</p>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>
