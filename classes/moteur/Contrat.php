<?php

/**
 * Les contrats de stage : accord entre l'université, l'étudiant et l'entreprise
 */

class Contrat {

    var $identifiant_BDD; // Identifiant unique en base
    var $sujetDeStage; // Texte descriptif du contenu du stage
    var $typeDeContrat;//apprentissage ou professionnalisation
    var $aSonResume; // Indicateur de la présence d'un résumé ou pas
    var $note; // La note d'évaluation attribuée à l'étudiant
    var $idParrain; // Identifiant du parrain
    var $idExaminateur; // Identifiant de l'examinateur
    var $idEtudiant; // Identifiant de l'étudiant
    var $idSoutenance; // Identifiant de la soutenance
    var $idContact; // Identifiant du contact
    var $idTheme; // Identifiant du thème de stage.

    /**
     * Constructeur d'un objet Contrat
     * @param integer $identifiant_BDD
     * @param string $sujetDeStage
     * @param integer $typeDeContrat
     * @param boolean $aSonResume
     * @param decimal $note
     * @param integer $idParrain
     * @param integer $idExaminateur
     * @param integer $idEtudiant
     * @param integer $idSoutenance
     * @param integer $idContact
     * @param integer $idTheme
     */
    public function __construct($identifiant_BDD, $sujetDeStage,$typeDeContrat, $aSonResume,
	    $note, $idParrain, $idExaminateur, $idEtudiant, $idSoutenance,
	    $idContact, $idTheme) {
	$this->identifiant_BDD = $identifiant_BDD;
	$this->sujetDeContrat = $sujetDeStage;
  $this->typeDeContrat = $typeDeContrat;
	$this->aSonResume = $aSonResume;
	$this->note = $note;
	$this->idParrain = $idParrain;
	$this->idExaminateur = $idExaminateur;
	$this->idEtudiant = $idEtudiant;
	$this->idSoutenance = $idSoutenance;
	$this->idContact = $idContact;
	$this->idTheme = $idTheme;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiant_BDD;
    }

    public function getSujetDeContrat() {
	return $this->sujetDeContrat;
    }

    public function getTypeDeContrat() {
	return $this->typeDeContrat;
    }

    public function getASonResume() {
	return $this->aSonResume;
    }

    public function getNote() {
	return $this->note;
    }

    public function getIdParrain() {
	return $this->idParrain;
    }

    public function getIdExaminateur() {
	return $this->idExaminateur;
    }

    public function getIdEtudiant() {
	return $this->idEtudiant;
    }

    public function getIdSoutenance() {
	return $this->idSoutenance;
    }

    public function getContact() {
	return Contact::getContact($this->idContact);
    }

