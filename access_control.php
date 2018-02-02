<?php

/**
 * Page access_control.php
 * Utilisation : page de contrôle d'accès aux pages privées
 * Dépendance(s) : access_control_verification.php --> traitement des requêtes Ajax
 * Accès : public
 */

global $access_control_target;

// Sauvegarde en session pour la journalisation
session_start();
$_SESSION['$access_control_target'] = $access_control_target;
session_write_close();

include_once("../classes/ihm/IHM_Generale.php");
include_once("../classes/ihm/Menu.php");

IHM_Generale::header("Les stages", "étudiants", "/", array(), "auchargement");
Menu::menuAccueil();
?>

<br></br>
<p>Ce site est dédié à la gestion et à l'accès aux informations concernant les stages des étudiants en informatique de la Faculté des Sciences et Techniques de l'Université du Maine. Il est l'outil principal de communication entre les différentes personnes concernées : les étudiants, l'équipe enseignante, les entreprises, et le responsable pédagogique des stages.</p>
<p>Il permet aux étudiants de prendre connaissance d'un certain nombre d'offres de stages et de faire des demandes de validation de sujet de stage. Il liste également les entreprises ayant déjà accueillies des stagiaires. </p>
<p>En ce qui concernent l'équipe enseignante, il permet d'accéder à la liste des enseignants-référents et à la liste des conventions pas section et par année. Les plannings des soutenances des différentes sections sont accessibles durant les périodes concernées.</p>
<p>Ce site permet également aux entreprises de saisir directement des propositions de stages qui seront ensuite diffusées aux étudiants.</p>
<br />
<p align=right>Cordialement, le responsable des stages<br/>Thierry Lemeunier</p>

<script type="text/javascript">

    // L'édition du champ 'clef' entraîne une requête de vérification
    // Surcharge de la fonction définie dans la classe LoadData
    LoadData.prototype.load = function() {
	var clef = document.getElementById('clef').value;
	var verification_request = new XMLHttpRequest();
	verification_request.open("POST", "/access_control_verification.php", true);
	verification_request.setRequestHeader("Content-type", "text/plain; charset=utf-8");
	verification_request.onreadystatechange = function() {
	    if (verification_request.readyState == 4 && verification_request.status == 200) {
		if (verification_request.responseText == "OK")
		    location.href='<?php echo $access_control_target; ?>';
	    }
	}
	verification_request.send(clef);
    };

    // Traitement au chargement de la page
    var auchargement = function() {
	// Enregistrement des champs réactifs
	var table_onkeyup = new Array("clef");
	new LoadData(table_onkeyup, null, "onkeyup");

	// Opacifier le contenu
	document.getElementById("content-wrapAccueil").style.opacity = 0.2;
	document.getElementById("footerAccueil").style.opacity = 0.2;

	// Rendre visible le formulaire
	document.getElementById("formulaire").hidden = false;
	document.getElementById("clef").focus();
    };

</script>

<?php

IHM_Generale::endHeaderAccueil();
IHM_Generale::footerAccueil();

?>

<aside id="formulaire" hidden class="formulaire_saisie_clef">
    <table>
	<tr>
	    <td>
		<img src="/images/warning.png">
	    </td>
	    <td>
		<label>Cette partie du site est réservée aux personnes ayant un droit d'accès.<br/><br/></label>
		<center>
		    <label>Saisissez la clef d'accès pour y accéder :<br/><br/></label>
		    <input type="password" id="clef"/>
		</center>
	    </td>
	</tr>
    </table>
</aside>
