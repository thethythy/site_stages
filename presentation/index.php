<?php

include_once("./../classes/ihm/IHM_Generale.php");
include_once("./../classes/ihm/Menu.php");

header ("Content-type:text/html; charset=utf-8");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
IHM_Generale::header("Pr�sentation", "d�taill�e", "../", $tabLiens);

echo "<br/>";

Menu::menuPresentation();
?>

<a name="debut"></a>

<div class="navigation">
    <A href="../telechargements/presentation-1516.pdf">T�l�chargement</a>
    <A href="../telechargements/presentation-1516.pdf">
	<img title="Pr�sentation d�taill�e" align=middle src="../images/download.png">
    </a>
</div>

<div class="adroite">
    Responsable : M. Thierry Lemeunier<br />
    D�partement Informatique<br />
    T�l. 02 43 83 38 65<br/>
    Fax. 02 43 83 38 48<br />
    <a href="http://info-stages.univ-lemans.fr">http://info-stages.univ-lemans.fr</a>
</div>

<br/><br/><br/><br/><br/>

<div class="titre1"><a name="1">1. Pr�sentation</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>L'enseignement de l'informatique n�cessite une grande part de travaux pratiques et appliqu�s afin d'assimiler les nombreuses notions abord�es en cours et en travaux dirig�s. Les travaux pratiques sont assur�s par l'enseignement universitaire, mais l'apprentissage du d�veloppement d'un projet informatique ne peut se faire qu'en situation r�elle au cours de stages de formation en entreprise ou en laboratoire de recherche.</p>

<p>Ce document s'adresse en premier lieu aux �tudiants des fili�res informatiques de l'Universit� du Maine (Licence L3, Master Professionnel), mais il s'adresse �galement aux diff�rentes personnes concern�es par les stages&nbsp;: l'�quipe enseignante et les entreprises d'accueils.

<p>Il pr�sente toutes les informations concernant les stages �tudiants qu'ils soient normalement pr�vus dans le cursus (stage obligatoire de dur�e minimale) ou qu'ils soient fait en dehors du cursus (stage de dur�e variable � l'initiative de l'�tudiant). Dans les deux cas une convention de stage doit �tre �tablie entre les trois parties prenantes (l'�tudiant, l'Universit� et l'entreprise). La suite du document parle essentiellement des stages obligatoires mais les aspects administratifs sont les m�mes quel que soit le type de stage (obligatoire ou hors formation).</p>

<p>Enfin, d'un point de vue organisationnel, tous les aspects p�dagogiques (validation d'un sujet, suivi, organisation des soutenances) sont g�r�s par le responsable des stages et les enseignant-r�f�rents du D�partement Informatique. En ce qui concerne les aspects administratifs (retrait de la fiche d'�tablissement d'une convention, signature des conventions, avenant), ils sont g�r�s par la scolarit� de la Facult� des Sciences.</p>

<div class="titre2"><a name="11">1.1. Contenu du stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<br/>

<div class="titre3">Principe&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le contenu du stage ainsi que la dur�e et son �valuation diff�rent selon le dipl�me et selon l'ann�e dans le dipl�me (cf. tableau ci-apr�s). L'�valuation se fait d'apr�s le rapport �crit, la soutenance orale et l'avis de l'entreprise. Dans des conditions tr�s particuli�res ou dans le cas des stages � l'�tranger, la dur�e du stage peut �tre � n�goci�e � avec le responsable p�dagogique. Pour les fili�res professionnelles, le stage s'effectue g�n�ralement en entreprise mais, dans certains cas particuliers, il peut s'effectuer dans un laboratoire de recherche ou un service de recherche & d�veloppement. Pour les fili�res recherche, le stage doit obligatoirement s'effectuer dans un laboratoire de recherche (priv� ou public).</p>

<p>Il s'agit d'un stage de formation. L'�tudiant est consid�r� comme �tant en travaux pratiques mais hors de l'Universit�. Par cons�quent, il ne peut pas �tre contraint � une obligation de r�sultat de son activit� au sein de l'organisme d'accueil. Un stage ne peut pas �tre assimil� � un contrat de travail � dur�e d�termin�e. Cependant, il reste souhaitable que l'obtention d'un r�sultat tangible, mesurable, valide et r�utilisable soit recherch�e.</p>

