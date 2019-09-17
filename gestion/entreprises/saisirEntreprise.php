<?php

/**
 * Page saisirEntreprise.php
 * Utilisation : page pour saisir une nouvelle entreprise
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Saisir une", "entreprise", "../../", $tabLiens);

// Si un ajout a été effectué
if (isset($_POST['add'])) {
    extract($_POST);

    if (($nom == "") || ($adresse == "") || ($cp == "") || ($ville == "") || ($pays == "")) {
	Entreprise_IHM::afficherFormulaireSaisie("");
	IHM_Generale::erreur("Tous les champs sont obligatoires !");
    } else {
	$newEntreprise = new Entreprise("", $nom, $adresse, $cp, $ville, $pays, $email, $idtype, $siret);

	// Si l'entreprise que l'on veut créer n'existe pas déjà
	if (Entreprise_BDD::existe($newEntreprise) == false) {
	    $idEnt = Entreprise_BDD::sauvegarder($newEntreprise);
	    ?>
	    <table align="center">
	        <tr>
	    	<td colspan="2" align="center">
	    	    Création de l'entreprise réalisée avec succès.
	    	</td>
	        </tr>
	        <tr>
	    	<td width="50%" align="center">
	    	    <form method=post action="../">
	    		<input type="submit" value="Retourner au menu"/>
	    	    </form>
	    	</td>
	    	<td width="50%" align="center">
	    	    <form method=post action="./saisirContact.php">
	    		<input type="hidden" value="<?php echo $idEnt; ?>" name="idEntreprise"/>
	    		<input type="submit" value="Ajouter un contact"/>
	    	    </form>
	    	</td>
	        </tr>
	    </table>
	    <?php
	} else {
	    Entreprise_IHM::afficherFormulaireSaisie("");
	    IHM_Generale::erreur("Une entreprise du même nom et se trouvant dans la même ville et le même pays existe déjà !");
	}
    }
} else {
    Entreprise_IHM::afficherFormulaireSaisie("");
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>