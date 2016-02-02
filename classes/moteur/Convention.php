<?php

class Convention {
	var $identifiant_BDD;
	var $sujetDeStage;
	var $aSonResume;
	var $note;
	var $idParrain;
	var $idExaminateur;
	var $idEtudiant;
	var $idSoutenance;
	var $idContact;
	var $idTheme; //Ajout de la variable idTheme pour l'ajout du theme de stage.

	public function Convention($identifiant_BDD,$sujetDeStage,$aSonResume,$note,$idParrain,$idExaminateur,$idEtudiant,$idSoutenance,$idContact,$idTheme){
		$this->identifiant_BDD = $identifiant_BDD;
		$this->sujetDeStage = $sujetDeStage;
		$this->aSonResume = $aSonResume;
		$this->note = $note;
		$this->idParrain = $idParrain;
		$this->idExaminateur = $idExaminateur;
		$this->idEtudiant = $idEtudiant;
		$this->idSoutenance = $idSoutenance;
		$this->idContact = $idContact;
		$this->idTheme = $idTheme; //Ajout du theme de stage dans le constructeur. ------------
	}

	public function setSujetDeStage($sds) {
		$this->sujetDeStage = $sds;
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

	// Ajout du setter du theme de stage ---------------------------------------------------------
	public function setIdTheme($idTheme){
		$this->idTheme = $idTheme;
	}

	//Ajout du getter du theme de stage ----------------------------------------------------------
	public function getIdTheme(){
		return $this->idTheme;
	}

	public function getSujetDeStage() {
		return $this->sujetDeStage;
	}

	public function getASonResume() {
		return $this->aSonResume;
	}

	public function getNote() {
		return $this->note;
	}

	public function getParrain() {
		return Parrain::getParrain($this->idParrain);
	}

	public function getIdParrain() {
		return $this->idParrain;
	}

	public function getExaminateur() {
		return Parrain::getParrain($this->idExaminateur);
	}

	public function getIdExaminateur() {
		return $this->idExaminateur;
	}

	public function getEtudiant() {
		return Etudiant::getEtudiant($this->idEtudiant);
	}

	public function getIdEtudiant() {
		return $this->idEtudiant;
	}

	public function getSoutenance() {
		if($this->idSoutenance == 0)
			return new Soutenance(0, 0, 0, 0, 0, 0);
		else
			return Soutenance::getSoutenance($this->idSoutenance);
	}

	public function getIdSoutenance() {
		return $this->idSoutenance;
	}

	public function getContact() {
		return Contact::getContact($this->idContact);
	}

	public function getEntreprise(){
		$contact = Contact::getContact($this->idContact);
		return $contact->getEntreprise();
	}

	public function getPromotion(){
		$idPromotion = Convention_BDD::getPromotion($this->identifiant_BDD);
		return Promotion::getPromotion($idPromotion);
	}

	public function getIdentifiantBDD() {
		return $this->identifiant_BDD;
	}

	// Méthodes statiques

	public static function supprimerConvention($idConvention, $idPromo){
		$conv = Convention::getConvention($idConvention);
		$etu = $conv->getEtudiant();
		Convention_BDD::supprimerConvention($idConvention, $etu->getIdentifiantBDD(), $idPromo);
	}

	//Ajour de ', $convBDD["idtheme"]'
	public static function getConvention($idConvention){
		$convBDD = Convention_BDD::getConvention($idConvention);
		return new Convention($convBDD["idconvention"], $convBDD["sujetdestage"], $convBDD["asonresume"], $convBDD["note"], $convBDD["idparrain"], $convBDD["idexaminateur"], $convBDD["idetudiant"], $convBDD["idsoutenance"], $convBDD["idcontact"], $convBDD["idtheme"]);
	}

	//Ajour de ', $convBDD["idtheme"]'
	public static function getConventionFromEtudiantAndPromotion($idetudiant, $idpromotion) { 
		$convBDD = Convention_BDD::getConvention2($idetudiant, $idpromotion);
		return new Convention($convBDD["idconvention"], $convBDD["sujetdestage"], $convBDD["asonresume"], $convBDD["note"], $convBDD["idparrain"], $convBDD["idexaminateur"], $convBDD["idetudiant"], $convBDD["idsoutenance"], $convBDD["idcontact"], $convBDD["idtheme"]);
	}

	//Ajout de ', $tabLCString[$i][9]'
	public static function getListeConvention($filtres){
		$tabLCString = Convention_BDD::getListeConvention($filtres);

		$tabLC = array();
		for($i=0; $i<sizeof($tabLCString); $i++)
			array_push($tabLC, new Convention($tabLCString[$i][0], $tabLCString[$i][1], $tabLCString[$i][2], $tabLCString[$i][3], $tabLCString[$i][4], $tabLCString[$i][5], $tabLCString[$i][6], $tabLCString[$i][7], $tabLCString[$i][8], $tabLCString[$i][9]));

		return $tabLC;
	}

	//Ajout de ',$tab_donnees[$i][8]'
	public static function saisirDonneesConvention($tab_donnees){
		$conv = new Convention("",$tab_donnees[0],$tab_donnees[1],$tab_donnees[2],$tab_donnees[3],$tab_donnees[4],$tab_donnees[5],$tab_donnees[6],$tab_donnees[7],$tab_donnees[$i][8]);
		Convention_BDD::sauvegarder($conv);
	}

	public static function getResumesPossible($idEtu, $dossierResumes){
		$dir = opendir($dossierResumes);

		$tabRes = array();
		while($file = readdir($dir)) {
			if($file != '.' && $file != '..' && !is_dir($dossierResumes.$file)){
				$tabNomFile = explode("_", $file);

				if($tabNomFile[0] == $idEtu)
					array_push($tabRes, $file);
			}
		}

		closedir($dir);

		return $tabRes;
	}

	public static function compareHeureSoutenance($a, $b) {
		if ($a->getSoutenance()->getIdentifiantBDD() != 0 && $b->getSoutenance()->getIdentifiantBDD() != 0)
			return Soutenance::compareHeureSoutenance($a->getSoutenance(), $b->getSoutenance());
		return 1;
	}

	// -------------------------------------------------------------------------------------------------------------------------------
	public static function getListeTheme(){
		$tabThemeString = Convention_BDD::getListeTheme();
		
		$tabTheme = array();
		for($i=0; $i<sizeof($tabThemeString); $i++)
  			array_push($tabTheme, $tabThemeString[$i][0]);
  			
		return array_unique($tabTheme);
	}

}

?>