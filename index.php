<?php

/**
 * Page index.php
 * Utilisation : page principale du site
 * Accès : public
 */

include_once('classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_root');

IHM_Generale::header("alternance et stages", "étudiants", "", array());
IHM_Menu::menuAccueil();
?>
<br></br>
<p>Ce site est dédié à la gestion et à l'accès aux informations concernant les stages et l'alternance des étudiants en informatique de la Faculté des Sciences et Techniques de l'Université du Maine. Il est l'outil principal de communication entre les différentes personnes concernées : les étudiants, l'équipe enseignante, les entreprises, et les responsables pédagogiques.</p>
<p>Il permet aux étudiants de prendre connaissance d'un certain nombre d'offres de stages et d'alternances et de faire des demandes de validation. Il liste également les entreprises ayant déjà accueillies des stagiaires ou des alternants. </p>
<p>En ce qui concernent l'équipe enseignante, il permet d'accéder à la liste des enseignants-référents et à la liste des affectations des étudiants. Les plannings des soutenances des différentes sections sont accessibles durant les périodes concernées.</p>
<p>Ce site permet également aux entreprises de saisir directement des propositions de stages ou d'alternances qui seront ensuite diffusées aux étudiants.</p>
<br />
<p align=right>Cordialement,<br/>le responsable des stages<br/>et le responsable de l'alternance</p>

    <?php

IHM_Generale::endHeaderAccueil();
IHM_Generale::footerAccueil();

?>
