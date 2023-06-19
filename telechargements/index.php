<?php

/**
 * Page index.php
 * Utilisation : page de téléchargement des documents liés aux stages
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("", "Téléchargements", "../", $tabLiens);

?>

<h3>Voici tous les documents relatifs aux stages :</h3>

<h4>Présentations orales</h4>

<ul>
    <li>Présentation détaillée 2022-2023 (format PDF) <A href="/documents/telechargements/presentation-2223.pdf"><IMG border=0 title="Présentation détaillée" align=middle src="../images/download.png"/></A></li>
    <li>Présentation aux étudiants de M2 2022-2023 (format PDF) <A href="/documents/telechargements/presentation-M2-2223.pdf"><IMG border=0 title="Présentation M2" align=middle src="../images/download.png"/></A></li>
    <li>Présentation aux étudiants de M1 2022-2023 (format PDF) <A href="/documents/telechargements/presentation-M1-2223.pdf"><IMG border=0 title="Présentation M1" align=middle src="../images/download.png"/></A></li>
</ul>

<h4>Documents annexes</h4>

<ul>
<li>Annexe 1 - Norme de présentation du rapport de stage (format PDF) <a href="/documents/telechargements/Annexe1.pdf"><IMG border=0 title="Fiche rapport" align=middle src="../images/download.png"/></a></li>
<li>Annexe 1bis - Norme de présentation du rapport de stage (template Overleaf) <a href='https://www.overleaf.com/4394543784cwspycvwmgwz' ><IMG border=0 title="Fiche rapport" align=middle src="../images/download.png"/></a></li>
<li>Annexe 2 - Fiche d'évaluation 2022-2023 pour l'entreprise
    (format DOCX) <A href="/documents/telechargements/Fiche_Entreprise_2223.docx"><IMG border=0 title="Fiche entreprise format DOCX" align=middle src="../images/download.png"/></A>
    (format PDF) <A href="/documents/telechargements/Fiche_Entreprise_2223.pdf"><IMG border=0 title="Fiche entreprise format PDF" align=middle src="../images/download.png"/></A></li>
<li>Annexe 2bis - Fiche d'évaluation 2022-2023 pour l'entreprise version anglaise
    (format DOC) <A href="/documents/telechargements/Entreprise_Form_2223.doc"><IMG border=0 title="Fiche entreprise version anglaise format DOC" align=middle src="../images/download.png"/></A>
    (format PDF) <A href="/documents/telechargements/Entreprise_Form_2223.pdf"><IMG border=0 title="Fiche entreprise version anglaise format PDF" align=middle src="../images/download.png"/></A></li>
<li>Annexe 3 - Fiche de soutenance 2022-2023 pour le jury
    (format DOC) <A href="/documents/telechargements/Fiche_Soutenance_2223.doc"><IMG border=0 title="Fiche soutenance format DOC" align=middle src="../images/download.png"/></A>
    (format PDF) <A href="/documents/telechargements/Fiche_Soutenance_2223.pdf"><IMG border=0 title="Fiche soutenance format PDF" align=middle src="../images/download.png"/></A></li>
</ul>

<h4>Documents officiels</h4>

<ul>
<li>Guide des stages 2022 du Ministère de L'Education Nationale et de l'Enseignement Supérieur (format PDF) <A href="/documents/telechargements/GuideStages2022.pdf"><IMG border=0 title="Guide des stages" align=middle src="../images/download.png"></A></li>
<li>Accueil des stagiaires dans le fonction public 2021 (format PDF) <A href="/documents/telechargements/GuideAccueilStagiairesFonctionPublique2021.pdf"><IMG border=0 title="Accueil des stages dans la fonction public" align=middle src="../images/download.png"></A></li>
<li>Loi n°2014-788 du 10 juillet 2014 tendant au développement, à l'encadrement des stages et à l'amélioration du statut des stagiaires (format PDF) <a href="/documents/telechargements/Loi-2014-788.pdf"><IMG border=0 title="Loi n°2014-788" align=middle src="../images/download.png"></a></li>
</ul>

<?php

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>