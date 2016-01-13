<?php

class Tache_BDD {

    /* Méthodes statiques */

    public static function save($tache) {
        global $tab21;
        global $db;

        if ($tache->getIdentifiantBDD() == "") {
            $sql = "INSERT INTO $tab21 VALUES ('" . $tache->getIdentifiantBDD() . "', '" . $tache->getIntitule() . "', '" . $tache->getStatut() . "', '" . $tache->getPriorite() . "', '" . $tache->getDateLimite() . "')";
        } else {
            $sql = "UPDATE $tab21 SET intitule='" . $tache->getIntitule() . "', statut='" . $tache->getStatut() . "', priorite='" . $tache->getPriorite() . "', datelimite='" . $tache->getDateLimite() . "' WHERE idtache='" . $tache->getIdentifiantBDD() . "'";
        }

        $result = mysql_query($sql, $db);
    }

    public static function getTache($identifiant) {
        global $tab21;
        global $db;

        $sql = "SELECT * FROM $tab21 WHERE idtache='$identifiant'";
        $result = mysql_query($sql, $db);
	return mysql_fetch_array($result);
    }

    public static function getTaches() {
        global $tab21;
        global $db;

        $sql = "SELECT * FROM $tab21 ORDER BY datelimite ASC, priorite DESC";
        $result = mysql_query($sql, $db);

        $tabTache = array();

        while ($tache = mysql_fetch_assoc($result)) {
            $tab = array();
            array_push($tab, $tache["idtache"]);
            array_push($tab, $tache["intitule"]);
            array_push($tab, $tache["statut"]);
            array_push($tab, $tache["priorite"]);
            array_push($tab, $tache["datelimite"]);
            array_push($tabTache, $tab);
        }
        return $tabTache;
    }

    public static function delete($identifiantBDD) {
        global $tab21;
        global $db;
        $sql = "DELETE FROM $tab21 WHERE idtache='$identifiantBDD'";
        $result = mysql_query($sql, $db);
    }

}

?>
