<?php

$chemin = '../../classes/';
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/ThemeDeStage.php");
include_once("frameworksJS/statistique_fonctions.php");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Statistiques", "entreprises", "../../", $tabLiens, "statistiques");
$tabAU = Promotion_BDD::getAnneesUniversitaires();
$tabListeTheme = ThemeDeStage::getListeTheme();
include("statistiquesData.php");
?>
<script>



$(function() {
    var curPage="";
    $("#menu a").click(function() {
        if (curPage.length) { 
            $("#"+curPage).hide();
        }
        curPage=$(this).data("page");
        $("#"+curPage).show();
    });
});
</script>
<div class="nav">
    <ul id="menu">
    	<?php
for ($i=0; $i<sizeof($tabAU); $i++) {

		echo "<li id='link".$i."'><a href='#' data-page='page".$i."'>".$tabAU[$i]."</a></li>";
    	
    }
    ?>
    </ul>
</div>
<?php


echo "<div id='view'>\n";
include("pageInter.php");
echo "\n</div>";


IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>
