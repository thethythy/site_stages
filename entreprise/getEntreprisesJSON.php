<?php

/**
 * Page getEntreprisesJSON.php
 * Utilisation : traitement requête Ajax de index.php
 *               retourne une liste d'entreprises (format JSON)
 * Accès : public
 */

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

if (count($_REQUEST) == 0 || !array_key_exists("search", $_REQUEST)) {
    print "Usage : $_SERVER[PHP_SELF]?search=un-nom";
} else {
    
    if (array_key_exists("size", $_REQUEST) && is_numeric($_REQUEST["size"])) {
	$size = intval($_REQUEST["size"]);
    } else {
	$size = 10;
    }
    
    $noms = Entreprise_BDD::getListeEntreprisesByNom($_REQUEST["search"], $size);
    
    header("Cache-Control: max-age=2");
    header("Content-type: application/json; charset=utf-8");
    
    // Encodage en JSON puis envoie du flux
    print(json_encode($noms));
}

deconnexion();

?>

