<?php

class Salle_IHM {

    /**
     * Afficher un formulaire de création d'une nouvelle salle
     */
    public static function afficherFormulaireSaisie() {
	?>
	<FORM METHOD="POST" ACTION="">
	    <table>
		<tr>
		    <td colspan=2>
			<table>
			    <tr id="entete2">
				<td colspan=2>Saisir une salle</td>
			    </tr>
			    <tr>
				<th width="100">Nom :</th>
				<td>
				    <input type="text" name="nom" >
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
	<?php
    }

    /**
     * Afficher un formulaire de modification d'une salle existante
     * @param integer $idSalle Identifiant de la salle éditée
     */
    public static function afficherFormulaireModification($idSalle) {
	$salle = Salle::getSalle($idSalle);
	?>
	<form action='' method='post'>
	    <input type=hidden name='id' value=<?php echo $salle->getIdentifiantBDD(); ?>>
	    <table>
		<tr>
		    <td colspan="2">
			<table>
			    <tr id='entete2'>
				<td colspan="2">Modifier une salle</td>
			    </tr>
			    <tr>
				<th width="100">Nom : </th>
				<td>
				    <input type="text" name='nom' value='<?php echo $salle->getNom(); ?>'>
				</td>
			    </tr>
			    <tr>
				<td colspan="2">
				    <input type=submit value='Enregistrer les données'/>
				</td>
			    </tr>
			</table>
		</tr>
	    </table>
	</form>
	<?php
    }

    /**
     * Afficher un tableau interactif pour éditer ou supprimer une salle
     * parmis la liste des salles affichées
     */
    public static function afficherListeSalleAEditer() {
	$tabSalles = Salle::listerSalle();
	if (sizeof($tabSalles) > 0) {
	    echo
	    "<table>
		<tr id='entete'>
		    <td width='50%'>Salle</td>
		    <td width='10%' align='center'>Modifier</td>
		    <td width='10%' align='center'>Supprimer</td>
		</tr>";
	    for ($i = 0; $i < sizeof($tabSalles); $i++) {
		$salle = $tabSalles[$i];
		?>
		<tr class="ligne<?php echo $i % 2; ?>">
		    <td width='50%'><?php echo $salle->getNom(); ?></td>
		    <td align="center">
			<a href="gestionSalle.php?action=mod&id=<?php echo $salle->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
		    </td>
		    <td align="center">
			<a href="gestionSalle.php?action=sup&id=<?php echo $salle->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
		<?php
	    }
	    echo "</table>";
	    echo "<br/><br/>";
	} else {
	    echo "<br/><center>Aucune salle n'a été trouvée.</center><br/>";
	}
    }

    /**
     * Afficher par ordre chronologique les soutenances d'une salle.
     * @param integer $annee L'année concernée
     * @param tableau d'objets $listeConvention Liste de Convention triés chronologiquement pour la salle
     */
    public static function afficherPlanningSalles($annee, $listeConvention) {
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

	// Pour chaque convention
	$k = 0; $i = 0; $j = 0;
	foreach ($listeConvention as $convention) {
	    $soutenance = $convention->getSoutenance();

	    if ($j == 0) {
		echo $finTableau;
		echo $enteteTableau;
	    }

	    $j++; $k++;
	    $nomSalle = ($soutenance->getSalle()->getIdentifiantBDD() != 0) ? $soutenance->getSalle()->getNom() : "Non attribuée";
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
	    if ($minuteFin > 59) {
		$minuteFin-=60;
		$heureFin++;
	    }
	    $minuteDebut = ($minuteDebut!=0) ? $minuteDebut : "00";
	    $minuteFin = ($minuteFin!=0) ? $minuteFin : "00";

	    // Incrementation
	    $i = ($i+1) % 2;

	    // Affichage
	    echo
	    "<tr id='ligne".$i."'>
		<td>".$heureDebut."h".$minuteDebut." / ".$heureFin."h".$minuteFin."</td>
		<td>".strtoupper($etudiant->getNom())." ".$etudiant->getPrenom()."</td>
		<td>".$filiere->getNom()." ".$parcours->getNom()."</td>
		<td><a href='fichedestage.php?idEtu=".$etudiant->getIdentifiantBDD()."&idPromo=".$promotion->getIdentifiantBDD()."' target='_blank'><img src=\"../images/resume.png\" /></a></td>
		<td>".strtoupper($parrain->getNom())." ".$parrain->getPrenom()."
		<td>".strtoupper($examinateur->getNom())." ".$examinateur->getPrenom()."
		<td>".$nomSalle."</td>
	    </tr>";
	}

	echo $finTableau;

	// S'il n'y a pas de conventions
	if ($k == 0)
	    echo "<br/><center>Il n'y a pas de soutenance associée à cette salle pour la date sélectionnée.</center>";
    }

    }
?>