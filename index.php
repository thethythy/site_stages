<?php 
include_once("./classes/ihm/IHM_Generale.php");
include_once("./classes/ihm/Menu.php");
header ("Content-type:text/html; charset=utf-8");
IHM_Generale::header("Les stages", "étudiants", "", array());
Menu::menuAccueil();
?>
<br></br>
<p>Ce site est dédié à la gestion et à l'accès aux informations concernant les stages des étudiants en informatique de la Faculté des Sciences et Techniques de l'Université du Maine. Il est l'outil principal de communication entre les différentes personnes concernées : les étudiants, l'équipe enseignante, les entreprises, et le responsable pédagogique des stages.</p>
<p>Il permet aux étudiants de prendre connaissance d'un certain nombre d'offres de stages et de faire des demandes de validation de sujet de stage. Il liste également les entreprises ayant déjà accueillies des stagiaires. </p>
<p>En ce qui concernent l'équipe enseignante, il permet d'accéder à la liste des enseignants-référents et à la liste des conventions pas section et par année. Les plannings des soutenances des différentes sections sont accessibles durant les périodes concernées.</p>
<p>Ce site permet également aux entreprises de saisir directement des propositions de stages qui seront ensuite diffusées aux étudiants.</p>
<br />
<p align=right>Cordialement, le responsable des stages<br/>Thierry Lemeunier</p>
<?php
IHM_Generale::endHeaderAccueil();
IHM_Generale::footerAccueil();
?>