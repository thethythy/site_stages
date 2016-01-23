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
IHM_Generale::header("Saisir une", "entreprise", "../../", $tabLiens);

// Si un ajout a �t� effectu�
if(isset($_POST['add'])){
	extract($_POST);
		
	if(($nom == "") || ($adresse == "") || ($cp == "") || ($ville == "") || ($pays == "") || ($type == "")){
		Entreprise_IHM::afficherFormulaireSaisie("");
		IHM_Generale::erreur("Tous les champs sont obligatoires !");
	}else{		
		$newEntreprise = new Entreprise("", $nom, $adresse, $cp, $ville, $pays, $email, $type);
		
		// Si l'entreprise que l'on veut cr�er n'existe pas d�j�
		if(Entreprise_BDD::existe($newEntreprise) == false){
			
			$ent = Entreprise_BDD::sauvegarder($newEntreprise);
			
			?>				
				<table align="center">
					<tr>
						<td colspan="2" align="center">
							Cr�ation de l'entreprise r�alis�e avec succ�s.
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
								<input type="hidden" value="<?php echo $ent; ?>" name="idEntreprise"/>
								<input type="submit" value="Ajouter un contact"/>
							</form>
						</td>
					</tr>
				</table>
			<?php 
		}else{
			Entreprise_IHM::afficherFormulaireSaisie("");
			IHM_Generale::erreur("Une entreprise du m�me nom et se trouvant dans la m�me ville et le m�me pays existe d�j� !");
		}
	}
}else{
	Entreprise_IHM::afficherFormulaireSaisie("");
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>