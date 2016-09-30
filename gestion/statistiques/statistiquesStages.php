<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");

include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Statistiques des", "stages", "../../", $tabLiens, "statistiques");

// Affichage du formulaire de recherche
Promotion_IHM::afficherFormulaireSelectionInterval();

// Chargement des traitements (affichage et contrôle)
echo "<div id='data'></div>\n";
echo "<script type='text/javascript' src='statistiques.js'></script>\n";

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>
