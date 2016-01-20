<?php

$chemin = '../../classes/';

include_once $chemin.'bdd/connec.inc';
include_once $chemin.'moteur/Filtre.php';
include_once $chemin.'moteur/FiltreNumeric.php';
include_once $chemin.'bdd/Convention_BDD.php';
include_once $chemin.'bdd/Contact_BDD.php';
include_once $chemin.'bdd/Entreprise_BDD.php';
include_once $chemin.'bdd/Promotion_BDD.php';
include_once $chemin.'bdd/Filiere_BDD.php';
include_once $chemin.'bdd/Parcours_BDD.php';
include_once $chemin.'moteur/Convention.php';
include_once $chemin.'moteur/Contact.php';
include_once $chemin.'moteur/Entreprise.php';
include_once $chemin.'moteur/Promotion.php';
include_once $chemin.'moteur/Filiere.php';
include_once $chemin.'moteur/Parcours.php';



//$etudiant = Etudiant::getEtudiant($_GET['idEtu']);
$promotion = Promotion::getPromotion($_GET['idPromo']);

/* recuperation des donnees entreprises */
//$entreprise = $contact->getEntreprise();
//$parrain = $convention->getParrain();

/* recuperation des donnees etudiants */
//$contact = $convention->getContact();
//$filiere = $promotion->getFiliere();
//$parcours = $promotion->getParcours();

/* recuperation des donnees soutenance */


/* recuperation des donnees stage */
//$convention = $etudiant->getConvention($promotion->getAnneeUniversitaire());
echo "<div id='data'>\n";
echo "truc";
echo $promotion ;
echo "\n</div>";



?>