<?php

/**
 * Page mentions.php
 * Utilisation : page d'informations légales sur le site
 * Accès : public
 */

include_once("classes/ihm/IHM_Generale.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("mentions", "légales", "../", $tabLiens);

?>

<h1>Mentions légales pour le site web : <a href='http://info-stages.univ-lemans.fr'>info-stages.univ-lemans.fr</a></h1>
<br/>
<h1>Responsable du site :</h1>
<p>
Département Informatique<br/>
Université du Maine<br/>
Avenue Olivier Messiaen<br/>
72085 LE MANS cedex 9<br/>
Tél : 02 43 83 38 38<br/>
<a href="mailto:thierry.lemeunier@univ-lemans.fr">webmaster@info-stages.univ-lemans.fr</a>
</p>
<br/>
<h1>Directeur de la publication :</h1>
<p>
Responsable des stages du Département Informatique<br/>
<a href="mailto:thierry.lemeunier@univ-lemans.fr">publication@info-stages.univ-lemans.fr</a>
</p>
<br/>
<h1>Hébergeur :</h1>
<p>
Département Informatique, Université du Maine<br/>
<a href="mailto:thierry.lemeunier@univ-lemans.fr">hebergeur@info-stages.univ-lemans.fr</a>
</p>
<br/>
<h1>Déclaration à la CNIL :</h1>
<p style="width: 70%;">
Comformémant à la délibération n°2006-138 du 09/05/2006 décidant de la dispense
de déclaration des traitements par tout organisme privé ou public constitués à
des fins d'information ou de communication externe (Dispence DI-007), les fichiers
de données utilisés par ce site Web n'ont pas être déclarés auprès de la CNIL
(cf. <a href='http://www.cnil.fr'>www.cnil.fr</a>).<br/>
</p>
<br/>
<h1>Informations aux internautes</h1>
<p style="width: 70%;">
Les internautes ont accès aux informations récoltées les concernant et bénéficient
d'un droit de modification et de suppression de leurs données personnelles par simple demande
auprès du directeur de la publication.
<br/><br/>
Un cookie d'authentification est utilisé pour accéder à certaines parties privées
du site. Conformément à la législation en vigueur (ordonnance n°2011-1012 du 24
août 2011 relative aux communications électroniques), l'utilisation de ce type de
cookie est dispensé du recueil du consentement de l'internaute
(cf. <a href='http://www.cnil.fr'>www.cnil.fr</a>).
</p>
<br/>
<h1>Dernière publication : <time datetime="2016-11-18">18/11/2016</time></h1>

<?php

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>