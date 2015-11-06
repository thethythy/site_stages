<?php

include_once("../../classes/moteur/Couleur.php");
include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/bdd/connec.inc");

class Couleur_IHM {
	
	public static function afficherFormulaireSaisie() { ?>
            <FORM METHOD="POST" ACTION="">
                <table id="table_saisieCouleur">
                    <tr><td colspan=2>
                            <table id="presentation_saisieCouleur">
                                <tr id="entete2">
                                    <td colspan=2>Saisir une couleur</td>
				</tr>
				<tr>
                                    <th width="100">Nom :</th>
                                    <td><input type="text" name="nomCouleur" /></td>
				</tr>
				<tr>
                                    <th>Couleur :</th>
                                    <td><input id="colorPicker" type="color" name="codeHexa" value="#FFFFFF"/></td>
				</tr>
                                <tr>
                                    <td colspan=2><input type=submit value="Enregistrer les données"/><input type=reset value="Effacer" onclick="effacerCouleur()"/></td>
				</tr>
                            </table>
                       </td></tr> 
		</table>
            </FORM>
            <script>
                function effacerCouleur() {
                    document.getElementById("colorPicker").value = '#FFFFFF';
                }
            </script>
	<?php }
	
	public static function afficherFormulaireModification(){ ?>
            <FORM id="formModifCouleur" METHOD="POST" ACTION="" name="sd">
                <table id="table_msCouleur">
                    <tr><td colspan=2>
                            <table id="presentation_msCouleur">
				<tr id="entete2">
                                    <td colspan=2>Modifier/Supprimer une couleur</td>
				</tr>
				<tr>
                                    <th width="220">Sélectionner la couleur : </th>
                                    <th>
                                        <?php
                                            $tabCouleur = Couleur::listerCouleur();
                                            echo "<select id='couleur' name='couleur' onchange='showColor()'>";	
                                            echo "<option  value='-1' selected></option>";
                                            for($i=0; $i<sizeof($tabCouleur); $i++) {		
                                                echo "<option value='".$tabCouleur[$i]->getIdentifiantBDD()."'name='".$tabCouleur[$i]->getNom()."' style='color: #".$tabCouleur[$i]->getCode().";'> ".$tabCouleur[$i]->getNom()."</option>";
                                            }
                                            echo "</select>";
					?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input id="couleurActuel" readonly="disabled" style="width: 100px; border-width: 0px;"/>
                                    </th>
				</tr>
				<tr>
                                    <td colspan=2>
                                        <input type=submit value="Modifier une couleur" />
					<input type=submit value="Supprimer une couleur" onclick="this.form.action='../../gestion/parrains/sup_couleur.php'"/>
                                    </td>
				</tr>
                            </table>
                        </td></tr>
                   </table>
            </FORM>
            <script>
                function showColor() {
                    var couleurActuelHTML = document.getElementById("couleurActuel");
                    var couleurHTML = document.getElementById("couleur");
                    couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
                }
            </script>
	<?php }
}
?>