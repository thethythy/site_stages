<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");

include_once($chemin."ihm/IHM_Generale.php");

include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Contact.php");

include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."moteur/Entreprise.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');

IHM_Generale::header("Taxe", "d'apprentissage", "../../", $tabLiens);

// Affichage du formulaire de recherche
Promotion_IHM::afficherFormulaireRecherche("listeEtiquetteEntreprisesData.php", true);

// Affichage des données
echo "<div id='data'>\n";
include_once("listeEtiquetteEntreprisesData.php");
echo "\n</div>";

?>

<table align="center">
    <tr>
	<td width="100%" align="center">
	    <form method=post action="../index.php">
		<input type="submit" value="Retour"/>
	    </form>
	</td>
    </tr>
</table>

<br/><br/>

<?php

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>