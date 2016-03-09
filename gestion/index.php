<?php
$chemin = "../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");
include_once($chemin . "bdd/Tache_BDD.php");
include_once($chemin . "moteur/Tache.php");

header ("Content-type:text/html; charset=utf-8");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
IHM_Generale::header("Gestion des ", "stages", "../", $tabLiens);
?>

<div id="menuGestion">
    <ul id="ongletsGestion">
	<li id="li_onglet1" class="active"><a href="#" onclick="cacheOuMontre('onglet1')"> T?ches </a></li>
	<li id="li_onglet2"><a href="#" onclick="cacheOuMontre('onglet2')"> Outils </a></li>
    </ul>
</div>

<br/>

<div id="onglet1">
    <table id="menuBdd">
	<tr>
	    <td id="titreMenuBdd">
		T?ches
	    </td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
	    <td align="center">
		<table>
		    <tr>
			<th>Intitul?</th>
			<th>Priorit?</th>
			<th>Statut</th>
			<th>Date limite</th>
		    </tr>
		    <td>&nbsp;</td>
		    <?php
			foreach (Tache::listerTaches() as $oTache) {
			    switch ($oTache->getStatut()) {
			        case 'Finie' : $sStatut = "<img alt='T?che finie' src='../images/action_check.png'/>"; break;
				case 'En cours' : $sStatut = "<img alt='T?che en cours' src='../images/action_remove.png'/>"; break;
				case 'Finie' : $sStatut = "<img alt='T?che pas faite' src='../images/action_delete.png'/>"; break;
				default : $sStatut = "<img alt='T?che pas faite' src='../images/action_delete.png'/>";
			    }

			    setlocale(LC_TIME, "fr_FR", "fr");
			    $sDateLimite = strftime('%A %e %B %Y', strtotime($oTache->getDateLimite()));

			    $sTache = "<td align=center>" . $oTache->getIntitule() . "</td><td align=center>" . $oTache->getPriorite() . "</td><td align=center>$sStatut</td><td align=center>$sDateLimite</td>";
			    printf("<tr>%s</tr>", $sTache);
			}
		    ?>
		</table>
	    </td>
	</tr>
    </table>
</div>

