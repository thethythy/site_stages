<?php

class Attribution_IHM {

    /**
     * Afficher une liste des notifications d'attribution à sélectionner
     * @param tableau $tabOAttribution Un tableau d'objets Attribution
     * @param integer $annee L'année de la promotion
     * @param integer $parcours Le parcours de la promotion
     * @param integer $filiere La filière de la promotion
     */
    public static function afficherSelectionDestinairesNotification($tabOAttribution, $annee, $parcours, $filiere, $url) {
	if (sizeof($tabOAttribution) > 0) {
	    ?>
	    <form method="post" action="<?php echo $url; ?>">
		<table>
		    <tr id='entete'>
			<td width='30%'>Etudiant</td>
			<td width='30%'>Référent</td>
			<td width='30%'>Encadrant entreprise</td>
			<td width='10%'>Notification</td>
		    </tr>

		    <?php
		    for ($i = 0; $i < sizeof($tabOAttribution); $i++) {
			$oConvention = Convention::getConvention($tabOAttribution[$i]->getIdconvention());

			$etudiant = $oConvention->getEtudiant();
			$referent = $oConvention->getParrain();
			$contact = $oConvention->getContact();
			$entreprise = $oConvention->getEntreprise();

			$idNotification = $tabOAttribution[$i]->getIdentifiantBDD();
			?>

			<tr class="ligne<?php echo $i % 2; ?>">
			    <td align="center">
				<?php echo $etudiant->getPrenom() . " " . $etudiant->getNom(); ?>
			    </td>
			    <td align="center">
				<?php echo $referent->getPrenom() ." " . $referent->getNom(); ?>
			    </td>
			    <td align="center">
				<?php echo $contact->getPrenom() ." " . $contact->getNom() . " (". $entreprise->getNom() . ")" ?>
			    </td>
			    <td align="center">
				<?php
				if ($tabOAttribution[$i]->getEnvoi() == 1)
				    echo "<input type='checkbox' checked disabled name='notifications[]' value='$idNotification'/>";
				else
				    echo "<input type='checkbox' name='notifications[]' value='$idNotification'/>";
				?>
			    </td>
			<?php
		    }
		    ?>

		    <tr>
			<td colspan="3" width="50%" align="center">
			    <br/>
			    <?php
				echo "<input type='hidden' name='annee' value='$annee'/>";
				echo "<input type='hidden' name='filiere' value='$filiere'/>";
				echo "<input type='hidden' name='parcours' value='$parcours'/>";
			    ?>
			    <input type="submit" value="Nofifier" name="notification"/>
			    <br/>&nbsp;
			</td>
			<td colspan="2" width="50%" align="center">
			    <br/>
			    <input type="submit" value="Annuler" formaction="../"/>
			    <br/>&nbsp;
			</td>
		    </tr>
		</table>
	    </form>
	    <?php
	} else {
	    echo "<center>Aucune notification trouvée pour cette sélection.</center>";
	}
    }

}

?>