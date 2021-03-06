<?php

/**
* Représentation et accès à la table n°12 : les offres de stage proposées par
* les entreprises
*/

class offreDeStage_BDD {

    /**
    * Enregistrer ou mettre à jour un objet OffreDeStage ansi que les associations
    * avec les compétences, les filières, les parcours et les promotions
    *
    * @global resource $db Référence sur la base ouverte
    * @global string $tab7 Nom de la table 'profilsouhaite_offredestage'
    * @global string $tab8 Nom de la table 'theme_offredestage'
    * @global string $tab11 Nom de la table 'relation_competence_offredestage'
    * @global string $tab12 Nom de la table 'offredestage'
    * @global string $tab37 Nom de la table 'relation_promotion_offredestage'
    * @param OffreDeStage $offreDeStage L'objet à enregistrer
    * @return integer L'identifiant de l'enregistrement
    */
    public static function sauvegarder($offreDeStage) {
      global $db;
      global $tab7;
      global $tab8;
      global $tab11;
      global $tab12;
      global $tab37;

      $estVisible = $offreDeStage->estVisible() ? 1 : 0;

      if ($offreDeStage->getIdentifiantBDD() == "") {
        $sql = "INSERT INTO $tab12
                VALUES ('0',
                        '" . $offreDeStage->getSujet() . "',
                        '" . $offreDeStage->getTitre() . "',
                        '" . $offreDeStage->getDureeMinimale() . "',
                        '" . $offreDeStage->getDureeMaximale() . "',
                        '" . $offreDeStage->getIndemnite() . "',
                        '" . $offreDeStage->getRemarques() . "',
                        '$estVisible',
                        '" . $offreDeStage->getIdContact() . "');";

          $db->query($sql);
          $lastId = $db->insert_id;
      } else {
        $sql = "UPDATE $tab12
                SET sujet='" . $offreDeStage->getSujet() . "',
                    titre='" . $offreDeStage->getTitre() . "',
                    dureemin='" . $offreDeStage->getDureeMinimale() . "',
                    dureemax='" . $offreDeStage->getDureeMaximale() . "',
                    indemnite='" . $offreDeStage->getIndemnite() . "',
                    remarques='" . $offreDeStage->getRemarques() . "',
                    estVisible='$estVisible',
                    idcontact='" . $offreDeStage->getIdContact() . "'
                WHERE idoffre='" . $offreDeStage->getIdentifiantBDD() . "';";
        $db->query($sql);

        // Themes
        $sql = "DELETE FROM $tab8 WHERE idoffre='" . $offreDeStage->getIdentifiantBDD() . "';";
        $db->query($sql);

        // Profils
        $sql = "DELETE FROM $tab7 WHERE idoffre='" . $offreDeStage->getIdentifiantBDD() . "';";
        $db->query($sql);

        // Competences
        $sql = "DELETE FROM $tab11 WHERE idoffre='" . $offreDeStage->getIdentifiantBDD() . "';";
        $db->query($sql);

        // Promotions
        $sql = "DELETE FROM $tab37 WHERE idoffre='". $offreDeStage->getIdentifiantBDD() . "';";
        $db->query($sql);

        $lastId = $offreDeStage->getIdentifiantBDD();
      }

      // Themes = Parcours
      $tabThemes = $offreDeStage->getThemes();
      for ($i = 0; $i < sizeof($tabThemes); $i++) {
        $sql = "INSERT INTO $tab8 VALUES('" . $tabThemes[$i]->getIdentifiantBDD() . "', '" . $lastId . "');";
        $db->query($sql);
      }

      // Profils = Filière
      $tabProfils = $offreDeStage->getListeProfilSouhaite();
      for ($i = 0; $i < sizeof($tabProfils); $i++) {
        $sql = "INSERT INTO $tab7 VALUES('" . $lastId . "', '" . $tabProfils[$i]->getIdentifiantBDD() . "')";
        $db->query($sql);
      }

      // Compétences
      $tabCompetences = $offreDeStage->getListesCompetences();
      for ($i = 0; $i < sizeof($tabCompetences); $i++) {
        $sql = "INSERT INTO $tab11 VALUES('" . $tabCompetences[$i]->getIdentifiantBDD() . "', '" . $lastId . "')";
        $db->query($sql);
      }

      // Promotions
      $tabPromotions = $offreDeStage->getPromotions();
      for ($i =0; $i < sizeof($tabPromotions); $i++) {
          $sql = "INSERT INTO $tab37 VALUES('" . $tabPromotions[$i]->getIdentifiantBDD() . "', '" . $lastId . "')";
          $db->query($sql);
      }

      return $lastId;
    }

    /**
    * Suppression d'un enregistrement à partir de son identifiant
    *
    * La table relation_competence_offredestage est mise à jour du fait
    * des contraintes d'intégrité relationnelles
    *
    * La table profilsouhaite_offredestage est mise à jour du fait
    * des contraintes d'intégrité relationnelles
    *
    * La table theme_offredestage est mise à jour du fait
    * des contraintes d'intégrité relationnelles
    *
    * @global resource $db Référence sur la base ouverte
    * @global string $tab12 Nom de la table 'offredestage'
    * @param integer $identifiantBDD Identifiant de l'enregistrement à supprimer
    */
    public static function delete($identifiantBDD) {
      global $db;
      global $tab12;

      $sql = "DELETE FROM $tab12 WHERE idoffre='$identifiantBDD'";
      $db->query($sql);
    }

