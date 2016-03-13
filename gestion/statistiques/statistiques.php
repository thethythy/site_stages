<?php

$chemin = '../../classes/';
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");


include_once($chemin."ihm/Entreprise_IHM.php");
include_once($chemin."ihm/Etudiant_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."ihm/Contact_IHM.php");
include_once($chemin."ihm/Convention_IHM.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."ihm/Filiere_IHM.php");
include_once($chemin."ihm/IHM_Generale.php");


include_once($chemin."moteur/Entreprise.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."moteur/ThemeDeStage.php");
include_once($chemin."moteur/TypeEntreprise.php");
include_once($chemin."moteur/Convention.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Statistiques", "entreprises", "../../", $tabLiens, "statistiques");
$tabAU = Promotion_BDD::getAnneesUniversitaires();
$tabListeTheme = ThemeDeStage::getListeTheme();
$tabListeType = TypeEntreprise::getListeTypeEntreprise();
$tabParcours = Parcours::listerParcours();
$tabFiliere = Filiere::listerFilieres();

include("statistiquesData.php");
include("genererExcel.php");
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
    <p style="font-weight: bold;">Veuillez sélectionner une année :</p>
    <ul id="menu">
    	<?php
for ($i=0; $i<sizeof($tabAU); $i++) {

		echo "<li id='link".$i."'><a href='#' data-page='page".$i."'>".$tabAU[$i]."</a></li>";
    	
    }
    ?>
    </ul>
    <div style='border-bottom : 1px solid #555;padding-bottom:10px'>
    <p style="color:grey">Les statistiques sont généré sous forme de fichiers Excel dans le répertoire documents/statistiques</p>
    
    </div>
</div>
<?php


echo "<div id='view'>\n";

include("statistiquesAffichage.php");
echo "\n</div>";


IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>
