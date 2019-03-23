<?php

/**
* Classe Etudiant : les étudiants d'une promotion
*/

class Etudiant {

  var $identifiantBDD;  // Identifiant unique en base
  var $nom;  // Le nom de l'étudiant
  var $prenom;  // Le prénom de l'étudiant
  var $emailInstitutionel;  // L'adresse mail de l'université
  var $emailPersonnel;  // L'adresse mail personnel
  var $codeEtudiant;  // Statut de l'étudiant

  /**
  * Constructeur de classe
  * @param integer $identifiantBDD
  * @param string $nom
  * @param string $prenom
  * @param string $emailInstitutionel
  * @param string $emailPersonnel
  * @param integer $codeEtudiant
  */
  public function __construct($identifiantBDD, $nom, $prenom, $emailInstitutionel,
  $emailPersonnel, $codeEtudiant = "") {
    $this->identifiantBDD = $identifiantBDD;
    $this->nom = $nom;
    $this->prenom = $prenom;
    $this->emailInstitutionel = $emailInstitutionel;
    $this->emailPersonnel = $emailPersonnel;
    $this->codeEtudiant = $codeEtudiant;
  }

  // ------------------------------------------------------------------------
  // Accesseurs en lecture

  public function getIdentifiantBDD() {
    return $this->identifiantBDD;
  }

  public function getNom() {
    return $this->nom;
  }

  public function getPrenom() {
    return $this->prenom;
  }

  public function getEmailInstitutionel() {
    return $this->emailInstitutionel;
  }

  public function getEmailPersonnel() {
    return $this->emailPersonnel;
  }

  public function getCodeEtudiant() {
    return $this->codeEtudiant;
  }

  // ------------------------------------------------------------------------
  // Accesseurs en écriture

  public function setNom($nom) {
    $this->nom = $nom;
  }

  public function setPrenom($prenom) {
    $this->prenom = $prenom;
  }

  public function setEmailInstitutionel($emailInstitutionel) {
    $this->emailInstitutionel = $emailInstitutionel;
  }

  public function setEmailPersonnel($emailPersonnel) {
    $this->emailPersonnel = $emailPersonnel;
  }

  public function setCodeEtudiant($codeEtudiant) {
    $this->codeEtudiant = $codeEtudiant;
  }

  // ------------------------------------------------------------------------
  // Méthodes dérivées

  /**
  * Obtenir la promotion de l'étudiant suivant une année�donnée
  * @param integer $annee
  * @return Promotion ou null
  */
  public function getPromotion($annee) {
    $idPromo = Etudiant_BDD::recherchePromotion($this->identifiantBDD, $annee);

    if ($idPromo == "")
    return null;

    return Promotion::getPromotion($idPromo);
  }

  /**
  * Obtenir la dernière promotion de l'étudiant à partir de l'année donnée
  * @param integer $annee
  * @return Promotion ou null
  */
  public function getLastPromotion($annee) {
    do {
      $oPromo = $this->getPromotion($annee);
      $annee -= 1;
    } while ($annee > 1970 && ! $oPromo);

    return $oPromo;
  }

  /**
  * Obtenir la convention de l'étudiant suivant une année�donnée
  * @param integer $annee
  * @return Convention ou null
  */
  public function getConvention($annee) {
    $idConv = Etudiant_BDD::rechercheConvention($this->identifiantBDD, $annee);

    if ($idConv == "")
    return null;

    return Convention::getConvention($idConv);
  }

  

  /**
  * Obtenir la dernière convention de l'étudiant à partir de l'année donnée
  * @param integer $annee
  * @return Convention ou null
  */
  public function getLastConvention($annee) {
    do {
      $oConv = $this->getConvention($annee);
      $annee -= 1;
    } while ($annee > 1970 && ! $oConv);

    return $oConv;
  }
  /**
  * Obtenir le contrat de l'étudiant suivant une année�donnée
  * @param integer $annee
  * @return Contrat ou null
  */
  public function getContrat($annee) {
    $idContrat = Etudiant_BDD::rechercheContrat($this->identifiantBDD, $annee);

    if ($idContrat == "")
    return null;

    return Contrat::getContrat($idContrat);
  }

