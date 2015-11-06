<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."ihm/Entreprise_IHM.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."moteur/Entreprise.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Modifier/Supprimer une", "entreprise", "../../", $tabLiens);

if(isset($_GET['id'])){
	// Nécéssaire pour que dans le formulaire de recherche, on resélectionne les valeurs précédement sélectionnées
	$_POST['nom'] = $_GET['nom'];
	$_POST['cp'] = $_GET['cp'];
	$_POST['ville'] = $_GET['ville'];
	$_POST['pays'] = $_GET['pays'];
	
	// Suppression de l'entreprise
	Entreprise::supprimerEntreprise($_GET['id']);
}

Entreprise_IHM::afficherFormulaireRecherche("modifierListeEntreprises.php");

// Si une recherche a été effectuée
if((isset($_POST['rech'])) || (isset($_GET['id']))){	
	$nom = $_POST['nom'];
	$cp = $_POST['cp'];
	$ville = $_POST['ville'];
	$pays = $_POST['pays'];
}else{
	$nom = $cp = $ville = $pays = "";
}

$filtres = array();

// Si une recherche sur le nom de l'entreprise est demandée
if($nom != "")
	array_push($filtres, new FiltreString("nom", "%".$nom."%"));
	
// Si une recherche sur le code postal est demandée
if($cp != "")
	array_push($filtres, new FiltreString("codepostal", $cp."%"));
	
// Si une recherche sur la ville est demandée
if($ville != "")
	array_push($filtres, new FiltreString("ville", $ville."%"));
	
// Si une recherche sur le pays est demandée
if($pays != "")
	array_push($filtres, new FiltreString("pays", $pays."%"));

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

$tabEntreprises = Entreprise::getListeEntreprises($filtre);
	
// Si il y a au moins une entreprise 
if(sizeof($tabEntreprises)>0){
	// Affichage des entreprises correspondants aux critères de recherches
	for($i=0; $i<sizeof($tabEntreprises); $i++){
		?>
		<table id="presentation_entreprise">	
			<tr>
				<td width="50%">
					<div align="right">
						<a href="modifierEntreprise.php?nom=<?php echo $_POST['nom']; ?>&cp=<?php echo $_POST['cp']; ?>&ville=<?php echo $_POST['ville']; ?>&pays=<?php echo $_POST['pays']; ?>&id=<?php echo $tabEntreprises[$i]->getIdentifiantBDD(); ?>">
							<img src="../../images/reply.png"/>
						</a>
						<a href="modifierListeEntreprises.php?nom=<?php echo $_POST['nom']; ?>&cp=<?php echo $_POST['cp']; ?>&ville=<?php echo $_POST['ville']; ?>&pays=<?php echo $_POST['pays']; ?>&id=<?php echo $tabEntreprises[$i]->getIdentifiantBDD(); ?>">
							<img src="../../images/action_delete.png"/>
						</a>
					</div>
					<?php	echo $tabEntreprises[$i]->getNom();	?> <br/>
					<?php	echo $tabEntreprises[$i]->getAdresse();	?> <br/>
					<?php	echo $tabEntreprises[$i]->getCodePostal();	?>
					<?php	echo $tabEntreprises[$i]->getVille();	?> <br/>
					<?php	echo $tabEntreprises[$i]->getPays();	?>
				</td>
				<td width="50%" id="contact">
					<?php
						$contacts = $tabEntreprises[$i]->listeDeContacts();
					
						if(sizeof($contacts) >= 2)
							echo "<b>Contacts</b><br/><br/>";
						else if(sizeof($contacts) == 1)
							echo "<b>Contact</b><br/><br/>";
							
						for($j=0; $j<sizeof($contacts); $j++){
							echo $contacts[$j]->getNom()." ";
							echo $contacts[$j]->getPrenom()."<br/>";
							
							if($contacts[$j]->getTelephone() != "")
								echo "Telephone : ".$contacts[$j]->getTelephone()."<br/>";
							
							if($contacts[$j]->getTelecopie() != "")
								echo "Fax : ".$contacts[$j]->getTelecopie()."<br/>";
							
							if($contacts[$j]->getEmail() != "")
								echo "Email : ".$contacts[$j]->getEmail()."<br/>";
							
							if($j+1<sizeof($contacts))
								echo "<br/>";
						}
					?>
				</td>
			</tr>
		</table>
		<?php
	}
}else{
	echo "Aucune entreprise ne correspond aux critères de recherche.";
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>