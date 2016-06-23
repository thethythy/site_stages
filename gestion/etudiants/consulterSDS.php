<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");

include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/SujetDeStage_IHM.php");
include_once($chemin . "bdd/SujetDeStage_BDD.php");
include_once($chemin . "moteur/SujetDeStage.php");

include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Consulter", "les sujets de stage", "../../", $tabLiens);

$tabSDS = SujetDeStage::getSujetDeStageValide();
if (sizeof($tabSDS) > 0)
    SujetDeStage_IHM::afficherTableauSDSValide($tabSDS);
else
    echo "<p>Il n'y aucun sujet de stage validé.</p>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>