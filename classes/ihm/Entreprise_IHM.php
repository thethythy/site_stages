<?php

class Entreprise_IHM {

    /**
     * Afficher un formulaire de sélection des entreprises par nom, par ville,
     * par code postal et par pays
     * @param string $page La page de traitement du formulaire
     */
    public static function afficherFormulaireRecherche($page) {
	?>
	<form method=post action="javascript:">
	    <table width="100%">
		<tr>
		    <td width="50%" align="center">
			<table>
			    <tr>
				<td>Nom de l'entreprise</td>
				<td>
				    <input id="nom" type="text" name="nom"
					<?php
					if (isset($_POST['nom']))
					    echo "value='" . $_POST['nom'] . "'"; ?>
				    />
				</td>
			    </tr>
			    <tr>
				<td>Code Postal</td>
				<td>
				    <input id="cp" type="text" name="cp"
					<?php
					if (isset($_POST['cp']))
					    echo "value='" . $_POST['cp'] . "'"; ?>
				    />
				</td>
			    </tr>
			</table>
		    </td>
		    <td width="50%">
			<table>
			    <tr>
				<td>Ville</td>
				<td>
				    <input id="ville" type="text" name="ville"
					<?php
					if (isset($_POST['ville']))
					    echo "value='" . $_POST['ville'] . "'"; ?>
				    />
				</td>
			    </tr>
			    <tr>
				<td>Pays</td>
				<td>
				    <input id="pays" type="text" name="pays"
					<?php
					if (isset($_POST['pays']))
					    echo "value='" . $_POST['pays'] . "'"; ?>
				    />
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>

	<script type="text/javascript">
	    var table = new Array("nom", "cp", "ville", "pays");
	    new LoadData(table, "<?php echo $page; ?>", "onkeyup");
	</script>

	<?php
    }

