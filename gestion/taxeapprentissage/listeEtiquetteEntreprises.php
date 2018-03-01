<?php

/**
 * Page listeEtiquetteEntreprises.php
 * Utilisation : page pour visualiser la liste des étiquettes pour publipostage
 * Dépendance(s) : listeEtiquetteEntreprisesData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');

IHM_Generale::header("Taxe", "d'apprentissage", "../../", $tabLiens);

// Affichage du formulaire de recherche
Promotion_IHM::afficherFormulaireRecherche("listeEtiquetteEntreprisesData.php", true);

// Affichage des données
echo "<div id='data'>\n";
include_once("listeEtiquetteEntreprisesData.php");
echo "\n</div>";

?>

<table align="center">
    <tr>
	<td width="100%" align="center">
	    <form method=post action="../index.php">
		<input type="submit" value="Retour"/>
	    </form>
	</td>
    </tr>
</table>

<br/><br/>

<?php

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>