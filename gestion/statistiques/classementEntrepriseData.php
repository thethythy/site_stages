<?php

/**
 * Page classementEntrepriseData.php
 * Utilisation : page de traitement Ajax retournant un tableau de classement
 *		 des entreprises par nombre de stagiaire
 *		 les fiches de stage sont accessibles
 * Accès : restreint par authentification HTTP
 */

$chemin = '../../classes/';

include_once $chemin.'bdd/connec.inc';

include_once($chemin.'moteur/Filtre.php');
include_once($chemin.'moteur/FiltreNumeric.php');

include_once $chemin.'bdd/Convention_BDD.php';
include_once $chemin.'moteur/Convention.php';

include_once $chemin.'bdd/Contact_BDD.php';
include_once $chemin.'moteur/Contact.php';

include_once $chemin.'bdd/Entreprise_BDD.php';
include_once $chemin.'moteur/Entreprise.php';

include_once $chemin.'bdd/Promotion_BDD.php';
include_once $chemin.'moteur/Promotion.php';

include_once $chemin.'bdd/Filiere_BDD.php';
include_once $chemin.'moteur/Filiere.php';

include_once $chemin.'bdd/Parcours_BDD.php';
include_once $chemin.'moteur/Parcours.php';

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header('Content-type: text/html; charset=utf-8');

// -----------------------------------------------------------------------------
// Création des filtres

$filtres = array();

if (isset($_POST['annee']) && $_POST['annee'] != '*')
    array_push($filtres, new FiltreNumeric('anneeuniversitaire', $_POST['annee']));

if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric('idparcours', $_POST['parcours']));

if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric('idfiliere', $_POST['filiere']));

if (count($filtres) > 0) {
    $filtre = $filtres[0];
    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], 'AND');
} else {
    $filtre = "";
}

// -----------------------------------------------------------------------------
// Affichage des données

function trouveEmailEntreprise($oEntreprise) {
    $email = $oEntreprise->getEmail();

    if ($email == '' || $email == NULL) {
	$email = 'Pas d\'email connu';
    }

    return $email;
}

if (isset($_POST['annee']) && $_POST['annee'] != '')
    $tabOConventions = Convention::getListeConvention($filtre);
else
    $tabOConventions = array();

if (sizeof($tabOConventions) > 0) {
    // Création du tableau des données
    $tabData = array();
    foreach ($tabOConventions as $oConvention) {
	$idEntreprise = $oConvention->getEntreprise()->getIdentifiantBDD();
	$idPromotion = $oConvention->getPromotion()->getIdentifiantBDD();

	$tabData[$idEntreprise]['nbConventions']++;
	$tabData[$idEntreprise]['promotions'][$idPromotion]++;
	$tabData[$idEntreprise]['promotions']['conventions'][$idPromotion][$oConvention->getIdentifiantBDD()] = $oConvention;
    }

    // Fonction de comparaison pour le tri sur le nombre de conventions
    function cmp1($a, $b) {
	if ($a['nbConventions'] == $b['nbConventions']) return 0;
	return ($a['nbConventions'] > $b['nbConventions']) ? -1 : 1;
    }

    // Fonction de comparaison pour le tri sur les promotions
    function cmp2($a, $b) {
	$a1 = Promotion::getPromotion($a)->anneeUniversitaire;
	$a2 = Promotion::getPromotion($b)->anneeUniversitaire;

	if ($a1 == $a2) return 0;
	return ($a1 > $a2) ? -1 : 1;
    }

    // Tri du tableau des données
    uasort($tabData, 'cmp1');
    foreach ($tabData as $key => $value) {
	uksort($tabData[$key]['promotions']['conventions'], 'cmp2');
    }

    // Affichage du tableau trié
    echo "Nombre d'entreprises sélectionnées : ".sizeof($tabData)."<p/>";

    echo '<table>
	    <tr id="entete">
		<td width="40%">Entreprise</td>
		<td width="10%">Stagiaire(s)</td>
		<td width="60%">Stage(s)</td>
	    </tr>';

    $i = 0; // Pour l'affichage de couleur alterné
    foreach ($tabData as $key => $value) {

	echo '<tr id="ligne' . $i%2 . '">';

	// L'entreprise
	$oEntreprise = Entreprise::getEntreprise($key);
	echo '<td>';
	echo $oEntreprise->getNom() . '<br/>';
	echo $oEntreprise->getAdresse() . '<br/>';
	echo $oEntreprise->getCodePostal() . '&nbsp;';
	echo $oEntreprise->getVille() . '<br/>';
	echo trouveEmailEntreprise($oEntreprise);
	echo '</td>';

	// Le nombre de stagiaires
	echo '<td>';
	echo $value['nbConventions'];
	echo '</td>';

	// Les fiches par promotion
	echo '<td>';

	$anneeUniversitaire = '';
	foreach ($value['promotions']['conventions'] as $key2 => $value2) {

	    $oPromotion = Promotion::getPromotion($key2);

	    if ($anneeUniversitaire == '') $anneeUniversitaire = $oPromotion->anneeUniversitaire;
	    $annees = $oPromotion->anneeUniversitaire . '-' . ($oPromotion->anneeUniversitaire + 1) ;

	    $j = 1; // Numéro de la fiche
	    $fiches = '';
	    foreach ($value2 as $key3 => $value3) {
		$fiches .= '<a href="./ficheDeStage.php?&idEtu=' . $value3->getIdEtudiant() . '&idPromo=' . $oPromotion->getIdentifiantBDD() .'" target="_blank">F'.$j.'</a>';
		if ($j++ < sizeof($value2)) $fiches .= ' ';
	    }

	    if ($anneeUniversitaire != $oPromotion->anneeUniversitaire) {
		echo '<hr/>';
		$anneeUniversitaire = $oPromotion->anneeUniversitaire;
	    }

	    echo sprintf('%d&nbsp;&nbsp;%s %s&nbsp;&nbsp;[%s]&nbsp;&nbsp;{%s}', sizeof($value2), $oPromotion->getFiliere()->getNom(), $oPromotion->getParcours()->getNom(), $annees, $fiches);

	    echo '<br/>';
	}

	echo '</td>';
	echo '</tr>';

	$i++;
    }

    echo "</table>";

} else {
    echo '<br/><center>Aucune entreprise ne correspond aux critères de recherche.</center><br/>';
}

?>
