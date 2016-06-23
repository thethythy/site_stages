<?php

include_once("../classes/ihm/IHM_Generale.php");
include_once("../classes/ihm/Menu.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("Conventions et", "référents", "../", $tabLiens);

Menu::menuParrainage();

?>

<p>Cette partie du site concerne principalement les enseignants-référents.</p>

<p>Elle permet d'une part d'accéder à la liste des enseignants-référents de stages par année, par référent et par diplôme.</p>

<p>Elle permet d'autre part d'accéder à un résumé de la charge des référents par année et par diplôme pour chaque enseignant-référent membre de l'équipe pédagogique du département informatique.
</p>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>
