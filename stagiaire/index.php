<?php 
include_once("../classes/ihm/IHM_Generale.php");
include_once("../classes/ihm/Menu.php");
$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
IHM_Generale::header("Stagiaire ", "", "../", $tabLiens);
Menu::menuStagiaire();
?>
	<p>Cette partie du site concerne principalement les étudiants.</p>
	<p>Elle leur permet d'une part d'accéder à une liste des entreprises ayant déjà accueillies des stagiaires les années précédentes et la liste des contacts dans ces entreprises.</p>
	<p>D'autre part, elle donne accès à plusieurs sites d'offres de stages.</p>
	<p>Les étudiants peuvent y trouver un formulaire de demande de validation de sujet de stage, demande qui sera transmise au responsable des stages.</p>
	<p>Enfin, ils peuvent déposer les rapports de stage et les résumés de stage. Ces documents seront ensuite accessibles aux enseignants.</p>
<?php 
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");
?>