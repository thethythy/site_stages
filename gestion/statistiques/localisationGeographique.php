<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Statistique_IHM.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Convention.php");
include_once($chemin."bdd/Convention_BDD.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Localisation", "géographique", "../../", $tabLiens);

// Afficher un formulaire de sélection des années pour la recherche
Statistique_IHM::afficherFormulaireRechercheLocalisation("localisationGeographique.php");

include_once("afficheGraphiques.php"); // Ici car modifie les styles

// Prise en compte d'une recherche précédente
if (isset($_POST['rech'])) {
	$tabConventions = Convention_BDD::getListeEntreprises($_POST['annee_in'], $_POST['annee_fin']);
	$tabVilles = Convention_BDD::getListeVillesRepartition($_POST['annee_in'], $_POST['annee_fin']);
	$tabPays = Convention_BDD::getListePaysRepartition($_POST['annee_in'], $_POST['annee_fin']);
}

// Afficher le résultat de la recherche sous forme d'histogramme
if (sizeof($tabVilles) > 0) {
	$donnees = $tabVilles[0][0];
	$vil_prec = $tabVilles[0][0];
	$summ = $tabVilles[0][1];
	for ($i = 1; $i < sizeof($tabVilles); $i++) {
		if (strpos($tabVilles[$i][0], $vil_prec) === 0) {
			$summ = $summ + $tabVilles[$i][1];
		} else {
			if ($i == 1) {
				$donnees = $donnees.";".$summ;
				$vil_prec = $tabVilles[$i][0];
				$summ = $tabVilles[$i][1];
			} else {
				$donnees = $donnees.";".$vil_prec.";".$summ;
				$vil_prec = $tabVilles[$i][0];
				$summ = $tabVilles[$i][1];
			}
		}
	}
	
	$donnees_pays = $tabPays[0][0].";".$tabPays[0][1];
	for ($i = 1; $i < sizeof($tabPays); $i++) {
		$donnees_pays = $donnees_pays.";".$tabPays[$i][0].";".$tabPays[$i][1];
	}
	
	?>
	<div id="ville-container" style="width: 100%; height: 500px"></div><br/><br/>
	<div id="pays-container" style="width: 100%; height: 500px"></div>
	<script>
		setVillesChart("<?php echo $donnees; ?>");
		setPaysChart("<?php echo $donnees_pays; ?>");
	</script>
	<?php
}

// Lien vers une carte Google
if (sizeof($tabConventions) > 0) {
	// Afficher un tableau des conventions avec lien vers une carte Google
	Statistique_IHM::afficherTableauLocalisation($tabConventions, "afficheMap.html");
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>