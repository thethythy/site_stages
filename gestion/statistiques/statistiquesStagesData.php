<?php

/**
 * Page statistiquesStagesData.php
 * Utilisation : page de traitement des requêtes Ajax
 *		 créer un fichier Excel
 *		 retourner un flux json de valeurs statistiques
 * Dépendance(s) : statistiquesStagesExcel.php --> exportation fichier Excel
 * Accès : restreint par authentification HTTP
 */

include_once("statistiquesStagesExcel.php");

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// -----------------------------------------------------------------------------
// En-tête du flux JSON

header("Content-type: application/json; charset=utf-8");

// -----------------------------------------------------------------------------
// Création des filtres

$filtres = array();

if (isset($_GET['annee_deb']))
    array_push($filtres, new FiltreSuperieur('anneeuniversitaire', $_GET['annee_deb']));

if (isset($_GET['annee_fin']))
    array_push($filtres, new FiltreInferieur('anneeuniversitaire', $_GET['annee_fin']));

if (isset($_GET['parcours']) && $_GET['parcours'] != '*')
    array_push($filtres, new FiltreNumeric('idparcours', $_GET['parcours']));

if (isset($_GET['filiere']) && $_GET['filiere'] != '*')
    array_push($filtres, new FiltreNumeric('idfiliere', $_GET['filiere']));

if(isset($_GET['offre'])){
  switch($_GET['offre']){
    case 'Stage' :
      $dataFlag = 0;
      break;
    case 'Alternance' :
      $dataFlag = 1;
      break;
    default :
      $dataFlag = 2;
  }
}

if (sizeof($filtres) > 0) {
    $filtre = $filtres[0];
    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], 'AND');
} else {
    $filtre = "";
}

// -----------------------------------------------------------------------------
// Récupération des promotions

if (isset($_GET['annee_deb']) && isset($_GET['annee_fin'])) {
    $tabOPromotions = Promotion::listerPromotions($filtre);
} else {
    $tabOPromotions = array();
}

// -----------------------------------------------------------------------------
// Fonctions pour récupérer les données

function donneTabRepartitionLieuDuStage($tabOConventions) {
    $ville = 0;
    $departement = 0;
    $region = 0;
    $france = 0;
    $monde = 0;

    $lieux = Utils::getLieuxStage();

    if (sizeof($tabOConventions) > 0) {
	foreach ($tabOConventions as $oConvention) {
	    $entreprise = $oConvention->getEntreprise();
	    $codepostal = $entreprise->getCodePostal();
	    $laville = $entreprise->getVille();
	    $lepays = $entreprise->getPays();

	    $lieu = Utils::getLieuDuStage($codepostal, $laville, $lepays);

	    if ($lieu == $lieux[0]) {
		$ville++;
	    } else if ($lieu == $lieux[1]) {
		$departement++;
	    } else if ($lieu == $lieux[2]) {
		$region++;
	    } else if ($lieu == $lieux[3]) {
		$france++;
	    } else {
		$monde++;
	    }
	}
    }

    return array(
	$lieux[0] => $ville,
	$lieux[1] => $departement,
	$lieux[2] => $region,
	$lieux[3] => $france,
	$lieux[4] => $monde);
}

function donneTabRepartitionThemeDuStage($tabOConventions) {
    $tabRepartitionTheme = array();

    if (sizeof($tabOConventions) > 0) {
	// Mise à zéro
	foreach ($tabOConventions as $oConvention) {
	    $tabRepartitionTheme[$oConvention->getTheme()->getTheme()] = 0;
	}

	// Comptage
	foreach ($tabOConventions as $oConvention) {
	    $tabRepartitionTheme[$oConvention->getTheme()->getTheme()] += 1;
	}
    }

    return $tabRepartitionTheme;
}

function donneTabRepartitionTypeEntreprise($tabOConventions) {
    $tabRepartitionType = array();

    if (sizeof($tabOConventions) > 0) {
	// Mise à zéro
	foreach ($tabOConventions as $oConvention) {
	    $tabRepartitionType[$oConvention->getEntreprise()->getType()->getType()] = 0;
	}

	// Comptage
	foreach ($tabOConventions as $oConvention) {
	    $tabRepartitionType[$oConvention->getEntreprise()->getType()->getType()] += 1;
	}
    }

    return $tabRepartitionType;
}

function donneFiltre($annee, $oFiliere, $oParcours) {
    $filtres = array();
    array_push($filtres, new FiltreNumeric('anneeuniversitaire', $annee));
    array_push($filtres, new FiltreNumeric('idparcours', $oParcours->getIdentifiantBDD()));
    array_push($filtres, new FiltreNumeric('idfiliere', $oFiliere->getIdentifiantBDD()));
    $filtre = $filtres[0];
    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], 'AND');
    return $filtre;
}

