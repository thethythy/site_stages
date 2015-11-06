<?php

class OffreDeStage_IHM {

    public static function afficherFormulaireRecherche($fichier) {
	?>
	<form action="javascript:">
	    <table width="100%">
		<tr>
		    <td width="70%" align="center">
			<table>
			    <tr>
				<td>Nom de l'entreprise</td>
				<td>
				    <input id="nom" type="text" value="<?php if (isset($_POST['nom'])) { echo $_POST['nom']; } ?>" name="nom"/>
				</td>
			    </tr>
			    <tr>
				<td>Numéro département (ou code postal)</td>
				<td>
				    <input id="cp" type="text" value="<?php if (isset($_POST['cp'])) { echo $_POST['cp']; } ?>"name="cp"/>
				</td>
			    </tr>
			    <tr>
				<td>Diplôme</td>
				<td>
				    <select id="filiere" name="filiere">
					<?php
					    echo "<option value='*'>Tous</option>";

					    $tabF = Filiere::listerFilieres();

					    for ($i = 0; $i < sizeof($tabF); $i++) {
						if ($_POST['filiere'] == $tabF[$i]->getIdentifiantBDD())
						    echo "<option selected value='" . $tabF[$i]->getIdentifiantBDD() . "'>" . $tabF[$i]->getNom() . "</option>";
						else
						    echo "<option value='" . $tabF[$i]->getIdentifiantBDD() . "'>" . $tabF[$i]->getNom() . "</option>";
					    }
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td>Durée</td>
				<td>
				    <select id="duree" name="duree"><option value='*'>Indifférent </option>
					<?php
					    for ($i = 1; $i <= 12; $i++) {
						if (isset($_POST['duree']) && $_POST['duree'] == $i) {
						    echo "<option selected value='$i'>$i</option>";
						} else {
						    echo"<option value='$i'>$i</option>";
						}
					    }
					?>
				    </select>
				    mois
				</td>
			    </tr>
			</table>
		    </td>
		    <td width="30%">
			<table>
			    <tr>
				<td>Ville</td>
				<td>
				    <input id="ville" type="text" value="<?php if (isset($_POST['ville'])) { echo $_POST['ville']; } ?>" name="ville"/>
				</td>
			    </tr>
			    <tr>
				<td>Pays</td>
				<td>
				    <input id="pays" type="text" value="<?php if (isset($_POST['pays'])) { echo $_POST['pays']; } ?>" name="pays"/>
				</td>
			    </tr>
			    <tr>
				<td>Spécialité</td>
				<td>
				    <select id="parcours" name="parcours">
					<?php
					    echo "<option value='*'>Toutes</option>";

					    $tabP = Parcours::listerParcours();

					    for ($i = 0; $i < sizeof($tabP); $i++) {
						if ($_POST['parcours'] == $tabP[$i]->getIdentifiantBDD())
						    echo "<option selected value='" . $tabP[$i]->getIdentifiantBDD() . "'>" . $tabP[$i]->getNom() . "</option>";
						else
						    echo "<option value='" . $tabP[$i]->getIdentifiantBDD() . "'>" . $tabP[$i]->getNom() . "</option>";
					    }
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td>Compétence</td>
				<td>
				    <select id="competence" name="competence">
					<?php
					    echo "<option value='*'>Toutes</option>";

					    $tabC = Competence::listerCompetences();

					    for ($i = 0; $i < sizeof($tabC); $i++) {
						if ($_POST['competence'] == $tabC[$i]->getIdentifiantBDD())
						    echo "<option selected value='" . $tabC[$i]->getIdentifiantBDD() . "'>" . $tabC[$i]->getNom() . "</option>";
						else
						    echo "<option value='" . $tabC[$i]->getIdentifiantBDD() . "'>" . $tabC[$i]->getNom() . "</option>";
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
	    var table_onchange = new Array("filiere", "parcours", "duree", "competence");
	    new LoadData(table_onchange, "<?php echo $fichier; ?>", "onchange");
	    var table_onkeyup = new Array("nom", "ville", "cp", "pays");
	    new LoadData(table_onkeyup, "<?php echo $fichier; ?>", "onkeyup");
	</script>

    <?php
    }

    public static function afficherFormulaireSaisie() {
	?>
	<script language="javascript">
	    var compteur = 0; // Compteur des compétences ajoutées
	    function ajout_competence(){
		var child1 = document.createTextNode("Nom : ");
		var child2 = document.createElement("input");
		var child3 = document.createElement("br");
		child2.setAttribute("type", 'text');
		child2.setAttribute("name", 'competence_ajout' + compteur);
		document.getElementById('ajout_competence').appendChild(child1);
		document.getElementById('ajout_competence').appendChild(child2);
		document.getElementById('ajout_competence').appendChild(child3);
		compteur++;
	    }
	</script>

	<p>Les champs marqués d'une * sont obligatoires</p>

	<FORM METHOD="POST" ACTION="">

	    <!-- Dans le cas d'une modification d'une offre de stage -->
	    <table id="table_saisieOffreDeStage">
		<tr>
		    <td>
			<table id="presentation_saisieOffreDeStage">
			    <tr id="entete2">
				<td colspan="2">Le stage</td>
			    </tr>
			    <tr>
				<th>Titre du stage (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['titre'])) { echo $_POST['titre']; } ?>" name="titre" size="100"/></td>
			    </tr>
			    <tr>
				<th>Sujet du stage (*) :</th>
				<td><textarea name="sujet"><?php if (isset($_POST['sujet'])) { echo $_POST['sujet']; } ?></textarea></td>
			    </tr>
			    <tr>
				<th colspan="2"><p/><hr/><p/></th>
			    </tr>
			    <tr>
				<th>Compétence(s) (*) :</th>
			    </tr>
			    <tr>
				<td colspan="2">
				    <table>
					<!-- Récupération des compétences -->
					<?php
					$tabCompetences = Competence::listerCompetences();
					for ($i = 0; $i < sizeof($tabCompetences); $i++) {
					    if ($i % 6 == 0) {
						echo "<tr>";
					    }
					    if (isset($_POST['competence' . $tabCompetences[$i]->getIdentifiantBDD()])) {
						echo "<td width='100'><input checked='checked' type='checkbox' value='" . $tabCompetences[$i]->getIdentifiantBDD() . "' name='competence" . $tabCompetences[$i]->getIdentifiantBDD() . "'> " . $tabCompetences[$i]->getNom() . "</td>";
					    } else {
						echo "<td width='100'><input type='checkbox' value='" . $tabCompetences[$i]->getIdentifiantBDD() . "' name='competence" . $tabCompetences[$i]->getIdentifiantBDD() . "'> " . $tabCompetences[$i]->getNom() . "</td>";
					    }
					    if ($i % 6 == 6) {
						echo "</tr>";
					    }
					}
					?>
				    </table>
				</td>
			    </tr>
			    <tr>
				<td colspan="2">
				    <input type="button" value="Ajouter une compétence" onClick="ajout_competence()"/>
				    <div id="ajout_competence"></div>
				</td>
			    </tr>
			    <tr>
				<th>Environnement(s) :</th>
			    </tr>
			    <tr>
				<td colspan="2">
				    <table>
					<tr>
					    <td width="100"><input <?php if (isset($_POST['environnementWin'])) { echo "checked='checked'"; } ?> type="checkbox" value="win" name="environnementWin"> Windows</td>
					    <td width="100"><input <?php if (isset($_POST['environnementUnix'])) { echo "checked='checked'"; } ?>type="checkbox" value="unix" name="environnementUnix"> Unix/Linux</td>
					    <td width="100"><input <?php if (isset($_POST['environnementMac'])) { echo "checked='checked'"; } ?>type="checkbox" value="mac" name="environnementMac"> Macintosh</td>
					</tr>
				    </table>
				</td>
			    </tr>
			    <tr>
				<th>Profil souhaité (*) :</th>
			    </tr>
			    <tr>
				<td colspan="2">
				    <table>
					<!-- Récupération des filières -->
					<?php
					    $tabFilieres = Filiere::listerFilieres();
					    for ($i = 0; $i < sizeof($tabFilieres); $i++) {
						if ($i % 5 == 0) {
						    echo "<tr>";
						}
						if (isset($_POST['filiere' . $tabFilieres[$i]->getIdentifiantBDD()])) {
						    echo "<td width='150'><input checked='checked' type='checkbox' value='" . $tabFilieres[$i]->getIdentifiantBDD() . "'name='filiere" . $tabFilieres[$i]->getIdentifiantBDD() . "'> " . $tabFilieres[$i]->getNom() . "</td>";
						} else if ($tabFilieres[$i]->getAffDepot() == 1) {
						    echo "<td width='150'><input type='checkbox' value='" . $tabFilieres[$i]->getIdentifiantBDD() . "'name='filiere" . $tabFilieres[$i]->getIdentifiantBDD() . "'> " . $tabFilieres[$i]->getNom() . "</td>";
						}
						if ($i % 5 == 5) {
						    echo "</tr>";
						}
					    }
					?>
				    </table>
				</td>
			    </tr>
			    <tr>
				<th colspan="2"><p/><hr/><p/></th>
			    </tr>
			    <tr>
				<th>Durée (*) :</th>
				<td>Entre <select name="dureeMin">
					    <?php
						for ($i = 1; $i <= 12; $i++) {
						    if (isset($_POST['dureeMin']) && $_POST['dureeMin'] == $i) {
							echo"<option selected value='$i'>$i</option>";
						    } else {
							echo"<option value='$i'>$i</option>";
						    }
						}
					    ?>
				    </select> et <select name="dureeMax">
					    <?php
						for ($i = 1; $i <= 12; $i++) {
						    if (isset($_POST['dureeMax']) && $_POST['dureeMax'] == $i) {
							echo"<option selected value='$i'>$i</option>";
						    } else {
							echo"<option value='$i'>$i</option>";
						    }
						}
					    ?>
				    </select>
				    mois
				</td>
			    </tr>
			    <tr>
				<th>Indemnités :</th>
				<td><input type="text" value="<?php if (isset($_POST['indemnites'])) { echo $_POST['indemnites']; } ?>" name="indemnites" size="100"/></td>
			    </tr>
			    <tr>
				<th>Remarques diverses :</th>
				<td><textarea name="rmq"><?php if (isset($_POST['rmq'])) { echo $_POST['rmq']; } ?></textarea></td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td>
			<table id="presentation_saisieOffreDeStage">
			    <tr id="entete2">
				<td colspan=2>L'entreprise</td>
			    </tr>
			    <tr>
				<th width="170">Nom (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['nom_entreprise'])) { echo $_POST['nom_entreprise']; } ?>" name="nom_entreprise" size="50"/></td>
			    </tr>
			    <tr>
				<th>Adresse (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['adresse'])) { echo $_POST['adresse']; } ?>" name="adresse" size="50"/></td>
			    </tr>
			    <tr>
				<th>Ville (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['ville'])) { echo $_POST['ville']; } ?>" name="ville" size="50"/></td>
			    </tr>
			    <tr>
				<th>Code postal (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['codePostal'])) { echo $_POST['codePostal']; } ?>" name="codePostal" size="50"/></td>
			    </tr>
			    <tr>
				<th>Pays :</th>
				<td><input type="text" value="<?php if (isset($_POST['pays'])) { echo $_POST['pays']; } else { echo 'FRANCE'; } ?>" name="pays" size="50"/></td>
			    </tr>
			    <tr>
				<th>Email DRH ou équivalent :</th>
				<td><input type="text" value="<?php if (isset($_POST['email_entreprise'])) { echo $_POST['email_entreprise']; } else { echo ""; } ?>" name="email_entreprise" size="50"></td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td>
			<table id="presentation_saisieOffreDeStage">
			    <tr id="entete2">
				<td colspan=2>Contact ou maître de stage</td>
			    </tr>
			    <tr>
				<th width='170'>Nom (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['nom_contact'])) { echo $_POST['nom_contact']; } ?>" name="nom_contact" size="50"/></td>
			    </tr>
			    <tr>
				<th>Prénom (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['prenom_contact'])) { echo $_POST['prenom_contact']; } ?>" name="prenom_contact" size="50"/></td>
			    </tr>
			    <tr>
				<th>Tel (*) :</th>
				    <td><input type="text" value="<?php if (isset($_POST['tel_contact'])) { echo $_POST['tel_contact']; } ?>" name="tel_contact" size="50"/></td>
			    </tr>
			    <tr>
				<th>Fax :</th>
				<td><input type="text" value="<?php if (isset($_POST['fax_contact'])) { echo $_POST['fax_contact']; } ?>" name="fax_contact" size="50"/></td>
			    </tr>
			    <tr>
				<th>Email (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['email_contact'])) { echo $_POST['email_contact']; } ?>" name="email_contact" size="50"/></td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td align="center"><input type="submit" value="Envoyer"></td>
		</tr>
	    </table>
	</FORM>
    <?php
    }

    public static function afficherFormulaireModification() { ?>
	<script language="javascript">
	    function ajout_competence(){
		var code="";
		var compteur=parseInt(document.getElementById('compteur_competence').value);
		code = "Nom : <input type='text' name='competence_ajout"+compteur+"'/><br/> ";
		compteur+=1;
		document.getElementById('compteur_competence').value=compteur;
		document.getElementById('ajout_competence').innerHTML+=code;
	    }
	</script>

	<p>Les champs marqués d'une * sont obligatoires</p>

	<FORM METHOD="POST" ACTION="">
	    <!-- Dans le cas d'une modification d'une offre de stage -->
	    <?php
		if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		    ?>
			<input type="hidden" value="<?php echo $_GET['id']; ?>" name="idOffreDeStage"/>
		    <?php
			$modificationOffreDeStage = OffreDeStage::getOffreDeStage($_GET['id']);
			$modificationCompetences = $modificationOffreDeStage->getListesCompetences();
			$modificationThemes = $modificationOffreDeStage->getThemes();
			$modificationProfils = $modificationOffreDeStage->getListeProfilSouhaite();
			$modificationContact = $modificationOffreDeStage->getContact();
			$modificationEntreprise = $modificationContact->getEntreprise();
			$environnement = array();
			$environnement = explode(";", $modificationOffreDeStage->getListeEnvironnements());
		}
	    ?>

	    <input type="hidden" value="<?php if (isset($modificationOffreDeStage)) { echo $modificationOffreDeStage->estVisible(); } ?>" name="estVisible"/>

	    <table id="table_saisieOffreDeStage">
		<tr>
		    <td colspan=2>
			<table id="presentation_saisieOffreDeStage">
			    <tr id="entete2">
				<td colspan=2>Stage</td>
			    </tr>
			    <tr>
				<th>Titre du stage (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['titre'])) { echo $_POST['titre']; } else if (isset($modificationOffreDeStage)) { echo htmlentities($modificationOffreDeStage->getTitre(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="titre" size="100"></td>
			    </tr>
			    <tr>
				<th>Sujet du stage (*) :</th>
				<td><textarea name="sujet"><?php if (isset($_POST['sujet'])) { echo $_POST['sujet']; } else if (isset($modificationOffreDeStage)) { echo $modificationOffreDeStage->getSujet(); } ?></textarea></td>
			    </tr>
			    <tr>
				<td colspan="2">
				    Copier/coller le texte suivant pour insérer un lien html vers un document descriptif :<br/>
				    <?php echo htmlentities("<a href='http://info-stages.univ-lemans.fr/documents/sujetsDeStages/nom_document'>Commentaire</a>"); ?>
				</td>
			    </tr>
			    <tr>
				<th colspan="2"><p/><hr/><p/></th>
			    </tr>
			    <tr>
				<th colspan="2">Compétence(s) (*) :</th>
			    </tr>
			    <tr>
				<td colspan="2">
				    <table>
					<!-- Récupération des compétences -->
					<?php
					    $tabCompetences = Competence::listerCompetences();
					    for ($i = 0; $i < sizeof($tabCompetences); $i++) {
						if ($i % 6 == 0) {
						    echo "<tr>";
						}
						if (isset($_POST['competence' . $tabCompetences[$i]->getIdentifiantBDD()])) {
						    echo "<td width='100'><input checked='checked' type='checkbox' value='" . $tabCompetences[$i]->getIdentifiantBDD() . "' name='competence" . $tabCompetences[$i]->getIdentifiantBDD() . "'> " . $tabCompetences[$i]->getNom() . "</td>";
						} else {
						    $competenceTrouve = false;
						    if (isset($modificationCompetences)) {
							for ($j = 0; $j < sizeof($modificationCompetences); $j++) {
							    if ($modificationCompetences[$j]->getIdentifiantBDD() == $tabCompetences[$i]->getIdentifiantBDD()) {
								$competenceTrouve = true;
							    }
							}
						    }
						    if ($competenceTrouve) {
							echo "<td width='100'><input checked='checked' type='checkbox' value='" . $tabCompetences[$i]->getIdentifiantBDD() . "' name='competence" . $tabCompetences[$i]->getIdentifiantBDD() . "'> " . $tabCompetences[$i]->getNom() . "</td>";
						    } else {
							echo "<td width='100'><input type='checkbox' value='" . $tabCompetences[$i]->getIdentifiantBDD() . "' name='competence" . $tabCompetences[$i]->getIdentifiantBDD() . "'> " . $tabCompetences[$i]->getNom() . "</td>";
						    }
						}
						if ($i % 6 == 6) {
						    echo "</tr>";
						}
					    }
					?>
				    </table>
				</td>
			    </tr>
			    <tr>
				<td colspan="2">
				    <input type="button" value="Ajouter une compétence" onClick="ajout_competence()">
				    <input type="hidden" value="0" name="compteur_competence" id="compteur_competence"/>
				    <div id="ajout_competence"></div>
				</td>
			    </tr>
			    <tr>
				<th colspan="2">Environnement(s) :</th>
			    </tr>
			    <tr>
				<td colspan="2">
				    <table>
					<tr>
					    <?php
						$winTrouve = false;
						$unixTrouve = false;
						$macTrouve = false;
						if (isset($environnement)) {
						    for ($i = 0; $i < sizeof($environnement); $i++) {
							if ($environnement[$i] == "win")
							    $winTrouve = true;
							if ($environnement[$i] == "unix")
							    $unixTrouve = true;
							if ($environnement[$i] == "mac")
							    $macTrouve = true;
						    }
						}
					    ?>
					    <td width="100">
						<input <?php if (isset($_POST['environnementWin']) || $winTrouve) { echo "checked='checked'"; } ?> type="checkbox" value="win" name="environnementWin"/> Windows
					    </td>
					    <td width="100">
						<input <?php if (isset($_POST['environnementUnix']) || $unixTrouve) { echo "checked='checked'"; } ?>type="checkbox" value="unix" name="environnementUnix"/> Unix/Linux
					    </td>
					    <td width="100">
						<input <?php if (isset($_POST['environnementMac']) || $macTrouve) { echo "checked='checked'"; } ?>type="checkbox" value="mac" name="environnementMac"/> Macintosh
					    </td>
					</tr>
				    </table>
				</td>
			    </tr>
			    <tr>
				<th colspan="2">Thème du stage :</th>
			    </tr>
			    <tr>
				<td colspan="2">
				    <table>
					<!-- Récupération des parcours -->
					<?php
					$tabParcours = Parcours::listerParcours();
					for ($i = 0; $i < sizeof($tabParcours); $i++) {
					    if ($i % 5 == 0) {
						echo "<tr>";
					    }
					    if (isset($_POST['parcours' . $tabParcours[$i]->getIdentifiantBDD()])) {
						echo "<td width='150'><input checked='checked' type='checkbox' value='" . $tabParcours[$i]->getIdentifiantBDD() . "'name='parcours" . $tabParcours[$i]->getIdentifiantBDD() . "'> " . $tabParcours[$i]->getNom() . "</td>";
					    } else {
						$themeTrouve = false;
						if (isset($modificationThemes)) {
						    for ($j = 0; $j < sizeof($modificationThemes); $j++) {
							if ($modificationThemes[$j]->getIdentifiantBDD() == $tabParcours[$i]->getIdentifiantBDD()) {
							    $themeTrouve = true;
							}
						    }
						}
						if ($themeTrouve) {
						    echo "<td width='150'><input checked='checked' type='checkbox' value='" . $tabParcours[$i]->getIdentifiantBDD() . "'name='parcours" . $tabParcours[$i]->getIdentifiantBDD() . "'> " . $tabParcours[$i]->getNom() . "</td>";
						} else {
						    echo "<td width='150'><input type='checkbox' value='" . $tabParcours[$i]->getIdentifiantBDD() . "'name='parcours" . $tabParcours[$i]->getIdentifiantBDD() . "'> " . $tabParcours[$i]->getNom() . "</td>";
						}
					    }
					    if ($i % 5 == 5) {
						echo "</tr>";
					    }
					}
					?>
				    </table>
				</td>
			    </tr>
			    <tr>
				<th colspan="2">Profil souhaité :</th>
			    </tr>
			    <tr>
				<td colspan="2">
				    <table>
					<!-- Récupération des filières -->
					<?php
					    $tabFilieres = Filiere::listerFilieres();
					    for ($i = 0; $i < sizeof($tabFilieres); $i++) {
						if ($i % 5 == 0) {
						    echo "<tr>";
						}
						if (isset($_POST['filiere' . $tabFilieres[$i]->getIdentifiantBDD()])) {
						    echo "<td width='150'><input checked='checked' type='checkbox' value='" . $tabFilieres[$i]->getIdentifiantBDD() . "'name='filiere" . $tabFilieres[$i]->getIdentifiantBDD() . "'> " . $tabFilieres[$i]->getNom() . "</td>";
						} else {
						    $profilTrouve = false;
						    if (isset($modificationProfils)) {
							for ($j = 0; $j < sizeof($modificationProfils); $j++) {
							    if ($modificationProfils[$j]->getIdentifiantBDD() == $tabFilieres[$i]->getIdentifiantBDD()) {
								$profilTrouve = true;
							    }
							}
						    }
						    if ($profilTrouve) {
							echo "<td width='150'><input checked='checked' type='checkbox' value='" . $tabFilieres[$i]->getIdentifiantBDD() . "'name='filiere" . $tabFilieres[$i]->getIdentifiantBDD() . "'> " . $tabFilieres[$i]->getNom() . "</td>";
						    } else {
							echo "<td width='150'><input type='checkbox' value='" . $tabFilieres[$i]->getIdentifiantBDD() . "'name='filiere" . $tabFilieres[$i]->getIdentifiantBDD() . "'> " . $tabFilieres[$i]->getNom() . "</td>";
						    }
						}
						if ($i % 5 == 5) {
						    echo "</tr>";
						}
					    }
					?>
				    </table>
				</td>
			    </tr>
			    <tr>
				<th colspan="2"><p/><hr/><p/></th>
			    </tr>
			    <tr>
				<th>Durée (*) :</th>
				<td>Entre <select name="dureeMin">
					<?php
					    for ($i = 1; $i <= 12; $i++) {
						if ((isset($modificationOffreDeStage) && $modificationOffreDeStage->getDureeMinimale() == $i) || (isset($_POST['dureeMin']) && $_POST['dureeMin'] == $i)) {
						    echo"<option selected value='$i'>$i</option>";
						} else {
						    echo"<option value='$i'>$i</option>";
						}
					    }
					?>
				    </select> et <select name="dureeMax">
					<?php
					    for ($i = 1; $i <= 12; $i++) {
						if ((isset($modificationOffreDeStage) && $modificationOffreDeStage->getDureeMaximale() == $i) || (isset($_POST['dureeMax']) && $_POST['dureeMax'] == $i)) {
						    echo"<option selected value='$i'>$i</option>";
						} else {
						    echo"<option value='$i'>$i</option>";
						}
					    }
					?>
				    </select> mois
				</td>
			    </tr>
			    <tr>
				<th>Indemnités :</th>
				<td>
				    <input type="text" value="<?php if (isset($_POST['indemnites'])) { echo $_POST['indemnites']; } else if (isset($modificationOffreDeStage)) { echo $modificationOffreDeStage->getIndemnite(); } ?>" name="indemnites" size="50"/>
				</td>
			    </tr>
			    <tr>
				<th>Remarques diverses :</th>
				<td>
				    <textarea name="rmq"><?php if (isset($_POST['rmq'])) { echo $_POST['rmq']; } else if (isset($modificationOffreDeStage)) { echo $modificationOffreDeStage->getRemarques(); } ?></textarea>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td colspan=2>
			<table id="presentation_saisieOffreDeStage">
			    <tr id="entete2">
				<td colspan=2>Entreprise</td>
			    </tr>
			    <tr>
				<th width="170">Nom (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['nom_entreprise'])) { echo $_POST['nom_entreprise']; } else if (isset($modificationEntreprise)) { echo htmlentities($modificationEntreprise->getNom(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="nom_entreprise" size="50"/></td>
			    </tr>
			    <tr>
				<th>Adresse (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['adresse'])) { echo $_POST['adresse']; } else if (isset($modificationEntreprise)) { echo htmlentities($modificationEntreprise->getAdresse(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="adresse" size="50"/></td>
			    </tr>
			    <tr>
				<th>Ville (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['ville'])) { echo $_POST['ville']; } else if (isset($modificationEntreprise)) { echo htmlentities($modificationEntreprise->getVille(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="ville" size="50"></td>
			    </tr>
			    <tr>
				<th>Code postal (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['codePostal'])) { echo $_POST['codePostal']; } else if (isset($modificationEntreprise)) { echo htmlentities($modificationEntreprise->getcodePostal(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="codePostal" size="50"/></td>
			    </tr>
			    <tr>
				<th>Pays :</th>
				<td><input type="text" value="<?php if (isset($_POST['pays'])) { echo $_POST['pays']; } else if (isset($modificationEntreprise)) { echo $modificationEntreprise->getPays(); } else { echo 'FRANCE'; } ?>" name="pays" size="50"/></td>
			    </tr>
			    <tr>
				<th>Email DRH ou équivalent :</th>
				<td><input type="text" value="<?php if (isset($_POST['email_entreprise'])) { echo $_POST['email_entreprise']; } else { echo ""; } ?>" name="email_entreprise" size="50"/></td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td colspan="2">
			<table id="presentation_saisieOffreDeStage">
			    <tr id="entete2">
				<td colspan=2>Contact ou Maître de stage</td>
			    </tr>
			    <tr>
				<th width="170">Nom (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['nom_contact'])) { echo $_POST['nom_contact']; } else if (isset($modificationContact)) { echo htmlentities($modificationContact->getNom(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="nom_contact" size="50"/></td>
			    </tr>
			    <tr>
				<th>Prénom (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['prenom_contact'])) { echo $_POST['prenom_contact']; } else if (isset($modificationContact)) { echo htmlentities($modificationContact->getPrenom(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="prenom_contact" size="50"/></td>
			    </tr>
			    <tr>
				<th>Tel (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['tel_contact'])) { echo $_POST['tel_contact']; } else if (isset($modificationContact)) { echo htmlentities($modificationContact->getTelephone(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="tel_contact" size="50"/></td>
			    </tr>
			    <tr>
				<th>Fax :</th>
				<td><input type="text" value="<?php if (isset($_POST['fax_contact'])) { echo $_POST['fax_contact']; } else if (isset($modificationContact)) { echo htmlentities($modificationContact->getTelecopie(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="fax_contact" size="50"/></td>
			    </tr>
			    <tr>
				<th>Email (*) :</th>
				<td><input type="text" value="<?php if (isset($_POST['email_contact'])) { echo $_POST['email_contact']; } else if (isset($modificationContact)) { echo htmlentities($modificationContact->getEmail(), ENT_QUOTES, 'iso-8859-1'); } ?>" name="email_contact" size="50"/></td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td colspan="2"><input type="submit" name="valider" value="Valider l'offre de stage"> <input type="submit" name="cancel" value="Effacer l'offre de stage"></td>
		</tr>
	    </table>
	</FORM>
    <?php
    }

    public static function visualiserOffre($offreDeStage, $page, $nom_init, $ville_init, $cp_init, $pays_init, $filiere_init, $parcours_init, $duree_init, $competence_init) {

	    $competences = $offreDeStage->getListesCompetences();
	    $themes = $offreDeStage->getThemes();
	    $profils = $offreDeStage->getListeProfilSouhaite();
	    $contact = $offreDeStage->getContact();
	    $entreprise = $offreDeStage->getEntreprise();
	    $environnement = array();
	    $environnement = explode(";", $offreDeStage->getListeEnvironnements());
	?>

	<table >
	    <tr>
		<td colspan=2>
		    <table id="presentation_saisieOffreDeStage">
			<tr id="entete2">
			    <td colspan="2">Stage</td>
			</tr>
			<tr>
			    <th>Titre du stage :</th>
			    <td><?php echo $offreDeStage->getTitre(); ?></td>
			</tr>
			<tr>
			    <th>Sujet du stage :</th>
			    <td><?php echo $offreDeStage->getSujet(); ?></td>
			</tr>
			<tr>
			    <th colspan="2"><p/><hr/><p/></th>
			</tr>
			<tr>
			    <th>Compétence(s) :</th>
			    <td>
				<!-- Récupération des compétences -->
				<?php
				    for ($i = 0; $i < sizeof($competences); $i++) {
					$competence = Competence::getCompetence($competences[$i]->getIdentifiantBDD());
					if ($i == (sizeof($competences) - 1)) {
					    echo $competence->getNom();
					} else {
					    echo $competence->getNom() . ", ";
					}
				    }
				?>
			    </td>
			</tr>
			<tr>
			    <th width="160">Environnement(s) :</th>
			    <td>
				<?php
				    $winTrouve = false;
				    $unixTrouve = false;
				    $macTrouve = false;
				    if (isset($environnement)) {
					for ($i = 0; $i < sizeof($environnement); $i++) {
					    if ($environnement[$i] == "win")
						echo " Windows ";
					    if ($environnement[$i] == "unix")
						echo " Unix/Linux ";
					    if ($environnement[$i] == "mac")
						echo " Macintosh ";
					}
				    }
				?>
			    </td>
			</tr>
			<tr>
			    <th>Thème du stage :</th>
			    <td>
				<!-- Récupération des parcours -->
				<?php
				    for ($i = 0; $i < sizeof($themes); $i++) {
					$parcours = Parcours::getParcours($themes[$i]->getIdentifiantBDD());
					if ($i == (sizeof($themes) - 1)) {
					    echo $parcours->getNom();
					} else {
					    echo $parcours->getNom() . ", ";
					}
				    }
				?>
			    </td>
			</tr>
			<tr>
			    <th>Profil souhaité :</th>
			    <td>
				<!-- Récupération des filières -->
				<?php
				    for ($i = 0; $i < sizeof($profils); $i++) {
					$filiere = Filiere::getFiliere($profils[$i]->getIdentifiantBDD());
					if ($i == (sizeof($profils) - 1)) {
					    echo $filiere->getNom();
					} else {
					    echo $filiere->getNom() . ", ";
					}
				    }
				?>
			    </td>
			</tr>
			<tr>
			    <th colspan="2"><p/><hr/><p/></th>
			</tr>
			<tr>
			    <th>Durée :</th>
			    <td>Entre <?php echo $offreDeStage->getDureeMinimale(); ?> et <?php echo $offreDeStage->getDureeMaximale(); ?> mois</td>
			</tr>
			<tr>
			    <th>Indemnités :</th>
			    <td>
				<?php if ($offreDeStage->getIndemnite()) { echo $offreDeStage->getIndemnite(); } else { echo " ";} ?>
			    </td>
			</tr>
			<tr>
			    <th>Remarques diverses :</th>
			    <td><?php echo $offreDeStage->getRemarques(); ?></td>
			</tr>
		    </table>
		</td>
	    </tr>
	    <tr>
		<td colspan=2>
		    <table id="presentation_saisieOffreDeStage">
			<tr id="entete2">
			    <td colspan="2">Entreprise</td>
			</tr>
			<tr>
			    <th width="160">Nom :</th>
			    <td><?php echo $entreprise->getNom(); ?></td>
			</tr>
			<tr>
			    <th>Adresse :</th>
			    <td><?php echo $entreprise->getAdresse(); ?></td>
			</tr>
			<tr>
			    <th>Ville :</th>
			    <td><?php echo $entreprise->getVille(); ?></td>
			</tr>
			<tr>
			    <th>Code postal :</th>
			    <td><?php echo $entreprise->getcodePostal(); ?></td>
			</tr>
			<tr>
			    <th>Pays :</th>
			    <td><?php echo $entreprise->getPays(); ?></td>
			</tr>
		    </table>
		</td>
	    </tr>
	    <tr>
		<td colspan="2">
		    <table id="presentation_saisieOffreDeStage">
			<tr id="entete2">
			    <td colspan="2">Contact ou Maître de stage</td>
			</tr>
			<tr>
			    <th width="160">Nom :</th>
			    <td><?php echo $contact->getNom(); ?></td>
			</tr>
			<tr>
			    <th>Prénom :</th>
			    <td><?php echo $contact->getPrenom(); ?></td>
			</tr>
			<tr>
			    <th>Tel :</th>
			    <td><?php echo $contact->getTelephone(); ?></td>
			</tr>
			<tr>
			    <th>Fax :</th>
			    <td><?php echo $contact->getTelecopie(); ?></td>
			</tr>
			<tr>
			    <th>Email :</th>
			    <td><?php echo $contact->getEmail(); ?></td>
			</tr>
		    </table>
		</td>
	    </tr>
	    <tr>
	    <td align="center">
		<FORM width="500" method="post" action="<?php echo $page; ?>">
		    <?php if ($nom_init != "") echo "<input type='hidden' value='" . $nom_init . "' name='nom'/>" ?>
		    <?php if ($ville_init != "") echo "<input type='hidden' value='" . $ville_init . "' name='ville'/>" ?>
		    <?php if ($cp_init != "") echo "<input type='hidden' value=" . $cp_init . " name='cp'/>" ?>
		    <?php if ($pays_init != "") echo "<input type='hidden' value=" . $pays_init . " name='pays'/>" ?>
		    <?php if ($filiere_init != "") echo "<input type='hidden' value=$filiere_init name='filiere'/>" ?>
		    <?php if ($parcours_init != "") echo "<input type='hidden' value=$parcours_init name='parcours'/>" ?>
		    <?php if ($duree_init != "") echo "<input type='hidden' value=$duree_init name='duree'/>" ?>
		    <?php if ($competence_init != "") echo "<input type='hidden' value=$competence_init name='competence'/>" ?>
		    <input type="hidden" value="1" name="rech" />
		    <input type="submit" value="Retour"/>
		</form>
	    </td>
	</tr>
    </table>
    <?php
    }

}
?>