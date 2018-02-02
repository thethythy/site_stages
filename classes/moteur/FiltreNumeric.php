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
    public function FiltreNumeric($champ, $valeur) {
	$this->strFiltres = $champ . " = '" . $valeur . "'";
    }

}

?>