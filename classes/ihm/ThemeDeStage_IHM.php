<?php
$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."moteur/ThemeDeStage.php");
include_once($chemin."moteur/Couleur.php");

class ThemeDeStage_IHM {
	
	public static function afficherFormulaireSaisie() {
		?>
		<FORM METHOD="POST" ACTION="">
        <table id="table_saisieTheme">
            <tr><td colspan=2>
                    <table id="presentation_saisieTheme">
                        <tr id="entete2">
                            <td colspan=2>Saisir un thème de stage</td>
                            <td><input type="text" name="theme" ></td>
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
                            <td colspan=2><input type=submit value="Ajouter"/><input type=reset value="Effacer"/></td>
                        </tr>
                        <tr id="entete2">
                            <td colspan=2>Liste des themes</td>
                        </tr>
                    </table>
                    <?php
                        $tabTheme = ThemeDeStage::getListeTheme();
                        for ($i = 0; $i < sizeof($tabTheme); $i++) {
                            $couleur = $tabTheme[$i]->getCouleur();
                    ?>
                    <table id="presentation_theme">
                        <tr>
                            <td width="220" align="right"><?php echo "<FONT COLOR=#".$couleur->getCode().">";
                                echo $tabTheme[$i]->getTheme()." -";?>
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
		<FORM id="formModifTheme" METHOD="POST" ACTION="">
        <table id="table_msTheme">
            <tr><td colspan=2>
                    <table id="presentation_msTheme">
                        <tr id="entete2">
                            <td colspan=2>Modifier/Supprimer un thème de stage</td>
                        </tr>
                        <tr>
                            <th width="220">Sélectionnez le thème : </th>
                            <th>
                                <?php
                                $tabTheme = ThemeDeStage::getListeTheme();
                                echo "<select name=theme>";
                                echo "<option  value='-1' selected>---Theme de stage---</option>";

                                for ($i = 0; $i < sizeof($tabTheme); $i++) {
                                    $couleur = $tabTheme[$i]->getCouleur();

                                	echo "<option value='".$tabTheme[$i]->getIdTheme()."'style='color: #" . $couleur->getCode() . ";'>".$tabTheme[$i]->getTheme()."</option>";
                                }
                                echo "</select>";
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <input type=submit value="Modifier" />
                                <input type=submit value="Supprimer" onclick="this.form.action='../../gestion/conventions/sup_themeDeStage.php'"/>
                            </td>
                        </tr>
                    </table>
        </table>
    	</FORM>
    	<?php
	}
}
?>