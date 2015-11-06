<?php

class FiltreNumeric extends Filtre{
	
	// Constructeur de classe
	public function FiltreNumeric($champ, $valeur) {
		$this->champ = $champ;
		$this->valeur = $valeur;
		$this->strFiltres = $this->champ." = '".$this->valeur."'";
	}
}

?>