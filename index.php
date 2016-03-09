<?php 
include_once("./classes/ihm/IHM_Generale.php");
include_once("./classes/ihm/Menu.php");
header ("Content-type:text/html; charset=utf-8");
IHM_Generale::header("Les stages", "�tudiants", "", array());
Menu::menuAccueil();
?>
<br></br>
<p>Ce site est d�di� � la gestion et � l'acc�s aux informations concernant les stages des �tudiants en informatique de la Facult� des Sciences et Techniques de l'Universit� du Maine. Il est l'outil principal de communication entre les diff�rentes personnes concern�es : les �tudiants, l'�quipe enseignante, les entreprises, et le responsable p�dagogique des stages.</p>
<p>Il permet aux �tudiants de prendre connaissance d'un certain nombre d'offres de stages et de faire des demandes de validation de sujet de stage. Il liste �galement les entreprises ayant d�j� accueillies des stagiaires. </p>
<p>En ce qui concernent l'�quipe enseignante, il permet d'acc�der � la liste des enseignants-r�f�rents et � la liste des conventions pas section et par ann�e. Les plannings des soutenances des diff�rentes sections sont accessibles durant les p�riodes concern�es.</p>
<p>Ce site permet �galement aux entreprises de saisir directement des propositions de stages qui seront ensuite diffus�es aux �tudiants.</p>
<br />
<p align=right>Cordialement, le responsable des stages<br/>Thierry Lemeunier</p>
<?php
IHM_Generale::endHeaderAccueil();
IHM_Generale::footerAccueil();
?>