  /**
  * Obtenir le dernier contrat de l'étudiant à partir de l'année donnée
  * @param integer $annee
  * @return Contrat ou null
  */
  public function getLastContrat($annee) {
    do {
      $oContrat = $this->getContrat($annee);
      $annee -= 1;
    } while ($annee > 1970 && ! $oContrat);

    return $oContrat;
  }


  // ------------------------------------------------------------------------
  // Méthodes statiques

  /**
  * Enlever un étudiant d'une promotion
  * @param integer $idEtudiant Identifiant de l'étudiant
  * @param integer $idPromo Identifiant de la promotion
  */
  public static function supprimerEtudiant($idEtudiant, $idPromo) {
    Etudiant_BDD::supprimerLienPromotionEtudiant($idEtudiant, $idPromo);
  }

  /**
  * Supprimer un étudiant de la base
  * @param integer $idEtudiant Identifiant de l'étudiant
  */
  public static function supprimerDefinitivementEtudiant($idEtudiant) {
    Etudiant_BDD::supprimerEtudiant($idEtudiant);
  }

  /**
  * Obtenir un objet Etudiant à partir de son identifiant
  * @param integer $idEtudiant
  * @return Etudiant
  */
  public static function getEtudiant($idEtudiant) {
    $etuBDD = Etudiant_BDD::getEtudiant($idEtudiant);
    return new Etudiant($etuBDD["idetudiant"],
    $etuBDD["nometudiant"],
    $etuBDD["prenometudiant"],
    $etuBDD["email_institutionnel"],
    $etuBDD["email_personnel"],
    $etuBDD["codeetudiant"]);
  }

  /**
  * Obtenir la liste des étudiants d'une promotion
  * @param integer $idPromotion
  * @return tableau d'étudiants
  */
  public static function getListeEtudiants($idPromotion) {
    $tabEtudiantString = Etudiant_BDD::getListeEtudiants($idPromotion);
    $tabEtudiant = array();

    for ($i = 0; $i < sizeof($tabEtudiantString); $i++)
    array_push($tabEtudiant,
    new Etudiant($tabEtudiantString[$i][0],
    $tabEtudiantString[$i][1],
    $tabEtudiantString[$i][2],
    $tabEtudiantString[$i][3],
    $tabEtudiantString[$i][4],
    $tabEtudiantString[$i][5]));

    return $tabEtudiant;
  }

  /**
  * Obtenir une liste d'étudiants correspondant au filtre
  * @param chaîne $filtre Un filtre de sélection des étudiants
  *@return tableau d'étudiants
  */
  public static function getEtudiants($filtre) {
    // Si le filtre existe c'est un objet Filtre
    if ($filtre)
    $filtre = $filtre->getStrFiltres();

    $tabEtudiantString = Etudiant_BDD::getEtudiants($filtre);
    $tabEtudiant = array();

    for ($i = 0; $i < sizeof($tabEtudiantString); $i++)
    array_push($tabEtudiant,
    new Etudiant($tabEtudiantString[$i][0],
    $tabEtudiantString[$i][1],
    $tabEtudiantString[$i][2],
    $tabEtudiantString[$i][3],
    $tabEtudiantString[$i][4],
    $tabEtudiantString[$i][5]));

    return $tabEtudiant;
  }

  /**
  * Chercher les étudiants avec un certain nom et un certain prénom
  * @param chaîne $nom
  * @param chaîne $prenom
  * @return tableau des éudiants trouvés correspondants aux deux critères
  */
  public static function searchEtudiants($nom, $prenom) {
    $tabEtudiantString = Etudiant_BDD::searchEtudiants($nom, $prenom);
    $tabEtudiant = array();
    for ($i = 0; $i < sizeof($tabEtudiantString); $i++)
    array_push($tabEtudiant,
    new Etudiant($tabEtudiantString[$i][0],
    $tabEtudiantString[$i][1],
    $tabEtudiantString[$i][2],
    $tabEtudiantString[$i][3],
    $tabEtudiantString[$i][4],
    $tabEtudiantString[$i][5]));
    return $tabEtudiant;
  }

}

?>
