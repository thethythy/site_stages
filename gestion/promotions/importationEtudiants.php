<?php

// Début de session
session_start();

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Utils.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Importer des", "étudiants", "../../", $tabLiens);

// Info venant de la page modifierPromotion
if (isset($_POST['promo'])) {
	$_SESSION['promo'] = $_POST['promo'];
	$promo_modifiee = Promotion::getPromotion($_POST['promo']);
	$filiere_modifiee = $promo_modifiee->getFiliere();
	$parcours_modifie = $promo_modifiee->getParcours();
}

// Info venant de la session
if (isset($_SESSION['promo'])) {
	$promo_modifiee = Promotion::getPromotion($_SESSION['promo']);
	$filiere_modifiee = $promo_modifiee->getFiliere();
	$parcours_modifie = $promo_modifiee->getParcours();
}

// Si un import a été effectué
if (isset($_POST['import'])) {
	
	// Création du filtre de recherche
	$filtres = array();
	
	array_push($filtres, new FiltreString("anneeuniversitaire", $_POST['annee']));
	array_push($filtres, new FiltreString("idparcours", $_POST['parcours']));
	array_push($filtres, new FiltreString("idfiliere", $_POST['filiere']));
	
	$nbFiltres = sizeof($filtres);
	$filtre = $filtres[0];
	
	for ($i = 1; $i < sizeof($filtres); $i++) $filtre = new Filtre($filtre, $filtres[$i], "AND");
	
	// Récupérer les étudiants de la promotion sélectionnée
	$tabEtudiants = Promotion::listerEtudiants($filtre);
	
	// Récupérer la promo, la filiere et le parcours
	$tabPromos = Promotion_BDD::getListePromotions($filtre);
	$promo = Promotion::getPromotion($tabPromos[0][0]);
	$filiere = $promo->getFiliere();
	$parcours = $promo->getParcours();
	
	echo "Les étudiants ci-dessous ont été ajoutés à la promotion : ";
	echo $filiere_modifiee->getNom()." ".$parcours_modifie->getNom()." - ".$promo_modifiee->getAnneeUniversitaire()."<br/>";
	
	?>
	
	<table>
		
		<?php
		
			for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
				if (isset($_POST['etu'.$tabEtudiants[$i]->getIdentifiantBDD()])) {
					// Mise à jour de l'étudiant
					Etudiant_BDD::sauvegarder($tabEtudiants[$i], false);
					// Insertion de l'étudiant dans la promotion
					Etudiant_BDD::ajouterPromotion($tabEtudiants[$i]->getIdentifiantBDD(), $promo_modifiee->getIdentifiantBDD());
					?>
					<tr id="ligne<?php echo $i%2; ?>">
						<td width="100%" align="left">
							<?php echo $tabEtudiants[$i]->getNom()." ".$tabEtudiants[$i]->getPrenom()." ".$tabEtudiants[$i]->getEmailInstitutionel(); ?>
						</td>
					</tr>
					<?php
				}
			}
			
		?>
		
		<tr>
			<td>
				<table>
					<tr>
						<td width="50%" align="center">
							<form method=post action="modifierPromotion.php">
								<input type="hidden" value="1" name="rech"/>
								<input type="hidden" value="<?php echo $promo_modifiee->getAnneeUniversitaire(); ?>" name="annee"/>
								<input type="hidden" value="<?php echo $filiere_modifiee->getIdentifiantBDD(); ?>" name="filiere"/>
								<input type="hidden" value="<?php echo $parcours_modifie->getIdentifiantBDD(); ?>" name="parcours"/>
								<input type="submit" value="Afficher la promotion"/>
							</form>
						</td>
						<td width="50%" align="center">
							<form method=post action="../">
								<input type="submit" value="Retourner au menu"/>
							</form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
  	</table>
	
	<?php
	
	// Fin de session
	session_unset();
	session_destroy();
	
} else {
	
	echo "Veuillez sélectionner la promotion des étudiants à importer dans la nouvelle promotion : ";
	echo $filiere_modifiee->getNom()." ".$parcours_modifie->getNom()." - ".$promo_modifiee->getAnneeUniversitaire()."<br/>";
	
	Promotion_IHM::afficherFormulaireRecherche("importationEtudiantsData.php", false);
	
	// Affichage des données
	echo "<div id='data'>\n";
	include_once("importationEtudiantsData.php");
	echo "\n</div>";
	
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>