<p>Le contenu du stage doit �tre compatible avec l'orientation de l'enseignement du dipl�me du stagiaire et de l'ann�e dans le dipl�me. Il faut toujours chercher un stage aboutissant � <strong>une r�alisation</strong> (mat�rielle et/ou logicielle) dans l'esprit de la formation suivie et permettant suffisamment d'innovations personnelles. Le niveau attendu d�pend du dipl�me et de l'ann�e dans le dipl�me. Un stage de niveau Master demande une part importante d'analyse, de conception et de d�veloppement. Un stage de niveau Licence demande une part moindre de conception et pas ou peu d'analyse.</p>

<div class="titre3">Th�mes acceptables&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le th�me du stage doit correspondre � ce qui est trait� dans la formation de l'�tudiant&nbsp;: int�gration d'une fonctionnalit� dans un syst�me, �tude et d�veloppement de logiciels sp�cifiques, participation � la r�alisation d'un syst�me de taille importante, participation � un projet de recherche, d�veloppement d'un site Web de taille importante, etc. Les applications de gestion de base de donn�es sont accept�es mais seulement si elles s'accompagnent du d�veloppement d'interfaces utilisateurs.</p>

<p>Le logiciel objet du stage doit �tre �crit dans un langage structur� (C, langage orient� objet, langage de programmation logique par exemple), ou en assembleur. L'utilisation d'une m�thode ou d'une d�marche de d�veloppement issue du g�nie logiciel ou de l'intelligence artificielle est fortement recommand�e. Un planning du stage est d'ailleurs demand� dans le rapport et � la soutenance.</p>

<div class="titre2"><a name="12">1.2. Planification et dur�e en 2015-2016</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>
    <table border=1 align=center cellpadding=5 cellspacing=1>
	<th align=center>Dipl�me</th><th align=center>P�riode</th><th align=center>Date d�but</th><th align=center>Date fin</th><th align=center>Dur�e</th><th align=center>Soutenance</th>
	<tr>
	    <td align=center valign=center>Master 1</td>
	    <td align=center valign=center>avril � juin</td>
	    <td align=center valign=center>4 Avril 2016</td>
	    <td align=center valign=center>24 Juin 2016</td>
	    <td align=center valign=center>3 mois<br/>(12 semaines)</td>
	    <td align=center valign=center>27 juin 2016</td>
	</tr>
	<tr>
	    <td align=center valign=center>Master 2</td>
	    <td align=center valign=center>mars � ao�t</td>
	    <td align=center valign=center>29 F�vrier 2016</td>
	    <td align=center valign=center>12 Ao�t 2016</td>
	    <td align=center valign=center>6 mois<br/>(24 semaines)</td>
	    <td align=center valign=center>29 Ao�t 2016</td>
	</tr>
    </table>
</p>

