<?php

header ('Content-type:text/html; charset=utf-8');

$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/TypeEntreprise_IHM.php");
include_once($chemin."moteur/TypeEntreprise.php");
include_once($chemin."moteur/Couleur.php");

class TypeEntreprise_IHM {

	public static function afficherFormulaireSaisie(){ 
		?>

		<FORM METHOD="POST" ACTION="">
			<table id="table_saisieType">
				<tr><td colspan=2>
                <table id="presentation_saisieType">
                    <tr id="entete2">
                        <td colspan=2>Saisir un type d'entreprise</td>
                        <td><input type="text" name="type" ></td>
                    </tr>
                    <tr id="entete2">
                        <th>Sélectionnez la couleur :</th>
                        <td>
                            <select id="idCouleur" name="idCouleur" onchange='showColor()'>
                                <?php
                                $tabCouleur = Couleur::listerCouleur();

                                for ($i = 0; $i < sizeof($tabCouleur); $i++)
                                    echo "<option value='" . $tabCouleur[$i]->getIdentifiantBDD() . "' style='color: #" . $tabCouleur[$i]->getCode() . ";'>" . $tabCouleur[$i]->getNom() . "</option>";
                                ?>
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;<input id="couleurActuel" readonly="disabled" style="background-color: <?php echo '#' . $tabCouleur[0]->getCode(); ?>; width: 100px; border-width: 0px;"/></td>
                    </tr>
                    <tr>
                        <td colspan=2><input type=submit value="Enregistrer le type"/><input type=reset value="Effacer"/></td>
                    </tr>
              		<tr id="entete2">
        				<td colspan=2>Liste des types</td>
              		</tr>
                </table>
                <?php
                    $tabType = TypeEntreprise::getListeTypeEntreprise();
                    for ($i = 0; $i < sizeof($tabType); $i++) {
                        $couleur = $tabType[$i]->getCouleur();
                ?>
                <table id="presentation_type">
                    <tr>
                        <td width="220" align="right"><?php echo "<FONT COLOR=#".$couleur->getCode().">";
                            echo $tabType[$i]->getType()." -";?>
                            </FONT>
                        </td>
                        <td>
                            <?php echo "- ".$couleur->getNom(); ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?> 
                </table>
			</table>
		</FORM>
		<script>
        function showColor() {
            var couleurActuelHTML = document.getElementById("couleurActuel");
            var couleurHTML = document.getElementById("idCouleur");
            couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
        }
    	</script>

		<?php 
	}


	public static function afficherFormulaireModification(){
			?>
			<FORM id="formModifType" METHOD="POST" ACTION="">
            <table id="table_modifType">
                <tr><td colspan=2>
                <table id="presentation_modifType">
                    <tr id="entete2">
                        <td colspan=2>Modifier/Supprimer un type d'entreprise</td>
                    </tr>
                    <tr>
                        <th width="220">Sélectionnez le type : </th>
                        <th>
                            <?php
							$tabTypeEntreprise = TypeEntreprise::getListeTypeEntreprise();
							echo "<select name='type'>";
							echo "<option value='-1' selected>---Type Entreprise---</option>";
							for($i=0; $i<sizeof($tabTypeEntreprise); $i++) {
								$couleur = $tabTypeEntreprise[$i]->getCouleur();
								echo "<option value='".$tabTypeEntreprise[$i]->getIdentifiantBDD()."'style='color: #" . $couleur->getCode() . ";'>".$tabTypeEntreprise[$i]->getType()."</option>";
							}
							echo "</select>";
                            ?>
                        </th>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <input type=submit value="Modifier" />
                            <input type=submit value="Supprimer" onclick="this.form.action='../../gestion/entreprises/supTypeEntreprise.php'"/>
                        </td>
                    </tr>
                </table>
            </table>
        	</FORM>
        	<?php
		}
	}
?>