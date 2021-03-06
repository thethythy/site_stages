<?php

/**
 * Page saisirConventionData.php
 * Utilisation : page qui retourne un formulaire de saisie d'une convention
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Prise en compte des paramètres
$filtres = array();

if (isset($_POST['parcours']) && $_POST['parcours'] != '*' && $_POST['parcours'] != '') {
    $parcours = $_POST['parcours'];
    array_push($filtres, new FiltreNumeric("idparcours", $parcours));
}

if (isset($_POST['filiere']) && $_POST['filiere'] != '*' && $_POST['filiere'] != '') {
    $filiere = $_POST['filiere'];
    array_push($filtres, new FiltreNumeric("idfiliere", $filiere));
}

// On ajoute l'année que si le parcours et la filière sont sélectionnés
if (isset($filiere) && isset($parcours) && isset($_POST['annee'])) {
    $annee = $_POST['annee'];
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
}

// On affiche la liste des étudiants que si l'année est sélectionnée
if (isset($annee)) {
    $filtre = $filtres[0];

    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

    $tabEtudiants = Promotion::listerEtudiants($filtre);
} else {
    $tabEtudiants = array();
}

// Si un ajout a été effectué
if (isset($_POST['add']) && isset($_POST['idEtu'])) {
    extract($_POST);

    $newConvention = new Convention("", $sujet, 0, 0, $idPar, $idExam, $idEtu, NULL, $idCont, $idTheme);

    // Si la convention que l'on veut créer n'existe pas déjà
    if (Convention_BDD::existe($newConvention, $annee) == false) {

	// Sauvegarde de la convention
	$idConv = Convention_BDD::sauvegarder($newConvention);

	// Création et sauvegarde de l'attribution liée à la convention
	$attribution = new Attribution('', 0, $idConv);
	Attribution_BDD::sauvegarder($attribution);

	// Mise à jour du lien promotion / étudiant / convention
	if (isset($filiere) && isset($parcours)) {
	    $promotion = Promotion::getPromotionFromParcoursAndFiliere($annee, $filiere, $parcours);
	    Etudiant_BDD::ajouterConvention($idEtu, $idConv, $promotion->getIdentifiantBDD());
	}
	?>
	<table align="center">
	    <tr>
		<td align="center">
		    Création de la convention réalisée avec succès.
		</td>
	    </tr>
	    <tr>
		<td width="100%" align="center">
		    <form method=post action="../">
			<input type="submit" value="Retourner au menu"/>
		    </form>
		</td>
	    </tr>
	</table>
	<?php

    } else {
	Convention_IHM::afficherFormulaireSaisie("", $tabEtudiants, $annee, $parcours, $filiere);
	IHM_Generale::erreur("Cet étudiant à déjà une convention pour l'année sélectionnée !");
    }
} else {
    if (! isset($parcours)) $parcours = "";
    if (! isset($filiere)) $filiere = "";
    Convention_IHM::afficherFormulaireSaisie("", $tabEtudiants, $annee, $parcours, $filiere);
}
?>