function donneUneSerie($tabOConventions, $annee, $nomFiliere, $nomParcours) {
    $serie = array();
    $serie['annee'] = $annee;
    $serie['filiere'] = $nomFiliere;
    $serie['parcours'] = $nomParcours;

    // --------------------------------------------------------------------
    // Ajout des données sur le lieu du stage
    $tabCouleur = array("#FF0000", "#E0BB00", "#7DDB83", "#0082B2", "#A35BBF");
    $lieu = array();
    $num_lieu = 1;
    $nom_lieu = "l".$num_lieu;
    $somme = 0;

    $tabLieuDuStage = donneTabRepartitionLieuDuStage($tabOConventions);
    foreach ($tabLieuDuStage as $nom => $nombre) {
	$lieu_stage = array();
	$lieu_stage['couleur'] = $tabCouleur[$num_lieu - 1];
	$lieu_stage['nom'] = $nom;
	$lieu_stage['nombre'] = $nombre;
	$lieu[$nom_lieu] = $lieu_stage;

	$somme += $nombre;
	$num_lieu += 1;
	$nom_lieu = "l".$num_lieu;
    }

    $lieu['nbLieu'] = sizeof($tabLieuDuStage);
    $lieu['somme'] = $somme;
    $serie['Lieu du stage'] = $lieu;

    // --------------------------------------------------------------------
    // Ajout des données sur le thème de stage
    $theme = array();
    $num_theme = 1;
    $nom_theme = "t".$num_theme;
    $somme = 0;

    $tabThemeDuStage = donneTabRepartitionThemeDuStage($tabOConventions);
    foreach ($tabThemeDuStage as $nom => $nombre) {
	$theme_stage = array();
	$theme_stage['couleur'] = '#'.ThemeDeStage::getThemeDeStageFromNom($nom)->getCouleur()->getCode();
	$theme_stage['nom'] = $nom;
	$theme_stage['nombre'] = $nombre;
	$theme[$nom_theme] = $theme_stage;

	$somme += $nombre;
	$num_theme += 1;
	$nom_theme = "t".$num_theme;
    }

    $theme['nbTheme'] = sizeof($tabThemeDuStage);
    $theme['somme'] = $somme;
    $serie['Thème du stage'] = $theme;

    // --------------------------------------------------------------------
    // Ajout des données concernant le type d'entreprise
    $typeEnt = array();
    $num_type = 1;
    $nom_type = "e".$num_type;
    $somme = 0;

    $tabTypeEntreprise = donneTabRepartitionTypeEntreprise($tabOConventions);
    foreach ($tabTypeEntreprise as $nom => $nombre) {
	$type_ent = array();
	$type_ent['couleur'] = '#'.TypeEntreprise::getTypeEntrepriseFromNom($nom)->getCouleur()->getCode();
	$type_ent['nom'] = $nom;
	$type_ent['nombre'] = $nombre;
	$typeEnt[$nom_type] = $type_ent;

	$somme += $nombre;
	$num_type += 1;
	$nom_type = "e".$num_type;
    }

    $typeEnt['nbType'] = sizeof($tabTypeEntreprise);
    $typeEnt['somme'] = $somme;
    $serie['Type d\'entreprise'] = $typeEnt;

    return $serie;
}

// -----------------------------------------------------------------------------
// Récupération, mise en forme puis envoi des données

// Nombre de série à faire
$nbSerie = sizeof($tabOPromotions);

if ($nbSerie > 0) {

    // Si il a plusieurs séries à traiter prévoir de faire le total
    if ($nbSerie > 1) {
	$tabTotalOConventions = array();
    }

    // Spécifier l'année sélectionnée
    $data = array( "annee_deb" => intval($_GET['annee_deb']), "annee_fin" => intval($_GET['annee_fin']));
    $data['nbSerie'] = $nbSerie > 1 ? $nbSerie + 1 : $nbSerie ;

    // Numéro et nom de la série de données
    $num_serie = 1;
    $nom_serie = "s".$num_serie;

    // Ajout des séries de données
    foreach ($tabOPromotions as $oPromotion) {
	$oFiliere = $oPromotion->getFiliere();
	$oParcours = $oPromotion->getParcours();
	$pAnnee = $oPromotion->getAnneeUniversitaire();
	$filtre = donneFiltre($pAnnee, $oFiliere, $oParcours);
  $tabOConventions = array();
  $tabOContrats = array();
  Utils::printLog("dataFLAG : ".$dataFlag);
  if($dataFlag == 0 || $dataFlag == 2){
    $tabOConventions = Convention::getListeConvention($filtre);
  }
  if($dataFlag == 1 || $dataFlag == 2){
    $tabOContrats = Contrat::getListeContrat($filtre);
  }

  $tabOC = array_merge($tabOConventions, $tabOContrats);
	// Accumulation des conventions au cas ou il y aura une série 'Total'
	if ($nbSerie > 1) {
	    $tabTotalOConventions = array_merge($tabTotalOConventions, $tabOC);
	}

	// Nouvelle série de données (une promotion)
	$data[$nom_serie] = donneUneSerie($tabOC, intval($pAnnee), $oFiliere->getNom(), $oParcours->getNom());

	// Préparation pour la série suivante
	$num_serie += 1;
	$nom_serie = "s".$num_serie;
    }

    // Ajout de la série 'Total' le cas échéant
    if ($nbSerie > 1) {
	$data["s".($nbSerie + 1)] = donneUneSerie($tabTotalOConventions, "", "Total", "");
    }

    // Génération du fichier Excel
    $generator = new StatistiquesGenerateurExcel("../../documents/statistiques");
    $generator->genereFichierExcel($data);

    // Encodage en JSON puis envoie du flux
    echo json_encode($data);
}

?>
