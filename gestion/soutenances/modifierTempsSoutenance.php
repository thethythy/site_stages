<?php

/**
 * Page modifierTempsSoutenance.php
 * Utilisation : page pour éditer le temps de soutenance par filière
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "moteur/Utils.php");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");
include_once($chemin . "moteur/FiltreString.php");

include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Filiere_IHM.php");
include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "ihm/Promotion_IHM.php");
include_once($chemin . "moteur/Promotion.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier une", "durée de soutenance", "../../", $tabLiens);

function modifier() {
    if (isset($_POST['filiere']) && $_POST['filiere'] != -1) {
	Filiere_IHM::afficherFormulaireModificationTempsSoutenance($_POST['filiere']);
    }
}

Filiere_IHM::afficherFormulaireChoixFiliere();
modifier();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>