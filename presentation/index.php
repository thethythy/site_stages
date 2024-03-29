<?php

/**
 * Page index.php
 * Utilisation : page principale d'informations
 * Accès : public
 */

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("Présentation", "détaillée", "../", $tabLiens);

IHM_Menu::menuPresentation();

?>

<a name="debut"></a>

<div class="navigation">
    <A href="../documents/telechargements/presentation-2223.pdf">Téléchargement</a>
    <A href="../documents/telechargements/presentation-2223.pdf">
	<img title="Présentation détaillée" align=middle src="../images/download.png">
    </a>
</div>

<div class="adroite">
    Responsable : M. Thierry Lemeunier<br />
    Département Informatique<br />
    Tél. 02 43 83 38 65<br/>
    <a href="http://info-stages.univ-lemans.fr">http://info-stages.univ-lemans.fr</a>
</div>

<br/><br/><br/><br/><br/>

<div class="titre1"><a name="1">1. Présentation</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>L'enseignement de l'informatique nécessite une grande part de travaux pratiques et appliqués afin d'assimiler les nombreuses notions abordées en cours et en travaux dirigés. Les travaux pratiques sont assurés par l'enseignement universitaire, mais l'apprentissage du développement d'un projet informatique ne peut se faire qu'en situation réelle au cours de stages de formation en entreprise ou en laboratoire de recherche.</p>

<p>Ce document s'adresse en premier lieu aux étudiants des filières informatiques de l'Université du Maine (Licence et Master Informatique), mais il s'adresse également aux différentes personnes concernées par les stages&nbsp;: l'équipe enseignante et les entreprises d'accueils.

<p>Il présente toutes les informations concernant les stages étudiants qu'ils soient normalement prévus dans le cursus (stage obligatoire de durée minimale) ou qu'ils soient fait en dehors du cursus (stage de durée variable à l'initiative de l'étudiant). Dans les deux cas une convention de stage doit être établie entre les trois parties prenantes (l'étudiant, l'Université et l'entreprise). La suite du document parle essentiellement des stages obligatoires mais les aspects administratifs sont les mêmes quel que soit le type de stage (obligatoire ou hors formation).</p>

<p>Enfin, d'un point de vue organisationnel, tous les aspects pédagogiques (validation d'un sujet, suivi, organisation des soutenances) sont gérés par le responsable des stages et les enseignant-référents du Département Informatique. En ce qui concerne les aspects administratifs (retrait de la fiche d'établissement d'une convention, signature des conventions, avenant), ils sont gérés par la scolarité de la Faculté des Sciences.</p>

<p><b>Dans le cas d'une alternance, les informations données ci-après ne s'appliquent pas sauf ce qui concerne les soutenances (dates, planning, conditions de la soutenance) et le rapport de stage.</b></p>

<div class="titre2"><a name="11">1.1. Contenu du stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<br/>

<div class="titre3">Principe&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le contenu du stage ainsi que la durée et son évaluation diffèrent selon le diplôme et selon l'année dans le diplôme (cf. tableau ci-après). L'évaluation se fait d'après le rapport écrit, la soutenance orale et l'avis de l'entreprise. Dans des conditions très particulières ou dans le cas des stages à l'étranger, la durée du stage peut être « négociée » avec le responsable pédagogique. Le stage s'effectue généralement en entreprise mais, dans certains cas, il peut s'effectuer dans un laboratoire de recherche public.</p>

<p>Il s'agit d'un stage de formation. L'étudiant est considéré comme étant en travaux pratiques mais hors de l'Université. Par conséquent, il ne peut pas être contraint à une obligation de résultat de son activité au sein de l'organisme d'accueil. Un stage ne peut pas être assimilé à un contrat de travail à durée déterminée. Cependant, il reste souhaitable que l'obtention d'un résultat tangible, mesurable, valide et réutilisable soit recherchée.</p>

