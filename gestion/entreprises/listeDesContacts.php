<?php
header ('Content-type:text/html; charset=utf-8');
$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."ihm/Contact_IHM.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."moteur/Entreprise.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Liste des", "contacts", "../../", $tabLiens);

Contact_IHM::afficherFormulaireRecherche("listeDesContacts.php");

// Si une recherche a été effectuée
if(isset($_POST['rech'])){	
	$filtres = array();
	
	// Si une recherche sur le nom du contact est demandée
	if(isset($_POST['nom']) && $_POST['nom'] != "")
		array_push($filtres, new FiltreString("nomcontact", $_POST['nom']."%"));
		
	// Si une recherche sur le prénom du contact est demandée
	if(isset($_POST['prenom']) && $_POST['prenom'] != "")
		array_push($filtres, new FiltreString("prenomcontact", $_POST['prenom']."%"));
		
	// Si une recherche sur le téléphone est demandée
	if(isset($_POST['tel']) && $_POST['tel'] != "")
		array_push($filtres, new FiltreString("telephone", $_POST['tel']."%"));
		
	// Si une recherche sur le fax est demandée
	if(isset($_POST['fax']) && $_POST['fax'] != "")
		array_push($filtres, new FiltreString("telecopie", $_POST['fax']."%"));
	
	$nbFiltres = sizeof($filtres);
	
	if($nbFiltres >= 2){
		$filtre = $filtres[0];
		for($i=1; $i<sizeof($filtres); $i++)			
	  		$filtre = new Filtre($filtre, $filtres[$i], "AND");
	}else if($nbFiltres == 1){
		$filtre = $filtres[0];
	}else{
		$filtre = "";
	}
	
	$tabContacts = Contact::getListeContacts($filtre);
}else{
	$tabContacts = Contact::getListeContacts("");
}

// Si il y a au moins un contact 
if(sizeof($tabContacts)>0){
	// Affichage des contacts correspondants aux critères de recherches
	for($i=0; $i<sizeof($tabContacts); $i++){
		?>
		<table id="presentation_entreprise">	
			<tr>
				<td width="50%">
					<?php	
						echo $tabContacts[$i]->getNom()." ".$tabContacts[$i]->getPrenom()."<br/>";
						
						if($tabContacts[$i]->getTelephone() != "")
							echo "Tel : ".$tabContacts[$i]->getTelephone()."<br/>";
							
						if($tabContacts[$i]->getTelecopie() != "")
							echo "Fax : ".$tabContacts[$i]->getTelecopie()."<br/>";

						if($tabContacts[$i]->getEmail() != "")
							echo "Email : ".$tabContacts[$i]->getEmail();
					?>
				</td>
				<td width="50%" id="contact">
					<?php
						$entreprise = $tabContacts[$i]->getEntreprise();
					
						echo "<b>Entreprise</b><br/><br/>";
							
						echo $entreprise->getNom()."<br/>";
						echo $entreprise->getAdresse()."<br/>";
						echo $entreprise->getCodePostal()." ".$entreprise->getVille()."<br/>";
						echo $entreprise->getPays();
					?>
				</td>
			</tr>
		</table>
		<?php
	}
}else{
	echo "Aucun contact ne correspond aux critères de recherche.";
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>