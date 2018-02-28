<?php

/**
 * Classe Filtre : un filtre général servant dans les requêtes SQL
 */

class Filtre {

    var $strFiltres;  // Le filtre avec une syntaxe SQL

    /**
     * Constructeur d'un objet Filtre à partir de deux autres objets Filtre
     * et du lien logique entre les deux
     * @param Filtre $filtre1
     * @param Filtre $filtre2
     * @param string $type Le lien logique
     */
    public function __construct($filtre1, $filtre2, $type) {
	$this->strFiltres = $filtre1->getStrFiltres() . " " . $type . " " . $filtre2->getStrFiltres();
    }

    /**
     * Obtenir le filtre sous forme de chaîne SQL
     * @return string
     */
    public function getStrFiltres() {
	if ((substr_count($this->strFiltres, "=") <= 1) &&
	    (substr_count($this->strFiltres, "ILIKE") <= 1))
	    return $this->strFiltres;
	else
	    return "(" . $this->strFiltres . ")";
    }

}

?>