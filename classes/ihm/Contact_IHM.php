<?php

class Contact_IHM {

    // Méthodes statiques

    public static function afficherFormulaireRecherche($page) {
	?>
	<form method=post action="<?php echo $page; ?>">
	    <table width="100%">
		<tr>
		    <td width="50%" align="center">
			<table>
			    <tr>
				<td>Nom</td>
				<td>
				    <input type="text" name="nom"
					<?php if (isset($_POST['nom'])) echo "value='" . $_POST['nom'] . "'"; ?>/>
				</td>
			    </tr>
			    <tr>
				<td>Prénom</td>
				<td>
				    <input type="text" name="prenom"
					<?php if (isset($_POST['prenom'])) echo "value='" . $_POST['prenom'] . "'"; ?> />
				</td>
			    </tr>
			</table>
		    </td>
		    <td width="50%">
			<table>
			    <tr>
				<td>Téléphone</td>
				<td>
				    <input type="text" name="tel"
					<?php if (isset($_POST['tel'])) echo "value='" . $_POST['tel'] . "'"; ?> />
				</td>
			    </tr>
			    <tr>
				<td>Fax</td>
				<td>
				    <input type="text" name="fax"
					<?php if (isset($_POST['fax'])) echo "value='" . $_POST['fax'] . "'"; ?> />
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td colspan="2" id="submit">
			<input type="hidden" value="1" name="rech">
			<input type="submit" value="Afficher">
		    </td>
		</tr>
	    </table>
	</form>

	<?php
    }

