<?php

class IHM_Generale {

    public static function header($titreGris, $titreOrange, $lienRacine, $liens, $ext=false) {
        ?>

        <!DOCTYPE HTML>
	<html lang="fr">
        <head>
	    <title>Département Informatique - Stage</title>
	    <meta name="application-name" content="Gestion des stages"/>
            <meta name="author" content="Thierry Lemeunier"/>
            <meta name="keywords" content="stage,informatique,université du maine"/>
            <meta charset="ISO-8859-1"/>
            <link rel="alternate" type="application/rss+xml" title="Flux RSS" href="http://info-stages.univ-lemans.fr/flux/fluxrss.xml"/>
	    <script src="<?php echo $lienRacine; ?>classes/ihm/util.js"></script>

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
            echo "<script src='frameworksJS/Chart.js'></script>";
            echo "<script src='frameworksJS/jquery.js'></script>";
            echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>";
        }
	    ?>

	    <link rel="stylesheet" href="<?php echo $lienRacine; ?>classes/ihm/Orange.css"/>
        <!--<script src="frameworksJS/jquery.js"></script>
        <script src="frameworksJS/Chart.js"></script>-->
        
        </head>
        <body>
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
                <div id="content-wrap<?php if (sizeof($liens) == 0)
                        echo "Accueil"; ?>" class="clearfix">
        <?php }

	public static function endHeaderAccueil() { ?>
		</div>
                <br/><br/>
            </div>
        <?php }

        public static function footerAccueil() { ?>
            <div id="footerAccueil">
                <a href="gestion/" title="Partie réservée au responsable">Gestion des stages</a>
                <p>Publié : <time datetime="2015-09-28">28/09/2015</time>
		    <a href="mailto:Thierry.Lemeunier%20@%20univ-lemans.fr?subject=Site%20web%20des%20stages&body=Enlevez les espaces entourant @ dans l'adresse mail de destination !" title='Contactez-moi par email'><img src='/images/mail.png' align='center' alt='Email' /></a>
		    <a href='http://info-stages.univ-lemans.fr/flux/fluxrss.xml' title='Suivez les offres de stage sur le flux RSS'><img src='/images/feed.png' align='center' alt='Flux RSS' /></a>
		    <a href="http://fr.linkedin.com/pub/thierry-lemeunier/64/72a/1b1/" title="Suivez-moi sur LinkedIn"><img src='/images/InBug-16px_0.png' align='center' alt='Profil LinkedIn' /></a>
		    <a href="http://www.viadeo.com/fr/profile/thierry.lemeunier2" title="Suivez-moi sur Viadeo"><img src='/images/Favicon.png' align='center' alt='Profil Viadeo' /></a>
		</p>
                <p>
                <nav>
                    <a href="http://www-info.univ-lemans.fr"><img src="./images/deptinfo.jpg" width="100" height="64" /></a>
                    <a href="http://sciences.univ-lemans.fr"><img src="./images/logo_sciences.gif" width="100" height="64" /></a>
                    <a href="http://ic2.univ-lemans.fr/"><img src="./images/iicc.png" width="140" height="64" /></a>
                    <a href="http://www.univ-lemans.fr"><img src="./images/logouniversite.gif" width="100" height="64" /></a>
                </nav>
            </p>
        </div>
        </body>
        </html>
    <?php }

    public static function endHeader($pageAvecMenu) { ?>
        <?php
        if ($pageAvecMenu)
            echo "</div>";
        ?>
        </div>
        <br/><br/>
        </div>
    <?php }

    public static function footer($lienRacine) { ?>
        <div id="footer">
            <nav>
                <a href='<?php echo $lienRacine; ?>index.php' title="Accueil du site">Accueil | </a>
                <a href='<?php echo $lienRacine; ?>presentation/' title="Présentation détaillée">Présentation | </a>
                <a href='<?php echo $lienRacine; ?>stagiaire/' title="Outils pour rechercher un stage">Rechercher un stage | </a>
                <a href='<?php echo $lienRacine; ?>stagiaire/' title="Validation d'un stage par le responsable">Valider un stage | </a>
                <a href='<?php echo $lienRacine; ?>parrainage/' title="Partie pour les enseignants">Enseignant référent | </a>
                <a href='<?php echo $lienRacine; ?>entreprise/' title="Partie pour les entreprises">Déposer un sujet | </a>
                <a href='<?php echo $lienRacine; ?>soutenances/' title="Accès aux plannings des soutenances">Soutenances | </a>
                <a href='<?php echo $lienRacine; ?>gestion/' title="Partie réservée au responsable">Gestion des stages</a>
            </nav>
            <p>Publié : <time datetime="2015-09-28">28/09/2015</time>
		<a href="mailto:Thierry.Lemeunier%20@%20univ-lemans.fr?subject=Site%20web%20des%20stages&body=Enlevez les espaces entourant @ dans l'adresse mail de destination !"><img src='/images/mail.png' align='center' alt='Email' /></a>
		<a href='http://info-stages.univ-lemans.fr/flux/fluxrss.xml' title='Suivez les offres de stage'><img src='/images/feed.png' align='center' alt='Flux RSS' /></a>
		<a href="http://fr.linkedin.com/pub/thierry-lemeunier/64/72a/1b1/" title="Suivez-moi sur LinkedIn"><img src='/images/InBug-16px_0.png' align='center' alt='Profil LinkedIn' /></a>
		<a href="http://www.viadeo.com/fr/profile/thierry.lemeunier2" title="Suivez-moi sur Viadeo"><img src='/images/Favicon.png' align='center' alt='Profil Viadeo' /></a>
	    </p>
        </div>
        </body>
        </html>
    <?php }

    public static function erreur($text) { ?>
        <div id='erreur'>
            <br/>
            <h1 style="border: none;">&nbsp;Erreur&nbsp;</h1>
        <?php echo $text; ?>
            <br/><br/>
        </div>
    <?php }

    public static function enConstruction() { ?>
        <div id='construction'>
            <br/>
            <h1>&nbsp;En construction&nbsp;</h1>
            <br/><br/>
        </div>
    <?php
    }

}
?>