    /**
     * Affiche un formulaire de création ou d'édition d'une entreprise
     * Si $ent = "", alors il s'agit d'un formulaire de création (champs vide)
     * @param Entreprise ou "" $ent L'entreprise à éditer ou rien
     */
    public static function afficherFormulaireSaisie($ent) {
	$tabTypeEntreprise = TypeEntreprise::getListeTypeEntreprise();
	?>
	<form method=post action="">
	    <table width="100%">
		<tr>
		    <td width="50%" align="center">
			<table>
			    <tr>
				<td>Nom de l'entreprise</td>
				<td>
				    <input type="text" name="nom" value="<?php
					if (isset($_POST['nom']))
					    echo $_POST['nom'];
					else
					    if ($ent != "")
						echo $ent->getNom(); ?>"/>
				</td>
			    </tr>
			    <tr>
				<td>Adresse</td>
				<td>
				    <input type="text" name="adresse" value="<?php
					if (isset($_POST['adresse']))
					    echo $_POST['adresse'];
					else
					    if ($ent != "")
						echo $ent->getAdresse(); ?>"/>
				</td>
			    </tr>
			    <tr>
				<td>Email DRH ou équivalent</td>
				<td>
				    <input type="text" name="email"
					<?php
					if (isset($_POST['email']))
					    echo "value='" . $_POST['email'] . "'";
					else
					    if ($ent != "")
						echo "value='" . $ent->getEmail() . "'"; ?>
				    />
				</td>
			    </tr>
			    <tr>
				<td>Type de l'entreprise</td>
				<td>
				    <?php
				    echo "<select name='idtype'>";
				    for ($i = 0; $i < sizeof($tabTypeEntreprise); $i++) {
					$id = $tabTypeEntreprise[$i]->getIdentifiantBDD();
					$type = $tabTypeEntreprise[$i]->getType();

					if ($ent != "" && $ent->getType()->getIdentifiantBDD() == $id)
					    echo "<option value='$id' selected>$type</option>";
					else
					    echo "<option value='$id'>$type</option>";
				    }
				    echo "</select>";
				    ?>
				</td>
			    </tr>
			</table>
		    </td>
		    <td width="50%" align="center">
			<table>
			    <tr>
				<td>Code Postal</td>
				<td>
				    <input type="text" name="cp"
					<?php
					if (isset($_POST['cp']))
					    echo "value='" . $_POST['cp'] . "'";
					else
					    if ($ent != "")
						echo "value='" . $ent->getCodePostal() . "'"; ?>
				    />
				</td>
			    </tr>
			    <tr>
				<td>Ville</td>
				<td>
				    <input type="text" name="ville" value="<?php
					if (isset($_POST['ville']))
					    echo $_POST['ville'];
					else
					    if ($ent != "")
						echo $ent->getVille(); ?>"/>
				</td>
			    </tr>
			    <tr>
				<td>Pays</td>
				<td>
				    <input type="text" name="pays" value="<?php
					if (isset($_POST['pays']))
					    echo $_POST['pays'];
					else
					    if ($ent != "")
						echo $ent->getPays(); ?>"/>
				</td>
			    </tr>
			    <tr>
				<td>&nbsp;</td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td colspan="2">
			<?php
			if ($ent != "")
			    echo "<input type='hidden' name='id' value='".$ent->getIdentifiantBDD()."'/>";
			?>
			<input type="hidden" name="<?php if ($ent != "") echo "edit"; else echo "add"; ?>" />
			<input type="submit" value="Valider" />
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

    /**
     * Affiche un tableau statique d'entreprises
     * @param tableau d'objets $tabEntreprises Tableau d'objets Entreprise
     */
    public static function afficherListeEntreprise($tabEntreprises) {
	for ($i = 0; $i < sizeof($tabEntreprises); $i++) {
	?>
	<table id="presentation_entreprise">
	    <tr>
		<td width="50%">
		    <div align="right">
			<a href="../statistiques/statistiquesEntreprise.php?id=<?php echo $tabEntreprises[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/search.png" alt="Statistiques" title="Statistiques de l'entreprise"/>
			</a>
		    </div>
		    <?php echo $tabEntreprises[$i]->getNom(); ?> <br/>
		    <?php echo $tabEntreprises[$i]->getAdresse(); ?> <br/>
		    <?php echo $tabEntreprises[$i]->getCodePostal(); ?>
		    <?php echo $tabEntreprises[$i]->getVille(); ?> <br/>
		    <?php echo $tabEntreprises[$i]->getPays(); ?> <br/>
		    <?php echo $tabEntreprises[$i]->getEmail(); ?> <br/>
		    <?php echo $tabEntreprises[$i]->getType()->getType(); ?>
		</td>
		<td width="50%" id="contact">
		    <?php
		    $contacts = $tabEntreprises[$i]->listeDeContacts();

		    if (sizeof($contacts) >= 2)
			echo "<b>Contacts</b><br/><br/>";
		    else if (sizeof($contacts) == 1)
			echo "<b>Contact</b><br/><br/>";

		    for ($j = 0; $j < sizeof($contacts); $j++) {
			echo $contacts[$j]->getNom() . " ";
			echo $contacts[$j]->getPrenom() . "<br/>";

			if ($contacts[$j]->getTelephone() != "")
			    echo "Telephone : " . $contacts[$j]->getTelephone() . "<br/>";

			if ($contacts[$j]->getTelecopie() != "")
			    echo "Fax : " . $contacts[$j]->getTelecopie() . "<br/>";

			if ($contacts[$j]->getEmail() != "")
			    echo "Email : " . $contacts[$j]->getEmail() . "<br/>";

			if ($j + 1 < sizeof($contacts))
			    echo "<br/>";
		    }
		    ?>
		</td>
	    </tr>
	</table>
	<?php
	}
	echo "<br/><br/>";
    }

    /**
     * Afficher un tableau interactif pour éditer ou supprimer une entreprise
     * parmi la liste des entreprises affichées
     * @param tableau d'objets $tabEntreprises Tableau d'objets Entreprise
     */
    public static function afficherListeEntrepriseAEditer($tabEntreprises) {
	for ($i = 0; $i < sizeof($tabEntreprises); $i++) {
	    ?>
	    <table id="presentation_entreprise">
		<tr>
		    <td width="50%">
			<div align="right">
			    <a href="modifierEntreprise.php?nom=<?php if (isset($_POST['nom'])) echo $_POST['nom']; ?>&cp=<?php if (isset($_POST['cp'])) echo $_POST['cp']; ?>&ville=<?php if (isset($_POST['ville'])) echo $_POST['ville']; ?>&pays=<?php if (isset($_POST['pays'])) echo $_POST['pays']; ?>&id=<?php echo $tabEntreprises[$i]->getIdentifiantBDD(); ?>">
				<img src="../../images/reply.png"/>
			    </a>
			    <a href="modifierListeEntreprises.php?nom=<?php if (isset($_POST['nom'])) echo $_POST['nom']; ?>&cp=<?php if (isset($_POST['cp'])) echo $_POST['cp']; ?>&ville=<?php if (isset($_POST['ville'])) echo $_POST['ville']; ?>&pays=<?php if (isset($_POST['pays'])) echo $_POST['pays']; ?>&id=<?php echo $tabEntreprises[$i]->getIdentifiantBDD(); ?>">
				<img src="../../images/action_delete.png"/>
			    </a>
			</div>
			<?php echo $tabEntreprises[$i]->getNom(); ?> <br/>
			<?php echo $tabEntreprises[$i]->getAdresse(); ?> <br/>
			<?php echo $tabEntreprises[$i]->getCodePostal(); ?>
			<?php echo $tabEntreprises[$i]->getVille(); ?> <br/>
			<?php echo $tabEntreprises[$i]->getPays(); ?> <br/>
			<?php echo $tabEntreprises[$i]->getEmail(); ?> <br/>
			<?php echo $tabEntreprises[$i]->getType()->getType(); ?>
		    </td>
		    <td width="50%" id="contact">
			<?php
			$contacts = $tabEntreprises[$i]->listeDeContacts();

			if (sizeof($contacts) >= 2)
			    echo "<b>Contacts</b><br/><br/>";
			else if (sizeof($contacts) == 1)
			    echo "<b>Contact</b><br/><br/>";

			for ($j = 0; $j < sizeof($contacts); $j++) {
			    echo $contacts[$j]->getNom() . " ";
			    echo $contacts[$j]->getPrenom() . "<br/>";

			    if ($contacts[$j]->getTelephone() != "")
				echo "Telephone : " . $contacts[$j]->getTelephone() . "<br/>";

			    if ($contacts[$j]->getTelecopie() != "")
				echo "Fax : " . $contacts[$j]->getTelecopie() . "<br/>";

			    if ($contacts[$j]->getEmail() != "")
				echo "Email : " . $contacts[$j]->getEmail() . "<br/>";

			    if ($j + 1 < sizeof($contacts))
				echo "<br/>";
			}
			?>
		    </td>
		</tr>
	    </table>
	    <?php
	}
    }
}

?>