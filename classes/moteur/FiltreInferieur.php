<?php

class FiltreInferieur extends Filtre{

	// Constructeur de classe
	public function FiltreInferieur($champ, $valeur) {
		$this->champ = $champ;
		$this->valeur = $valeur;
		$this->strFiltres = $this->champ." <= '".$this->valeur."'";
	}
}
?>