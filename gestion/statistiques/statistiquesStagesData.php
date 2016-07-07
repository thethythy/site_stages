<?php

$chemin = '../../classes/';

include_once($chemin.'bdd/connec.inc');

include_once($chemin.'moteur/Filtre.php');
include_once($chemin.'moteur/FiltreNumeric.php');

include_once $chemin.'bdd/Couleur_BDD.php';
include_once $chemin.'moteur/Couleur.php';

include_once $chemin.'bdd/Promotion_BDD.php';
include_once $chemin.'moteur/Promotion.php';

include_once $chemin.'bdd/Convention_BDD.php';
include_once $chemin.'moteur/Convention.php';

include_once $chemin.'bdd/Filiere_BDD.php';
include_once $chemin.'moteur/Filiere.php';

include_once $chemin.'bdd/Parcours_BDD.php';
include_once $chemin.'moteur/Parcours.php';

include_once $chemin.'bdd/Entreprise_BDD.php';
include_once $chemin.'moteur/Entreprise.php';

include_once $chemin.'bdd/Contact_BDD.php';
include_once $chemin.'moteur/Contact.php';

include_once($chemin . "bdd/ThemeDeStage_BDD.php");
include_once($chemin . "moteur/ThemeDeStage.php");

include_once($chemin . "bdd/TypeEntreprise_BDD.php");
include_once($chemin . "moteur/TypeEntreprise.php");

// -----------------------------------------------------------------------------
// En-tête du flux JSON
header("Content-type: application/json; charset=utf-8");

// -----------------------------------------------------------------------------
// Création des filtres

$filtres = array();

if (isset($_GET['annee']) && $_GET['annee'] != '*')
    array_push($filtres, new FiltreNumeric('anneeuniversitaire', $_GET['annee']));

if (isset($_GET['parcours']) && $_GET['parcours'] != '*')
    array_push($filtres, new FiltreNumeric('idparcours', $_GET['parcours']));

if (isset($_GET['filiere']) && $_GET['filiere'] != '*')
    array_push($filtres, new FiltreNumeric('idfiliere', $_GET['filiere']));

if (sizeof($filtres) > 0) {
    $filtre = $filtres[0];
    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], 'AND');
} else {
    $filtre = "";
}

// -----------------------------------------------------------------------------
// Récupération des promotions

if (isset($_GET['annee'])) {
    $tabOPromotions = Promotion::listerPromotions($filtre);
} else {
    $tabOPromotions = array();
}

// -----------------------------------------------------------------------------
// Fonctions pour récupérer les données

function donneTabRepartitionLieuDuStage($tabOConventions) {
    $mans = 0;
    $sarthe = 0;
    $region = 0;
    $france = 0;
    $monde = 0;
    $dep = 0;

    if (sizeof($tabOConventions) > 0) {
	foreach ($tabOConventions as $oConvention) {
	    $entreprise = $oConvention->getEntreprise();
	    $codepostal = $entreprise->getCodePostal();
	    $ville = strtolower($entreprise->getVille());
	    $pays = strtolower($entreprise->getPays());

	    if (strlen($codepostal) == 5)
		$dep = $codepostal[0] . $codepostal[1];

	    $deps = array("53", "85", "49", "44");

	    if (strstr($ville, "mans") && ($codepostal == "72000" || $codepostal == "72100") && strstr($pays, "france")) {
		$mans++;
	    } else if ($dep == "72" && strstr($pays, "france") && ($codepostal != "72000" || $codepostal != "72100")) {
		$sarthe++;
	    } else if (in_array($dep, $deps) && strstr($pays, "france")) {
		$region++;
	    } else if (strstr($pays, "france")) {
		$france++;
	    } else {
		$monde++;
	    }
	}
    }

    return array(
	'Le Mans' => $mans,
	'Sarthe' => $sarthe,
	'Pays de la Loire' => $region,
	'France' => $france,
	'Etranger' => $monde);
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

function donneUneSerie($tabOConventions, $nomFiliere, $nomParcours) {
    $serie = array();
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
    $data = array( "annee" => intval($_GET['annee']) );
    $data['nbSerie'] = $nbSerie > 1 ? $nbSerie + 1 : $nbSerie ;

    // Numéro et nom de la série de données
    $num_serie = 1;
    $nom_serie = "s".$num_serie;

    // Ajout des séries de données
    foreach ($tabOPromotions as $oPromotion) {
	$oFiliere = $oPromotion->getFiliere();
	$oParcours = $oPromotion->getParcours();
	$filtre = donneFiltre($_GET['annee'], $oFiliere, $oParcours);
	$tabOConventions = Convention::getListeConvention($filtre);

	// Accumulation des conventions au cas ou il y aura une série 'Total'
	if ($nbSerie > 1) {
	    $tabTotalOConventions = array_merge($tabTotalOConventions, $tabOConventions);
	}

	// Nouvelle série de données (une promotion)
	$data[$nom_serie] = donneUneSerie($tabOConventions, $oFiliere->getNom(), $oParcours->getNom());

	// Préparation pour la série suivante
	$num_serie += 1;
	$nom_serie = "s".$num_serie;
    }

    // Ajout de la série 'Total' le cas échéant
    if ($nbSerie > 1) {
	$data["s".($nbSerie + 1)] = donneUneSerie($tabTotalOConventions, "Total", "");
    }

    // Encodage en JSON puis envoie du flux
    print(json_encode($data));
}

?>
