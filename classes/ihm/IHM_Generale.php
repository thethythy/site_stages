<?php

class IHM_Generale {

    /**
     * Afficher l'entête de page commune à toutes les pages du site
     * @param string $titreGris Titre affiché en gris
     * @param string $titreOrange Titre affiché en orange
     * @param string $lienRacine Chemin relatif de la racine du site
     * @param tableau de string $liens Tableau des liens de navigation internes
     * @param string $ext Indicateur pour personnaliser les scripts à utiliser
     */
    public static function header($titreGris, $titreOrange, $lienRacine, $liens, $ext = false) {
	?>
	<!DOCTYPE HTML>
	<html lang="fr">
	    <head>
		<title>Département Informatique - Stage</title>
		<meta name="application-name" content="Gestion des stages"/>
		<meta name="author" content="Thierry Lemeunier"/>
		<meta name="keywords" content="stage,informatique,université du maine"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<link rel="alternate" type="application/rss+xml" title="Flux RSS" href="http://info-stages.univ-lemans.fr/flux/fluxrss.xml"/>
		<script src="<?php echo $lienRacine; ?>classes/ihm/util.min.js"></script>

		<?php
		if ($ext == "planifieur") {
		    // L'arborescence
		    echo "<link rel='stylesheet' href='" . $lienRacine . "classes/ihm/dhtmlxtree/dhtmlxtree.css'/>\n";
		    echo "<script src='" . $lienRacine . "classes/ihm/dhtmlxtree/dhtmlxcommon.js'></script>\n";
		    echo "<script src='" . $lienRacine . "classes/ihm/dhtmlxtree/dhtmlxtree.js'></script>\n";

		    // Le planning
		    echo "<link rel='stylesheet' href='" . $lienRacine . "classes/ihm/dhtmlxscheduler/dhtmlxscheduler.css'/>\n";
		    echo "<script src='" . $lienRacine . "classes/ihm/dhtmlxscheduler/dhtmlxscheduler.js'></script>\n";
		    // Localisation du planning
		    echo "<script src='" . $lienRacine . "classes/ihm/dhtmlxscheduler/locale_fr.js'></script>\n";
		    // Affichage plein écran
		    echo "<script src='" . $lienRacine . "classes/ihm/dhtmlxscheduler/ext/dhtmlxscheduler_expand.js'></script>\n";
		    // Ajout des tooltips
		    echo "<script src='" . $lienRacine . "classes/ihm/dhtmlxscheduler/ext/dhtmlxscheduler_tooltip.js'></script>\n";
		    // Ajout des éditeurs spécifiques
		    echo "<script src='" . $lienRacine . "classes/ihm/dhtmlxscheduler/ext/dhtmlxscheduler_editors.js'></script>\n";
		    // Ajout du drag & drop depuis l'exterieur
		    echo "<script src='" . $lienRacine . "classes/ihm/dhtmlxscheduler/ext/dhtmlxscheduler_outerdrag.js'></script>\n";
		}

		if ($ext == "browser") {
		    echo "<link rel='stylesheet' type='text/css' href='scripts/jquery.filetree/jqueryFileTree.css' />";
		    echo "<link rel='stylesheet' type='text/css' href='scripts/jquery.contextmenu/jquery.contextMenu-1.01.css' />";
		    echo "<link rel='stylesheet' type='text/css' href='styles/filemanager.css' />";
		}

		if ($ext == "statistiques") {
		    echo "<script src='frameworks/Chart.min.js'></script>";
		}
		?>

		<link rel="stylesheet" href="<?php echo $lienRacine; ?>classes/ihm/Orange.css"/>
	    </head>
	    <?php
	    if ($ext == "auchargement") {
		echo "<body onload='auchargement()'>";
	    } else {
		echo "<body>";
	    }
	    ?>
		<div id="wrap">
		    <div id="header">
			<h1 id="logo"><?php echo $titreGris; ?><span class="orange"> <?php echo $titreOrange; ?></span></h1>
			<?php
			if (sizeof($liens) > 0) {
			    echo "<div id='liensNavigation'>";

			    for ($i = 0; $i < sizeof($liens); $i++) {
				echo "<a href='" . $liens[$i][0] . "'>";
				echo $liens[$i][1];
				echo "</a>";
				echo " > ";
			    }
			    echo $titreGris . " " . $titreOrange;

			    echo "</div>";
			}
			?>
		    </div>
		    <br/>
		    <div id="content-wrap<?php if (sizeof($liens) == 0) echo "Accueil";?>" class="clearfix">
	<?php
    }

    /**
     * Afficher la fin de l'entête commune à toutes les pages du site
     * @param boolean $pageAvecMenu Indicateur à vrai si la page contient un menu
     */
    public static function endHeader($pageAvecMenu) {
	if ($pageAvecMenu)
	    echo "</div>";
	?>
		    </div>
		    <br/><br/>
		</div>
	<?php
    }

    /**
     * Afficher la fin de l'entête spécifique à la page d'accueil
     */
    public static function endHeaderAccueil() {
	?>
		    </div>
		    <br/><br/>
		</div>
	<?php
    }

