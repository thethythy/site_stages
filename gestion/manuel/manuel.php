<?php
include_once("./../../classes/bdd/connec.inc");
include_once("./../../classes/ihm/IHM_Generale.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Aide", "en ligne", "../../", $tabLiens);
?>

<script>
    // Centrer un élément en position absolue
    var centerAside = function (element) {
	var height = document.getElementById(element).offsetHeight; //hauteur de l'élément à positionner
	var width = document.getElementById(element).offsetWidth; //largeur de l'élément à positionner
	var myParent = document.getElementById(element).parentNode;
	var pHeight = myParent.offsetHeight; //Hauteur de l'élément parent
	var pWidth = myParent.offsetWidth; //Largeur de l'élément parent
	var sTop = myParent.scrollTop; //Hauteur de défilement de l'élément parent
	var sLeft = myParent.scrollLeft; //Longueur de défilement de l'élément parent
	var posY = (pHeight / 2) - (height / 2) + sTop; //Calcul de la position en Y
	var posX = (pWidth / 2) - (width / 2) + sLeft; //Calcul de la position en X
	document.getElementById(element).style.top = posY + "px";
	document.getElementById(element).style.left = posX + "px";
    }

    // La pile des articles
    var anciensArticles = new Array();

    // Montre ou cache un article
    var cacheOuMontre = function (article, clarifie_fond) {
	ancienArticle = anciensArticles.pop();
	if (article != ancienArticle) {
	    // Cache l'ancien
	    anciensArticles.push(ancienArticle);
	    if (clarifie_fond && ancienArticle)
		document.getElementById(ancienArticle).hidden = true;
	    if (!clarifie_fond)
		document.getElementById("content-wrap").style.opacity = 0.3;
	    // Montre le nouvel article en le centrant
	    document.getElementById(article).hidden = false;
	    if (!clarifie_fond)
		centerAside(article);
	    anciensArticles.push(article);
	} else if (document.getElementById(article).hidden == false) {
	    // Cache l'article car il déjà visible
	    document.getElementById(article).hidden = true;
	    if (!clarifie_fond)
		document.getElementById("content-wrap").style.opacity = 1;
	}
    }
</script>

<article class="aide_en_ligne_detaillee">

    <section>
	<h1><a href="<?php echo $baseSite; ?>stagiaire/">Stagiaire</a></h1>
	<p>Cette partie est utilisée par les étudiants.</p>
	<p>Elle permet les actions suivantes :</p>
	<ul>
	    <li>consulter des offres de stage actuelles</a> ;</li>
	    <li>consulter les anciens stages et les entreprises ;</li>
	    <li>valider un sujet de stage ;</li>
	    <li>déposer des documents.</li>
	</ul>
	<footer><a href="#article_stagiaire" onclick="cacheOuMontre('article_stagiaire', true);">En savoir plus</a></footer>
	<hr/>
    </section>

    <section>
	<h1><a href="<?php echo $baseSite; ?>parrainage/">Enseignants référents</a></h1>
	<p>Cette partie du site est utilisée par les enseignants.</p>
	<p>Elle permet les actions suivantes :</p>
	<ul>
	    <li>obtenir la liste détaillée des stagiaires suivis par l'enseignant ;</li>
	    <li>obtenir une synthèse par enseignant.</li>
	</ul>
	<footer><a href="#article_enseignant"onclick="cacheOuMontre('article_enseignant', true);">En savoir plus</a></footer>
	<hr/>
    </section>

    <section>
	<h1><a href="<?php echo $baseSite; ?>entreprise/">Déposer une offre de stage</a></h1>
	<p>Cette partie permet au entreprise de déposer les offres de stage.</p>
	<footer><a href="#article_entreprise"onclick="cacheOuMontre('article_entreprise', true);">En savoir plus</a></footer>
	<hr/>
    </section>

    <section>
	<h1><a href="<?php echo $baseSite; ?>soutenances/">Soutenances</a></h1>
	<p>Cette partie du site permet d'accéder aux plannings des soutenances.</p>
	<p>Elle permet les actions suivantes :</p>
	<ul>
	    <li>connaître les périodes de soutenances ;</li>
	    <li>connaître les plannings par salle ;</li>
	    <li>connaître les plannings par diplôme ;</li>
	    <li>connaître les plannings par enseignant.</li>
	</ul>
	<footer><a href="#article_soutenance"onclick="cacheOuMontre('article_soutenance', true);">En savoir plus</a></footer>
	<hr/>
    </section>

    <section>
	<h1><a href="<?php echo $baseSite; ?>gestion/">Gestion des stages</a></h1>
	<p>Cette partie du site est réservée au responsable en charge des stages.</p>
	<p>Elle permet les actions suivantes :</p>
	<ul>
	    <li>gérer la base de données (limité à certaines actions) ;</li>
	    <li>gérer les entreprises, les contacts et la diffusion des offres ;</li>
	    <li>gérer les promotions d'étudiants ;</li>
	    <li>gérer la validation des sujets de stage ;</li>
	    <li>gérer les enseignants référents ;</li>
	    <li>gérer les conventions ;</li>
	    <li>gérer les soutenances ;</li>
	    <li>obtenir les étiquettes pour la TA ;</li>
	    <li>obtenir des statistiques (non disponible).</li>
	</ul>
	<footer><a href="#article_gestion"onclick="cacheOuMontre('article_gestion', true);">En savoir plus</a></footer>
    </section>

