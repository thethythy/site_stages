<?php
$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/TypeEntreprise.php");

class TypeEntreprise_IHM {

	public static function afficherFormulaireSaisie(){ 
		?>
		<FORM METHOD="POST" ACTION="">
			<table id="table_saisieType">
				<tr><td colspan=2>
                <table id="presentation_saisieType">
                    <tr id="entete2">
                        <td colspan=2>Saisir un type dd'entreprise</td>
                        <td><input type="text" name="type" ></td>
                    </tr>
                    <tr>
                        <td colspan=2><input type=submit value="Enregistrer le type"/><input type=reset value="Effacer"/></td>
                    </tr>
                </table>
			</table>
		</FORM>

		<?php 
	}

	public static function afficherFormulaireModification(){
			?>
			<FORM id="formModifType" METHOD="POST" ACTION="">
            <table id="table_modifType">
                <tr><td colspan=2>
                <table id="presentation_modifType">
                    <tr id="entete2">
                        <td colspan=2>Modifier/Supprimer un type d'entreprise'</td>
                    </tr>
                    <tr>
                        <th width="220">Sélectionnez le type : </th>
                        <th>
                            <?php
							$tabTypeEntreprise = TypeEntreprise::getListeTypeEntreprise();
							echo "<select name='typeEntreprise'>";
							echo "<option value='-1' selected></option>";
							for($i=0; $i<sizeof($tabTypeEntreprise); $i++) {
								$id = $tabTypeEntreprise[$i]->getIdentifiantBDD();
								$type = $tabTypeEntreprise[$i]->getTypeEntreprise($id)->getType();
								echo "<option value='$id'>$type</option>"; 
							}
							echo "</select>";
                            ?>
                        </th>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <input type=submit value="Modifier un type" />
                            <input type=submit value="Supprimer un type" onclick="this.form.action='../../gestion/entreprises/supTypeEntreprise.php'"/>
                        </td>
                    </tr>
                </table>
            </table>
        	</FORM>
        	<?php
		}
	}
?>