<?php 

include_once("./../../classes/bdd/connec.inc");
include_once("./../../classes/ihm/IHM_Generale.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');
IHM_Generale::header("Aide", "en ligne", "../../", $tabLiens);

?>

<script>
	// Centrer un �l�ment en position absolue
	var centerAside = function(element) {
		var height = document.getElementById(element).offsetHeight; //hauteur de l'�l�ment � positionner
		var width = document.getElementById(element).offsetWidth; //largeur de l'�l�ment � positionner
		var myParent = document.getElementById(element).parentNode;
		var pHeight = myParent.offsetHeight; //Hauteur de l'�l�ment parent
		var pWidth = myParent.offsetWidth; //Largeur de l'�l�ment parent
		var sTop = myParent.scrollTop; //Hauteur de d�filement de l'�l�ment parent
		var sLeft = myParent.scrollLeft; //Longueur de d�filement de l'�l�ment parent
		var posY = (pHeight/2) - (height/2) + sTop; //Calcul de la position en Y
		var posX = (pWidth/2) - (width/2) + sLeft; //Calcul de la position en X
		document.getElementById(element).style.top = posY + "px";
		document.getElementById(element).style.left = posX + "px";
	}

	// La pile des articles
	var anciensArticles = new Array();
	
	// Montre ou cache un article
	var cacheOuMontre = function(article, clarifie_fond) {
		ancienArticle = anciensArticles.pop();
		if (article != ancienArticle) {
			// Cache l'ancien
			anciensArticles.push(ancienArticle);
			if (clarifie_fond && ancienArticle) document.getElementById(ancienArticle).hidden = true;
			if (!clarifie_fond) document.getElementById("content-wrap").style.opacity = 0.3;
			// Montre le nouvel article en le centrant
			document.getElementById(article).hidden = false;
			if (!clarifie_fond) centerAside(article);
			anciensArticles.push(article);
		} else if (document.getElementById(article).hidden == false) {
			// Cache l'article car il d�j� visible
			document.getElementById(article).hidden = true;
			if (!clarifie_fond) document.getElementById("content-wrap").style.opacity = 1;
		}
	}
</script>

<article class="aide_en_ligne_detaillee">

	<section>
		<h1><a href="<?php echo $baseSite; ?>stagiaire/">Stagiaire</a></h1>
		<p>Cette partie est utilis�e par les �tudiants.</p>
		<p>Elle permet les actions suivantes :</p>
		<ul>
			<li>consulter des offres de stage actuelles</a> ;</li>
			<li>consulter les anciens stages et les entreprises ;</li>
			<li>valider un sujet de stage ;</li>
			<li>d�poser des documents.</li>
		</ul>
		<footer><a href="#article_stagiaire" onclick="cacheOuMontre('article_stagiaire', true);">En savoir plus</a></footer>
		<hr/>
	</section>

	<section>
		<h1><a href="<?php echo $baseSite; ?>parrainage/">Enseignants r�f�rents</a></h1>
		<p>Cette partie du site est utilis�e par les enseignants.</p>
		<p>Elle permet les actions suivantes :</p>
		<ul>
			<li>obtenir la liste d�taill�e des stagiaires suivis par l'enseignant ;</li>
			<li>obtenir une synth�se par enseignant.</li>
		</ul>
		<footer><a href="#article_enseignant"onclick="cacheOuMontre('article_enseignant', true);">En savoir plus</a></footer>
		<hr/>
	</section>

	<section>
		<h1><a href="<?php echo $baseSite; ?>entreprise/">D�poser une offre de stage</a></h1>
		<p>Cette partie permet au entreprise de d�poser les offres de stage.</p>
		<footer><a href="#article_entreprise"onclick="cacheOuMontre('article_entreprise', true);">En savoir plus</a></footer>
		<hr/>
	</section>

	<section>
		<h1><a href="<?php echo $baseSite; ?>soutenances/">Soutenances</a></h1>
		<p>Cette partie du site permet d'acc�der aux plannings des soutenances.</p>
		<p>Elle permet les actions suivantes :</p>
		<ul>
			<li>conna�tre les p�riodes de soutenances ;</li>
			<li>conna�tre les plannings par salle ;</li>
			<li>conna�tre les plannings par dipl�me ;</li>
			<li>conna�tre les plannings par enseignant.</li>
		</ul>
		<footer><a href="#article_soutenance"onclick="cacheOuMontre('article_soutenance', true);">En savoir plus</a></footer>
		<hr/>
	</section>

	<section>
		<h1><a href="<?php echo $baseSite; ?>gestion/">Gestion des stages</a></h1>
		<p>Cette partie du site est r�serv�e au responsable en charge des stages.</p>
		<p>Elle permet les actions suivantes :</p>
		<ul>
			<li>g�rer la base de donn�es (limit� � certaines actions) ;</li>
			<li>g�rer les entreprises, les contacts et la diffusion des offres ;</li>
			<li>g�rer les promotions d'�tudiants ;</li>
			<li>g�rer la validation des sujets de stage ;</li>
			<li>g�rer les enseignants r�f�rents ;</li>
			<li>g�rer les conventions ;</li>
			<li>g�rer les soutenances ;</li>
			<li>obtenir les �tiquettes pour la TA ;</li>
			<li>obtenir des statistiques (non disponible).</li>
		</ul>
		<footer><a href="#article_gestion"onclick="cacheOuMontre('article_gestion', true);">En savoir plus</a></footer>
	</section>

</article>

<article id="article_stagiaire" hidden class="article_aide_en_ligne_detaillee">

	<header><h1>Outils pour les �tudiants</h1></header>

	<section>
		<header><h2>Consulter des offres de stage</h2></header>
		<p>L'�tudiant dispose d'un outil de consultation des offres de stage. Cet outil permet de s�lectionner un stage selon les crit�res suivants :</p>
		<ul>
			<li>nom de l'entreprise ;</li>
			<li>lieu du stage (n� de d�partement ou code postal ou ville ou pays) ;</li>
			<li>le dipl�me et/ou la sp�cialit� ;</li>
			<li>la dur�e ;</li>
			<li>les domaines ou technologies attendues.</li>
		</ul>
		<p>Les �tudiants sont inform�s par mail de chaque nouvelle offre disponible sur le site. Un flux RSS<a href='http://info-stages.univ-lemans.fr/flux/fluxrss.xml' title='Suivez les offres de stage'><img src='../../images/feed.png' align='center' alt='Flux RSS' /></a> est aussi disponible sur la page d'accueil du site.</p>
		<figure>
			<a href="#image_liste_offre_stage" onclick="cacheOuMontre('image_liste_offre_stage', false);"><img src="liste_offre_stage.png" alt="S�lection des offres de stage." width="50%"/></a>
			<figcaption>S�lection des offres de stage<a href="#image_liste_offre_stage" onclick="cacheOuMontre('image_liste_offre_stage', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>

	<section>
		<header><h2>Consulter les anciens stages et les entreprises</h2><header>
		<p>L'�tudiant dispose d'un outil de consultation des anciens stages. Il a ainsi acc�s aux entreprises ayant d�j� pris des stagiaires les ann�es pass�es. Cet outil permet de chercher les anciens stages selon les crit�res suivants :</p>
		<ul>
			<li>ann�e du stage ;</li>
			<li>le dipl�me et/ou la sp�cialit�.</li>
		</ul>
		<p>Chaque ancien stage est d�crit par un r�sum� accessible dans le tableau r�sultat de la s�lection.</p>
		<figure>
			<a href="#image_liste_ancien_stage" onclick="cacheOuMontre('image_liste_ancien_stage', false);"><img src="liste_ancien_stage.png" alt="S�lection des anciens stages." width="50%"/></a>
			<figcaption>S�lection des anciens stages<a href="#image_liste_ancien_stage" onclick="cacheOuMontre('image_liste_ancien_stage', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>

	<section>
		<header><h2>Valider un sujet de stage</h2></header>
		<p>L'�tudiant dispose d'un outil pour valider un sujet de stage. Cet outil informe le responsable des stages par email d'une nouvelle demande de validation.</p>
		<p>Pour faire une demande de validation, l'�tudiant doit s�lectionner :</p>
		<ul>
			<li>l'ann�e universitaire ;</li>
			<li>le dipl�me et/ou la sp�cialit� ;</li>
			<li>son nom dans la liste d�roulante ;</li>
			<li>un fichier d�crivant le sujet ou saisir directement cette description dans la zone d'�dition.</li>
		</ul>
		<p>L'�tudiant doit ensuite enregistrer la demande de validation avec le bouton "Enregistrer".</p>
		<figure>
			<a href="#image_valider_stage" onclick="cacheOuMontre('image_valider_stage', false);"><img src="valider_stage.png" alt="Faire une demande de validation d'un stage." width="50%"/></a>
			<figcaption>Validation d'un sujet de stage<a href="#image_valider_stage" onclick="cacheOuMontre('image_valider_stage', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>

	<section>
		<header><h2>D�poser un document</h2></header>
		<p>L'�tudiant dispose d'un outil pour d�poser des documents sur le site. Il peut d�poser un rapport de stage et un r�sum� du rapport de stage.</p>
		<p>Chaque document d�pos� est mis � disposition de l'enseignant-r�f�rent qui est mis au courant par mail automatique contenant un lien vers ce document.</p>
		<p>Pour d�poser un document, l'�tudiant doit s�lectionner :</p>
		<ul>
			<li>l'ann�e universitaire ;</li>
			<li>le dipl�me et/ou la sp�cialit� ;</li>
			<li>son nom dans la liste d�roulante ;</li>
			<li>le nom de l'enseignant qui recevra la notification de d�p�t ;</li>
			<li>le fichier � d�poser (rapport de stage ou r�sum� du stage).</li>
		</ul>
		<p>L'�tudiant doit ensuite valider le formulaire soit avec le bouton "D�poser le rapport" soit avec le bouton "D�poser le r�sum�".</p>
		<figure>
			<a href="#image_deposer_document" onclick="cacheOuMontre('image_deposer_document', false);"><img src="deposer_document.png" alt="D�poser un document." width="50%"/></a>
			<figcaption>D�poser un document<a href="#image_deposer_document" onclick="cacheOuMontre('image_deposer_document', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>

</article>

<article id="article_enseignant" hidden class="article_aide_en_ligne_detaillee">

	<header><h1>Outils pour les enseignants</h1></header>

	<section>
		<header><h2>Obtenir la liste des stagiaires</h2></header>
		<p>L'enseignant dispose d'un outil pour obtenir la liste des stagiaires qu'il suit. Cet outil permet de s�lectionner les stagiaires selon les crit�res suivants :</p>
		<ul>
			<li>l'ann�e universitaire ;</li>
			<li>le dipl�me et/ou la sp�cialit� du stagiaire ;</li>
			<li>le nom de l'enseignant.</li>
		</ul>
		<figure>
			<a href="#image_liste_stagiaire" onclick="cacheOuMontre('image_liste_stagiaire', false);"><img src="liste_stagiaire.png" alt="S�lection des stagiaires suivis." width="50%"/></a>
			<figcaption>S�lection des stagiaires<a href="#image_liste_stagiaire" onclick="cacheOuMontre('image_liste_stagiaire', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>

	<section>
		<header><h2>Obtenir une synth�se</h2></header>
		<p>L'enseignant dispose d'un outil pour obtenir une synth�se de tous les stagiaires qu'il suit par dipl�me. Cet outil permet de s�lectionner les stagiaires selon les crit�res suivants :</p>
		<ul>
			<li>l'ann�e universitaire ;</li>
			<li>le dipl�me et/ou la sp�cialit� du stagiaire ;</li>
			<li>le nom de l'enseignant.</li>
		</ul>
		<p>L'enseignant a acc�s �galement au planning des soutenances au format iCalendar (soit par abonnement soit par fichier).</p>
		<figure>
			<a href="#image_synthese_stagiaire" onclick="cacheOuMontre('image_synthese_stagiaire', false);"><img src="synthese_stagiaire.png" alt="Synth�se et calendrier des soutenances" width="50%"/></a>
			<figcaption>Synth�se et calendrier des soutenances<a href="#image_synthese_stagiaire" onclick="cacheOuMontre('image_synthese_stagiaire', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>

</article>

<article id="article_entreprise" hidden class="article_aide_en_ligne_detaillee">
	<header><h1>Outils pour les entreprises</h1></header>
	<section>
		<header><h2>D�poser une offre de stage</h2></header>
		<p>Les entreprises peuvent saisir des offres de stage. Ces offres seront valid�es par le responsable des stages qui est automatiquement averti par mail.</p>
		<p>Une fois valid�e, ces offres seront disponibles sur le site. Les �tudiants seront aussi avertis par mail. Le flux RSS sera �galement mis � jour.</p>
		<p>Pour saisir une offre de stage, l'entreprise doit saisir les informations suivantes :</p>
		<ul>
			<li>sur le stage :
				<ul>
					<li>le titre de l'offre ;</li>
					<li>le sujet ;</li>
					<li>la ou les comp�tences attendues ;</li>
					<li>le ou les environnements de travail si ils sont connus ;</li>
					<li>le ou les dipl�mes de l'�tudiant souhait�s ;</li>
					<li>la dur�e du stage (minimum et maximum) ;</li>
					<li>le montant de la r�mun�ration mensuelle ;</li>
					<li>divers remarques si n�cessaire ;</li>
				</ul>
			</li>
			<li>sur l'entreprise :
				<ul>
					<li>le nom ;</li>
					<li>l'adresse ;</li>
					<li>la ville ;</li>
					<li>le code postal ;</li>
					<li>le pays ;</li>
					<li>email du DRH ou �quivalent ;</li>
				</ul>
			</li>
			<li>sur le contact dans l'entreprise
				<ul>
					<li>le nom du contact ;</li>
					<li>le pr�nom du contact ;</li>
					<li>le num�ro de t�l�phone ;</li>
					<li>le num�ro de fax ;</li>
					<li>l'email du contact.</li>
				</ul>
			</li>
		</ul>
		<figure>
			<a href="#image_deposer_offre" onclick="cacheOuMontre('image_deposer_offre', false);"><img src="deposer_offre.png" alt="D�poser une offre de stage" width="50%"/></a>
			<figcaption>D�poser une offre de stage<a href="#image_deposer_offre" onclick="cacheOuMontre('image_deposer_offre', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>
</article>

<article id="article_soutenance" hidden class="article_aide_en_ligne_detaillee">

	<header><h1>Soutenances</h1></header>

	<section>
		<header><h2>Conna�tre les dates de soutenances</h2></header>
		<p>Un tableau pr�sente les dates des p�riodes des soutenances.</p>
		<figure>
			<a href="#image_dates_soutenance" onclick="cacheOuMontre('image_dates_soutenance', false);"><img src="dates_soutenance.png" alt="Obtenir les dates des p�riodes des soutenances" width="50%"/></a>
			<figcaption>Obtenir les dates des p�riodes des soutenances<a href="#image_dates_soutenance" onclick="cacheOuMontre('image_dates_soutenance', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>

	<section>
		<header><h2>Conna�tre les plannings par salle</h2></header>
		<p>Un tableau pr�sente le planning d'occupation des salles.</p>
		<p>L'utilisateur s�lectionne la salle et la date.</p>
		<figure>
			<a href="#image_planning_salle" onclick="cacheOuMontre('image_planning_salle', false);"><img src="planning_salle.png" alt="Obtenir le planning d'une salle" width="50%"/></a>
			<figcaption>Obtenir le planning d'une salle<a href="#image_planning_salle" onclick="cacheOuMontre('image_planning_salle', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>

	<section>
		<header><h2>Conna�tre les plannings par dipl�me</h2></header>
		<p>Un tableau pr�sente le planning par dipl�me. L'utilisateur s�lectionne le dipl�me voulu.</p>
		<figure>
			<a href="#image_planning_diplome" onclick="cacheOuMontre('image_planning_diplome', false);"><img src="planning_diplome.png" alt="Obtenir le planning des soutenances par dipl�me" width="50%"/></a>
			<figcaption>Obtenir le planning des soutenances par dipl�me<a href="#image_planning_diplome" onclick="cacheOuMontre('image_planning_diplome', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>
	
	<section>
		<header><h2>Conna�tre les plannings par enseignant</h2></header>
		<p>Un tableau pr�sente le planning par enseignant. L'utilisateur s�lectionne l'enseignant recherch�.</p>
		<figure>
			<a href="#image_planning_enseignant" onclick="cacheOuMontre('image_planning_enseignant', false);"><img src="planning_enseignant.png" alt="Obtenir le planning des soutenances par dipl�me" width="50%"/></a>
			<figcaption>Obtenir le planning des soutenances par enseignant<a href="#image_planning_enseignant" onclick="cacheOuMontre('image_planning_enseignant', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
	</section>
	
</article>

<article id="article_gestion" hidden class="article_aide_en_ligne_detaillee">
	
	<header><h1>Gestion des stages</h1></header>
        
        <section>
            <header><h2>G�rer la base</h2></header>
            <p>Les actions sur la base de donn�es sont restreintes aux actions suivantes :</p>
            <ul>
                <li>Supprimer les anciennes offres accessibles aux �tudiants ;</li>
                <li>Supprimer les anciennes validations demand�es par les �tudiants ;</li>
                <li>Vider le flux RSS de l'ann�e pr�c�dente.</li>
            </ul>
            <p>Afin de supprimer toutes suppressions accidentelles, ces trois actions sont accessibles uniquement durant les mois de septembre et octobre de l'ann�e en cours.</p>
            <figure>
                    <a href="#image_gestion_base" onclick="cacheOuMontre('image_gestion_base', false);"><img src="gestion_base.png" alt="Supprimer des informations de la base de donn�es" width="50%"/></a>
                    <figcaption>Supprimer des informations de la base de donn�es<a href="#image_gestion_base" onclick="cacheOuMontre('image_gestion_base', false);"><img src="../../images/magnify.png"/></a></figcaption>
            </figure>
        </section>
        
        <section>
            <header>
                <h2>G�rer les entreprises</h2>
                <h3>Obtenir la liste des entreprises</h3>
            </header>
            <p>Le gestionnaire peut obtenir la liste des entreprises enregistr�es dans la base. On peut filtrer cette liste en fonction :</p>
            <ul>
                <li>du nom de l'entreprise ;</li>
                <li>de la ville ;</li>
                <li>du code postal ;</li>
                <li>du pays.</li>
            </ul>
            <figure>
                    <a href="#image_liste_entreprise" onclick="cacheOuMontre('image_liste_entreprise', false);"><img src="liste_entreprise.png" alt="Obtenir la liste des entreprises" width="50%"/></a>
                    <figcaption>Obtenir la liste des entreprises<a href="#image_liste_entreprise" onclick="cacheOuMontre('image_liste_entreprise', false);"><img src="../../images/magnify.png"/></a></figcaption>
            </figure>
            
            <header><h3>Saisir une nouvelle entreprise</h3></header>
            <p>Le gestionnaire peut ajouter une nouvelle entreprise � la base. Pour cela il doit saisir les informations suivantes :</p>
            <ul>
                <li>le nom de l'entreprise ;</li>
                <li>le code postal ;</li>
                <li>l'adresse ;</li>
                <li>la ville ;</li>
                <li>l'email du DRH ou son �quivalent (non obligatoire) ;</li>
                <li>le pays.</li>
            </ul>
            <p>Si l'entreprise n'existe pas encore dans la base (v�rification sur le nom, la ville et le pays), elle est ajout�e � la base sinon un message d'erreur est affich� et l'ajout �choue.</p>
            <figure>
                    <a href="#image_saisir_entreprise" onclick="cacheOuMontre('image_saisir_entreprise', false);"><img src="saisir_entreprise.png" alt="Saisir une entreprise" width="50%"/></a>
                    <figcaption>Saisir une entreprise<a href="#image_saisir_entreprise" onclick="cacheOuMontre('image_saisir_entreprise', false);"><img src="../../images/magnify.png"/></a></figcaption>
            </figure>
            
            <header><h3>Modifier ou supprimer une entreprise</h3></header>
            <p>Le gestionnaire peut modifier ou supprimer une entreprise. Pour cela, il doit d'abord chercher l'entreprise en question dans une liste que l'on peut filtrer en fonction :</p>
            <ul>
                <li>du nom ;</li>
                <li>du code postal ;</li>
                <li>de la ville ;</li>
                <li>du pays.</li>
            </ul>
            <figure>
                    <a href="#image_liste_entreprise_supp_mod" onclick="cacheOuMontre('image_liste_entreprise_supp_mod', false);"><img src="liste_entreprise_supp_mod.png" alt="Modifier ou supprimer une entreprise" width="50%"/></a>
                    <figcaption>Modifier ou supprimer une entreprise<a href="#image_liste_entreprise_supp_mod" onclick="cacheOuMontre('image_liste_entreprise_supp_mod', false);"><img src="../../images/magnify.png"/></a></figcaption>
            </figure>
            <p>Pour supprimer une entreprise, cliquez sur l'ic�ne en forme de croix <img src="../../images/action_delete.png"/>. Attention, <strong>aucune v�rification</strong> n'est ici effectu�e. L'entreprise sera supprim�e m�me si elle est li�e � un contact ou � une convention de stage existante par exemple.</p>
            <p>Pour �diter une entreprise, cliquez sur l'ic�ne en forme de crayon <img src="../../images/reply.png"/>. Une fen�tre d'�dition (identique � la fen�tre de saisie) est affich�e.</p>
            
            <header><h3>Obtenir la liste des contacts</h3></header>
            <p>Le gestionnaire peut obtenir la liste des contacts dans les entreprises. On peut filtrer cette liste en fonction :</p>
            <ul>
                <li>du nom du contact ;</li>
                <li>du pr�nom du contact ;</li>
                <li>du num�ro de t�l�phone ;</li>
                <li>du num�ro de fax.</li>
            </ul>
            <figure>
                    <a href="#image_liste_contact" onclick="cacheOuMontre('image_liste_contact', false);"><img src="liste_contact.png" alt="Obtenir la liste des contacts" width="50%"/></a>
                    <figcaption>Obtenir la liste des contacts<a href="#image_liste_contact" onclick="cacheOuMontre('image_liste_contact', false);"><img src="../../images/magnify.png"/></a></figcaption>
            </figure>
    
            
            
            
        </section>
	
</article>

<?php

IHM_Generale::endHeader(false);

?>

<aside id="image_liste_offre_stage" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_liste_offre_stage" onclick="cacheOuMontre('image_liste_offre_stage', false);"><img src="liste_offre_stage.png" width="80%"></a>
		<figcaption>S�lection des offres de stage</figcaption>
	<figure>
</aside>

<aside id="image_liste_ancien_stage" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_liste_ancien_stage" onclick="cacheOuMontre('image_liste_ancien_stage', false);"><img src="liste_ancien_stage.png" width="80%"></a>
		<figcaption>S�lection des offres de stage</figcaption>
	<figure>
</aside>

<aside id="image_valider_stage" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_valider_stage" onclick="cacheOuMontre('image_valider_stage', false);"><img src="valider_stage.png" width="80%"></a>
		<figcaption>Validation d'un sujet de stage</figcaption>
	<figure>
</aside>

<aside id="image_deposer_document" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_deposer_document" onclick="cacheOuMontre('image_deposer_document', false);"><img src="deposer_document.png" width="80%"></a>
		<figcaption>D�poser un document</figcaption>
	<figure>
</aside>

<aside id="image_liste_stagiaire" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_liste_stagiaire" onclick="cacheOuMontre('image_liste_stagiaire', false);"><img src="liste_stagiaire.png" width="80%"></a>
		<figcaption>Obtenir la liste des stagiaires</figcaption>
	<figure>
</aside>

<aside id="image_synthese_stagiaire" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_synthese_stagiaire" onclick="cacheOuMontre('image_synthese_stagiaire', false);"><img src="synthese_stagiaire.png" width="80%"></a>
		<figcaption>Synth�se et calendrier des soutenances</figcaption>
	<figure>
</aside>

<aside id="image_deposer_offre" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_deposer_offre" onclick="cacheOuMontre('image_deposer_offre', false);"><img src="deposer_offre.png" width="80%"></a>
		<figcaption>D�poser une offre de stage</figcaption>
	<figure>
</aside>

<aside id="image_dates_soutenance" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_dates_soutenance" onclick="cacheOuMontre('image_dates_soutenance', false);"><img src="dates_soutenance.png" width="80%"></a>
		<figcaption>Obtenir les dates des p�riodes des soutenances</figcaption>
	<figure>
</aside>

<aside id="image_planning_salle" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_planning_salle" onclick="cacheOuMontre('image_planning_salle', false);"><img src="planning_salle.png" width="80%"></a>
		<figcaption>Obtenir le planning par salle et par date</figcaption>
	<figure>
</aside>

<aside id="image_planning_diplome" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_planning_diplome" onclick="cacheOuMontre('image_planning_diplome', false);"><img src="planning_diplome.png" width="80%"></a>
		<figcaption>Obtenir le planning par dipl�me</figcaption>
	<figure>
</aside>

<aside id="image_planning_enseignant" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_planning_enseignant" onclick="cacheOuMontre('image_planning_enseignant', false);"><img src="planning_enseignant.png" width="80%"></a>
		<figcaption>Obtenir le planning par enseignant</figcaption>
	<figure>
</aside>

<aside id="image_gestion_base" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_gestion_base" onclick="cacheOuMontre('image_gestion_base', false);"><img src="gestion_base.png" width="80%"></a>
		<figcaption>Supprimer des informations de la base de donn�es</figcaption>
	<figure>
</aside>

<aside id="image_liste_entreprise" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_liste_entreprise" onclick="cacheOuMontre('image_liste_entreprise', false);"><img src="liste_entreprise.png" width="80%"></a>
		<figcaption>Obtenir la liste des entreprises</figcaption>
	<figure>
</aside>

<aside id="image_saisir_entreprise" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_saisir_entreprise" onclick="cacheOuMontre('image_saisir_entreprise', false);"><img src="saisir_entreprise.png" width="80%"></a>
		<figcaption>Saisir une entreprise</figcaption>
	<figure>
</aside>

<aside id="image_liste_entreprise_supp_mod" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_liste_entreprise_supp_mod" onclick="cacheOuMontre('image_liste_entreprise_supp_mod', false);"><img src="liste_entreprise_supp_mod.png" width="80%"></a>
		<figcaption>Liste des entreprises � supprimer ou modifier</figcaption>
	<figure>
</aside>

<aside id="image_liste_contact" hidden class="image_aide_en_ligne_detaillee">
	<figure>
		<a href="#image_liste_contact" onclick="cacheOuMontre('image_liste_contact', false);"><img src="liste_contact.png" width="80%"></a>
		<figcaption>Obtenir la liste des contacts</figcaption>
	<figure>
</aside>

<?php

IHM_Generale::footer("../../");

?>
