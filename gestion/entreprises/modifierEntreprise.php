<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Entreprise_IHM.php");
include_once($chemin."moteur/Entreprise.php");

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
		$ent->setNom($nom);
		$ent->setAdresse($adresse);
		$ent->setCodePostal($cp);
		$ent->setVille($ville);
		$ent->setPays($pays);
		$ent->setEmail($email);
		//$ent->setType($idtype);
							
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
							<select>
								<option value="0">petite</option>
								<option value="1">moyenne</option>
								<option value="2">grande</option>
								<option value="3">hors info</option>
							</select>
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