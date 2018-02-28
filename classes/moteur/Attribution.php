<?php

/**
 * La classe Attribution sert à mémoriser les notifications
 * d'attributions des conventions aux enseignants
 */

class Attribution {

    var $idattribution;  // Identifiant unique
    var $envoi;  // Flag indiquant si la notification a déjà été faite
    var $idconvention;  // Identifiant de la convention concernée

    /**
     * Initialisation d'un objet Attribution
     * @param integer $idattribution
     * @param integer $envoi
     * @param integer $idconvention
     */
    public function __construct($idattribution, $envoi, $idconvention) {
	$this->idattribution = $idattribution;
	$this->envoi = $envoi;
	$this->idconvention = $idconvention;
    }

    // Accesseurs

    function getIdentifiantBDD() {
	return $this->idattribution;
    }

    function getEnvoi() {
	return $this->envoi;
    }

    function getIdconvention() {
	return $this->idconvention;
    }

    function setEnvoi($envoi) {
	$this->envoi = $envoi;
    }

    function setIdconvention($idconvention) {
	$this->idconvention = $idconvention;
    }

    // Méthodes statiques

    /**
     * Rechercher un objet Attribution à partir de son identifiant
     * @param integer $idAttribution
     * @return FALSE ou Attribution
     */
    public static function getAttribution($idAttribution) {
	$attributionBDD = Attribution_BDD::getAttribution($idAttribution);
	if ($attributionBDD)
	    return new Attribution($attributionBDD["idattribution"],
				   $attributionBDD["envoi"],
				   $attributionBDD["idconvention"]);
	else
	    return FALSE;
    }

    /**
     * Rechercher un objet Attribution à partir de la convention associée
     * @param integer $idconvention
     * @return FALSE ou Attribution
     */
    public static function getAttributionFromConvention($idconvention) {
	$attributionBDD = Attribution_BDD::getAttributionFromConvention($idconvention);
	if ($attributionBDD)
	    return new Attribution($attributionBDD["idattribution"],
				   $attributionBDD["envoi"],
				   $attributionBDD["idconvention"]);
	else
	    return FALSE;
    }


    /**
     * Rechercher les attributions associées à une promotion
     * @param integer $annee
     * @param integer $idparcours
     * @param integer $idfiliere
     */
    public static function getListeAttributionFromPromotion($annee, $idparcours, $idfiliere) {
	$tabAttributionBDD = Attribution_BDD::getListeAttributionFromPromotion($annee, $idparcours, $idfiliere);

	$tabOA = array();
	for ($i = 0; $i < sizeof($tabAttributionBDD); $i++)
	    array_push ($tabOA,
		    new Attribution($tabAttributionBDD[$i][0],
				    $tabAttributionBDD[$i][1],
				    $tabAttributionBDD[$i][2]));

	return $tabOA;
    }

}

?>