    // $cont = Contact qui est modifié et dont les informations son affichées.
    // si $cont = "", alors il s'agit d'un formulaire de création (champs vide)
    public static function afficherFormulaireSaisie($cont) {

	if ($cont != "")
	    $ent = $cont->getEntreprise();
	?>
	<form method=post action="">

	    <table width="100%">
		<tr>
		    <td width="50%" align="center">
			<table>
			    <tr>
				<td>Nom</td>
				<td>
				    <input type="text" name="nom"
					<?php
					if (isset($_POST['nom']))
					    echo "value='" . $_POST['nom'] . "'";
					else if ($cont != "")
					    echo "value='" . $cont->getNom() . "'";
					?>/>
				</td>
			    </tr>
			    <tr>
				<td>Prénom</td>
				<td>
				    <input type="text" name="prenom"
					<?php
					if (isset($_POST['prenom']))
					    echo "value='" . $_POST['prenom'] . "'";
					else if ($cont != "")
					    echo "value='" . $cont->getPrenom() . "'";
					?> />
				</td>
			    </tr>
			</table>
		    </td>
		    <td width="50%" align="center">
			<table>
			    <tr>
				<td>Téléphone</td>
				<td>
				    <input type="text" name="tel"
					<?php
					if (isset($_POST['tel']))
					    echo "value='" . $_POST['tel'] . "'";
					else if ($cont != "")
					    echo "value='" . $cont->getTelephone() . "'";
					?> />
				</td>
			    </tr>
			    <tr>
				<td>Fax</td>
				<td>
				    <input type="text" name="fax"
					<?php
					if (isset($_POST['fax']))
					    echo "value='" . $_POST['fax'] . "'";
					else if ($cont != "")
					    echo "value='" . $cont->getTelecopie() . "'";
					?> />
				</td>
			    </tr>
			    <tr>
				<td>Email</td>
				<td>
				    <input type="text" name="email"
					<?php
					if (isset($_POST['email']))
					    echo "value='" . $_POST['email'] . "'";
					else if ($cont != "")
					    echo "value='" . $cont->getEmail() . "'";
					?> />
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td colspan="2" align="center">
			Sélectionnez l'entreprise :
			<select name="idEntreprise">
			    <?php
			    $tabEnt = Entreprise::getListeEntreprises("");
			    for ($i = 0; $i < sizeof($tabEnt); $i++) {
				if ((isset($_POST['idEntreprise']) && ($_POST['idEntreprise'] == $tabEnt[$i]->getIdentifiantBDD())) ||
				    (($cont != "") && ($ent->getIdentifiantBDD() == $tabEnt[$i]->getIdentifiantBDD())))
				    echo "<option selected value='" . $tabEnt[$i]->getIdentifiantBDD() . "'>" . $tabEnt[$i]->getNom() . " (" . $tabEnt[$i]->getVille() . ")</option>";
				else
				    echo "<option value='" . $tabEnt[$i]->getIdentifiantBDD() . "'>" . $tabEnt[$i]->getNom() . " (" . $tabEnt[$i]->getVille() . ")</option>";
			    }
			    ?>
			</select>
		    </td>
		</tr>
		<tr>
		    <td colspan="2" id="submit">
			<input type="hidden" value="1" name="<?php if ($cont != "") echo "edit"; else echo "add"; ?>" />
			<input type="submit" value="Valider" />
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

    public static function afficherListeContacts($tabContacts) {
	for ($i = 0; $i < sizeof($tabContacts); $i++) {
	?>
	<table id="presentation_entreprise">
	    <tr>
		<td width="50%">
		    <?php
		    echo $tabContacts[$i]->getNom() . " " . $tabContacts[$i]->getPrenom() . "<br/>";

		    if ($tabContacts[$i]->getTelephone() != "")
			echo "Tel : " . $tabContacts[$i]->getTelephone() . "<br/>";

		    if ($tabContacts[$i]->getTelecopie() != "")
			echo "Fax : " . $tabContacts[$i]->getTelecopie() . "<br/>";

		    if ($tabContacts[$i]->getEmail() != "")
			echo "Email : " . $tabContacts[$i]->getEmail();
		    ?>
		</td>
		<td width="50%" id="contact">
		    <?php
		    $entreprise = $tabContacts[$i]->getEntreprise();

		    echo "<b>Entreprise</b><br/><br/>";

		    echo $entreprise->getNom() . "<br/>";
		    echo $entreprise->getAdresse() . "<br/>";
		    echo $entreprise->getCodePostal() . " " . $entreprise->getVille() . "<br/>";
		    echo $entreprise->getPays();
		    ?>
		</td>
	    </tr>
	</table>
	<?php
	}
	echo "<br/><br/>";
    }

    public static function afficherListeContactsAEditer($tabContacts) {
	for ($i = 0; $i < sizeof($tabContacts); $i++) {
	?>
	<table id="presentation_entreprise">
	    <tr>
		<td width="50%">
		    <div align="right">
			<a href="modifierContact.php?nom=<?php if (isset($_POST['nom'])) echo $_POST['nom']; ?>&prenom=<?php if (isset($_POST['prenom'])) echo $_POST['prenom']; ?>&tel=<?php if (isset($_POST['tel'])) echo $_POST['tel']; ?>&fax=<?php if (isset($_POST['fax'])) echo $_POST['fax']; ?>&id=<?php echo $tabContacts[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
			<a href="modifierListeContacts.php?nom=<?php if (isset($_POST['nom'])) echo $_POST['nom']; ?>&prenom=<?php if (isset($_POST['prenom'])) echo $_POST['prenom']; ?>&tel=<?php if (isset($_POST['tel'])) echo $_POST['tel']; ?>&fax=<?php if (isset($_POST['fax'])) echo $_POST['fax']; ?>&id=<?php echo $tabContacts[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </div>
		    <?php
		    echo $tabContacts[$i]->getNom() . " " . $tabContacts[$i]->getPrenom() . "<br/>";

		    if ($tabContacts[$i]->getTelephone() != "")
			echo "Tel : " . $tabContacts[$i]->getTelephone() . "<br/>";

		    if ($tabContacts[$i]->getTelecopie() != "")
			echo "Fax : " . $tabContacts[$i]->getTelecopie() . "<br/>";

		    if ($tabContacts[$i]->getEmail() != "")
			echo "Email : " . $tabContacts[$i]->getEmail();
		    ?>
		</td>
		<td width="50%" id="contact">
		    <?php
		    $entreprise = $tabContacts[$i]->getEntreprise();

		    echo "<b>Entreprise</b><br/><br/>";

		    echo $entreprise->getNom() . "<br/>";
		    echo $entreprise->getAdresse() . "<br/>";
		    echo $entreprise->getCodePostal() . " " . $entreprise->getVille() . "<br/>";
		    echo $entreprise->getPays();
		    ?>
		</td>
	    </tr>
	</table>
	<?php
    }

    }
}

?>