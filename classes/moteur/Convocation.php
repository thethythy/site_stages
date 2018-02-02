<?php

/**
 * Classe Convocation : mémoriser les convocations/invitations
 * aux soutenances de stage auprès des contacts en entreprise
 */

class Convocation {

    var $idconvocation;  // Identifiant unique
    var $envoi;  // Flag indiquant si la convocation a déjà été faite
    var $idsoutenance;  // Identifiant de la soutenance concernée

    /**
     * Création d'un objet Convocation
     * @param integer $idconvocation
     * @param integer $envoi
     * @param integer $idsoutenance
     */
    public function Convocation($idconvocation, $envoi, $idsoutenance) {
	$this->idconvocation = $idconvocation;
	$this->envoi = $envoi;
	$this->idsoutenance = $idsoutenance;
    }

    // Accesseurs en lecture

    function getIdentifiantBDD() {
	return $this->idconvocation;
    }

    function getEnvoi() {
	return $this->envoi;
    }

    function getIdsoutenance() {
	return $this->idsoutenance;
    }

    // Accesseurs en écriture

    function setEnvoi($envoi) {
	$this->envoi = $envoi;
    }

    function setIdsoutenance($idsoutenance) {
	$this->idsoutenance = $idsoutenance;
    }

    // Méthodes statiques

    /**
     * Rechercher un objet Convocation à partir de son identifiant
     * @param type $idConvocation
     * @return FALSE ou Convocation
     */
    public static function getConvocation($idConvocation) {
	$convocationBDD = Convocation_BDD::getConvocation($idConvocation);
	if ($convocationBDD)
	    return new Convocation($convocationBDD["idconvocation"],
				    $convocationBDD["envoi"],
				    $convocationBDD["idsoutenance"]);
	else
	    return FALSE;
    }

    /**
     * Rechercher un objet Convocation à partir de la soutenance associée
     * @param integer $idsoutenance
     * @return FALSE ou Convocation
     */
    public static function getConvocationFromSoutenance($idsoutenance) {
	$convocationBDD = Convocation_BDD::getConvocationFromSoutenance($idsoutenance);
	if ($convocationBDD)
	    return new Convocation($convocationBDD["idconvocation"],
				    $convocationBDD["envoi"],
				    $convocationBDD["idsoutenance"]);
	else
	    return FALSE;
    }

    /**
     * Rechercher les convocations associées à une date de soutenance
     * @param integer $iddatesoutenance
     * @return tableau d'objets
     */
    public static function getListeConvovationFromDateSoutenance($iddatesoutenance) {
	$tabConvocationBDD = Convocation_BDD::getConvocationsFromDateSoutenance($iddatesoutenance);

	$tabOC = array();
	for ($i = 0; $i < sizeof($tabConvocationBDD); $i++)
	    array_push ($tabOC,
		    new Convocation($tabConvocationBDD[$i][0],
				    $tabConvocationBDD[$i][1],
				    $tabConvocationBDD[$i][2]));

	return $tabOC;
    }

}

?>