    /**
     * Afficher le pied de page commun à toutes les pages du site
     * @param type $lienRacine
     */
    public static function footer($lienRacine) {
	?>
		<div id="footer">
		    <nav>
			<a href='<?php echo $lienRacine; ?>index.php' title="Accueil du site">Accueil | </a>
			<a href='<?php echo $lienRacine; ?>presentation/' title="Présentation détaillée">Présentation | </a>
			<a href='<?php echo $lienRacine; ?>stagiaire/' title="Outils pour rechercher un stage">Rechercher un stage<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/>| </a>
			<a href='<?php echo $lienRacine; ?>stagiaire/' title="Validation d'un stage par le responsable">Valider un stage<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/>| </a>
			<a href='<?php echo $lienRacine; ?>parrainage/' title="Partie pour les enseignants">Enseignant référent<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/>| </a>
			<a href='<?php echo $lienRacine; ?>entreprise/' title="Partie pour les entreprises">Déposer un sujet | </a>
			<a href='<?php echo $lienRacine; ?>soutenances/' title="Accès aux plannings des soutenances">Soutenances<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/>| </a>
			<a href='<?php echo $lienRacine; ?>gestion/' title="Partie réservée au responsable">Connexion<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/>| </a>
			<a href='<?php echo $lienRacine; ?>mentions.php' title="Mentiosn légales">Mentions légales</a>
		    </nav>
		    <p>
			<a href="mailto:Thierry.Lemeunier%20@%20univ-lemans.fr?subject=Site%20web%20des%20stages&body=Enlevez les espaces entourant @ dans l'adresse mail de destination !"><img src='/images/mail.png' align='center' alt='Email' /></a>
			<a href='http://info-stages.univ-lemans.fr/flux/fluxrss.xml' title='Suivez les offres de stage'><img src='/images/feed.png' align='center' alt='Flux RSS' /></a>
			<a href="http://fr.linkedin.com/pub/thierry-lemeunier/64/72a/1b1/" title="Suivez-moi sur LinkedIn"><img src='/images/InBug-16px_0.png' align='center' alt='Profil LinkedIn' /></a>
			<a href="http://www.viadeo.com/fr/profile/thierry.lemeunier2" title="Suivez-moi sur Viadeo"><img src='/images/Favicon.png' align='center' alt='Profil Viadeo' /></a>
		    </p>
		</div>
	    </body>
	</html>
	<?php
    }

    /**
     * Afficher le pied de page spécifique à la page d'accueil
     */
    public static function footerAccueil() {
	?>
		<div id="footerAccueil">
		    <a href="gestion/" title="Partie réservée">Connexion<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/> | </a>
		    <a href="mentions.php" title="Partie réservée">Mentions légales</a>
		    <p>
			<a href="mailto:Thierry.Lemeunier%20@%20univ-lemans.fr?subject=Site%20web%20des%20stages&body=Enlevez les espaces entourant @ dans l'adresse mail de destination !" title='Contactez-moi par email'><img src='/images/mail.png' align='center' alt='Email' /></a>
			<a href='http://info-stages.univ-lemans.fr/flux/fluxrss.xml' title='Suivez les offres de stage sur le flux RSS'><img src='/images/feed.png' align='center' alt='Flux RSS' /></a>
			<a href="http://fr.linkedin.com/pub/thierry-lemeunier/64/72a/1b1/" title="Suivez-moi sur LinkedIn"><img src='/images/InBug-16px_0.png' align='center' alt='Profil LinkedIn' /></a>
			<a href="http://www.viadeo.com/fr/profile/thierry.lemeunier2" title="Suivez-moi sur Viadeo"><img src='/images/Favicon.png' align='center' alt='Profil Viadeo' /></a>
		    </p>
		    <p><nav>
			<a href="http://www-info.univ-lemans.fr"><img src="/images/logo_deptinfo.jpg" width="100" height="50" align='center'/></a>
			<a href="http://ic2.univ-lemans.fr/"><img src="/images/logo_iicc.png" width="120" height="40" align='center'/></a>
			<a href="http://sciences.univ-lemans.fr"><img src="/images/logo_sciences.gif" width="80" height="50" align='center'/></a>
			<a href="http://www.univ-lemans.fr"><img src="/images/logo_universite.png" width="120" height="30" align='center'/></a>
		    </nav></p>
		</div>
	    </body>
	</html>
	<?php
    }

    /**
     * Afficher le pied de page spécifique à la page d'accueil
     */
    public static function footerAccueilAccessControl() {
	?>
		<div id="footerAccueil">
		    <a>Connexion<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/> | </a>
		    <a>Mentions légales</a>
		    <p>
			<img src='/images/mail.png' align='center' alt='Email' />
			<img src='/images/feed.png' align='center' alt='Flux RSS' />
			<img src='/images/InBug-16px_0.png' align='center' alt='Profil LinkedIn' />
			<img src='/images/Favicon.png' align='center' alt='Profil Viadeo' />
		    </p>
		    <p><nav>
			<img src="/images/logo_deptinfo.jpg" width="100" height="50" align='center'/>
			<img src="/images/logo_iicc.png" width="120" height="40" align='center'/>
			<img src="/images/logo_sciences.gif" width="80" height="50" align='center'/>
			<img src="/images/logo_universite.png" width="120" height="30" align='center'/>
		    </nav></p>
		</div>
	    </body>
	</html>
	<?php
    }

    /**
     * Afficher une erreur dans un cadre rouge avec une grande image
     * et un message explicatif
     * @param string $text Le message explicatif
     */
    public static function erreur($text) {
	?>
	    <div id='erreur'>
		<br/>
		<h1 style="border: none;">&nbsp;Attention&nbsp;</h1>
		<?php echo $text; ?>
		<br/><br/>
	    </div>
	<?php
    }

    /**
     * Afficher un avertissement pour signaler l'absence d'une fonctionnalité
     */
    public static function enConstruction() {
	?>
	    <div id='construction'>
		<br/>
		<h1>&nbsp;En construction&nbsp;</h1>
		<br/><br/>
	    </div>
	<?php
    }

}
?>