<p>Le contenu du stage doit être compatible avec l'orientation de l'enseignement du diplôme du stagiaire et de l'année dans le diplôme. Il faut toujours chercher un stage aboutissant à <strong>une réalisation</strong> (matérielle et/ou logicielle) dans l'esprit de la formation suivie et permettant suffisamment d'innovations personnelles. Le niveau attendu dépend du diplôme et de l'année dans le diplôme. Un stage de niveau Master demande une part importante d'analyse, de conception et de développement. Un stage de niveau Licence demande une part moindre de conception et pas ou peu d'analyse.</p>

<div class="titre3">Thèmes acceptables&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le thème du stage doit correspondre à ce qui est traité dans la formation de l'étudiant&nbsp;: intégration d'une fonctionnalité dans un système, étude et développement de logiciels spécifiques, participation à la réalisation d'un système de taille importante, participation à un projet de recherche, développement d'un site Web de taille importante, etc. Les applications de gestion de base de données sont acceptées mais seulement si elles s'accompagnent du développement d'interfaces utilisateurs.</p>

<p>Le logiciel objet du stage doit être écrit dans un langage structuré (C, langage orienté objet, langage de programmation logique par exemple), ou en assembleur. L'utilisation d'une méthode ou d'une démarche de développement issue du génie logiciel ou de l'intelligence artificielle est fortement recommandée. Un planning du stage est d'ailleurs demandé dans le rapport et à la soutenance.</p>

<div class="titre2"><a name="12">1.2. Planification et durée en 2022-2023</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>
    <table border=1 align=center cellpadding=5 cellspacing=1>
	<th align=center>Diplôme</th><th align=center>Date début</th><th align=center>Date fin</th><th align=center>Durée</th><th align=center>Soutenance</th>
	<tr>
	    <td align=center valign=center>Master 1</td>
	    <td align=center valign=center>10 Avril 2023</td>
	    <td align=center valign=center>Initiaux : 30 Juin 2023<hr/>Alternants : fin du contrat</td>
	    <td align=center valign=center>Initiaux : 3 mois (12 semaines)<hr/>Alternants : jusqu'à fin du contrat</td>
	    <td align=center valign=center>3 Juillet 2023<br/>(susceptible de modification)</td>
	</tr>
	<tr>
	    <td align=center valign=center>Master 2</td>
	    <td align=center valign=center>27 Février 2023</td>
	    <td align=center valign=center>Initiaux : 11 Août 2023<hr/>Alternants : fin du contrat</td>
	    <td align=center valign=center>Initiaux : 6 mois (24 semaines)<hr/>Alternants : jusqu'à fin du contrat</td>
	    <td align=center valign=center>31 Août et 1 Sept. 2023<br/>(susceptible de modification)</td>
	</tr>
    </table>
</p>

