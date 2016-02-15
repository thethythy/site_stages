<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Entreprise_IHM.php");
include_once($chemin."moteur/Entreprise.php");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."moteur/TypeEntreprise.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Modifier une", "entreprise", "../../", $tabLiens);

$ent = Entreprise::getEntreprise($_GET['id']);

// Si une edition a été effectué
if(isset($_POST['edit'])){
	extract($_POST);
		
	if(($nom == "") || ($adresse == "") || ($cp == "") || ($ville == "") || ($pays == "")){
		Entreprise_IHM::afficherFormulaireSaisie($ent);
		IHM_Generale::erreur("Tous les champs sont obligatoires !");
	}else{

		$idtype = $_POST['typeEntreprise'];

		$ent->setNom($nom);
		$ent->setAdresse($adresse);
		$ent->setCodePostal($cp);
		$ent->setVille($ville);
		$ent->setPays($pays);
		$ent->setEmail($email);
		$ent->setTypeEntreprise($idtype);

		echo "Juste avant l'appel a entreprise_bdd : (".$ent->getIdentifiantBDD()."), ".$ent->getNom().", ".$ent->getType()->getType();
							
		$idEnt = Entreprise_BDD::sauvegarder($ent);
		
		echo "Les informations sur l'entreprise $nom ont été mises à jour.";
					
		?>
			<table>
				<tr>
					<td width="50%" align="center">
						<form method=post action="modifierListeEntreprises.php">
							<input type="hidden" value="1" name="rech"/>
							<input type="hidden" value="<?php echo $_GET['nom']; ?>" name="nom"/>
							<input type="hidden" value="<?php echo $_GET['cp']; ?>" name="cp"/>
							<input type="hidden" value="<?php echo $_GET['ville']; ?>" name="ville"/>
							<input type="hidden" value="<?php echo $_GET['pays']; ?>" name="pays"/>
							<input type="hidden" value="<?php echo $_GET['email']; ?>" name="email"/>
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
}else{
	Entreprise_IHM::afficherFormulaireSaisie($ent);
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>