<?php

class Gestion_IHM {

    /**
     * Afficher dans un onglet le tableau des tâches et dans un deuxième onglet
     * la page principale d'administration (back-office du site)
     * L'onglet actif est mémoriser en stockage local du navigateur
     */
    public static function afficherMenuGestion() {
	?>
	<center><a href="./manuel/manuel.php">Manuel d'utilisation</a></center>

	<div id="menuGestion">
	    <ul id="ongletsGestion">
		<li id="li_onglet1" class="active"><a href="#" onclick="cacheOuMontre('onglet1')"> Tâches </a></li>
		<li id="li_onglet2"><a href="#" onclick="cacheOuMontre('onglet2')"> Outils </a></li>
	    </ul>
	</div>

	<br/>

	<div id="onglet1">
	    <table id="menuBdd">
		<tr>
		    <td id="titreMenuBdd">
			Tâches
		    </td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		    <td align="center">
			<table>
			    <tr>
				<th>Intitulé</th>
				<th>Priorité</th>
				<th>Statut</th>
				<th>Date limite</th>
			    </tr>
			    <td>&nbsp;</td>
			    <?php
			    foreach (Tache::listerTaches() as $oTache) {
				switch ($oTache->getStatut()) {
				    case 'Finie' : $sStatut = "<img alt='Tâche finie' src='../images/action_check.png'/>";
					break;
				    case 'En cours' : $sStatut = "<img alt='Tâche en cours' src='../images/action_remove.png'/>";
					break;
				    case 'Finie' : $sStatut = "<img alt='Tâche pas faite' src='../images/action_delete.png'/>";
					break;
				    default : $sStatut = "<img alt='Tâche pas faite' src='../images/action_delete.png'/>";
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
				    Site
				</td>
			    </tr>
			    <tr>
				<td>
				    <ul>
					<li><a href="./gestion/gestionClef.php">Gérer la clef d'accès</a></li>
					<li><a href="./gestion/exporterBDD.php">Exporter la base</a></li>
					<li><a href='./gestion/phpInfo.php' target="_blank">Informations PHP</a></li>
          <li><a href="./couleurs/gestionCouleur.php">Gérer les couleurs</a></li>
				    </ul>
				</td>
			    </tr>
			</table>
			<table id="menuBdd">
			    <tr>
				<td id="titreMenuBdd">
				    Données
				</td>
			    </tr>
			    <tr>
				<td>
				    <ul>
					<li><a href="./gestion/viderfluxrss.php">Vider le flux RSS</a></li>
					<li><a href="./gestion/editiontache.php">Gestion des tâches</a></li>
					<li><a href="./gestion/browser/index.php">Gestion des documents</a></li>
				    </ul>
				</td>
			    </tr>
			</table>
      <table id="menuBdd">
          <tr>
        <td id="titreMenuBdd">
            Promotions
        </td>
          </tr>
          <tr>
        <td>
            <ul>
          <li><a href="./promotions/ajouterPromotion.php">Ajouter une promotion</a></li>
          <li><a href="./promotions/modifierPromotion.php">Modifier une promotion</a></li>
          <li><a href="./promotions/suiviPromotion.php">Suivre la promotion</a></li>
            </ul>
        </td>
          </tr>
      </table>
		    </td>

		    <td>
			<table id="menuBdd">
			    <tr>
				<td id="titreMenuBdd">
				    Etudiants
				</td>
			    </tr>
			    <tr>
				<td>
				    <ul>
					<li><a href="./etudiants/gestionEtudiants.php">Gérer les étudiants</a></li>
					<li><a href="./etudiants/gestionSujetDeStage.php">Gérer les demandes de validation</a></li>
          <li><a href="./gestion/vidersujetstage.php">Supprimer les validations</a></li>
				    </ul>
				</td>
			    </tr>
			</table>
			<table id="menuBdd">
			    <tr>
				<td id="titreMenuBdd">
				    Référents
				</td>
			    </tr>
			    <tr>
				<td>
				    <ul>
					<li><a href="./parrains/gestionParrain.php">Gérer les référents</a></li>
				    </ul>
				</td>
			    </tr>
			</table>
      <table id="menuBdd">
          <tr>
        <td id="titreMenuBdd">
            Stages
        </td>
          </tr>
          <tr>
        <td>
            <ul>
                 <li><a href="./entreprises/listeDesOffreDeStage.php">Valider/Editer des offres de stage</a></li>
                 <li><a href="">Supprimer des offres de stage</a></li>
            </ul>
        </td>
          </tr>
      </table>
      <table id="menuBdd">
          <tr>
        <td id="titreMenuBdd">
            Alternance
        </td>
          </tr>
          <tr>
        <td>
            <ul>
                <li><a href="./entreprises/listeDesOffreDAlternance.php">Valider/Editer des offres d'alternance</a></li>
                <li><a href="">Supprimer des offres d'alternance</a></li>
                <li><a href="./SuiviCandidatures/SuiviCandidatures.php">Suivi des démarches alternants</a></li>
                <li><a href="./exportation/exportListeContrat.php">Exporter étudiant/contrat</a></li>
            </ul>
        </td>
          </tr>
      </table>
		    </td>

		    <td>
			<table id="menuBdd">
			    <tr>
				<td id="titreMenuBdd">
				    Entreprises
				</td>
			    </tr>
			    <tr>
				<td>
				    <ul>
					<li><a href="./entreprises/gestionCompetence.php">Gérer des compétences</a></li>
					<li><a href="./entreprises/gestionTypeEntreprise.php">Gérer les types d'entreprise</a></li><br/>
					<li><a href="./entreprises/listeDesEntreprises.php">Lister les entreprises</a></li>
					<li><a href="./entreprises/saisirEntreprise.php">Saisir une entreprise</a></li>
					<li><a href="./entreprises/modifierListeEntreprises.php">Modifier/Supprimer une entreprise</a></li><br/>
					<li><a href="./entreprises/listeDesContacts.php">Lister les contacts</a></li>
					<li><a href="./entreprises/saisirContact.php">Saisir un contact</a></li>
					<li><a href="./entreprises/modifierListeContacts.php">Modifier/Supprimer un contact</a></li>
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
      					<li><a href="./statistiques/statistiquesEntreprise.php">Statistiques par entreprise</a></li><br/>
      					<li><a href="./statistiques/statistiquesStages.php">Statistiques stages</a></li>
                <li><a href="">Statistiques alternant</a></li>
				    </ul>
				</td>
			    </tr>
			</table>
			<table id="menuBdd">
			    <tr>
				<td id="titreMenuBdd">
				    Taxe apprentissage
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
				    Conventions/Contrats
				</td>
			    </tr>
			    <tr>
				<td>
				    <ul>
					<li><a href="./conventions/gestionThemeDeStage.php">Gérer les thèmes de stage</a></li><br/>

					<li><a href="./conventions/saisirConvention.php">Saisir une convention</a></li>
					<li><a href="./conventions/modifierListeConventions.php">Modifier/Supprimer une convention</a></li><br/>

          <li><a href="./contrats/saisirContrat.php">Saisir un contrat</a></li>
          <li><a href="./contrats/modifierListeContrat.php">Modifier/Supprimer un contrat</a></li><br/>

					<li><a href="./conventions/mailAttribution.php">Notifier les attributions</a></li><br/>
					<li><a href="./conventions/saisirNotesStages.php">Saisir des notes de stages</a></li>
					<li><a href="./conventions/rattacherResumes.php">Rattacher des résumés</a></li><br/>
					<li><a href="./conventions/bilanConventions.php">Bilan des conventions</a></li>
				    </ul>
				</td>
			    </tr>
			</table>
			<table id="menuBdd">
			    <tr>
				<td id="titreMenuBdd">
				    Soutenances
				</td>
			    </tr>
			    <tr>
				<td>
				    <ul>
					<li><a href="./soutenances/gestionSalle.php">Gérer les salles</a></li>
					<li><a href="./soutenances/gestionDate.php">Gérer les dates</a></li><br/>
					<li><a href="./soutenances/gestionTempsSoutenance.php">Gérer les durées de soutenance</a></li>
					<li><a href="./soutenances/planning/planifier.php">Planifier les soutenances</a></li><br/>
					<li><a href="./soutenances/convocation.php">Convocation aux soutenances</a></li>
				    </ul>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</div>

	<br/>

	<script>
	    // Récupération de la valeur stockée localement sur le client
	    if (!localStorage.getItem('onglet'))
		localStorage.setItem('onglet', 'onglet1');

	    // La pile des onglets
	    var anciensOnglets = ['onglet1'];

	    // Montre ou cache un onglet
	    var cacheOuMontre = function (onglet) {
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
	    };

	    cacheOuMontre(localStorage.getItem('onglet'));
	</script>

	<?php
    }

}
