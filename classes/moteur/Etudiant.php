<?php

class Etudiant {

    // D�claration des attributs de la classe
    var $identifiantBDD;
    var $nom;
    var $prenom;
    var $emailInstitutionel;
    var $emailPersonnel;
    var $codeEtudiant;

    // Constructeur de classe
    public function Etudiant($identifiantBDD, $nom, $prenom, $emailInstitutionel, $emailPersonnel, $codeEtudiant = "") {
	$this->identifiantBDD = $identifiantBDD;
	$this->nom = $nom;
	$this->prenom = $prenom;
	$this->emailInstitutionel = $emailInstitutionel;
	$this->emailPersonnel = $emailPersonnel;
	$this->codeEtudiant = $codeEtudiant;
    }

    // M�thodes diverses

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    // Retourne la promotion de l'�tudiant suivant une ann�e donn�e
    public function getPromotion($annee) {
	$idPromo = Etudiant_BDD::recherchePromotion($this->identifiantBDD, $annee);

	if ($idPromo == "")
	    return null;

	return Promotion::getPromotion($idPromo);
    }

    // Retourne la convention de l'�tudiant suivant une ann�e donn�e
    public function getConvention($annee) {
	$idConv = Etudiant_BDD::rechercheConvention($this->identifiantBDD, $annee);

	if ($idConv == "")
	    return null;

	return Convention::getConvention($idConv);
    }

    public function getNom() {
	return $this->nom;
    }

    public function setNom($nom) {
	$this->nom = $nom;
    }

    public function getPrenom() {
	return $this->prenom;
    }

    public function setPrenom($prenom) {
	$this->prenom = $prenom;
    }

    public function getEmailInstitutionel() {
	return $this->emailInstitutionel;
    }

    public function setEmailInstitutionel($emailInstitutionel) {
	$this->emailInstitutionel = $emailInstitutionel;
    }

    public function getEmailPersonnel() {
	return $this->emailPersonnel;
    }

    public function setEmailPersonnel($emailPersonnel) {
	$this->emailPersonnel = $emailPersonnel;
    }

    public function getCodeEtudiant() {
	return $this->codeEtudiant;
    }

    public function setCodeEtudiant($codeEtudiant) {
	$this->codeEtudiant = $codeEtudiant;
    }

    // M�thodes statiques

    public static function supprimerEtudiant($idEtudiant, $idPromo) {
	Etudiant_BDD::supprimerEtudiant($idEtudiant, $idPromo);
    }

    public static function supprimerDefinitivementEtudiant($idEtudiant) {
	Etudiant_BDD::supprimerDefinitivementEtudiant($idEtudiant);
    }

    public static function getEtudiant($idEtudiant) {
	$etuBDD = Etudiant_BDD::getEtudiant($idEtudiant);

	return new Etudiant($etuBDD["idetudiant"], $etuBDD["nometudiant"], $etuBDD["prenometudiant"], $etuBDD["email_institutionnel"], $etuBDD["email_personnel"], $etuBDD["codeetudiant"]);
    }

    public static function getListeEtudiants($idPromotion) {
	$tabEtudiantString = Etudiant_BDD::getListeEtudiants($idPromotion);

	//echo sizeof($tabEtudiantString)."<br/>";

	$tabEtudiant = array();
	for ($i = 0; $i < sizeof($tabEtudiantString); $i++)
	    array_push($tabEtudiant, new Etudiant($tabEtudiantString[$i][0], $tabEtudiantString[$i][1], $tabEtudiantString[$i][2], $tabEtudiantString[$i][3], $tabEtudiantString[$i][4], $tabEtudiantString[$i][5]));

	return $tabEtudiant;
    }

    /**
     * Cherche les �tudiants avec un certain nom et un certain pr�nom
     * @param cha�ne $nom
     * @param cha�ne $prenom
     * @return Etudiant[] tableau des �tudiants trouv�s correspondants aux deux crit�res
     */
    public static function searchEtudiants($nom, $prenom) {
	$tabEtudiantString = Etudiant_BDD::searchEtudiants($nom, $prenom);
	$tabEtudiant = array();
	for ($i = 0; $i < sizeof($tabEtudiantString); $i++)
	    array_push($tabEtudiant, new Etudiant($tabEtudiantString[$i][0], $tabEtudiantString[$i][1], $tabEtudiantString[$i][2], $tabEtudiantString[$i][3], $tabEtudiantString[$i][4], $tabEtudiantString[$i][5]));
	return $tabEtudiant;
    }

}

?>