</article>

<article id="article_stagiaire" hidden class="article_aide_en_ligne_detaillee">

    <header><h1>Outils pour les étudiants</h1></header>

    <section>
	<header><h2>Consulter des offres de stage</h2></header>
	<p>L'étudiant dispose d'un outil de consultation des offres de stage. Cet outil permet de sélectionner un stage selon les critères suivants :</p>
	<ul>
	    <li>nom de l'entreprise ;</li>
	    <li>lieu du stage (n° de département ou code postal ou ville ou pays) ;</li>
	    <li>le diplôme et/ou la spécialité ;</li>
	    <li>la durée ;</li>
	    <li>les domaines ou technologies attendues.</li>
	</ul>
	<p>Les étudiants sont informés par mail de chaque nouvelle offre disponible sur le site. Un flux RSS<a href='http://info-stages.univ-lemans.fr/flux/fluxrss.xml' title='Suivez les offres de stage'><img src='../../images/feed.png' align='center' alt='Flux RSS' /></a> est aussi disponible sur la page d'accueil du site.</p>
	<figure>
	    <a href="#image_liste_offre_stage" onclick="cacheOuMontre('image_liste_offre_stage', false);"><img src="liste_offre_stage.png" alt="Sélection des offres de stage." width="50%"/></a>
	    <figcaption>Sélection des offres de stage<a href="#image_liste_offre_stage" onclick="cacheOuMontre('image_liste_offre_stage', false);"><img src="../../images/magnify.png"/></a></figcaption>
	</figure>
    </section>

    <section>
	<header><h2>Consulter les anciens stages et les entreprises</h2><header>
		<p>L'étudiant dispose d'un outil de consultation des anciens stages. Il a ainsi accès aux entreprises ayant déjà pris des stagiaires les années passées. Cet outil permet de chercher les anciens stages selon les critères suivants :</p>
		<ul>
		    <li>année du stage ;</li>
		    <li>le diplôme et/ou la spécialité.</li>
		</ul>
		<p>Chaque ancien stage est décrit par un résumé accessible dans le tableau résultat de la sélection.</p>
		<figure>
		    <a href="#image_liste_ancien_stage" onclick="cacheOuMontre('image_liste_ancien_stage', false);"><img src="liste_ancien_stage.png" alt="Sélection des anciens stages." width="50%"/></a>
		    <figcaption>Sélection des anciens stages<a href="#image_liste_ancien_stage" onclick="cacheOuMontre('image_liste_ancien_stage', false);"><img src="../../images/magnify.png"/></a></figcaption>
		</figure>
		</section>

		<section>
		    <header><h2>Valider un sujet de stage</h2></header>
		    <p>L'étudiant dispose d'un outil pour valider un sujet de stage. Cet outil informe le responsable des stages par email d'une nouvelle demande de validation.</p>
		    <p>Pour faire une demande de validation, l'étudiant doit sélectionner :</p>
		    <ul>
			<li>l'année universitaire ;</li>
			<li>le diplôme et/ou la spécialité ;</li>
			<li>son nom dans la liste déroulante ;</li>
			<li>un fichier décrivant le sujet ou saisir directement cette description dans la zone d'édition.</li>
		    </ul>
		    <p>L'étudiant doit ensuite enregistrer la demande de validation avec le bouton "Enregistrer".</p>
		    <figure>
			<a href="#image_valider_stage" onclick="cacheOuMontre('image_valider_stage', false);"><img src="valider_stage.png" alt="Faire une demande de validation d'un stage." width="50%"/></a>
			<figcaption>Validation d'un sujet de stage<a href="#image_valider_stage" onclick="cacheOuMontre('image_valider_stage', false);"><img src="../../images/magnify.png"/></a></figcaption>
		    </figure>
		</section>

		<section>
		    <header><h2>Déposer un document</h2></header>
		    <p>L'étudiant dispose d'un outil pour déposer des documents sur le site. Il peut déposer un rapport de stage et un résumé du rapport de stage.</p>
		    <p>Chaque document déposé est mis à disposition de l'enseignant-référent qui est mis au courant par mail automatique contenant un lien vers ce document.</p>
		    <p>Pour déposer un document, l'étudiant doit sélectionner :</p>
		    <ul>
			<li>l'année universitaire ;</li>
			<li>le diplôme et/ou la spécialité ;</li>
			<li>son nom dans la liste déroulante ;</li>
			<li>le nom de l'enseignant qui recevra la notification de dépôt ;</li>
			<li>le fichier à déposer (rapport de stage ou résumé du stage).</li>
		    </ul>
		    <p>L'étudiant doit ensuite valider le formulaire soit avec le bouton "Déposer le rapport" soit avec le bouton "Déposer le résumé".</p>
		    <figure>
			<a href="#image_deposer_document" onclick="cacheOuMontre('image_deposer_document', false);"><img src="deposer_document.png" alt="Déposer un document." width="50%"/></a>
			<figcaption>Déposer un document<a href="#image_deposer_document" onclick="cacheOuMontre('image_deposer_document', false);"><img src="../../images/magnify.png"/></a></figcaption>
		    </figure>
		</section>

		</article>

		<article id="article_enseignant" hidden class="article_aide_en_ligne_detaillee">

		    <header><h1>Outils pour les enseignants</h1></header>

		    <section>
			<header><h2>Obtenir la liste des stagiaires</h2></header>
			<p>L'enseignant dispose d'un outil pour obtenir la liste des stagiaires qu'il suit. Cet outil permet de sélectionner les stagiaires selon les critères suivants :</p>
			<ul>
			    <li>l'année universitaire ;</li>
			    <li>le diplôme et/ou la spécialité du stagiaire ;</li>
			    <li>le nom de l'enseignant.</li>
			</ul>
			<figure>
			    <a href="#image_liste_stagiaire" onclick="cacheOuMontre('image_liste_stagiaire', false);"><img src="liste_stagiaire.png" alt="Sélection des stagiaires suivis." width="50%"/></a>
			    <figcaption>Sélection des stagiaires<a href="#image_liste_stagiaire" onclick="cacheOuMontre('image_liste_stagiaire', false);"><img src="../../images/magnify.png"/></a></figcaption>
			</figure>
		    </section>

		    <section>
			<header><h2>Obtenir une synthèse</h2></header>
			<p>L'enseignant dispose d'un outil pour obtenir une synthèse de tous les stagiaires qu'il suit par diplôme. Cet outil permet de sélectionner les stagiaires selon les critères suivants :</p>
			<ul>
			    <li>l'année universitaire ;</li>
			    <li>le diplôme et/ou la spécialité du stagiaire ;</li>
			    <li>le nom de l'enseignant.</li>
			</ul>
			<p>L'enseignant a accès également au planning des soutenances au format iCalendar (soit par abonnement soit par fichier).</p>
			<figure>
			    <a href="#image_synthese_stagiaire" onclick="cacheOuMontre('image_synthese_stagiaire', false);"><img src="synthese_stagiaire.png" alt="Synthèse et calendrier des soutenances" width="50%"/></a>
			    <figcaption>Synthèse et calendrier des soutenances<a href="#image_synthese_stagiaire" onclick="cacheOuMontre('image_synthese_stagiaire', false);"><img src="../../images/magnify.png"/></a></figcaption>
			</figure>
		    </section>

		</article>

		<article id="article_entreprise" hidden class="article_aide_en_ligne_detaillee">
		    <header><h1>Outils pour les entreprises</h1></header>
		    <section>
			<header><h2>Déposer une offre de stage</h2></header>
			<p>Les entreprises peuvent saisir des offres de stage. Ces offres seront validées par le responsable des stages qui est automatiquement averti par mail.</p>
			<p>Une fois validée, ces offres seront disponibles sur le site. Les étudiants seront aussi avertis par mail. Le flux RSS sera également mis à jour.</p>
			<p>Pour saisir une offre de stage, l'entreprise doit saisir les informations suivantes :</p>
			<ul>
			    <li>sur le stage :
				<ul>
				    <li>le titre de l'offre ;</li>
				    <li>le sujet ;</li>
				    <li>la ou les compétences attendues ;</li>
				    <li>le ou les environnements de travail si ils sont connus ;</li>
				    <li>le ou les diplômes de l'étudiant souhaités ;</li>
				    <li>la durée du stage (minimum et maximum) ;</li>
				    <li>le montant de la rémunération mensuelle ;</li>
				    <li>divers remarques si nécessaire ;</li>
				</ul>
			    </li>
			    <li>sur l'entreprise :
				<ul>
				    <li>le nom ;</li>
				    <li>l'adresse ;</li>
				    <li>la ville ;</li>
				    <li>le code postal ;</li>
				    <li>le pays ;</li>
				    <li>email du DRH ou équivalent ;</li>
				</ul>
			    </li>
			    <li>sur le contact dans l'entreprise
				<ul>
				    <li>le nom du contact ;</li>
				    <li>le prénom du contact ;</li>
				    <li>le numéro de téléphone ;</li>
				    <li>le numéro de fax ;</li>
				    <li>l'email du contact.</li>
				</ul>
			    </li>
			</ul>
			<figure>
			    <a href="#image_deposer_offre" onclick="cacheOuMontre('image_deposer_offre', false);"><img src="deposer_offre.png" alt="Déposer une offre de stage" width="50%"/></a>
			    <figcaption>Déposer une offre de stage<a href="#image_deposer_offre" onclick="cacheOuMontre('image_deposer_offre', false);"><img src="../../images/magnify.png"/></a></figcaption>
			</figure>
		    </section>
		</article>

		<article id="article_soutenance" hidden class="article_aide_en_ligne_detaillee">

		    <header><h1>Soutenances</h1></header>

		    <section>
			<header><h2>Connaître les dates de soutenances</h2></header>
			<p>Un tableau présente les dates des périodes des soutenances.</p>
			<figure>
			    <a href="#image_dates_soutenance" onclick="cacheOuMontre('image_dates_soutenance', false);"><img src="dates_soutenance.png" alt="Obtenir les dates des périodes des soutenances" width="50%"/></a>
			    <figcaption>Obtenir les dates des périodes des soutenances<a href="#image_dates_soutenance" onclick="cacheOuMontre('image_dates_soutenance', false);"><img src="../../images/magnify.png"/></a></figcaption>
			</figure>
		    </section>

		    <section>
			<header><h2>Connaître les plannings par salle</h2></header>
			<p>Un tableau présente le planning d'occupation des salles.</p>
			<p>L'utilisateur sélectionne la salle et la date.</p>
			<figure>
			    <a href="#image_planning_salle" onclick="cacheOuMontre('image_planning_salle', false);"><img src="planning_salle.png" alt="Obtenir le planning d'une salle" width="50%"/></a>
			    <figcaption>Obtenir le planning d'une salle<a href="#image_planning_salle" onclick="cacheOuMontre('image_planning_salle', false);"><img src="../../images/magnify.png"/></a></figcaption>
			</figure>
		    </section>

		    <section>
			<header><h2>Connaître les plannings par diplôme</h2></header>
			<p>Un tableau présente le planning par diplôme. L'utilisateur sélectionne le diplôme voulu.</p>
			<figure>
			    <a href="#image_planning_diplome" onclick="cacheOuMontre('image_planning_diplome', false);"><img src="planning_diplome.png" alt="Obtenir le planning des soutenances par diplôme" width="50%"/></a>
			    <figcaption>Obtenir le planning des soutenances par diplôme<a href="#image_planning_diplome" onclick="cacheOuMontre('image_planning_diplome', false);"><img src="../../images/magnify.png"/></a></figcaption>
			</figure>
		    </section>

		    <section>
			<header><h2>Connaître les plannings par enseignant</h2></header>
			<p>Un tableau présente le planning par enseignant. L'utilisateur sélectionne l'enseignant recherché.</p>
			<figure>
			    <a href="#image_planning_enseignant" onclick="cacheOuMontre('image_planning_enseignant', false);"><img src="planning_enseignant.png" alt="Obtenir le planning des soutenances par diplôme" width="50%"/></a>
			    <figcaption>Obtenir le planning des soutenances par enseignant<a href="#image_planning_enseignant" onclick="cacheOuMontre('image_planning_enseignant', false);"><img src="../../images/magnify.png"/></a></figcaption>
			</figure>
		    </section>

		</article>

		<article id="article_gestion" hidden class="article_aide_en_ligne_detaillee">

		    <header><h1>Gestion des stages</h1></header>

		    <section>
			<header><h2>Gérer la base</h2></header>
			<p>Les actions sur la base de données sont restreintes aux actions suivantes :</p>
			<ul>
			    <li>Supprimer les anciennes offres accessibles aux étudiants ;</li>
			    <li>Supprimer les anciennes validations demandées par les étudiants ;</li>
			    <li>Vider le flux RSS de l'année précédente.</li>
			</ul>
			<p>Afin de supprimer toutes suppressions accidentelles, ces trois actions sont accessibles uniquement durant les mois de septembre et octobre de l'année en cours.</p>
			<figure>
			    <a href="#image_gestion_base" onclick="cacheOuMontre('image_gestion_base', false);"><img src="gestion_base.png" alt="Supprimer des informations de la base de données" width="50%"/></a>
			    <figcaption>Supprimer des informations de la base de données<a href="#image_gestion_base" onclick="cacheOuMontre('image_gestion_base', false);"><img src="../../images/magnify.png"/></a></figcaption>
			</figure>
		    </section>

		    <section>
			<header>
			    <h2>Gérer les entreprises</h2>
			    <h3>Obtenir la liste des entreprises</h3>
			</header>
			<p>Le gestionnaire peut obtenir la liste des entreprises enregistrées dans la base. On peut filtrer cette liste en fonction :</p>
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
			<p>Le gestionnaire peut ajouter une nouvelle entreprise à la base. Pour cela il doit saisir les informations suivantes :</p>
			<ul>
			    <li>le nom de l'entreprise ;</li>
			    <li>le code postal ;</li>
			    <li>l'adresse ;</li>
			    <li>la ville ;</li>
			    <li>l'email du DRH ou son équivalent (non obligatoire) ;</li>
			    <li>le pays.</li>
			</ul>
			<p>Si l'entreprise n'existe pas encore dans la base (vérification sur le nom, la ville et le pays), elle est ajoutée à la base sinon un message d'erreur est affiché et l'ajout échoue.</p>
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
			<p>Pour supprimer une entreprise, cliquez sur l'icône en forme de croix <img src="../../images/action_delete.png"/>. Attention, <strong>aucune vérification</strong> n'est ici effectuée. L'entreprise sera supprimée même si elle est liée à un contact ou à une convention de stage existante par exemple.</p>
			<p>Pour éditer une entreprise, cliquez sur l'icône en forme de crayon <img src="../../images/reply.png"/>. Une fenêtre d'édition (identique à la fenêtre de saisie) est affichée.</p>

			<header><h3>Obtenir la liste des contacts</h3></header>
			<p>Le gestionnaire peut obtenir la liste des contacts dans les entreprises. On peut filtrer cette liste en fonction :</p>
			<ul>
			    <li>du nom du contact ;</li>
			    <li>du prénom du contact ;</li>
			    <li>du numéro de téléphone ;</li>
			    <li>du numéro de fax.</li>
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
			<figcaption>Sélection des offres de stage</figcaption>
		    </figure>
		</aside>

		<aside id="image_liste_ancien_stage" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_liste_ancien_stage" onclick="cacheOuMontre('image_liste_ancien_stage', false);"><img src="liste_ancien_stage.png" width="80%"></a>
			<figcaption>Sélection des offres de stage</figcaption>
		    </figure>
		</aside>

		<aside id="image_valider_stage" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_valider_stage" onclick="cacheOuMontre('image_valider_stage', false);"><img src="valider_stage.png" width="80%"></a>
			<figcaption>Validation d'un sujet de stage</figcaption>
		    </figure>
		</aside>

		<aside id="image_deposer_document" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_deposer_document" onclick="cacheOuMontre('image_deposer_document', false);"><img src="deposer_document.png" width="80%"></a>
			<figcaption>Déposer un document</figcaption>
		    </figure>
		</aside>

		<aside id="image_liste_stagiaire" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_liste_stagiaire" onclick="cacheOuMontre('image_liste_stagiaire', false);"><img src="liste_stagiaire.png" width="80%"></a>
			<figcaption>Obtenir la liste des stagiaires</figcaption>
		    </figure>
		</aside>

		<aside id="image_synthese_stagiaire" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_synthese_stagiaire" onclick="cacheOuMontre('image_synthese_stagiaire', false);"><img src="synthese_stagiaire.png" width="80%"></a>
			<figcaption>Synthèse et calendrier des soutenances</figcaption>
		    </figure>
		</aside>

		<aside id="image_deposer_offre" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_deposer_offre" onclick="cacheOuMontre('image_deposer_offre', false);"><img src="deposer_offre.png" width="80%"></a>
			<figcaption>Déposer une offre de stage</figcaption>
		    </figure>
		</aside>

		<aside id="image_dates_soutenance" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_dates_soutenance" onclick="cacheOuMontre('image_dates_soutenance', false);"><img src="dates_soutenance.png" width="80%"></a>
			<figcaption>Obtenir les dates des périodes des soutenances</figcaption>
		    </figure>
		</aside>

		<aside id="image_planning_salle" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_planning_salle" onclick="cacheOuMontre('image_planning_salle', false);"><img src="planning_salle.png" width="80%"></a>
			<figcaption>Obtenir le planning par salle et par date</figcaption>
		    </figure>
		</aside>

		<aside id="image_planning_diplome" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_planning_diplome" onclick="cacheOuMontre('image_planning_diplome', false);"><img src="planning_diplome.png" width="80%"></a>
			<figcaption>Obtenir le planning par diplôme</figcaption>
		    </figure>
		</aside>

		<aside id="image_planning_enseignant" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_planning_enseignant" onclick="cacheOuMontre('image_planning_enseignant', false);"><img src="planning_enseignant.png" width="80%"></a>
			<figcaption>Obtenir le planning par enseignant</figcaption>
		    </figure>
		</aside>

		<aside id="image_gestion_base" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_gestion_base" onclick="cacheOuMontre('image_gestion_base', false);"><img src="gestion_base.png" width="80%"></a>
			<figcaption>Supprimer des informations de la base de données</figcaption>
		    </figure>
		</aside>

		<aside id="image_liste_entreprise" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_liste_entreprise" onclick="cacheOuMontre('image_liste_entreprise', false);"><img src="liste_entreprise.png" width="80%"></a>
			<figcaption>Obtenir la liste des entreprises</figcaption>
		    </figure>
		</aside>

		<aside id="image_saisir_entreprise" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_saisir_entreprise" onclick="cacheOuMontre('image_saisir_entreprise', false);"><img src="saisir_entreprise.png" width="80%"></a>
			<figcaption>Saisir une entreprise</figcaption>
		    </figure>
		</aside>

		<aside id="image_liste_entreprise_supp_mod" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_liste_entreprise_supp_mod" onclick="cacheOuMontre('image_liste_entreprise_supp_mod', false);"><img src="liste_entreprise_supp_mod.png" width="80%"></a>
			<figcaption>Liste des entreprises à supprimer ou modifier</figcaption>
		    </figure>
		</aside>

		<aside id="image_liste_contact" hidden class="image_aide_en_ligne_detaillee">
		    <figure>
			<a href="#image_liste_contact" onclick="cacheOuMontre('image_liste_contact', false);"><img src="liste_contact.png" width="80%"></a>
			<figcaption>Obtenir la liste des contacts</figcaption>
		    </figure>
		</aside>

<?php
IHM_Generale::footer("../../");
?>