<p>Il est possible de faire des avenants aux conventions pour prolonger la dur�e d'un stage au-del� de la dur�e minimale indiqu�e dans ce tableau. Il faut cependant noter, d'une part, que les dates de soutenances ne peuvent pas �tre report�es en dehors des p�riodes pr�vues m�me en cas de prolongation, et, d'autre part, que les �tudiants de Master 2 ne peuvent prolonger leur stage au-del� de la limite d'inscription administrative officielle du 30 septembre (sauf s'ils se r�-inscrivent pour une seconde ann�e de M2).</p>

<p>Si au cours du stage vous d�cidez d'en prolonger sa dur�e contactez le plus rapidement possible la scolarit� de la Facult� des Sciences pour �tablir l'avenant n�cessaire � la convention pour fixer la nouvelle date de fin du stage.</p>

<div class="titre2"><a name="13">1.3. Remarques et conseils</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>
<ul>
    <li>Commencez vos d�marches de recherche d�s la rentr�e. Cela s'applique encore plus dans le cas ou vous souhaitez partir � l'�tranger.</li>
    <li>Consulter ce site pour d�couvrir les entreprises ayant d�j� pris des stagiaires les ann�es pass�es.</li>
    <li>Si vos finances le permettent, cherchez plut�t un stage int�ressant que bien r�mun�r�.</li>
    <li>Le stage de M2 peut �tre primordial pour le d�but de votre carri�re professionnel dans le sens ou de nombreuses entreprises proposent des contrats d'embauche aux stagiaires dont elles ont �t� satisfaites des prestations durant le stage.</li>
    <li>La pr�sentation orale compte presque pour autant que le rapport �crit. Il faut penser � bien la pr�parer car c'est elle qui donne l'impression g�n�rale sur le stage et le stagiaire.</li>
    <li>Si l'�tudiant b�n�ficie d'une bourse r�gionale des Pays de La Loire, il doit <strong>imp�rativement</strong> effectu� son stage dans la r�gion Pays de La Loire.</li>
</ul>

<div class="titre1"><a name="2">2. D�roulement du stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>L'�tudiant cherche lui-m�me son stage (des offres sont accessibles via le site Web des stages). Afin d'�viter tout retard, il doit suivre une proc�dure sp�cifique (d�finie ci-apr�s) jusqu'� la signature d'une convention de stage par toutes les parties prenantes. Durant le stage, l'�tudiant est suivi, d'une part, par l'entreprise ou le laboratoire de recherche o� il effectue son stage, et d'autre part par un enseignant r�f�rent membre du D�partement d'Informatique. � l'issue du stage, un rapport est remis (sous forme num�rique uniquement) et une soutenance orale est organis�e.</p>

<div class="titre2"><a name="21">2.1. La recherche d'un stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<br/>

<div class="titre3">Principes&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>
<ul>
    <li>Chaque �tudiant recherche un sujet de stage (des offres sont accessibles via le site Web des stages).</li>
    <li>Il n'est pas souhaitable de faire deux stages cons�cutifs dans la m�me entreprise (le but est aussi d'avoir un aper�u de diff�rentes cultures d'entreprise).</li>
    <li>Pour les fili�res professionnelles, les stages doivent se d�rouler en entreprise. Dans des cas exceptionnels, laiss�s � l'appr�ciation du responsable p�dagogique, il peut se d�rouler dans un laboratoire d'universit�, cette d�rogation ne pouvant �tre accord�e qu'une seule fois � un �tudiant donn�.</li>
    <li>Pour les fili�res recherches, les stages doivent se d�rouler dans un laboratoire de recherche (public ou priv�, fran�ais ou �tranger) ou dans un service de recherche & d�veloppement.</li>
    <li><strong>Le responsable p�dagogique doit valider le sujet de stage avant l'�tablissement de la convention.</strong></li>
    <li>Agissez de fa�on responsable car l'image de la formation est fortement en jeu dans vos d�marches et interactions avec les entreprises : tenez votre parole et si vous changez d'avis, avertissez les personnes concern�es.</li>
    <li>La recherche ne se termine que lorsque la convention est sign�e. Il ne peut et ne doit pas y avoir de d�part en stage si la convention n'est pas sign�e avant la date de d�but de stage.</li>
</ul>

<div class="titre3">Validation du sujet de stage&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le responsable p�dagogique doit valider le sujet de stage de chaque �tudiant stagiaire. Afin de faciliter ce travail, les �tudiants saisissent sur le site des stages un r�sum� (30 lignes maximum) pr�sentant le sujet de stage envisag�. Une demande de validation et envoy�e automatiquement au responsable p�dagogique � l'issue de cette saisie. En retour, le responsable p�dagogique pr�vient l'�tudiant par email de la validation ou de la non-validation du sujet propos�. L'�tudiant doit donc consulter r�guli�rement son email institutionnel apr�s la saisie d'une demande de validation.</p>

<p>D�s que le sujet propos� par l'�tudiant est valid� par le responsable p�dagogique, l'�tudiant peut poursuivre la proc�dure pr�vue pour le d�roulement du stage (cf. ci-apr�s).</p>

<div class="titre3">Cas des stages � l'�tranger&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Des possibilit�s de stages sont offertes dans les projets europ�ens de coop�ration COMETT et ERASMUS pour effectuer son stage dans un pays membre de la Communaut� Europ�enne. Il est conseill� de commencer � vous renseigner d�s l'ann�e qui pr�c�de l'ann�e du stage. Vous devez vous adressez au service des relations internationales au rez-de-chauss�e de la Maison de l'Universit�. Des bourses ERASMUS-Stage d'aide au financement de stage effectu� dans un pays europ�en sont propos�s. Renseignez-vous aupr�s du service des relations internationales.</p>

<div class="titre2"><a name="22">2.2. Le suivi des stages</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Chaque stagiaire est suivi par un enseignant r�f�rent du D�partement Informatique de la Facult� des Sciences de l'Universit� du Maine. Les r�f�rents n'ont pas la possibilit� de visiter syst�matiquement les �tudiants pendant les stages, mais pour les stages de longue dur�e se d�roulant � proximit� du Mans, une visite est souhaitable. Dans tous les cas, un contact (t�l�phonique ou par email) est fortement conseill�.</p>

<div class="titre3"><a name="221">2.2.1. R�le de l'enseignant r�f�rent</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>
<ul>
    <li>Assurer le contact avec l'�tudiant et l'entreprise.</li>
    <li>Assurer le premier niveau d'interaction en cas de probl�me (d�saccord avec l'entreprise, accident du travail, maladie de longue dur�e...).</li>
    <li>Lire le rapport fourni par l'�tudiant � l'issue du stage.</li>
    <li>Assister et participer � la soutenance orale.</li>
    <li>Remplir la fiche d'�valuation sur le stage avec le second membre du jury.</li>
    <li>V�rifier lors de la soutenance que toutes les conditions sont satisfaites : d�p�ts du rapport et du r�sum�, remise de la fiche d'appr�ciation de l'entreprise.</li>
