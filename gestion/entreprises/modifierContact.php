<?php

/**
 * Page modifierContact.php
 * Utilisation : page pour modifier un contact existant
 *		 page accessible depuis modifierListeContacts.php
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Contact_IHM.php");
include_once($chemin . "bdd/Contact_BDD.php");
include_once($chemin . "moteur/Contact.php");

include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un", "contact", "../../", $tabLiens);

$contact = Contact::getContact($_GET['id']);

// Si une edition a été effectué
if (isset($_POST['edit'])) {
    extract($_POST);

    if (($nom == "") || ($prenom == "") || ($tel == "")) {
	Contact_IHM::afficherFormulaireSaisie($contact);
	IHM_Generale::erreur("Le nom, le prénom et le numéro de téléphone sont obligatoires !");
    } else {
	$contact->setNom($nom);
	$contact->setPrenom($prenom);
	$contact->setTelephone($tel);
	$contact->setTelecopie($fax);
	$contact->setEmail($email);
	$contact->setIdentifiant_entreprise($idEntreprise);

	$idCont = Contact_BDD::sauvegarder($contact);
	$contact = Contact::getContact($idCont);
	$entreprise = $contact->getEntreprise();

	echo "Les informations sur le contact $nom $prenom (" . $entreprise->getNom() . ") ont été mis à jours.";
	?>
	<table>
	    <tr>
		<td width="50%" align="center">
		    <form method=post action="modifierListeContacts.php">
			<input type="hidden" value="1" name="rech"/>
			<input type="hidden" value="<?php echo $_GET['nom']; ?>" name="nom"/>
			<input type="hidden" value="<?php echo $_GET['prenom']; ?>" name="prenom"/>
			<input type="hidden" value="<?php echo $_GET['tel']; ?>" name="tel"/>
			<input type="hidden" value="<?php echo $_GET['fax']; ?>" name="fax"/>
			<input type="submit" value="Retourner à la liste"/>
		    </form>
		</td>
		<td width="50%" align="center">
		    <form method=post action="../">
			<input type="submit" value="Retourner au menu"/>
		    </form>
		</td>
	    </tr>
	</table>
	<?php
    }
} else {
    Contact_IHM::afficherFormulaireSaisie($contact);
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>