    public function getIdTheme() {
	return $this->idTheme;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setSujetDeContrat($sds) {
	$this->sujetDeContrat = $sds;
    }

    public function setTypeDeContrat($sds) {
  $this->typeDeContrat = $sds;
    }

    public function setASonResume($asr) {
	$this->aSonResume = $asr;
    }

    public function setNote($note) {
	$this->note = $note;
    }

    public function setIdParrain($idParrain) {
	$this->idParrain = $idParrain;
    }

    public function setIdExaminateur($idExaminateur) {
	$this->idExaminateur = $idExaminateur;
    }

    public function setIdEtudiant($idEtudiant) {
	$this->idEtudiant = $idEtudiant;
    }

    public function setIdSoutenance($idSoutenance) {
	$this->idSoutenance = $idSoutenance;
    }

    public function setIdContact($idContact) {
	$this->idContact = $idContact;
    }

    public function setIdTheme($idTheme) {
	$this->idTheme = $idTheme;
    }

    // ------------------------------------------------------------------------
    // Autres méthodes d'accès dérivés

    public function getPromotion() {
	$idPromotion = Contrat_BDD::getPromotion($this->identifiant_BDD);
	return Promotion::getPromotion($idPromotion);
    }

    public function getEtudiant() {
	return Etudiant::getEtudiant($this->idEtudiant);
    }

    public function getExaminateur() {
	return Parrain::getParrain($this->idExaminateur);
    }

    public function getParrain() {
	return Parrain::getParrain($this->idParrain);
    }

    public function getSoutenance() {
	if ($this->idSoutenance == 0)
	    return new Soutenance(0, 0, 0, 0, 0, 0);
	else
	    return Soutenance::getSoutenance($this->idSoutenance);
    }

    public function getEntreprise() {
	$contact = Contact::getContact($this->idContact);
	return $contact->getEntreprise();
    }

    public function getTheme() {
	return ThemeDeStage::getThemeDeStage($this->idTheme);
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Supprimer un enregistrement Contrat
     * @param integer $idContrat
     * @param integer $idPromo
     */
    public static function supprimerContrat($idContrat) {
	Contrat_BDD::supprimerContrat($idContrat);
    }

    /**
     * Obtenir un objet Contrat à partir d'un identifiant
     * @param integer $idContrat
     * @return Contrat
     */
    public static function getContrat($idContrat) {
	$convBDD = Contrat_BDD::getContrat($idContrat);
	return new Contrat($convBDD["idcontrat"], $convBDD["sujetcontrat"],$convBDD["typedecontrat"],
			      $convBDD["asonresume"], $convBDD["note"],
			      $convBDD["idparrain"], $convBDD["idexaminateur"],
			      $convBDD["idetudiant"], $convBDD["idsoutenance"],
			      $convBDD["idcontact"], $convBDD["idtheme"]);
    }

    /**
     * Obtenir un objet Contrat à partir de l'étudiant et de la promotion
     * @param integer $idetudiant
     * @param integer $idpromotion
     * @return Contrat
     */
    public static function getContratFromEtudiantAndPromotion($idetudiant, $idpromotion) {
	$convBDD = Contrat_BDD::getContrat2($idetudiant, $idpromotion);
	return new Contrat($convBDD["idcontrat"], $convBDD["sujetcontrat"],$convBDD["typedecontrat"],
			      $convBDD["asonresume"], $convBDD["note"],
			      $convBDD["idparrain"], $convBDD["idexaminateur"],
			      $convBDD["idetudiant"], $convBDD["idsoutenance"],
			      $convBDD["idcontact"], $convBDD["idtheme"]);
    }

    /**
     * Obtenir une liste de contrats à partir de l'année, d'un parrain et d'une promotion
     * @param integer $annee
     * @param integer $idparrain
     * @param integer $idfiliere
     * @param integer $idparcours
     * @return tableau d'objets Contrat
     */
    public static function getListeContratFromParrainAndPromotion($annee, $idparrain, $idfiliere, $idparcours) {
	$tabLCString = Contrat_BDD::getListeContratFromParrainAndPromotion($annee, $idparrain, $idfiliere, $idparcours);

	$tabLC = array();
	for ($i = 0; $i < sizeof($tabLCString); $i++)
	    array_push($tabLC,
		    new Contrat($tabLCString[$i][0], $tabLCString[$i][1],
				   $tabLCString[$i][2], $tabLCString[$i][3],
				   $tabLCString[$i][4], $tabLCString[$i][5],
				   $tabLCString[$i][6], $tabLCString[$i][7],
				   $tabLCString[$i][8], $tabLCString[$i][9]));

	return $tabLC;
    }

    /**
     * Obtenir une liste de contrats à partir d'un filtre de sélection
     * @param Filtre $filtre
     * @return tableau d'objets Contrat
     */
    public static function getListeContrat($filtre) {
	$tabLCString = Contrat_BDD::getListeContrat($filtre);

	$tabLC = array();
	for ($i = 0; $i < sizeof($tabLCString); $i++)
	    array_push($tabLC,
		    new Contrat($tabLCString[$i][0], $tabLCString[$i][1],
				   $tabLCString[$i][2], $tabLCString[$i][3],
				   $tabLCString[$i][4], $tabLCString[$i][5],
				   $tabLCString[$i][6], $tabLCString[$i][7],
				   $tabLCString[$i][8], $tabLCString[$i][9]));

	return $tabLC;
    }

    /**
     * Obtenir une liste de fichiers résumés possibles pour un étudiant
     * @param integer $idEtu
     * @param string $dossierResumes Le chemin d'accès aux fichiers
     * @return tableau de chemins complets d'accès
     */
    public static function getResumesPossible($idEtu, $dossierResumes) {
	$dir = opendir($dossierResumes);

	$tabRes = array();
	while ($file = readdir($dir)) {
	    if ($file != '.' && $file != '..' && !is_dir($dossierResumes . $file)) {
		$tabNomFile = explode("_", $file);
		if ($tabNomFile[0] == $idEtu)
		    array_push($tabRes, $file);
	    }
	}

	closedir($dir);

	return $tabRes;
    }

    /**
     * Comparer les heures de soutenances liées à deux contrats
     * @param Contrat $a
     * @param Contrat $b
     * @return integer
     */
    public static function compareHeureSoutenance($a, $b) {
	if ($a->getSoutenance()->getIdentifiantBDD() != 0 && $b->getSoutenance()->getIdentifiantBDD() != 0)
	    return Soutenance::compareHeureSoutenance($a->getSoutenance(), $b->getSoutenance());
	return 1;
    }

}

?>