</ul>

<div class="titre3"><a name="222">2.2.2. Choix de l'enseignant r�f�rent</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<ul>
    <li>Chaque enseignant suit un certain nombre de stages d�termin� selon le nombre d'�tudiants de chaque dipl�me et selon le nombre d'enseignant r�f�rents disponibles chaque ann�e.</li>
    <li>L'attribution d'un enseignant-r�f�rent � l'�tudiant est faite par le responsable p�dagogique.</li>
    <li>Le stagiaire prend connaissance du nom de son enseignant-r�f�rent via le site Web des stages.</li>
</ul>

<div class="titre2"><a name="23">2.3. Les conventions de stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>La convention de stage est un document officiel d�finissant un accord pass� entre l'universit�, l'entreprise et le stagiaire. A l'issue de la proc�dure, chacune des parties est en possession d'un exemplaire de cette convention. Chacun de ces trois exemplaires doit �tre sign� par les trois parties : une convention qui n'a pas ces trois signatures avant le d�part en stage n'a aucune valeur juridique. Enfin, tout stage qui n'entrerait pas dans le cadre de la formation obligatoire devra faire l'objet d'une convention distincte, pr�cisant qu'il s'agit d'un stage facultatif hors cursus universitaire.</p>

<p>Les conventions sont g�r�es par la scolarit� de la Facult� des Sciences. Une fois le sujet valid� par le responsable des stages, l'�tudiant fait une demande � la scolarit� d'une convention en suivant la proc�dure <a href="http://sciences.univ-lemans.fr/Stages-en-entreprise-ou-a-l">indiqu�e ici</a>. Une convention-type, r�dig�e par l'universit�, est �tablie par la scolarit� de la Facult� des Sciences avec les �l�ments propres � chaque stage, et en particulier&nbsp;:
<ul>
    <li>Les coordonn�es de l'entreprise.</li>
    <li>Les dates officielles de d�but et de fin de stage (en cas de prolongation du stage la convention devra �tre compl�t�e d'un avenant dont la demande se fera �galement � la scolarit�).</li>
    <li>Un r�sum� du sujet de stage (une vingtaine de lignes) qui aura �t� valid� pr�c�demment par le responsable p�dagogique.</li>
    <li>Le montant mensuel de la gratification dans le cas d'un stage d'une dur�e sup�rieur � 2 mois.</li>
</ul>

<p>Le nombre de conventions � signer est devenu important. Afin d'�viter toute perte de temps, il est indispensable que chacun respecte l'ordre suivant :</p>
<ul>
    <li style="list-style-type: decimal;">l'�tudiant <a href="../stagiaire/demanderValidationSDS.php">fait une demande de validation</a> au responsable des stages&nbsp;;</li>
    <li style="list-style-type: decimal;">le responsable des stages valide ou pas le sujet&nbsp;;</li>
    <li style="list-style-type: decimal;">l'�tudiant <a href="http://sciences.univ-lemans.fr/Stages-en-entreprise-ou-a-l">fait une demande d'�tablissement d'une convention</a> � la scolarit� des Sciences&nbsp;;</li>
    <li style="list-style-type: decimal;">la scolarit� �tablit la convention (�dition, impression, signatures).</li>
</ul>

<div class="titre2"><a name="24">2.4. Pendant le stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Pendant le stage, l'�tudiant est soumis aux horaires et aux conditions de travail de l'organisme d'accueil. En particulier, il est soumis aux contraintes de s�curit� en vigueur au sein de l'organisme d'accueil. En cas de probl�me, dont les causes peuvent �tre de divers origines (relation avec l'entreprise, conflit sur le sujet de stage, accident, etc.), il faut pr�venir au plus t�t au moins une des personnes suivantes&nbsp;:</p>
<ul>
    <li>l'enseignant-r�f�rent du stage (coordonn�es accessibles dans <a href="http://www.univ-lemans.fr/fr/annuaire.html">l'annuaire Web</a> de l'Universit�) ;</li>
    <li>le secr�tariat du D�partement Informatique : Mme Nathalie Rodier au 02 43 83 38 38 ou par email � l'adresse <a href="mailto:secretariat @ univ-lemans.fr">secretariat @ univ-lemans.fr</a> ;</li>
    <li>le responsable p�dagogique : M. Thierry Lemeunier au 02 43 83 38 65 ou par email � l'adresse <a href="mailto:Thierry.Lemeunier @ univ-lemans.fr">Thierry.Lemeunier @ univ-lemans.fr.</a></li>
