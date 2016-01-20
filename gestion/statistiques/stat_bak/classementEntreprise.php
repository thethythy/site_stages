<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Promotion.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Top", "entreprises", "../../", $tabLiens);

// Affichage du formulaire de recherche
Promotion_IHM::afficherFormulaireRecherche("classementEntrepriseData.php", TRUE, TRUE);

// Affichage des données
echo "<br/>";
echo "<div id='data'>\n";
include_once("classementEntrepriseData.php");
echo "\n</div>";

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>