<p>Il est possible de faire des avenants aux conventions pour prolonger la durée d'un stage au-delà de la durée minimale indiquée dans ce tableau. Il faut cependant noter, d'une part, que les dates de soutenances ne peuvent pas être reportées en dehors des périodes prévues même en cas de prolongation, et, d'autre part, que les étudiants de Master 2 ne peuvent prolonger leur stage au-delà de la limite d'inscription administrative officielle du 30 septembre (sauf s'ils se ré-inscrivent pour une seconde année de M2).</p>

<p>Si au cours du stage vous décidez d'en prolonger sa durée contactez le plus rapidement possible la scolarité de la Faculté des Sciences pour établir l'avenant nécessaire à la convention pour fixer la nouvelle date de fin du stage. Prévenez également le responsable des stages.</p>

<div class="titre2"><a name="13">1.3. Remarques et conseils</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>
<ul>
    <li>Commencez vos démarches de recherche dès la rentrée. Cela s'applique encore plus dans le cas ou vous souhaitez partir à l'étranger.</li>
    <li>Consulter ce site pour découvrir les entreprises ayant déjà pris des stagiaires les années passées.</li>
    <li>Si vos finances le permettent, cherchez plutôt un stage intéressant que bien rémunéré.</li>
    <li>Le stage de M2 peut être primordial pour le début de votre carrière professionnel dans le sens ou de nombreuses entreprises proposent des contrats d'embauche aux stagiaires dont elles ont été satisfaites des prestations durant le stage.</li>
    <li>La présentation orale compte autant que le rapport écrit. Il faut penser à bien la préparer car c'est elle qui donne l'impression générale sur le stage et le stagiaire.</li>
    <li>Si l'étudiant bénéficie d'une bourse régionale des Pays de La Loire, il doit <strong>impérativement</strong> effectué son stage dans la région Pays de La Loire.</li>
</ul>

<div class="titre1"><a name="2">2. Déroulement du stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>L'étudiant cherche lui-même son stage (des offres sont accessibles via le site Web des stages). Afin d'éviter tout retard, il doit suivre une procédure spécifique (définie ci-après) jusqu'à la signature d'une convention de stage par toutes les parties prenantes. Durant le stage, l'étudiant est suivi, d'une part, par l'entreprise ou le laboratoire de recherche où il effectue son stage, et d'autre part par un enseignant référent membre du Département d'Informatique. À l'issue du stage, un rapport est remis (sous forme numérique uniquement) et une soutenance orale est organisée.</p>

<div class="titre2"><a name="21">2.1. La recherche d'un stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<br/>

<div class="titre3">Principes&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>
<ul>
    <li>Chaque étudiant recherche un sujet de stage (des offres sont accessibles via le site Web des stages).</li>
    <li>Il n'est pas souhaitable de faire deux stages consécutifs dans la même entreprise (le but est aussi d'avoir un aperçu de différentes cultures d'entreprise).</li>
    <li><strong>Le responsable pédagogique doit valider le sujet de stage avant l'établissement de la convention.</strong></li>
    <li>Agissez de façon responsable car l'image de la formation est fortement en jeu dans vos démarches et interactions avec les entreprises : tenez votre parole et si vous changez d'avis, avertissez les personnes concernées.</li>
    <li>La recherche ne se termine que lorsque la convention est signée. Il ne peut et ne doit pas y avoir de départ en stage si la convention n'est pas signée avant la date de début de stage.</li>
</ul>

<div class="titre3">Validation du sujet de stage&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le responsable pédagogique doit valider le sujet de stage de chaque étudiant stagiaire. Afin de faciliter ce travail, les étudiants éditent une fiche préalable disponible sur l'application pStage (cf. ci-après) et envoient cette fiche par email au responsable pédagogique. En retour, le responsable pédagogique répond en validant ou en ne validant pas le sujet proposé. L'étudiant doit donc consulter régulièrement son email institutionnel après l'envoi de la fiche préalable.</p>

<p>Dès que le sujet proposé par l'étudiant est validé par le responsable pédagogique, l'étudiant peut poursuivre la procédure prévue pour le déroulement du stage (cf. ci-après).</p>

<div class="titre3">Cas des stages à l'étranger&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Des possibilités de stages sont offertes dans les projets européens de coopération COMETT et ERASMUS pour effectuer son stage dans un pays membre de la Communauté Européenne. Il est conseillé de commencer à vous renseigner dès l'année qui précède l'année du stage. Vous devez vous adressez au service des relations internationales au rez-de-chaussée de la Maison de l'Université. Des bourses ERASMUS-Stage d'aide au financement de stage effectué dans un pays européen sont proposés. Renseignez-vous auprès du service des relations internationales.</p>

<div class="titre2"><a name="22">2.2. Le suivi des stages</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Chaque stagiaire est suivi par un enseignant référent du Département Informatique de la Faculté des Sciences de l'Université du Maine. Les référents n'ont pas la possibilité de visiter systématiquement les étudiants pendant les stages, mais pour les stages de longue durée se déroulant à proximité du Mans, une visite est souhaitable. Dans tous les cas, un contact (téléphonique ou par email) est fortement conseillé.</p>

<div class="titre3"><a name="221">2.2.1. Rôle de l'enseignant référent</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>
<ul>
    <li>Assurer le contact avec l'étudiant et l'entreprise.</li>
    <li>Assurer le premier niveau d'interaction en cas de problème (désaccord avec l'entreprise, accident du travail, maladie de longue durée...).</li>
    <li>Lire le rapport fourni par l'étudiant à l'issue du stage.</li>
    <li>Assister et participer à la soutenance orale.</li>
    <li>Remplir la fiche d'évaluation sur le stage.</li>
    <li>Vérifier lors de la soutenance que toutes les conditions sont satisfaites : dépôts du rapport et du résumé, remise de la fiche d'appréciation de l'entreprise.</li>
