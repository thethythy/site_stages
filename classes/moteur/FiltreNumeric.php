<?php

/**
 * Classe FiltreNumeric : un filtre d'égalité stricte entre deux valeurs
 */

class FiltreNumeric extends Filtre {

    /**
     * Construction d'un objet Filtre '='
     * @param string $champ
     * @param string $valeur
     */
    public function __construct($champ, $valeur) {
	$this->strFiltres = $champ . " = '" . $valeur . "'";
    }
}

?>
