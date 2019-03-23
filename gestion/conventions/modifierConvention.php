<?php

/**
 * Page modifierConvention.php
 * Utilisation : page pour éditer une convention existante
 *		 page accessible depuis modifierListeConventions.php
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier une ", "convention", "../../", $tabLiens);

$oConv = Convention::getConvention($_GET['id']);
$oPromo = Promotion::getPromotion($_GET['promo']);
$oFiliere = $oPromo->getFiliere();
$oParcours = $oPromo->getParcours();

// Si une modification a été effectuée
if (isset($_POST['edit'])) {
    extract($_POST);

    if (isset($sujet))
	$oConv->setSujetDeStage($sujet);
    if (isset($idTheme))
	$oConv->setIdTheme($idTheme);

    $oConv->setIdParrain($idPar);
    $oConv->setIdExaminateur($idExam);
    $oConv->setIdContact($idCont);

    $idConv = Convention_BDD::sauvegarder($oConv);

    $oEtu = $oConv->getEtudiant();

    echo "Les informations sur la convention de " . $oEtu->getNom() . " " . $oEtu->getPrenom() . " ont été mises à jour.";
    ?>
    <table>
        <tr>
    	<td width="50%" align="center">
    	    <form method=post action="modifierListeConventions.php">
    		<input type="hidden" value="1" name="rech"/>
    		<input type="hidden" value="<?php echo $oPromo->getAnneeUniversitaire(); ?>" name="annee"/>
    		<input type="hidden" value="<?php echo $oFiliere->getIdentifiantBDD(); ?>" name="filiere"/>
    		<input type="hidden" value="<?php echo $oParcours->getIdentifiantBDD(); ?>" name="parcours"/>
    		<input type="submit" value="Retourner à la liste"/>
    	    </form>
    	</td>
    	<td width="50%" align="center">
    	    <form method=post action="../">
    		<input type="submit" value="Retourner au menu"/>
    	    </form>
    	</td>
        </tr>
    </table>
    <?php
} else {
    Convention_IHM::afficherFormulaireSaisie($oConv, array(),
	    $oPromo->getAnneeUniversitaire(),
	    $oParcours->getIdentifiantBDD(),
	    $oFiliere->getIdentifiantBDD());
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>