<div id="onglet2" hidden>
    <table>
	<tr>
	    <td>
		<table id="menuBdd">
		    <tr>
			<td id="titreMenuBdd">
			    Gestion de la base
			</td>
		    </tr>
		    <tr>
			<td>
			    <ul>
				<li><a href="./gestion/videroffrestage.php">Supprimer les anciennes offres</a></li>
				<li><a href="./gestion/vidersujetstage.php">Supprimer les anciennes validations</a></li>
				<li><a href="./gestion/viderfluxrss.php">Vider le flux RSS</a></li>
				<li><a href="./gestion/editiontache.php">Gestion des t?ches</a></li>
				<li><a href="./gestion/browser/index.php">Gestion des documents</a></li>
				<li><a href="./gestion/exporterBDD.php">Exporter la base de donn?es</a></li>

			    </ul>
			</td>
		    </tr>
		</table>

		<table id="menuBdd">
		    <tr>
			<td id="titreMenuBdd">
			    Gestion des entreprises
			</td>
		    </tr>
		    <tr>
			<td>
			    <ul>
			    <li><a href="./entreprises/saisirTypeEntreprise.php">Saisir un type d'entreprise</a></li><br/>
				<li><a href="./entreprises/modifierTypeEntreprise.php">Modifier/Supprimer un type d'entreprise</a></li><br/>
				<li><a href="./entreprises/listeDesEntreprises.php">Liste des entreprises</a></li>
				<li><a href="./entreprises/saisirEntreprise.php">Saisir une entreprise</a></li>
				<li><a href="./entreprises/modifierListeEntreprises.php">Modifier/Supprimer une entreprise</a></li><br/>
				<li><a href="./entreprises/listeDesContacts.php">Liste des contacts</a></li>
				<li><a href="./entreprises/saisirContact.php">Saisir un contact</a></li>
				<li><a href="./entreprises/modifierListeContacts.php">Modifier/Supprimer un contact</a></li><br/>
				<li><a href="./entreprises/listeDesOffreDeStage.php">Valider des offres de stage</a></li><br/>
				<li><a href="./entreprises/gestionCompetence.php">Gestion des comp?tences</a></li>
			    </ul>
			</td>
		    </tr>
		</table>

		<table id="menuBdd">
		    <tr>
			<td id="titreMenuBdd">
			    Gestion taxe apprentissage
			</td>
		    </tr>
		    <tr>
			<td>
			    <ul>
				<li><a href="./taxeapprentissage/listeEtiquetteEntreprises.php">Etiquettes des entreprises</a></li>
			    </ul>
			</td>
		    </tr>
		</table>
	    </td>

	    <td>
		<table id="menuBdd">
		    <tr>
			<td id="titreMenuBdd">
			    Gestion des promotions
			</td>
		    </tr>
		    <tr>
			<td>
			    <ul>
				<li><a href="./promotions/listeDesEtudiants.php">Liste des ?tudiants</a></li><br />
				<li><a href="./promotions/ajouterPromotion.php">Ajouter une promotion</a></li>
				<li><a href="./promotions/modifierPromotion.php">Modifier une promotion</a></li>
				<li><a href="./promotions/suiviPromotion.php">Suivre la promotion</a></li><br />
			    </ul>
			</td>
		    </tr>
		</table>
		<table id="menuBdd">
		    <tr>
			<td id="titreMenuBdd">
			    Gestion des ?tudiants
			</td>
		    </tr>
		    <tr>
			<td>
			    <ul>
				<li><a href="./etudiants/consulterSDS.php">Consulter les sujets valid?s</a></li>
				<li><a href="./etudiants/validerSDS.php">Valider une sujet de stage</a></li><br/>
				<li><a href="./etudiants/supprimerEtudiant.php">Supprimer un ?tudiant</a></li>
			    </ul>
			</td>
		    </tr>
		</table>
		<table id="menuBdd">
		    <tr>
			<td id="titreMenuBdd">
			    Gestion des r?f?rents
			</td>
		    </tr>
		    <tr>
			<td>
			    <ul>
				<li><a href="./parrains/saisie_parrains.php">Saisir un r?f?rent</a></li>
				<li><a href="./parrains/ms_parrains.php">Modifier/Supprimer un r?f?rent</a></li><br />
				<li><a href="./parrains/saisie_couleur.php">Saisir une couleur</a></li>
				<li><a href="./parrains/ms_couleur.php">Modifier/Supprimer une couleur</a></li>
			    </ul>
			</td>
		    </tr>
		</table>
	    </td>

	    <td>
		<table id="menuBdd">
		    <tr>
			<td id="titreMenuBdd">
			    Gestion des conventions
			</td>
		    </tr>
		    <tr>
			<td>
			    <ul>
				<li><a href="./conventions/saisirThemeDeStage.php">Saisir un th?me de stage</a></li>
				<li><a href="./conventions/modifierThemeDeStage.php">Modifier/Supprimer un th?me de stage</a></li><br/>
				<li><a href="./conventions/saisirConvention.php">Saisir une convention</a></li>
				<li><a href="./conventions/modifierListeConventions.php">Modifier/Supprimer une convention</a></li>
				<li><a href="./conventions/saisirNotesStages.php">Saisir des notes de stages</a></li><br/>
				<li><a href="./conventions/rattacherResumes.php">Rattacher des r?sum?s</a></li><br/>
				<li><a href="./conventions/bilanConventions.php">Bilan des conventions</a></li><br/>
			    </ul>
			</td>
		    </tr>
		</table>
		<table id="menuBdd">
		    <tr>
			<td id="titreMenuBdd">
			    Gestion des soutenances
			</td>
		    </tr>
		    <tr>
			<td>
			    <ul>
				<li><a href="./soutenances/saisirSalle.php">Saisir une salle</a></li>
				<li><a href="./soutenances/modifierSalle.php">Modifier les salles</a></li><br/>
				<li><a href="./soutenances/saisirDate.php">Saisir une date</a></li>
				<li><a href="./soutenances/modifierDate.php">Modifier les dates</a></li><br/>
				<li><a href="./soutenances/planifier.php">Planifier les soutenances</a></li>
				<li><a href="./promotions/modifierTempsSoutenance.php">Modifier une durée de soutenance</a></li>
			    </ul>
			</td>
		    </tr>
		</table>
		<table id="menuBdd">
		    <tr>
			<td id="titreMenuBdd">
			    Statistiques
			</td>
		    </tr>
		    <tr>
			<td>
			    <ul>
				<li><a href="./statistiques/classementEntreprise.php">Top entreprises</a></li>
				<li><a href="./statistiques/statistiques.php">Visualiser statistiques</a></li>
			    </ul>
			</td>
		    </tr>
		</table>
	    </td>
	</tr>
    </table>
</div>

<br/>

<center><a href="./manuel/manuel.php">Manuel d'utilisation en ligne</a></center>

<script>
    // R?cup?ration de la valeur stock?e localement sur le client
    if (!localStorage.getItem('onglet'))
	localStorage.setItem('onglet', 'onglet1');

    // La pile des onglets
    var anciensOnglets = ['onglet1'];

    // Montre ou cache un onglet
    var cacheOuMontre = function(onglet) {
	ancienOnglet = anciensOnglets.pop();
	if (onglet != ancienOnglet) {

	    // Cache l'ancien
	    anciensOnglets.push(ancienOnglet);
	    if (ancienOnglet) {
		document.getElementById(ancienOnglet).hidden = true;
		document.getElementById("li_" + ancienOnglet).className = null;
	    }

	    // Montre le nouvel onglet
	    document.getElementById(onglet).hidden = false;
	    document.getElementById("li_" + onglet).className = "active";

	    // Stocke localement l'onglet courant
	    localStorage.setItem('onglet', onglet);

	    anciensOnglets.push(onglet);
	} else {
	    anciensOnglets.push(onglet);
	}
    }

    cacheOuMontre(localStorage.getItem('onglet'));
</script>

<?php
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>
