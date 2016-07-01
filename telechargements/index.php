<?php

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");
include_once("../classes/ihm/IHM_Generale.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("", "Téléchargements", "../", $tabLiens);

?>

<h3>Voici tous les documents relatifs aux stages :</h3>

<h4>Présentations orales</h4>

<ul>
    <li>Présentation détaillée 2015-2016 (format PDF) <A href="./presentation-1516.pdf"><IMG border=0 title="Présentation détaillée" align=middle src="../images/download.png"/></A></li>
    <li>Présentation aux étudiants de M2 2015-2016 (format PDF) <A href="./presentation-M2-1516.pdf"><IMG border=0 title="Présentation M2" align=middle src="../images/download.png"/></A></li>
    <li>Présentation aux étudiants de M1 2015-2016 (format PDF) <A href="./presentation-M1-1516.pdf"><IMG border=0 title="Présentation M1" align=middle src="../images/download.png"/></A></li>
</ul>

<h4>Documents annexes</h4>

<ul>
<li>Annexe 1 - Exemple d'extrait de rapport de stage (format PDF) <a href="./Annexe1.pdf"><IMG border=0 title="Fiche extrait" align=middle src="../images/download.png"/></a></li>
<li>Annexe 2 - Norme de présentation du rapport de stage (format PDF) <a href="./Annexe2.pdf"><IMG border=0 title="Fiche rapport" align=middle src="../images/download.png"/></a></li>
<li>Annexe 3 - Fiche d'évaluation 2015-2016 pour l'entreprise
    (format DOC) <A href="./Fiche_Entreprise_1516.doc"><IMG border=0 title="Fiche entreprise format DOC" align=middle src="../images/download.png"/></A>
    (format PDF) <A href="./Fiche_Entreprise_1516.pdf"><IMG border=0 title="Fiche entreprise format PDF" align=middle src="../images/download.png"/></A></li>
<li>Annexe 3bis - Fiche d'évaluation 2014-2015 pour l'entreprise version anglaise
    (format DOC) <A href="./Entreprise_Form_1516.doc"><IMG border=0 title="Fiche entreprise version anglaise format DOC" align=middle src="../images/download.png"/></A>
    (format PDF) <A href="./Entreprise_Form_1516.pdf"><IMG border=0 title="Fiche entreprise version anglaise format PDF" align=middle src="../images/download.png"/></A></li>
<li>Annexe 4 - Fiche de soutenance 2014-2015 pour le jury
    (format DOC) <A href="./Fiche_Soutenance_1516.doc"><IMG border=0 title="Fiche soutenance format DOC" align=middle src="../images/download.png"/></A>
    (format PDF) <A href="./Fiche_Soutenance_1516.pdf"><IMG border=0 title="Fiche soutenance format PDF" align=middle src="../images/download.png"/></A></li>
</ul>

<h4>Documents officiels</h4>

<ul>
<li>Guide des stages 2012 du Ministère de L'Education Nationale et de l'Enseignement Supérieur (format PDF) <A href="./GuideStages2012.pdf"><IMG border=0 title="Guide des stages" align=middle src="../images/download.png"></A></li>
<li>Charte des stages 2006-2007 du Ministère de L'Education Nationale (format PDF) <A href="./Charte-des-stages.pdf"><IMG border=0 title="Charte des stages" align=middle src="../images/download.png"></A></li>
<li>Décret n°2009-885 du 21 juillet 2009 sur l'accueil des étudiants dans les établissements publics de l'Etat (format PDF) <A href="./Decret-2009-885.pdf"><IMG border=0 title="Décret n°2009-885" align=middle src="../images/download.png"></A></li>
<li>Décret n°2010-956 du 25 août 2010 sur les stages hors cursus (format PDF) <A href="./Decret-2010-956.pdf"><IMG border=0 title="Décret n°2010-956" align=middle src="../images/download.png"></A></li>
<li>Loi n°2014-788 du 10 juillet 2014 tendant au développement, à l'encadrement des stages et à l'amélioration du statut des stagiaires (format PDF) <a href="./Loi-2014-788.pdf"><IMG border=0 title="Loi n°2014-788" align=middle src="../images/download.png"></a></li>
</ul>

<?php

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>