</ul>

<div class="titre3"><a name="222">2.2.2. Choix de l'enseignant référent</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<ul>
    <li>Chaque enseignant suit un certain nombre de stages déterminé selon le nombre d'étudiants de chaque diplôme et selon le nombre d'enseignant référents disponibles chaque année.</li>
    <li>L'attribution d'un enseignant-référent à l'étudiant est faite par le responsable pédagogique.</li>
    <li>Le stagiaire prend connaissance du nom de son enseignant-référent via le site Web des stages.</li>
</ul>

<div class="titre2"><a name="23">2.3. Les conventions de stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>La convention de stage est un document officiel définissant un accord passé entre l'université, l'entreprise et le stagiaire. A l'issue de la procédure, chacune des parties est en possession d'un exemplaire de cette convention. Chacun de ces trois exemplaires doit être signé par les trois parties : une convention qui n'a pas ces trois signatures avant le départ en stage n'a aucune valeur juridique. Enfin, tout stage qui n'entrerait pas dans le cadre de la formation obligatoire devra faire l'objet d'une convention distincte, précisant qu'il s'agit d'un stage facultatif hors cursus universitaire.</p>

<p>Les conventions sont gérées par la scolarité de la Faculté des Sciences. Une fois le sujet validé par le responsable des stages, l'étudiant fait une demande à la scolarité d'une convention en suivant la procédure <a href="http://sciences.univ-lemans.fr/fr/ma-scolarite.html">indiquée ici ("Pendant mes études : Démarches administratives/Stages et demande de césure")</a>. Une convention-type, rédigée par l'université, est établie par la scolarité de la Faculté des Sciences avec les éléments propres à chaque stage, et en particulier&nbsp;:
<ul>
    <li>Les coordonnées de l'entreprise.</li>
    <li>Les dates officielles de début et de fin de stage (en cas de prolongation du stage la convention devra être complétée d'un avenant dont la demande se fera également à la scolarité).</li>
    <li>Un résumé du sujet de stage (une vingtaine de lignes) qui aura été validé précédemment par le responsable pédagogique.</li>
    <li>Le montant mensuel de la gratification dans le cas d'un stage d'une durée supérieur à 2 mois.</li>
</ul>

<p>Le nombre de conventions à signer est devenu important. Afin d'éviter toute perte de temps, il est indispensable que chacun respecte l'ordre suivant :</p>
<ul>
    <li style="list-style-type: decimal;">l'étudiant demande une validation en envoyant par email (ou en déposant <a href="../stagiaire/demanderValidationSDS.php">ici</a>) la fiche préalable récupérée sur <a href='https://pstage.univ-lemans.fr'>pStage</a>&nbsp;;</li>
    <li style="list-style-type: decimal;">le responsable des stages valide ou pas le sujet&nbsp;;</li>
    <li style="list-style-type: decimal;">l'étudiant fait une demande de convention via l'application <a href='http://pstage.univ-lemans.fr'>pStage</a>&nbsp;;</li>
    <li style="list-style-type: decimal;">la scolarité établit la convention (édition, impression, signatures) toujours via l'application pStage.</li>
</ul>

<div class="titre2"><a name="24">2.4. Pendant le stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Pendant le stage, l'étudiant est soumis aux horaires et aux conditions de travail de l'organisme d'accueil. En particulier, il est soumis aux contraintes de sécurité en vigueur au sein de l'organisme d'accueil. En cas de problème, dont les causes peuvent être de divers origines (relation avec l'entreprise, conflit sur le sujet de stage, accident, etc.), il faut prévenir au plus tôt au moins une des personnes suivantes&nbsp;:</p>
<ul>
    <li>l'enseignant-référent du stage (coordonnées accessibles dans <a href="http://www.univ-lemans.fr/fr/acces-directs-annuaire/annuaire.html">l'annuaire Web</a> de l'Université) ;</li>
    <li>la scolarité de la faculté : par email à l'adresse <a href="mailto:stage-sco-sciences @ univ-lemans.fr">stage-sco-sciences @ univ-lemans.fr</a> ;</li>
    <li>le responsable pédagogique : M. Thierry Lemeunier au 02 43 83 38 65 ou par email à l'adresse <a href="mailto:Thierry.Lemeunier @ univ-lemans.fr">Thierry.Lemeunier @ univ-lemans.fr.</a></li>
