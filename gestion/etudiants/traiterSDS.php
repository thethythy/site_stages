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
	//Envoie d'un mail de validation ou invalidation � l'�tudiant
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

				Votre demande de validation d'un sujet de stage a �t� trait�e et le sujet accept�e.<br>
				Veuillez poursuivre la proc�dure sp�cifique comme elle est indiqu�e <a href='".$baseSite."presentation/index.php'>ici</a>.<br>

				Bon courage<br><br>

				Thierry Lemeunier<br>
				Responsable p�dagogique des stages";
		
	envoyerNotification($message, $sds);
	
	echo "<p>Le sujet de stage a �t� valid�.</p>";
	echo "<p><a href='./validerSDS.php'>Retour</a></p>";
}

if(isset($_POST['refus'])){
	$sds=SujetDeStage::getSujetDeStage($_POST['idSds']);
	$sds->setEnAttenteDeValidation(false);
	$sds->setValide(false);
	SujetDeStage_BDD::sauvegarder($sds);
	
	$message = "Bonjour,<br><br>

				Votre demande de validation d'un sujet de stage a �t� trait�e mais le sujet propos�<br>
				ne peut �tre accept� tel que vous le pr�sentez actuellement car il ne correspond<br>
				pas � votre formation.<br><br>

				Vous avez plusieurs possibilit�s :<br>
				- refaire une demande de validation avec un sujet modifi� ;<br>
				- trouver un autre sujet et faire une demande de validation de ce sujet ;<br>
				- demander plus d'explications en venant voir le responsable p�dagogique.<br><br>

				Bon courage <br>

				Thierry Lemeunier<br>
				Responsable p�dagogique des stages";
	
	envoyerNotification($message, $sds);
	
	echo "<p>Le sujet de stage a �t� refus�.</p>";
	echo "<p><a href='./validerSDS.php'>Retour</a></p>";
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>