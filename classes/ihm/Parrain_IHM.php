<?php

class Parrain_IHM {

    /**
     * Afficher un formulaire de saisie d'un nouveu parrain
     */
    public static function afficherFormulaireSaisie() {
	$tabCouleur = Couleur::listerCouleur();
	?>
	<FORM METHOD="POST" ACTION="">
	    <table>
		<tr>
		    <td colspan=2>
			<table>
			    <tr id="entete2">
				<td colspan=2>Saisir un référent</td>
			    </tr>
			    <tr>
				<td width="200">Nom</td>
				<td><input type="text" name="nomparrain" ></td>
			    </tr>
			    <tr>
				<td>Prénom</td>
				<td><input type="text" name="prenomparrain" ></td>
			    </tr>
			    <tr>
				<td>Email</td>
				<td><input type="text" name="emailparrain" ></td>
			    </tr>
			    <tr>
				<td>Couleur</td>
				<td>
				    <select id="idcouleur" name="idcouleur" onchange='showColor()'>
					<?php
					for ($i = 0; $i < sizeof($tabCouleur); $i++)
					    echo "<option value='" . $tabCouleur[$i]->getIdentifiantBDD() . "' style='color: #" . $tabCouleur[$i]->getCode() . ";'>" . $tabCouleur[$i]->getNom() . "</option>";
					?>
				    </select>&nbsp;&nbsp;&nbsp;&nbsp;
				    <input id="couleurActuel" readonly="disabled" style="background-color: <?php echo '#' . $tabCouleur[0]->getCode(); ?>; width: 100px; border-width: 0px;"/>
				</td>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value="Enregistrer les données"/>
				    <input type=reset value="Effacer"/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</FORM>
	<script>
	    function showColor() {
		var couleurActuelHTML = document.getElementById("couleurActuel");
		var couleurHTML = document.getElementById("idcouleur");
		couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
	    }
	</script>
	<?php
    }

    /**
     * Afficher un formulaire d'édition d'un parrain existant
     * @param integer $idParrain Identifiant du parrain édité
     */
    public static function afficherFormulaireModificationParrain($idParrain) {
	$parrain = Parrain::getParrain($idParrain);
	$couleur = $parrain->getCouleur();
	$tabCouleur = Couleur::listerCouleur();
	?>

	<form action='' method="post">
	    <input type=hidden name='id' value=<?php echo $idParrain; ?>/>
	    <table>
		<tr>
		    <td colspan=2>
			<table>
			    <tr id="entete2">
				<td colspan="2">Modification d'un référent</td>
			    </tr>
			    <tr>
				<td width="200">Nom</td>
				<td>
				    <input type="text" name='nomparrain' value='<?php echo $parrain->getNom(); ?>'>
				</td>
			    </tr>
			    <tr>
				<td>Prénom</td>
				<td>
				    <input type="text" name='prenomparrain' value='<?php echo $parrain->getPrenom(); ?>'>
				</td>
			    </tr>
			    <tr>
				<td>Email</td>
				<td>
				    <input type="text" name='emailparrain' value='<?php echo $parrain->getEmail(); ?>'>
				</td>
			    </tr>
			    <tr>
				<td>Couleur</td>
				<td>
				    <select id='idcouleur' name='idcouleur' onchange='showColor()'>
					<?php
					for ($i = 0; $i < sizeof($tabCouleur); $i++) {
					    if ($couleur->getIdentifiantBDD() == $tabCouleur[$i]->getIdentifiantBDD())
						echo "<option style='color: #" . $tabCouleur[$i]->getCode() . ";' selected value='" . $tabCouleur[$i]->getIdentifiantBDD() . "'>" . $tabCouleur[$i]->getNom() . "</option>";
					    else
						echo "<option style='color: #" . $tabCouleur[$i]->getCode() . ";' value='" . $tabCouleur[$i]->getIdentifiantBDD() . "'>" . $tabCouleur[$i]->getNom() . "</option>";
					}
					?>
				    </select>
				    &nbsp;&nbsp;&nbsp;&nbsp;
				    <input id='couleurActuel' readonly='disabled' style='background-color: <?php echo '#' . $couleur->getCode(); ?>; width: 100px; border-width: 0px;'/>
				</td>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value='Enregistrer les données'/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>

	<script>
	    function showColor() {
		var couleurActuelHTML = document.getElementById('couleurActuel');
		var couleurHTML = document.getElementById('idcouleur');
		couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
	    }
	</script>
	<?php
    }