</ul>

<div class="titre2"><a name="25">2.5. Le rapport de stage et le résumé</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le rapport de stage rendu à l'issue du stage est un élément important de la notation. Il ne s'agit pas de faire le rapport le plus volumineux possible à partir de photocopie de documents divers, mais de <strong>décrire votre réalisation personnelle</strong>. L'étudiant doit veiller à planifier un temps suffisant pour sa rédaction. Les rapports sont d'ailleurs préparés pendant le stage et avec les moyens de l'organisme d'accueil. Il est même préférable d'en rédiger certaines parties au fur et à mesure.</p>

<p>Dans tous les cas, l'étudiant doit impérativement déposer <strong>une semaine avant la date de soutenance</strong> le rapport de stage numérique au format PDF :</p>
<ul>
    <li>Les étudiants initiaux déposent dans la partie "Stagiaire" du site <a href='https://info-stages.univ-lemans.fr/stagiaire/depot_doc.php'>ici</a></li>
    <li>Les étudiants alternants déposent dans la partie "Alternant" du site <a href='https://info-stages.univ-lemans.fr/alternant/depot_doc.php'>ici</a> <strong>ET</strong> sur le <a href='https://lea.univ-lemans.fr/'>LEA</a></li>
</ul>

<p>En plus du rapport, chaque étudiant doit déposer <strong>le résumé (en français et anglais) du rapport</strong> dans un document PDF séparé au même endroit que le dépôt du rapport. Ces résumés servent aux étudiants des années suivantes dans leur recherche d'une entreprise via ce site.</p>

<div class="titre3">Confidentialité&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Si l'entreprise le souhaite, le rapport peut être confidentiel. Dans ce cas, il doit être marqué comme tel (pages et couvertures estampillées).</p>
<p>La soutenance, qui est normalement publique, peut également avoir lieu à huis clos en présence uniquement de l'étudiant, du jury constitué de plusieurs enseignant-référent et d'un ou plusieurs représentants de l'entreprise.</p>

<div class="titre3">Forme, fond et contenu du rapport<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Ces informations ont été regroupées sur UMTICE sur les pages suivantes :</p>
<ul>
    <li>Pour les Master 1 : <a href='https://umtice.univ-lemans.fr/course/view.php?id=3022'>M1 Informatique - Informations</a></li>
    <li>Pour les Master 2 : <a href='https://umtice.univ-lemans.fr/enrol/index.php?id=3064'>M2 informatique - Accueil</a></li>
</ul>

<div class="titre2"><a name="26">2.6. Résumé de la procédure</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<div style="text-align: center; margin: 15px"><img src="../images/procedure.png" alt="Résumé de la procédure"></div>

<div class="titre1"><a name="3">3. La soutenance</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Les soutenances orales sont obligatoires pour tous les étudiants. Les soutenances suivent un planning prévisionnel, nominatif, fixé à l'avance et <strong>disponible sur le site des stages</strong>. Compte tenu des difficultés d'organisation des plannings qui prennent en compte les contraintes des multiples enseignants-référents et des encadrants qui viennent d'entreprises parfois distantes pour participer aux soutenances, les modifications ultérieures sont impossibles même par permutation (sauf cas exceptionnel et sur demande de l'entreprise faite au moins 5 jours ouvrables avant la soutenance).</p>

