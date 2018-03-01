<?php

/**
 * Page modifierListeConventions.php
 * Utilisation : page pour éditer ou supprimer une convention
 * Dépendance(s) : modifierListeConventionsData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/Supprimer une", "convention", "../../", $tabLiens);

if ((isset($_GET['id'])) && (isset($_GET['promo']))) {
    // Nécessaire pour que dans le formulaire de recherche, on re-sélectionne les valeurs précédement sélectionnées
    $promo = Promotion::getPromotion($_GET['promo']);
    $filiere = $promo->getFiliere();
    $parcours = $promo->getParcours();
    $_POST['annee'] = $promo->getAnneeUniversitaire();
    $_POST['parcours'] = $parcours->getIdentifiantBDD();
    $_POST['filiere'] = $filiere->getIdentifiantBDD();

    // Suppression de la convention (et de l'attribution automatiquement)
    Convention::supprimerConvention($_GET['id']);
}

Promotion_IHM::afficherFormulaireRecherche("modifierListeConventionsData.php", false);

// Affichage des données
echo "<div id='data'>\n";
include_once("modifierListeConventionsData.php");
echo "\n</div>";
?>
<br/><br/>

<table align="center">
    <tr>
	<td width="100%" align="center">
	    <form method=post action="../">
		<input type="submit" value="Retourner au menu"/>
	    </form>
	</td>
    </tr>
</table>

<?php
deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>