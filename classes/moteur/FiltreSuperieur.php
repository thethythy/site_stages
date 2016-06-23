<?php

class FiltreSuperieur extends Filtre {

    // Constructeur de classe
    public function FiltreSuperieur($champ, $valeur) {
	$this->champ = $champ;
	$this->valeur = $valeur;
	$this->strFiltres = $this->champ . " >= '" . $this->valeur . "'";
    }

}

?>