<?php
$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Entreprise_IHM.php");
include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

include_once($chemin . "bdd/TypeEntreprise_BDD.php");
include_once($chemin . "moteur/TypeEntreprise.php");

include_once($chemin . "bdd/Couleur_BDD.php");
include_once($chemin . "moteur/Couleur.php");

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