    /**
     * Afficher un tableau interactif de la liste des parrains
     * à éditer ou à supprimer
     */
    public static function afficherListeParrainAEditer() {
	$tabParrains = Parrain::listerParrain();
	if (sizeof($tabParrains) > 0) {
	    echo
	    "<table>
		<tr id='entete'>
		    <td width='50%'>Référent</td>
		    <td width='10%' align='center'>Modifier</td>
		    <td width='10%' align='center'>Supprimer</td>
		</tr>";
	    for ($i = 0; $i < sizeof($tabParrains); $i++) {
		$couleur = $tabParrains[$i]->getCouleur();
		$nom = $tabParrains[$i]->getNom();
		$prenom = $tabParrains[$i]->getPrenom();
		?>
		<tr id="ligne<?php echo $i % 2; ?>">
		    <td>
			<table >
			    <tr>
				<td width="35%"><?php echo $prenom . " " . $nom; ?></td>
				<td width="35%"><?php echo $tabParrains[$i]->getEmail(); ?></td>
				<td width='15%'><?php echo $couleur->getNom(); ?></td>
				<td width='15%'>
				    <input readonly="disabled" style="background-color:<?php echo '#' . $couleur->getCode(); ?>; width: 100px; border-width: 0px;"/>
				</td>
			    </tr>
			</table>
		    </td>
		    <td align="center">
			<a href="gestionParrain.php?action=mod&id=<?php echo $tabParrains[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
		    </td>
		    <td align="center">
			<a href="gestionParrain.php?action=sup&id=<?php echo $tabParrains[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
		<?php
	    }
	    echo "</table>";
	    echo "<br/><br/>";
	} else {
	    echo "<br/><center>Aucune parrain n'a été trouvé.</center><br/>";
	}
    }

