<?php

/**
 * Page modifierEtudiant.php
 * Utilisation : page pour modifier un étudiant d'une certaine promotion
 *		 page accessible depuis modifierPromotion.php
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "étudiant", "../../", $tabLiens);

$etu = Etudiant::getEtudiant($_GET['id']);

// Si un modification a été effectuée
if (isset($_POST['edit'])) {
	// Récupération des variables postées
	extract($_POST);

	// Vérification que le nom ou le prénom ne sont pas vide
	if (($nom == "") || ($prenom == "") || ($emailinst == "")) {
		Etudiant_IHM::afficherFormulaireEdition($etu);
		IHM_Generale::erreur("Le nom, le prénom et l'adresse institutionnel de l'étudiant sont obligatoires !");
	} else {
		// Si les emails sont valides alors ajouter dans la promotion
		if ( ($email == "" || Utils::VerifierAdresseMail($email)) && ($emailinst == "" || Utils::VerifierAdresseMail($emailinst)) ) {

			// Sauvegarde de l'étudiant
			$nom = strtoupper($nom);
			$etu->setNom($nom);
			$etu->setPrenom($prenom);
			$etu->setEmailPersonnel($email);
			$etu->setEmailInstitutionel($emailinst);
			$idEtu = Etudiant_BDD::sauvegarder($etu);

			// Mise à jour de la promotion
			$promo = Promotion::getPromotion($_GET['promo']);
			$filiere = $promo->getFiliere();
			$parcours = $promo->getParcours();
			Etudiant_BDD::ajouterPromotion($idEtu, $promo->getIdentifiantBDD());

			echo "Les informations sur l'étudiant $nom $prenom ont été mises à jour.";

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
			Etudiant_IHM::afficherFormulaireEdition($etu);
			IHM_Generale::erreur("L'email est invalide (Exemple : thierry.lemeunier@univ-lemans.fr) !");
		}
	}
} else {
	Etudiant_IHM::afficherFormulaireEdition($etu);
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>