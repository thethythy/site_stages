<?php

class FiltreString extends Filtre {

    // Constructeur de classe
    public function FiltreString($champ, $valeur) {
	$this->champ = $champ;
	$this->valeur = $valeur;
	$this->strFiltres = $this->champ . " LIKE '" . $this->valeur . "'";
    }

}

?>