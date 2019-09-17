<?php

/**
 * Page modifierEntreprise.php
 * Utilisation : page pour modifier une entreprise existante
 *		 page accessible depuis modifierListeEntreprises.php
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Modifier une", "entreprise", "../../", $tabLiens);

if (isset($_GET['id']))
    $oEnt = Entreprise::getEntreprise($_GET['id']);

if (isset($_POST['id']))
    $oEnt = Entreprise::getEntreprise($_POST['id']);

// Si une édition a été effectuée
if (isset($_POST['edit'])) {
    extract($_POST);

    if (($nom == "") || ($adresse == "") || ($cp == "") || ($ville == "") || ($pays == "")) {
	Entreprise_IHM::afficherFormulaireSaisie($idEnt);
	IHM_Generale::erreur("Tous les champs sont obligatoires !");
    } else {
	$oEnt->setNom($nom);
	$oEnt->setAdresse($adresse);
	$oEnt->setCodePostal($cp);
	$oEnt->setVille($ville);
	$oEnt->setPays($pays);
	$oEnt->setEmail($email);
	$oEnt->setSiret($siret);
	$oEnt->setTypeEntreprise($idtype);

	Entreprise_BDD::sauvegarder($oEnt);

	echo "Les informations sur l'entreprise '$nom' ont été mises à jour.";
	?>
	<form method=post action="modifierListeEntreprises.php">
	    <table>
		<tr>
		    <td align="center">
			<input type="submit" value="Retourner à la liste"/>
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }
} else {
    Entreprise_IHM::afficherFormulaireSaisie($oEnt);
}
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>
