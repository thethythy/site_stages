<?php

/**
 * Classe FiltreString : un filtre de ressemblance entre deux chaînes
 */

class FiltreString extends Filtre {

    /**
     * Constructeur d'un filtre 'LIKE'
     * @param string $champ
     * @param string $valeur
     */
    public function __construct($champ, $valeur) {
	$this->strFiltres = $champ . " LIKE '" . $valeur . "'";
    }

}

?>
