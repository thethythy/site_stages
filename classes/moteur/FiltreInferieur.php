<?php

/**
 * Classe FiltreInferieur : un filtre comparateur entre deux valeurs entières
 */

class FiltreInferieur extends Filtre {

    /**
     * Construction d'un objet Filtre '<='
     * @param string $champ
     * @param string $valeur
     */
    public function __construct($champ, $valeur) {
	$this->strFiltres = $champ . " <= '" . $valeur . "'";
    }

}

?>