    /**
     * Afficher un formulaire de sélection du parrain (nom du parrain, année,
     * filière et parcours)
     * @param string $fichier Page de traitement de la sélection
     */
    public static function afficherFormulaireRecherche($fichier) {
	$tabAU = Promotion_BDD::getAnneesUniversitaires();
	$tabP = Parrain::listerParrain();
	$tabF = Filiere::listerFilieres();
	$tabParcours = Parcours::listerParcours();
	?>
	<form action="javascript:">
	    <table width="100%">
		<tr>
		    <td>
			<table width="100%">
			    <tr>
				<td>
				    Sélectionnez l'année
				    <select id="annee" name="annee">
					<?php
					for ($i = 0; $i < sizeof($tabAU); $i++) {
					    if ((isset($_POST['annee'])) && ($_POST['annee'] == $tabAU[$i]))
						echo "<option selected value='$tabAU[$i]'>" . $tabAU[$i] . "-" . ($tabAU[$i] + 1) . "</option>";
					    else
						echo "<option value='$tabAU[$i]'>" . $tabAU[$i] . "-" . ($tabAU[$i] + 1) . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td>
				    Sélectionnez le nom du référent
				    <select id="nom" name="nom">
					<?php
					echo "<option value='*'>Tous</option>";
					for ($i = 0; $i < sizeof($tabP); $i++) {
					    if ((isset($_POST['nom'])) && ($_POST['nom'] == $tabP[$i]->getIdentifiantBDD()))
						echo "<option selected value='" . $tabP[$i]->getIdentifiantBDD() . "'>" . $tabP[$i]->getNom() . " " . $tabP[$i]->getPrenom() . "</option>";
					    else
						echo "<option value='" . $tabP[$i]->getIdentifiantBDD() . "'>" . $tabP[$i]->getNom() . " " . $tabP[$i]->getPrenom() . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			</table>
		    </td>
		    <td>
			<table width="100%">
			    <tr>
				<td>
				    Sélectionnez le diplôme
				    <select id="filiere" name="filiere">
					<?php
					echo "<option value='*'>Tous</option>";
					for ($i = 0; $i < sizeof($tabF); $i++) {
					    if ((isset($_POST['filiere'])) && ($_POST['filiere'] == $tabF[$i]->getIdentifiantBDD()))
						echo "<option selected value='" . $tabF[$i]->getIdentifiantBDD() . "'>" . $tabF[$i]->getNom() . "</option>";
					    else
						echo "<option value='" . $tabF[$i]->getIdentifiantBDD() . "'>" . $tabF[$i]->getNom() . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td>
				    Sélectionnez la spécialité
				    <select id="parcours" name="parcours">
					<?php
					echo "<option value='*'>Tous</option>";
					for ($i = 0; $i < sizeof($tabParcours); $i++) {
					    if ((isset($_POST['parcours'])) && ($_POST['parcours'] == $tabParcours[$i]->getIdentifiantBDD()))
						echo "<option selected value='" . $tabParcours[$i]->getIdentifiantBDD() . "'>" . $tabParcours[$i]->getNom() . "</option>";
					    else
						echo "<option value='" . $tabParcours[$i]->getIdentifiantBDD() . "'>" . $tabParcours[$i]->getNom() . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>

	<script type="text/javascript">
	    var table = new Array("annee", "nom", "filiere", "parcours");
	    new LoadData(table, "<?php echo $fichier; ?>", "onchange");
	</script>

	<?php
    }

    /**
     * Afficher la liste des parrainages à partir d'une liste de conventions
     * @param tableau d'objets $tabConventions Les objets Conventions concernées
     */
    public static function afficherListeParrainage($tabConventions) {
	if (sizeof($tabConventions) > 0) {
	?>
	<br/>
	<table width="100%">
	    <tr id="entete">
		<td width="15%">Référent</td>
		<td width="15%">Etudiant</td>
		<td width="15%">Diplôme</td>
		<td width="40%">Entreprise</td>
		<td align="center" width="15%">Sujet de stage</td>
	    </tr>
	<?php
	// Affichage des conventions correspondants aux critères de recherches
	$cpt = 0;
	for ($i = 0; $i < sizeof($tabConventions); $i++) {
	    if (isset($_POST['annee']) && $_POST['annee'] != "")
		$annee = $_POST['annee'];
	    else
		$annee = Promotion_BDD::getLastAnnee();
	    $etudiant = $tabConventions[$i]->getEtudiant();
	    $promotion = $etudiant->getPromotion($annee);
	    $filiere = $promotion->getFiliere();
	    $parcours = $promotion->getParcours();
	    ?>
	    <tr id="ligne<?php echo $cpt%2; $cpt++; ?>">
		<td>
		    <?php
		    $parrain = $tabConventions[$i]->getParrain();
		    echo $parrain->getNom()." ".$parrain->getPrenom();
		    ?>
		</td>
		<td><?php echo $etudiant->getNom()." ".$etudiant->getPrenom(); ?></td>
		<td><?php echo $filiere->getNom()." ".$parcours->getNom(); ?></td>
		<td>
		    <?php
		    $entreprise = $tabConventions[$i]->getEntreprise();
		    echo $entreprise->getNom()."<br/>".$entreprise->getAdresse()."<br/>".$entreprise->getCodePostal()." ".$entreprise->getVille();
		    ?>
		</td>

		<td align="center">
		    <a href="./ficheDeStage.php?annee=<?php echo $_POST['annee']; ?>&parcours=<?php echo $_POST['parcours']; ?>&filiere=<?php echo $_POST['filiere']; ?>&nom=<?php echo $_POST['nom']; ?>&idEtu=<?php echo $etudiant->getIdentifiantBDD(); ?>&idPromo=<?php echo $promotion->getIdentifiantBDD(); ?>"  target="_blank">
			<img src="../images/resume.png" />
		    </a>
		</td>
	    </tr>
	    <?php
	}
	?>
	</table>
	<br/><br/>
	<?php
	} else {
	?>
	    <br/>
		<p>Aucun référent ne correspond aux critères de recherche.</p>
	    <br/>
	<?php
}
    }

    /**
     * Afficher un décompte des parrainages par promotion pour un parrain
     * ou tous les parrains
     * @param tableau d'objets $tabPromotions Les objets promotions concernées
     * @param tableau d'objets $tabConventions Les conventions concernées
     */
    public static function afficherListeBilanParrains($tabPromotions, $tabConventions) {
	if (sizeof($tabConventions) > 0 && sizeof($tabPromotions) > 0) {
	    ?>
	    <table id="data" width='60%'>
		<tr id="entete">
		<td width="20%">Référent</td>
		<?php
		for ($i = 0; $i < sizeof($tabPromotions); $i++) {
		    echo "<td width='10%'>" . $tabPromotions[$i]->getFiliere()->getNom() . " " . $tabPromotions[$i]->getParcours()->getNom() . "</td>";
		}

		echo "<td width='6%'>Total</td><td width='7%'>ICalendar</td></tr>";

		$cpt = 0;
		$oldparrain = 0;
		for ($i = 0; $i < sizeof($tabConventions); $i++) {

		    if ($tabConventions[$i]->getIdParrain() != '') {

			if (isset($_POST['annee']) && $_POST['annee'] != "")
			    $annee = $_POST['annee'];
			else
			    $annee = Promotion_BDD::getLastAnnee();

			$parrain = $tabConventions[$i]->getParrain();

			if ($parrain->getIdentifiantBDD() != $oldparrain) {
			    ?>
				<tr id="ligne<?php echo $cpt % 2; $cpt++; ?>">
				    <td>
					<?php
					echo $parrain->getNom() . " " . $parrain->getPrenom();
					?>
				    </td>
				    <?php
				    $total = 0;
				    for ($j = 0; $j < sizeof($tabPromotions); $j++) {

					$filiere = $tabPromotions[$j]->getFiliere();
					$parcours = $tabPromotions[$j]->getParcours();

					$nbParrainage = Convention_BDD::compteConvention($annee, $parrain->getIdentifiantBDD(), $filiere->getIdentifiantBDD(), $parcours->getIdentifiantBDD());
					$total = $total + $nbParrainage;
					echo "<td>$nbParrainage</td>";
				    }
				    ?>
				    <td><?php echo $total; ?></td>
				    <td>
					<a href='getEnseignantICal.php?id=<?php echo $parrain->getIdentifiantBDD(); ?>'>Import</a> |
					<a href='webcal://info-stages.univ-lemans.fr/parrainage/getEnseignantICal.php?id=<?php echo $parrain->getIdentifiantBDD(); ?>'>Abonnement</a>
				    </td>
				</tr>
			    <?php
			    $oldparrain = $parrain->getIdentifiantBDD();
			}
		    }
		}
		?>

	    </table>

	    <br/>

	    <?php
	} else {
	    ?>
	    <br/>
	    <p>Aucun référent ne correspond aux critères de recherche.</p>
	    <br/>
	    <?php
	}
    }

    /**
     * Afficher un planning chronologique des soutenances d'un parrain.
     * Chaque soutenance affichée permet d'accéder à la convention associée.
     * @param integer $annee L'année concernée
     * @param tableau d'objets $listeDateSoutenance Les objets DateSoutenance concernés
     * @param tableau d'objets $listeConvention Les objets Convention concernés
     */
    public static function afficherPlanningParrains($annee, $listeDateSoutenance, $listeConvention) {
	$enteteTableau =
	"<table>
	    <tr id='entete'>
		<td rowspan='2' style='width: 85px;'>Horaires</td>
		<td colspan='2'>Étudiant</td>
		<td rowspan='2' style='width: 50px;'>Fiche de stage</td>
		<td colspan='2'>Jury</td>
		<td rowspan='2' style='width: 75px;'>Salle</td>
	    </tr>
	    <tr id='entete'>
		<td style='width: 100px;'>Nom prénom</td>
		<td style='width: 60px;'>Cycle</td>
		<td style='width: 110px;'>Référent</td>
		<td style='width: 110px;'>Examinateur</td>
	    </tr>";

	$finTableau = "</table>";
	echo '<table>';

	$k = 0;
	foreach ($listeDateSoutenance as $dateActuelle) {
	    $i = 0; $j = 0;

	    // Pour chaque convention
	    foreach ($listeConvention as $convention) {
		$soutenance = $convention->getSoutenance();

		// On test s'il y a une soutenance associee a la date
		if ($soutenance->getIdentifiantBDD()!=0 && $soutenance->getSalle()->getIdentifiantBDD()!=0) {
		    if ($soutenance->getDateSoutenance()->getIdentifiantBDD()==$dateActuelle->getIdentifiantBDD()) {
			if ($j==0) {
			    echo $finTableau;
			    echo '<h2> Le '.$dateActuelle->getJour().' '.Utils::numToMois($dateActuelle->getMois()).' '.$dateActuelle->getAnnee().'</h2>';
			    echo $enteteTableau;
			}
			$j++; $k++;
			$nomSalle = ($soutenance->getSalle()->getIdentifiantBDD()!=0) ? $soutenance->getSalle()->getNom() : "Non attribuée";
			$etudiant = $convention->getEtudiant();
			$promotion = $etudiant->getPromotion($annee);
			$parcours = $promotion->getParcours();
			$filiere = $promotion->getFiliere();
			$parrain = $convention->getParrain();
			$examinateur = $convention->getExaminateur();

			// Gestion horaires
			$tempsSoutenance = $filiere->getTempsSoutenance();
			$heureDebut = $soutenance->getHeureDebut();
			$minuteDebut = $soutenance->getMinuteDebut();
			$heureFin = $heureDebut;
			$minuteFin = ($minuteDebut + $tempsSoutenance);
			if ($minuteFin>59) {
			    $minuteFin-=60;
			    $heureFin++;
			}
			$minuteDebut = ($minuteDebut!=0) ? $minuteDebut : "00";
			$minuteFin = ($minuteFin!=0) ? $minuteFin : "00";

			// Incrementation
			$i=($i+1)%2;

			// Affichage
			echo
			"<tr id='ligne".$i."'>
			    <td>".$heureDebut."h".$minuteDebut." / ".$heureFin."h".$minuteFin."</td>
			    <td>".strtoupper($etudiant->getNom())." ".$etudiant->getPrenom()."</td>
			    <td>".$filiere->getNom()." ".$parcours->getNom()."</td>
			    <td>
				<a href='fichedestage.php?idEtu=".$etudiant->getIdentifiantBDD()."&idPromo=".$promotion->getIdentifiantBDD()."' target='_blank'>
				    <img src=\"../images/resume.png\" />
				</a>
			    </td>
			    <td>".strtoupper($parrain->getNom())." ".$parrain->getPrenom()."
			    <td>".strtoupper($examinateur->getNom())." ".$examinateur->getPrenom()."
			    <td>".$nomSalle."</td>
			</tr>";
		    }
		}
	    }
	}

	echo $finTableau;

	// S'il n'y a pas de conventions
	if ($k == 0)
	    echo "<br/><center>Il n'y a pas de soutenance associée à cet enseignant.</center>";
    }

}

?>