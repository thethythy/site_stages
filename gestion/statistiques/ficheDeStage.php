<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");

include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Contact.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."moteur/Entreprise.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Fiche de", "stage", "../../", $tabLiens);

$etudiant = Etudiant::getEtudiant($_GET['idEtu']);
$promotion = Promotion::getPromotion($_GET['idPromo']);
$filiere = $promotion->getFiliere();
$parcours = $promotion->getParcours();
$convention = $etudiant->getConvention($promotion->getAnneeUniversitaire());
$contact = $convention->getContact();
$entreprise = $contact->getEntreprise();
$parrain = $convention->getParrain();

?>

<h3>L'étudiant</h3>
<?php echo $etudiant->getPrenom()." ".$etudiant->getNom(); ?><br/>
Promotion : <?php echo $filiere->getNom()." ".$parcours->getNom(); ?><br/>
Annee : <?php echo $promotion->getAnneeUniversitaire(); ?>

<br/><br/><br/>

<h3>L'entreprise</h3>
<?php echo $entreprise->getNom();?> <br/>
<?php echo $entreprise->getAdresse();?> <br/>
<?php echo $entreprise->getCodePostal(); ?>&nbsp;
<?php echo $entreprise->getVille();?> <br/>
<?php echo $entreprise->getPays();?>

<br/><br/>

<h3>Contact dans l'entreprise</h3>
<?php
echo $contact->getPrenom()." ".$contact->getNom()."<br/>";

if($contact->getTelephone() != "")
	echo "Tel : ".$contact->getTelephone()."<br/>";

if($contact->getTelecopie() != "")
	echo "Fax : ".$contact->getTelecopie()."<br/>";

if($contact->getEmail() != "")
	echo "Email : ".$contact->getEmail();
?>

<br/><br/>

<h3>Le stage</h3>
<?php
	if($convention->aSonResume == "1"){
		echo "<a href='../../documents/resumes/".$convention->getSujetDeStage()."'>Résumé du stage</a>";
	}else{
		$chaine = $convention->getSujetDeStage();
		echo $chaine;
	}
?>

<br/><br/><br/>

<h3>Référent</h3>
<?php echo $parrain->getPreNom()." ".$parrain->getNom(); ?><br/>

<br/>

<?php

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>