<?php

$chemin = '../../classes/';
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
include_once("frameworksJS/statistique_fonctions.php");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Statistiques", "entreprises", "../../", $tabLiens, "statistiques");
?>
<script>
$(function() {
	var menuVisible = false;
	$('#menuBtn').click(function() {
		if (menuVisible) {
			$('#annee2009').css({'display':'none'});
			menuVisible = false;
			return;
		}
		$('#annee2009').css({'display':'block'});
		menuVisible = true;
	});
	$('#annee2009').click(function() {
		$(this).css({'display':'none'});
		menuVisible = false;
	});
});

</script>

<?php

echo "<div id='menuBtn'>click me</div>";

include("statistiquesData.php");

echo "<div id='view'>\n";
include("pageInter.php");
echo "\n</div>";


IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>
