<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/SujetDeStage_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."moteur/SujetDeStage.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."bdd/SujetDeStage_BDD.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');
IHM_Generale::header("Traiter", "un sujet de stage", "../../", $tabLiens);

function envoyerNotification($message, $sds){
	//Envoie d'un mail de validation ou invalidation à l'étudiant
	global $emailResponsable;
	
	$destinataire = $sds->getEtudiant()->getEmailInstitutionel();
	if($sds->getEtudiant()->getEmailPersonnel() != "")
		$destinataire = $destinataire.", ".$sds->getEtudiant()->getEmailPersonnel();
	$expediteur = $emailResponsable;
	$reponse = $expediteur;

	$headers = "From: $expediteur\nReply-To: $reponse\nCc: $expediteur\n";
    $headers .="Content-Type: text/html; charset=\"iso-8859-1\"\n";
   	$headers .="Content-Transfer-Encoding: 8bit";
    mail($destinataire, 'Site des stages : reponse demande de validation', $message, $headers);
}

if(isset($_GET['id'])){
	$sds=SujetDeStage::getSujetDeStage($_GET['id']);
	SujetDeStage_IHM::afficherSDS($sds, true);
}

if(isset($_POST['accept'])){
	$sds=SujetDeStage::getSujetDeStage($_POST['idSds']);
	$sds->setEnAttenteDeValidation(false);
	$sds->setValide(true);
	SujetDeStage_BDD::sauvegarder($sds);
	
	global $baseSite;
	$message = "Bonjour,<br><br>

				Votre demande de validation d'un sujet de stage a été traitée et le sujet acceptée.<br>
				Veuillez poursuivre la procédure spécifique comme elle est indiquée <a href='".$baseSite."presentation/index.php'>ici</a>.<br>

				Bon courage<br><br>

				Thierry Lemeunier<br>
				Responsable pédagogique des stages";
		
	envoyerNotification($message, $sds);
	
	echo "<p>Le sujet de stage a été validé.</p>";
	echo "<p><a href='./validerSDS.php'>Retour</a></p>";
}

if(isset($_POST['refus'])){
	$sds=SujetDeStage::getSujetDeStage($_POST['idSds']);
	$sds->setEnAttenteDeValidation(false);
	$sds->setValide(false);
	SujetDeStage_BDD::sauvegarder($sds);
	
	$message = "Bonjour,<br><br>

				Votre demande de validation d'un sujet de stage a été traitée mais le sujet proposé<br>
				ne peut être accepté tel que vous le présentez actuellement car il ne correspond<br>
				pas à votre formation.<br><br>

				Vous avez plusieurs possibilités :<br>
				- refaire une demande de validation avec un sujet modifié ;<br>
				- trouver un autre sujet et faire une demande de validation de ce sujet ;<br>
				- demander plus d'explications en venant voir le responsable pédagogique.<br><br>

				Bon courage <br>

				Thierry Lemeunier<br>
				Responsable pédagogique des stages";
	
	envoyerNotification($message, $sds);
	
	echo "<p>Le sujet de stage a été refusé.</p>";
	echo "<p><a href='./validerSDS.php'>Retour</a></p>";
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>