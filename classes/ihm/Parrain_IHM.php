<?php
include_once("../../classes/moteur/Parrain.php");
include_once("../../classes/bdd/Parrain_BDD.php");
include_once("../../classes/moteur/Couleur.php");
include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/bdd/connec.inc");

class Parrain_IHM {

    public static function afficherFormulaireSaisie() {
        ?>
        <FORM METHOD="POST" ACTION="">
            <table id="table_saisieParrain">
                <tr><td colspan=2>
                        <table id="presentation_saisieParrain">
                            <tr id="entete2">
                                <td colspan=2>Saisir un référent</td>
                            </tr>
                            <tr>
                                <th width="200">Nom :</th>
                                <td><input type="text" name="nomParrain" ></td>
                            </tr>
                            <tr>
                                <th>Prénom :</th>
                                <td><input type="text" name="prenomParrain" ></td>
                            </tr>
                            <tr>
                                <th>Email :</th>
                                <td><input type="text" name="emailParrain" ></td>
                            </tr>
                            <tr>
                                <th>Sélectionnez la couleur :</th>
                                <td><select id="idCouleur" name="idCouleur" onchange='showColor()'>
                                        <?php
                                        $tabCouleur = Couleur::listerCouleur();

                                        for ($i = 0; $i < sizeof($tabCouleur); $i++)
                                            echo "<option value='" . $tabCouleur[$i]->getIdentifiantBDD() . "' style='color: #" . $tabCouleur[$i]->getCode() . ";'>" . $tabCouleur[$i]->getNom() . "</option>";
                                        ?>
                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;<input id="couleurActuel" readonly="disabled" style="background-color: <?php echo '#' . $tabCouleur[0]->getCode(); ?>; width: 100px; border-width: 0px;"/></td>
                            </tr>
                            <tr>
                                <td colspan=2><input type=submit value="Enregistrer les données"/><input type=reset value="Effacer"/></td>
                            </tr>
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
    <?php }

    public static function afficherFormulaireModification() { ?>
        <FORM id="formModifParrain" METHOD="POST" ACTION="" name="sd">
            <table id="table_msParrain">
                <tr><td colspan=2>
                        <table id="presentation_msParrain">
                            <tr id="entete2">
                                <td colspan=2>Modifier/Supprimer un référent</td>
                            </tr>
                            <tr>
                                <th width="220">Sélectionnez le référent : </th>
                                <th>
                                    <?php
                                    $tabParrain = Parrain::listerParrain();
                                    echo "<select name=parrain>";
                                    echo "<option  value='-1' selected></option>";
                                    for ($i = 0; $i < sizeof($tabParrain); $i++) {

                                        $couleur = $tabParrain[$i]->getCouleur();

                                        echo "<option value='" . $tabParrain[$i]->getIdentifiantBDD() . "'name='" . $tabParrain[$i]->getNom() . "' style='color: #" . $couleur->getCode() . ";'> " . $tabParrain[$i]->getNom() . " " . $tabParrain[$i]->getPrenom() . "</option>";
                                    }
                                    echo "</select>";
                                    ?>
                                </th>
                            </tr>
                            <tr>
                                <td colspan=2>
                                    <input type=submit value="Modifier un référent" />
                                    <input type=submit value="Supprimer un référent" onclick="this.form.action='../../gestion/parrains/sup_parrains.php'"/>
                                </td>
                            </tr>
                        </table>
            </table>
        </FORM>
        <?php
    }

}
?>