</ul>

<div class="titre2"><a name="25">2.5. Le rapport de stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le rapport de stage rendu � l'issue du stage est un �l�ment important de la notation. Il ne s'agit pas de faire le rapport le plus volumineux possible � partir de photocopie de documents divers, mais de <strong>d�crire votre r�alisation personnelle</strong>. L'�tudiant doit veiller � planifier un temps suffisant pour sa r�daction. Les rapports sont d'ailleurs pr�par�s pendant le stage et avec les moyens de l'organisme d'accueil. Il est m�me pr�f�rable d'en r�diger certaines parties au fur et � mesure. Dans tous les cas, l'�tudiant doit imp�rativement d�livrer <strong>une semaine avant la date de soutenance</strong> les 2 �l�ments suivants :</p>
<div style="border: 1px solid #000;">
    <ul>
	<li>1 rapport de stage num�rique au format PDF (d�pos� gr�ce au <a href="../stagiaire/depot_doc.php">formulaire accessible ici</a>) pour que l'enseignant-r�f�rent puisse le lire&nbsp;;</li>
	<li>1 r�sum� de stage num�rique au format PDF (d�pos� gr�ce au <a href="../stagiaire/depot_doc.php">formulaire accessible ici</a>)&nbsp;;</li>
    </ul>
</div>

<p>Etant donn�e le grand nombre d'�tudiants (et nos capacit�s limit�es de stockage), <strong>aucune version papier et/ou sur CD-ROM ne sera d�livr�e et ne sera accept�e</strong>. Seul le d�p�t sur ce site sera pris en compte.</p>

<p>Le r�sum� de stage est mis en consultation sur le site Web des stages. C'est un court document r�sumant les �l�ments principaux du stage. Il doit suivre les sp�cifications donn�es � l'<a href="../telechargements/Annexe1.pdf">Annexe 1 accessible ici.</a></p>

