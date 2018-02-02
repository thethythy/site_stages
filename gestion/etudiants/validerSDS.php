<?php

/**
 * Page validerSDS.php
 * Utilisation : page pour visualiser les demandes de validation non traitées
 * Accès : restreint par authentification HTTP
 */

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

include_once($chemin . "moteur/Etudiant.php");
include_once($chemin . "bdd/Etudiant_BDD.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Validation", "d'un sujet de stage", "../../", $tabLiens);

$tabSDS = SujetDeStage::getSujetDeStageAValider();
if (sizeof($tabSDS) > 0)
    SujetDeStage_IHM::afficherTableauSDSAValider($tabSDS);
else
    echo "Il n'y a aucun sujet à valider en attente.<br/>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>