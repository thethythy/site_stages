<?php

/**
 * Page modifierTempsSoutenance.php
 * Utilisation : page pour éditer le temps de soutenance par filière
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

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