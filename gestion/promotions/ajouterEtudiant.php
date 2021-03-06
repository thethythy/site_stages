<?php

/**
 * Page ajouterEtudiant.php
 * Utilisation : page pour ajouter un étudiant à une promotion
 *		 page accessible depuis modifierPromotion.php
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

session_start();

if (isset($_POST['promo']))
    $_SESSION['promo'] = $_POST['promo'];

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Créer un ", "nouvel étudiant", "../../", $tabLiens);

$promo = Promotion::getPromotion($_SESSION['promo']);
$filiere = $promo->getFiliere();
$parcours = $promo->getParcours();

// Si un ajout a été effectué
if (isset($_POST['add'])) {
    extract($_POST);

    if (($nom == "") || ($prenom == "") || ($emailinst == "")) {
	Etudiant_IHM::afficherFormulaireEdition("");
	IHM_Generale::erreur("Le nom, le prénom et l'email institutionnel de l'étudiant sont obligatoires !");
    } else {
	// Si les emails sont valides
	if (Utils::VerifierAdresseMail($emailinst) && (($email == "") || Utils::VerifierAdresseMail($email))) {
	    $nom = strtoupper($nom);

	    $tabOEtudiants = Etudiant::searchEtudiants($nom, $prenom);
	    if (sizeof($tabOEtudiants) > 0) {
		foreach ($tabOEtudiants as $oEtudiant) {
		    echo $oEtudiant->getNom() . " " . $oEtudiant->getPreNom() . " existe déjà dans la liste des étudiants<br/>";
		}

		$newEtu = $tabOEtudiants[0];
	    } else {
		$newEtu = new Etudiant("", $nom, $prenom, $emailinst, $email);
	    }

	    $idNewEtu = Etudiant_BDD::sauvegarder($newEtu);
	    Etudiant_BDD::ajouterPromotion($idNewEtu, $promo->getIdentifiantBDD());

	    echo "L'étudiant $nom $prenom a été ajouté à la promotion : ";
	    echo $filiere->getNom() . " " . $parcours->getNom() . " - " . $promo->getAnneeUniversitaire() . "<br/><br/>";

	    $_SESSION = array();
	    session_destroy();
	    ?>
	    <table>
	        <tr>
		    <td width="50%" align="center">
			<form method=post action="modifierPromotion.php">
			    <input type="hidden" value="1" name="rech"/>
			    <input type="hidden" value="<?php echo $promo->getAnneeUniversitaire(); ?>" name="annee"/>
			    <input type="hidden" value="<?php echo $filiere->getIdentifiantBDD(); ?>" name="filiere"/>
			    <input type="hidden" value="<?php echo $parcours->getIdentifiantBDD(); ?>" name="parcours"/>
			    <input type="submit" value="Retourner à la promotion"/>
			</form>
		    </td>
	        </tr>
	    </table>
	    <?php
	} else {
	    Etudiant_IHM::afficherFormulaireEdition("");
	    IHM_Generale::erreur("L'email est invalide (Exemple : thierry.lemeunier@univ-lemans.fr) !");
	}
    }
} else {
    echo "Cet étudiant sera ajouté à la promotion : ";
    echo $filiere->getNom() . " " . $parcours->getNom() . " - " . $promo->getAnneeUniversitaire() . "<br/><br/>";
    Etudiant_IHM::afficherFormulaireEdition("");
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>