    /**
    * Obtenir un enregistrement OffreDeStage à partir de son identifiant
    * @global resource $db Référence sur la base ouverte
    * @global string $tab7 Nom de la table 'profilsouhaite_offredestage'
    * @global string $tab8 Nom de la table 'theme_offredestage'
    * @global string $tab11 Nom de la table 'relation_competence_offredestage'
    * @global string $tab12 Nom de la table 'offredestage'
    * @global string $tab37 Nom de la table 'relation_promotion_offredestage'
    * @param integer $identifiantBDD Identifiant de l'enregistrement cherché
    * @return enregistrement
    */
    public static function getOffreDeStage($identifiantBDD) {
      global $db;
      global $tab7;
      global $tab8;
      global $tab11;
      global $tab12;
      global $tab37;

      $sql = "SELECT * FROM $tab12 WHERE idoffre='$identifiantBDD'";
      $res = $db->query($sql);
      $data = $res->fetch_array();
      $res->free();
      $tabOffreDeStage = array();

      array_push($tabOffreDeStage, $data['idoffre']);
      array_push($tabOffreDeStage, $data['sujet']);
      array_push($tabOffreDeStage, $data['titre']);

      // Parcours
      $sql2 = "SELECT * FROM $tab8 WHERE idoffre='$identifiantBDD'";
      $res2 = $db->query($sql2);
      $tabThemes = array();
      while ($theme = $res2->fetch_array()) {
        array_push($tabThemes, $theme['idparcours']);
      }
      $res2->free();
      array_push($tabOffreDeStage, $tabThemes);

      // Filiere
      $sql3 = "SELECT * FROM $tab7 WHERE idoffre='$identifiantBDD'";
      $res3 = $db->query($sql3);
      $tabProfils = array();
      while ($profil = $res3->fetch_array()) {
        array_push($tabProfils, $profil['idfiliere']);
      }
      $res3->free();
      array_push($tabOffreDeStage, $tabProfils);

      array_push($tabOffreDeStage, $data['dureemin']);
      array_push($tabOffreDeStage, $data['dureemax']);
      array_push($tabOffreDeStage, $data['indemnite']);
      array_push($tabOffreDeStage, $data['remarques']);
      array_push($tabOffreDeStage, $data['estVisible']);

      // Compétences
      $sql4 = "SELECT * FROM $tab11 WHERE idoffre='$identifiantBDD'";
      $res4 = $db->query($sql4);
      $tabCompetences = array();
      while ($competence = $res4->fetch_array()) {
        array_push($tabCompetences, $competence['idcompetence']);
      }
      $res4->free();
      array_push($tabOffreDeStage, $tabCompetences);

      array_push($tabOffreDeStage, $data['idcontact']);

      // Promotions
      $sql5 = "SELECT * FROM $tab37 WHERE idoffre='$identifiantBDD'";
      $res5 = $db->query($sql5);
      $tabPromotions = array();
      while ($promotion = $res5->fetch_array()) {
          array_push($tabPromotions, $promotion['idpromotion']);
      }
      $res5->free();
      array_push($tabOffreDeStage, $tabPromotions);

      return $tabOffreDeStage;
    }

    /**
    * Obtenir une liste d'offres de stage correspondant à un filtre
    * @global resource $db Référence sur la base ouverte
    * @global string $tab3 Nom de la table 'contact'
    * @global string $tab6 Nom de la table 'entreprise'
    * @global string $tab7 Nom de la table 'profilsouhaite_offredestage'
    * @global string $tab8 Nom de la table 'theme_offredestage'
    * @global string $tab11 Nom de la table 'relation_competence_offredestage'
    * @global string $tab12 Nom de la table 'offredestage'
    * @global string $tab37 Nom de la table 'relation_promotion_offredestage'
    * @param Filtre $filtre Le filtre de la recherche
    * @return tableau d'enregistrements
    */
    public static function getListeOffreDeStage($filtre) {
      global $db;
      global $tab3;
      global $tab6;
      global $tab7;
      global $tab8;
      global $tab11;
      global $tab12;
      global $tab37;

      // --------------------------------------------------------------------
      // Recherche des identifiants des offres de stage selon le filtre

      if ($filtre == "") {
        $requete = "SELECT $tab12.idoffre FROM $tab12";
      } else {

        $table = "FROM $tab12,$tab3,$tab6";

        $requete = "WHERE $tab12.idcontact=$tab3.idcontact AND $tab6.identreprise=$tab3.identreprise";

        $pos1 = strripos($filtre->getStrFiltres(), "idfiliere");
        $pos2 = strripos($filtre->getStrFiltres(), "idparcours");
        $pos3 = strripos($filtre->getStrFiltres(), "idcompetence");
        $pos4 = strripos($filtre->getStrFiltres(), "idpromotion");

        if ($pos1 !== false) {
          $requete = $requete . " AND $tab7.idoffre=$tab12.idoffre";
          $table = $table . ",$tab7";
        }

        if ($pos2 !== false) {
          $requete = $requete . " AND $tab8.idoffre=$tab12.idoffre";
          $table = $table . "," . $tab8;
        }

        if ($pos3 !== false) {
          $requete = $requete . " AND $tab11.idoffre=$tab12.idoffre";
          $table = $table . "," . $tab11;
        }

        if ($pos4 !== false) {
          $requete = $requete . " AND $tab37.idoffre=$tab12.idoffre";
          $table = $table . "," . $tab37;
        }

        $requete = "SELECT DISTINCT $tab12.idoffre $table $requete AND " . $filtre->getStrFiltres() . " ORDER BY $tab12.idoffre";
      }

      $result = $db->query($requete);

      // --------------------------------------------------------------------
      // Construire le tableau des enregistrements trouvés

      $tabODS = array();

      if ($result != FALSE) {
        while ($idods = $result->fetch_array()) {
          $ods = OffreDeStage_BDD::getOffreDeStage($idods['idoffre']);
          array_push($tabODS, $ods);
        }
        $result->free();
      }

      return $tabODS;
    }

  }

  ?>
