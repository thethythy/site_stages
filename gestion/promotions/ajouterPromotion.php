<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Utils.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Ajouter une", "promotion", "../../", $tabLiens);

// Si un ajout a été effectué
if(isset($_POST['add'])){
	extract($_POST);
	
	if(ereg("^[0-9]{4}$", $annee)){
		
		if(($email != "") && Utils::VerifierAdresseMail($email)) {
		
			if($parcours2 != ""){
				$newParcours = new Parcours("", $parcours2);
				$parcours = Parcours_BDD::sauvegarder($newParcours);
			}else{
				$parcours = $parcours1;
			}
			
			if($filiere2 != ""){
				$newFiliere = new Filiere("", $filiere2);
				$filiere = Filiere_BDD::sauvegarder($newFiliere);
			}else{
				$filiere = $filiere1;
			}
				
			$newPromotion = new Promotion("", $annee, $parcours, $filiere, $email);
		
			// Si la promotion que l'on veut créer n'éxiste pas déjà
			if(Promotion_BDD::existe($newPromotion) == false){
			
				$promo = Promotion_BDD::sauvegarder($newPromotion);
			
				?>				
				<table align="center">
					<tr>
						<td colspan="2" align="center">
							Création de la promotion réalisée avec succès.
						</td>
					</tr>
					<tr>
						<td width="20%" align="center">
							<form method=post action="../">
								<input type="submit" value="Retourner au menu"/>
							</form>
						</td>
						<td width="20%" align="center">
							<form method=post action="./importationEtudiants.php">
								<input type="hidden" value="<?php echo $promo; ?>" name="promo"/>
								<input type="submit" value="Importer des étudiants"/>
							</form>
						</td>
					</tr>
				</table>
				<?php 
			}else{
				Promotion_IHM::afficherFormulaireAjout();
				IHM_Generale::erreur("Cette promotion existe déjà !");
			}		
		}else{
			Promotion_IHM::afficherFormulaireAjout();
			IHM_Generale::erreur("Il faut donner une adresse email valide !");
		}
	}else{
		Promotion_IHM::afficherFormulaireAjout();		
		IHM_Generale::erreur("L'année n'est pas valide ! (Exemple : ".date("Y").")");
	}
}else{
	Promotion_IHM::afficherFormulaireAjout();
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>