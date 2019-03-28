
<script> var tab = [] </script>
<?php

/**
 * Page exportListeConventionsData.php
 * Utilisation : page retournant une liste de contrats à exporter
 * Accès : restreint par authentification HTTP
 */
 function js_str($s)
 {
     return '"' . addcslashes($s, "\0..\37\"\\") . '"';
 }

 function js_array($array)
 {
     $temp = array_map('js_str', $array);
     return '[' . implode(',', $temp) . ']';
 }

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

$filtres = array();

if (!isset($_POST['annee']))
    $annee = Promotion_BDD::getLastAnnee();
else
    $annee = $_POST['annee'];

array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));

if (isset($_POST['parcours']) && $_POST['parcours'] != '*' && $_POST['parcours'] != '') {
    $parcours = $_POST['parcours'];
    array_push($filtres, new FiltreNumeric("idparcours", $parcours));
}

if (isset($_POST['filiere']) && $_POST['filiere'] != '*' && $_POST['filiere'] != '') {
    $filiere = $_POST['filiere'];
    array_push($filtres, new FiltreNumeric("idfiliere", $filiere));
}

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
    $idPromo = $tabPromos[0][0];

    // Récupération des étudiants ayant une convention
    $tabEtuWithConv = array();

    for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
	if ($tabEtudiants[$i]->getContrat($annee) != null)
	    array_push($tabEtuWithConv, $tabEtudiants[$i]);
    }

    // Si il y a au moins un étudiant avec un contrat
    if (sizeof($tabEtuWithConv) > 0) {
	// Affichage des contrats des étudiants
	Contrats_IHM::afficherListeContratsAExporter($annee, $idPromo, $tabEtuWithConv);
  $list = array (array("NB","Société","Titre","Nom",	"Prénom",	"Fonction",	"Adresse1",	"Adresse2",	"Code_postal",	"Ville",	"E-mail",	"Tel.",	"Prénom étudiant",	"Nom étudiant",	"E-mail etudiant",	"CONTRAT",	"Demande de prise en charge",	"Convention",	"Copie du contrat", "Début du contrat",	"Fin du contrat",	"Nb d'heures",	"Taux en Euro",	"Droits Universitaires",	"TOTAL en Euro"));
  for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
    $oContrat = $tabEtuWithConv[$i]->getContrat($annee);
    $oPromo = Promotion::getPromotion($idPromo);
    $oFiliere = $oPromo->getFiliere();
    $oParcours = $oPromo->getParcours();
    $etudiant = $oContrat->getEtudiant();
    $entreprise = $oContrat -> getEntreprise();
    $referent = $oContrat -> getContact();

  array_push($list,array("",$entreprise->getNom(),"",$referent->getNom(),$referent->getPrenom(),"",$entreprise->getAdresse(),"",$entreprise->getCodePostal(),$entreprise->getVille(),$referent->getEmail(),$referent->getTelephone(),$etudiant->getPrenom(),$etudiant->getNom(),$etudiant->getEmailInstitutionel()));
  }

    for ($i = 0; $i < sizeof($list); $i++) {
      echo '<script>tab.push(',js_array($list[$i]), ');</script>';
    }
  ?>
  <br/><br/>

  <table >
  	<td width="100%" align="center">
  		<input type="submit" value="Tout exporter" onclick="exporterListe()"/>
  	</td>
  </table>

  <script>

  function exporterListe(){
    let csvContent = "data:text/csv;charset=utf-8," + tab.map(e=>e.join(",")).join("\n");
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "Liste_Suivi_Contrats.csv");
    document.body.appendChild(link); // Required for FF

    link.click(); // This will download the data file named "my_data.csv".
  }

  </script>


  <?php
    } else {
	echo "<br/><center>Aucun contrat n'a été trouvée.</center><br/>";
    }
} else {
    echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.</center><br/>";
}
?>
