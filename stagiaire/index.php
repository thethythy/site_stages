<?php 
include_once("../classes/ihm/IHM_Generale.php");
include_once("../classes/ihm/Menu.php");
$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
IHM_Generale::header("Stagiaire ", "", "../", $tabLiens);
Menu::menuStagiaire();
?>
	<p>Cette partie du site concerne principalement les �tudiants.</p>
	<p>Elle leur permet d'une part d'acc�der � une liste des entreprises ayant d�j� accueillies des stagiaires les ann�es pr�c�dentes et la liste des contacts dans ces entreprises.</p>
	<p>D'autre part, elle donne acc�s � plusieurs sites d'offres de stages.</p>
	<p>Les �tudiants peuvent y trouver un formulaire de demande de validation de sujet de stage, demande qui sera transmise au responsable des stages.</p>
	<p>Enfin, ils peuvent d�poser les rapports de stage et les r�sum�s de stage. Ces documents seront ensuite accessibles aux enseignants.</p>
<?php 
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");
?>