<div class="titre3">Forme&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<ul>
    <li>La r�daction se fait en fran�ais, y compris pour les stages se d�roulant dans une soci�t� �trang�re ayant une filiale en France.</li>
    <li>Pour les stages � l'�tranger, le rapport peut �tre �crit en anglais.</li>
    <li>Le stagiaire doit imp�rativement suivre la norme de pr�sentation (cf. <a href="../telechargements/Annexe2.pdf">Annexe 2 accessible ici</a>).</li>
    <li>L'utilisation d'un traitement de texte est obligatoire (les documents manuscrits ne sont pas accept�s).</li>
    <li>Le format du document num�rique doit �tre le format PDF.</li>
    <li>Le nombre de page (hors annexes) est limit� selon l'ann�e du dipl�me de l'�tudiant :</li>
    <ul>
	<li>en Master 1 : 40 pages au maximum ;</li>
	<li>en Master 2 : 60 pages au maximum.</li>
    </ul>
</ul>

<div class="titre3">Confidentialit�&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Si l'entreprise le souhaite, le rapport peut �tre confidentiel. Dans ce cas, il doit �tre marqu� comme tel (pages et couvertures estampill�es).</p>
<p>La soutenance, qui est normalement publique, peut �galement avoir lieu � huis clos en pr�sence uniquement de l'�tudiant, de l'enseignant-r�f�rent et d'un second enseignant membre de l'�quipe p�dagogique et d'un ou plusieurs repr�sentants de l'entreprise.</p>

<div class="titre3">Fond et contenu&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le rapport doit comprendre :</p>
<ul>
    <li>Le r�sum� 4 pages maximum dans un fichier s�par� (cf. <a  href="../telechargements/Annexe1.pdf">Annexe 1 accessible ici</a>).</li>
    <li>Un court r�sum� inclus dans la page de garde (cf. <a href="../telechargements/Annexe2.pdf">Annexe 2 accessible ici</a>).</li>
    <li>Un sommaire.</li>
    <li>Le texte (structur�) lui-m�me d�crivant le travail effectu� durant le stage.</li>
    <li>Des annexes techniques (non compt�es dans le nombre maximum de page).</li>
</ul>

<p>Le texte d�crivant le travail r�alis� doit inclure au minimum&nbsp;:</p>
<ul>
    <li>la sp�cification initiale du probl�me (cadre du travail r�alis�, cahier des charges, int�gration dans un projet existant de l'entreprise, etc.)&nbsp;;</li>
    <li>l'analyse du probl�me (organigrammes, structures de donn�es, description de toutes les fonctionnalit�s, diagrammes UML de niveau analyse...)&nbsp;;</li>
    <li>la conception : choix effectu�s et leurs justifications, description et choix de l'architecture logicielle, difficult�s rencontr�es...</li>
    <li>les apports aussi bien pour l'entreprise que pour l'�tudiant.</li>
</ul>

<p>Tout d�tail pertinent aidant � la compr�hension doit �tre inclus, ainsi que les difficult�s rencontr�es et les solutions retenues. Les moyens mat�riels mis en oeuvre et les conditions effectives de la r�alisation doivent �tre �galement donn�s. Des plannings (initial et final) doivent appara�tre et �tre justifi�. Enfin les annexes peuvent contenir une description sommaire de l'entreprise et certaines parties de listings de code limit�es aux parties significatives et int�ressantes.</p>

<div class="titre2"><a name="26">2.6. R�sum� de la proc�dure</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<div style="text-align: center; margin: 15px"><img src="../images/procedure.png" alt="R�sum� de la proc�dure"></div>

<div class="titre1"><a name="3">3. La soutenance</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Les soutenances orales sont obligatoires pour tous les �tudiants. Les soutenances suivent un planning pr�visionnel, nominatif, fix� � l'avance et <strong>disponible sur le site des stages</strong>. Compte tenu des difficult�s d'organisation des plannings qui prennent en compte les contraintes des multiples enseignants-r�f�rents et des responsables de stages qui viennent d'entreprises parfois distantes pour participer aux soutenances, les modifications ult�rieures sont impossibles m�me par permutation (sauf cas exceptionnel et sur demande de l'entreprise faite au moins 5 jours ouvrables avant la soutenance).</p>

<div class="titre3">Conditions pour soutenir&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Les soutenances sont planifi�es par le responsable p�dagogique. Une soutenance ne peut �tre planifi�e que si une convention a �t� sign�e.</p>

