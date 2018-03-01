<?php

/**
 * Page saisirContact.php
 * Utilisation : page pour saisir un nouveau contact
 *		 page aussi accessible depuis saisirEntreprise.php
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Saisir un", "contact", "../../", $tabLiens);

// Si un ajout a été effectué
if (isset($_POST['add'])) {
    extract($_POST);

    if (($nom == "") || ($prenom == "") || ($tel == "")) {
	Contact_IHM::afficherFormulaireSaisie("");
	IHM_Generale::erreur("Le nom, le prénom et le numéro de téléphone sont obligatoires !");
    } else {
	$newContact = new Contact("", $nom, $prenom, $tel, $fax, $email, $idEntreprise);

	$idCont = Contact_BDD::sauvegarder($newContact);
	$contact = Contact::getContact($idCont);
	$entreprise = $contact->getEntreprise();
	?>
	<table align="center">
	    <tr>
		<td colspan="2" align="center">
		    Ajout du nouveau contact <?php echo $nom . " " . $prenom; ?> (<?php echo $entreprise->getNom() . " (" . $entreprise->getVille() . ")"; ?>) réalisé avec succès.
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
    }
} else {
    Contact_IHM::afficherFormulaireSaisie("");
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>