<p>Les soutenances se font <strong>par groupe et par demi-journée</strong>.</p>

<div class="titre3">Conditions pour soutenir&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Les soutenances sont planifiées par le responsable pédagogique. Une soutenance ne peut être planifiée que si une convention (ou un contrat d'alternance) a été signée.</p>

<div class="titre3">Fiche d'appréciation d'entreprise pour les stagaires initiaux&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Cette fiche est accessible dans la partie téléchargement du site (<a href="../telechargements/">ici</a>). Elle sera remplie par votre encadrant dans l'entreprise qui devra la transmettre de façon confidentielle avant ou le jour de la soutenance (<u>sous enveloppe cachetée</u> si nécessaire). Dans tous les cas, si cette pièce n'est pas disponible le jour de la soutenance, celle-ci sera <strong>ajournée</strong>.</p>

<p><strong>Attention</strong> : pour les alternants l'appréciation de l'entreprise se fait via le LEA et non via cette fiche.</p>

<div class="titre3">Participants aux soutenances&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<ul>
    <li>L'étudiant stagiaire ou alternant.</li>
    <li>Les personnes ayant encadrées le stage ou l'alternance dans l'organisme d'accueil. Ces personnes sont invitées à participer aux autres soutenances de la demi-journée en tant que membre du jury.</li>
    <li>Les autres étudiants de ce groupe.</li>
    <li>Les autres personnels d'entreprise de ce groupe.</li>
    <li>Un jury composé d'universitaires (dont l'enseignant-référent) et les personnels d'entreprises présents.</li>
</ul>

<p>Par défaut, la soutenance est publique sauf en cas de confidentialité demandée par l'organisme d'accueil. Dans ce cas la soutenance à lieu à huis clos et seul sont présents l'étudiant, l'entreprise et les membres universitaires du jury.</p>

<div class="titre3">Durée et critères d'évaluation de la soutenance&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>La durée des soutenances et les critères d"évaluation sont indiqués sur les pages UMTICE.</p>

<ul>
    <li>en Master 1 : <a href='https://umtice.univ-lemans.fr/course/view.php?id=3022'>M1 Informatique - Informations</a>;</li>
    <li>en Master 2 : <a href='https://umtice.univ-lemans.fr/enrol/index.php?id=3064'>M2 informatique - Accueil</a>;</li>
</ul>

<div class="titre3">Date de soutenance&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Les soutenances ne font pas l'objet d'une convocation : il est de la responsabilité des étudiants de <strong>consulter régulièrement le site des stages pour se tenir informés de la date et de l'heure de leur soutenance</strong>. Des périodes spécifiques sont réservées dans le planning de chaque diplôme.</p>

<p>Si, pour une raison quelconque mais impérieuse (par exemple accident), la soutenance ne peut se faire à la date prévue, une date ultérieure pourra être fixée. Cependant, le diplôme ne peut être décerné qu'après la soutenance orale. Cette solution peut donc être handicapante pour les étudiants désirant poursuivre leurs études. En particulier, même en cas de prolongation du stage au-delà de la durée officielle, les étudiants doivent soutenir à la date prévue.</p>

<div class="titre1"><a name="4">4. L'évaluation du stage</a>&nbsp;<a href="#debut"><img src="../images/arrow_top.png"></a></div>

<p>Le stage est évalué en fonction de l'appréciation de l'organisme d'accueil, de l'évaluation de l'enseignant-référent concernant le rapport et enfin de l'évaluation de la soutenance orale par le jury.</p>

<p><strong>Attention</strong>, dans le cas du M2, les MCC du semestre S4 indique que le module est acquis par la moyenne du rapport et de la soutenance orale. Le rapport de stage peut faire l'objet d'une seconde session (version améliorée du rapport).</p>

<br/>

<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>