<div class="titre3">Fiche d'appr�ciation&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Cette fiche est <a href="../telechargements/Fiche_Entreprise_1516.doc">accessible ici</a> (version anglaise <a href="../telechargements/Entreprise_Form_1516.doc">ici</a>) ou dans la partie t�l�chargement du site (<a href="../telechargements/">ici</a>). Elle  sera remplie par votre encadrant dans l'entreprise qui devra la transmettre de fa�on confidentielle avant ou le jour de la soutenance (<u>sous enveloppe cachet�e</u> si n�cessaire). Dans tous les cas, si cette pi�ce n'est pas disponible le jour de la soutenance, celle-ci sera <strong>ajourn�e</strong>.</p>

<div class="titre3">Participants � la soutenance&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<ul>
    <li>L'�tudiant stagiaire.</li>
    <li>Les personnes ayant encadr�es le stage dans l'organisme d'accueil selon leurs disponibilit�s.</li>
    <li>Au moins deux membres de l'�quipe p�dagogique, dont l'enseignant-r�f�rent.</li>
    <li>Par d�faut, la soutenance est publique et ouverte � toutes autres personnes sauf en cas de confidentialit� demand�e par l'organisme d'accueil.</li>
</ul>

<div class="titre3">Conditions mat�rielles de la soutenance&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>La dur�e de la soutenance diff�re selon l'ann�e dans le dipl�me :</p>
<ul>
    <li>en Master 1, la dur�e est de 30 min par �tudiant (20 min d'expos� + 10 min de questions) ;</li>
    <li>en Master 2, la dur�e est de 50 min par �tudiant (30 min d'expos� + 20 min de questions) ;</li>
</ul>

<p>Le respect de ces dur�es est essentiel, les d�bordements pourront �tre sanctionn�s lors de la notation de la soutenance. Les moyens mat�riels de soutenance sont ceux disponibles pour les expos�s en cours d'ann�e (r�troprojecteur, vid�o projecteur, magn�toscope...). En cas de d�monstration n�cessitant l'installation de mat�riels sp�cifiques, l'�tudiant est responsable de sa pr�paration (il peut demander de l'aide aux techniciens).</p>

<div class="titre3">P�riode de soutenance&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Les soutenances ne font pas l'objet d'une convocation : il est de la responsabilit� des �tudiants de <strong>consulter r�guli�rement le site des stages pour se tenir inform�s de la date et de l'heure de leur soutenance</strong>. Des p�riodes sp�cifiques sont r�serv�es dans le planning de chaque dipl�me. Pour l'ann�e 2015/2016&nbsp;:</p>
<ul>
    <li>en Master 1 la date pr�vue est le 27 juin 2016&nbsp;;</li>
    <li>en Master 2 la date pr�vue est le 29 ao�t 2016.</li>
</ul>

<p>Si, pour une raison quelconque mais imp�rieuse (par exemple accident), la soutenance ne peut se faire � la date pr�vue, une date ult�rieure pourra �tre fix�e. Cependant, le dipl�me ne peut �tre d�cern� qu'apr�s la soutenance orale. Cette solution peut donc �tre handicapante pour les �tudiants d�sirant poursuivre leurs �tudes. En particulier, m�me en cas de prolongation du stage au-del� de la dur�e officielle, les �tudiants doivent soutenir � la date pr�vue.</p>

<div class="titre1"><a name="4">4. L'�valuation du stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le stage est �valu� en fonction du travail effectu� par l'�tudiant, de l'appr�ciation de l'organisme d'accueil, de l'�valuation de l'enseignant-r�f�rent concernant le rapport et enfin de l'�valuation de la soutenance orale par le jury. Les crit�res d'�valuation retenus sont disponibles dans les deux fiches des Annexe 3 et 4 et <a href="http://info-stages.univ-lemans.fr/telechargements/">accessibles ici</a> (grille d'�valuation de la soutenance, grille d'�valuation du rapport, grille d'�valuation de l'entreprise).</p>

<p>La note obtenue est ensuite int�gr�e dans le contr�le des connaissances de l'ann�e du dipl�me de l'�tudiant (se reporter � ces diff�rents contr�les des connaissances).</p>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>
