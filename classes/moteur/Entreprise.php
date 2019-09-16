<?php

/**
* La classe Entreprise : l'entreprise des contacts d'une offre de stage
* ou d'une convention de stage
*/

class Entreprise {

  var $identifiantBDD;  // Identifiant unique en base
  var $nom;  // Nom officiel de l'entreprise
  var $adresse;  // Adresse de l'entreprise (lieu du stage ou siège social)
  var $codePostal;  // Code postal
  var $ville;  // Ville
  var $pays;  // Pays
  var $email;  // Adresse mail du DRH ou équivalent
  var $siret; // Numéro de siret de l'entreprise
  var $idTypeEntreprise;  // Identifiant du type d'entreprise

  /**
  * Constructeur de classe
  * @param integer $identifiantBDD
  * @param string $nom
  * @param string $adresse
  * @param string $codePostal
  * @param string $ville
  * @param string $pays
  * @param string $email
  * @param integer $idTypeEntreprise
  * @param integer $siret
  */
  public function __construct($identifiantBDD, $nom, $adresse, $codePostal,
  $ville, $pays, $email, $siret, $idTypeEntreprise) {
    $this->identifiantBDD = $identifiantBDD;
    $this->nom = $nom;
    $this->adresse = $adresse;
    $this->codePostal = $codePostal;
    $this->ville = $ville;
    $this->pays = $pays;
    $this->email = $email;
    $this->siret = $siret;
    $this->idTypeEntreprise = $idTypeEntreprise;
  }

  // ------------------------------------------------------------------------
  // Accesseurs en lecture

  public function getIdentifiantBDD() {
    return $this->identifiantBDD;
  }

  public function getNom() {
    return $this->nom;
  }

  public function getAdresse() {
    return $this->adresse;
  }

  public function getCodePostal() {
    return $this->codePostal;
  }

  public function getVille() {
    return $this->ville;
  }

  public function getPays() {
    return $this->pays;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getSiret() {
    return $this->siret;
  }

  public function getType() {
    return TypeEntreprise::getTypeEntreprise($this->idTypeEntreprise);
  }

  // ------------------------------------------------------------------------
  // Accesseurs en écriture

  public function setNom($nom) {
    $this->nom = $nom;
  }

  public function setAdresse($adresse) {
    $this->adresse = $adresse;
  }

  public function setCodePostal($codePostal) {
    $this->codePostal = $codePostal;
  }

  public function setVille($ville) {
    $this->ville = $ville;
  }

  public function setPays($pays) {
    $this->pays = $pays;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function setSiret($siret) {
    $this->siret = $siret;
  }

  public function setTypeEntreprise($idTypeEntreprise) {
    $this->idTypeEntreprise = $idTypeEntreprise;
  }

  // ------------------------------------------------------------------------
  // Méthodes d'accés dérivés

  public function listeDeContacts() {
    return Contact::listerContacts($this->identifiantBDD);
  }

  // ------------------------------------------------------------------------
  // Méthodes statiques

  /**
  * Supprimer un entreprise en base
  * @param integer $idEntreprise
  */
  public static function supprimerEntreprise($idEntreprise) {
    Entreprise_BDD::supprimerEntreprise($idEntreprise);
  }

  /**
  * Obtenir un objet Entreprise à partir d'un identifiant
  * @param integer $idEntreprise
  * @return Entreprise
  */
  public static function getEntreprise($idEntreprise) {
    $entrepriseBDD = Entreprise_BDD::getEntreprise($idEntreprise);
    return new Entreprise($entrepriseBDD["identreprise"],
    $entrepriseBDD["nom"],
    $entrepriseBDD["adresse"],
    $entrepriseBDD["codepostal"],
    $entrepriseBDD["ville"],
    $entrepriseBDD["pays"],
    $entrepriseBDD["email"],
    $entrepriseBDD["siret"],
    $entrepriseBDD["idtypeentreprise"]);
  }

  /**
  * Obtenir une liste d'entreprises selon un filtre
  * @param Filtre $filtre
  * @return tableau d'objets Entreprise
  */
  public static function getListeEntreprises($filtre) {
    $tabEntrepriseString = Entreprise_BDD::getListeEntreprises($filtre);
    $tabEntreprise = array();
    for ($i = 0; $i < sizeof($tabEntrepriseString); $i++)
    array_push($tabEntreprise,
    new Entreprise($tabEntrepriseString[$i][0],
    $tabEntrepriseString[$i][1],
    $tabEntrepriseString[$i][2],
    $tabEntrepriseString[$i][3],
    $tabEntrepriseString[$i][4],
    $tabEntrepriseString[$i][5],
    $tabEntrepriseString[$i][6],
    $tabEntrepriseString[$i][7],
    $tabEntrepriseString[$i][8]));
    return $tabEntreprise;
  }

}

?>
