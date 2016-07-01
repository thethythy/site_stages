<?php

$chemin = "../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");
include_once($chemin . "ihm/Gestion_IHM.php");

include_once($chemin . "bdd/Tache_BDD.php");
include_once($chemin . "moteur/Tache.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("Gestion des ", "stages", "../", $tabLiens);

Gestion_IHM::afficherMenuGestion();

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>
