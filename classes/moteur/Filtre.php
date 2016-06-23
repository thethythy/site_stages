<?php

class Filtre {

    // Déclaration des attributs de la classe
    var $champ;
    var $valeur;
    var $strFiltres;

    // Constructeur de classe
    public function Filtre($filtre1, $filtre2, $type) {
	$this->strFiltres = $filtre1->getStrFiltres() . " " . $type . " " . $filtre2->getStrFiltres();
    }

    // Méthodes diverses

    public function getChamp() {
	return $this->champ;
    }

    public function setChamp($champ) {
	$this->champ = $champ;
    }

    public function getValeur() {
	return $this->valeur;
    }

    public function setValeur($valeur) {
	$this->valeur = $valeur;
    }

    public function addNewFiltre($filtre, $type) {
	$this->strFiltres = $this->strFiltres . " " . $type . " " . $filtre->getStrFiltres();
    }

    public function getStrFiltres() {
	if ((substr_count($this->strFiltres, "=") <= 1) &&
	    (substr_count($this->strFiltres, "ILIKE") <= 1))
	    return $this->strFiltres;
	else
	    return "(" . $this->strFiltres . ")";
    }

}

?>