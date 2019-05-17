--
-- Schéma `stages` et les tables du schéma
-- Version 2019-05-17
--

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema stages
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `stages` DEFAULT CHARACTER SET utf8 ;
USE `stages` ;


-- -----------------------------------------------------
-- Table `stages`.`responsable`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`responsable` (
  `idresponsable` INT(10) NOT NULL AUTO_INCREMENT,
  `responsabilite` VARCHAR(100) NOT NULL,
  `nomresponsable` VARCHAR(100) NOT NULL,
  `prenomresponsable` VARCHAR(100) NOT NULL,
  `emailresponsable` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idresponsable`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`competence`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`competence` (
  `idcompetence` INT(10) NOT NULL AUTO_INCREMENT,
  `nomcompetence` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idcompetence`))
ENGINE = InnoDB
AUTO_INCREMENT = 64
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`couleur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`couleur` (
  `idcouleur` INT(10) NOT NULL AUTO_INCREMENT,
  `nomcouleur` VARCHAR(100) NOT NULL,
  `codehexa` VARCHAR(6) NOT NULL DEFAULT '000000',
  PRIMARY KEY (`idcouleur`))
ENGINE = InnoDB
AUTO_INCREMENT = 37
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`type_entreprise`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`type_entreprise` (
  `idtypeentreprise` INT(10) NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(30) NOT NULL,
  `idcouleur` INT(10) NOT NULL,
  PRIMARY KEY (`idtypeentreprise`),
  INDEX `idcouleur_idx` (`idcouleur` ASC),
  CONSTRAINT `fk_type_entreprise_couleur_idcouleur`
    FOREIGN KEY (`idcouleur`)
    REFERENCES `stages`.`couleur` (`idcouleur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`entreprise`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`entreprise` (
  `identreprise` INT(10) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `adresse` VARCHAR(100) NOT NULL,
  `codepostal` VARCHAR(8) NOT NULL,
  `ville` VARCHAR(100) NOT NULL,
  `pays` VARCHAR(100) NOT NULL,
  `email` VARCHAR(256) NOT NULL,
  `idtypeentreprise` INT(10) NULL DEFAULT NULL,
  `siret` BIGINT(14) NULL,
  PRIMARY KEY (`identreprise`),
  INDEX `identreprise_idx` (`identreprise` DESC),
  INDEX `idtypeentreprise_idx` (`idtypeentreprise` ASC),
  CONSTRAINT `fk_entreprise_type_entreprise_idtypeentreprise`
    FOREIGN KEY (`idtypeentreprise`)
    REFERENCES `stages`.`type_entreprise` (`idtypeentreprise`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 392
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`contact` (
  `idcontact` INT(10) NOT NULL AUTO_INCREMENT,
  `nomcontact` VARCHAR(100) NOT NULL,
  `prenomcontact` VARCHAR(100) NOT NULL,
  `telephone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(200) NULL DEFAULT NULL,
  `identreprise` INT(10) NOT NULL,
  PRIMARY KEY (`idcontact`),
  INDEX `identreprise_idx` (`identreprise` ASC),
  CONSTRAINT `fk_contact_entreprise_identreprise`
    FOREIGN KEY (`identreprise`)
    REFERENCES `stages`.`entreprise` (`identreprise`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 615
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`etudiant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`etudiant` (
  `idetudiant` INT(10) NOT NULL AUTO_INCREMENT,
  `nometudiant` VARCHAR(100) NOT NULL,
  `prenometudiant` VARCHAR(100) NOT NULL,
  `email_institutionnel` VARCHAR(200) NOT NULL,
  `email_personnel` VARCHAR(200) NULL DEFAULT NULL,
  `codeetudiant` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`idetudiant`))
ENGINE = InnoDB
AUTO_INCREMENT = 320
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`parrain`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`parrain` (
  `idparrain` INT(10) NOT NULL AUTO_INCREMENT,
  `nomparrain` VARCHAR(100) NOT NULL,
  `prenomparrain` VARCHAR(100) NOT NULL,
  `emailparrain` VARCHAR(200) NOT NULL,
  `idcouleur` INT(10) NOT NULL,
  PRIMARY KEY (`idparrain`),
  INDEX `idcouleur_idx` (`idcouleur` ASC),
  CONSTRAINT `fk_parrain_couleur_idcouleur`
    FOREIGN KEY (`idcouleur`)
    REFERENCES `stages`.`couleur` (`idcouleur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 34
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`theme_destage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`theme_destage` (
  `idtheme` INT(10) NOT NULL AUTO_INCREMENT,
  `theme` VARCHAR(20) NOT NULL,
  `idcouleur` INT(10) NOT NULL,
  PRIMARY KEY (`idtheme`),
  INDEX `idcouleur_idx` (`idcouleur` ASC),
  CONSTRAINT `fk_theme_destage_couleur_idcouleur`
    FOREIGN KEY (`idcouleur`)
    REFERENCES `stages`.`couleur` (`idcouleur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`datesoutenance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`datesoutenance` (
  `iddatesoutenance` INT(10) NOT NULL AUTO_INCREMENT,
  `jour` INT(2) NOT NULL DEFAULT '0',
  `mois` INT(2) NOT NULL DEFAULT '0',
  `annee` INT(4) NOT NULL DEFAULT '0',
  `convocation` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iddatesoutenance`))
ENGINE = InnoDB
AUTO_INCREMENT = 31
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`salle_soutenance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`salle_soutenance` (
  `idsalle` INT(10) NOT NULL AUTO_INCREMENT,
  `nomsalle` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idsalle`))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`soutenances`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`soutenances` (
  `idsoutenance` INT(10) NOT NULL AUTO_INCREMENT,
  `heuredebut` INT(2) NOT NULL DEFAULT '0',
  `mindebut` INT(2) NOT NULL DEFAULT '0',
  `ahuitclos` TINYINT(4) NOT NULL DEFAULT '0',
  `iddatesoutenance` INT(10) NOT NULL,
  `idsalle` INT(10) NOT NULL,
  PRIMARY KEY (`idsoutenance`),
  INDEX `iddatesoutenance_idx` (`iddatesoutenance` ASC),
  INDEX `idsalle_idx` (`idsalle` ASC),
  CONSTRAINT `fk_soutenances_datesoutenance_iddatesoutenance`
    FOREIGN KEY (`iddatesoutenance`)
    REFERENCES `stages`.`datesoutenance` (`iddatesoutenance`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_soutenances_salle_soutenance_idsalle`
    FOREIGN KEY (`idsalle`)
    REFERENCES `stages`.`salle_soutenance` (`idsalle`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 437
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`convention`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`convention` (
  `idconvention` INT(10) NOT NULL AUTO_INCREMENT,
  `sujetdestage` MEDIUMTEXT NOT NULL,
  `asonresume` TINYINT(4) NOT NULL DEFAULT '0',
  `note` DECIMAL(4,2) NOT NULL DEFAULT '0.00',
  `idparrain` INT(10) NOT NULL,
  `idexaminateur` INT(10) NOT NULL,
  `idetudiant` INT(10) NOT NULL,
  `idsoutenance` INT(10) NULL DEFAULT NULL,
  `idcontact` INT(10) NOT NULL,
  `idtheme` INT(10) NOT NULL,
  PRIMARY KEY (`idconvention`),
  INDEX `idetudiant_idx` (`idetudiant` ASC),
  INDEX `idparrain_idx` (`idparrain` ASC),
  INDEX `idexaminateur_idx` (`idexaminateur` ASC),
  INDEX `idcontact_idx` (`idcontact` ASC),
  INDEX `idtheme_idx` (`idtheme` ASC),
  UNIQUE INDEX `idsoutenance_idx` (`idsoutenance` ASC),
  CONSTRAINT `fk_convention_etudiant_idetudiant`
    FOREIGN KEY (`idetudiant`)
    REFERENCES `stages`.`etudiant` (`idetudiant`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_convention_parrain_idparrain`
    FOREIGN KEY (`idparrain`)
    REFERENCES `stages`.`parrain` (`idparrain`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_convention_parrain_idexaminateur`
    FOREIGN KEY (`idexaminateur`)
    REFERENCES `stages`.`parrain` (`idparrain`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_convention_contact_idcontact`
    FOREIGN KEY (`idcontact`)
    REFERENCES `stages`.`contact` (`idcontact`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_convention_theme_destage_idtheme`
    FOREIGN KEY (`idtheme`)
    REFERENCES `stages`.`theme_destage` (`idtheme`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_convention_soutenances_idsoutenance`
    FOREIGN KEY (`idsoutenance`)
    REFERENCES `stages`.`soutenances` (`idsoutenance`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 387
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`contrat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`contrat` (
  `idcontrat` INT(10) NOT NULL AUTO_INCREMENT,
  `sujetcontrat` MEDIUMTEXT NOT NULL,
  `typedecontrat` BOOLEAN NOT NULL,
  `duree` INT(4) NOT NULL,
  `indemnite` INT(4) NOT NULL,
  `asonresume` TINYINT(4) NOT NULL DEFAULT '0',
  `note` DECIMAL(4,2) NOT NULL DEFAULT '0.00',
  `idparrain` INT(10) NOT NULL,
  `idexaminateur` INT(10) NOT NULL,
  `idreferent` INT(10) NOT NULL,
  `idetudiant` INT(10) NOT NULL,
  `idsoutenance` INT(10) NULL DEFAULT NULL,
  `idtheme` INT(10) NOT NULL,
  PRIMARY KEY (`idcontrat`),
  INDEX `idetudiant_idx` (`idetudiant` ASC),
  INDEX `idparrain_idx` (`idparrain` ASC),
  INDEX `idexaminateur_idx` (`idexaminateur` ASC),
  INDEX `idreferent_idx` (`idreferent` ASC),
  INDEX `idtheme_idx` (`idtheme` ASC),
  UNIQUE INDEX `idsoutenance_idx` (`idsoutenance` ASC),
  CONSTRAINT `fk_contrat_etudiant_idetudiant`
    FOREIGN KEY (`idetudiant`)
    REFERENCES `stages`.`etudiant` (`idetudiant`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrat_parrain_idparrain`
    FOREIGN KEY (`idparrain`)
    REFERENCES `stages`.`parrain` (`idparrain`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrat_parrain_idparrain_2`
    FOREIGN KEY (`idexaminateur`)
    REFERENCES `stages`.`parrain` (`idparrain`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrat_contact_idreferent`
    FOREIGN KEY (`idreferent`)
    REFERENCES `stages`.`contact` (`idcontact`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrat_theme_destage_idtheme`
    FOREIGN KEY (`idtheme`)
    REFERENCES `stages`.`theme_destage` (`idtheme`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contrat_soutenances_idsoutenance`
    FOREIGN KEY (`idsoutenance`)
    REFERENCES `stages`.`soutenances` (`idsoutenance`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 387
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`filiere`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`filiere` (
  `idfiliere` INT(10) NOT NULL AUTO_INCREMENT,
  `nomfiliere` VARCHAR(50) NOT NULL,
  `temps_soutenance` INT(3) NOT NULL DEFAULT '20',
  `affDepot` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idfiliere`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`fluxrss`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`fluxrss` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `link` TEXT CHARACTER SET 'utf8' NOT NULL,
  `timestamp` INT(12) NOT NULL DEFAULT '0',
  `contents` TEXT CHARACTER SET 'utf8' NOT NULL,
  `author` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`ID`))
ENGINE = MyISAM
AUTO_INCREMENT = 41
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`offredestage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`offredestage` (
  `idoffre` INT(10) NOT NULL AUTO_INCREMENT,
  `sujet` TEXT NOT NULL,
  `titre` VARCHAR(120) NOT NULL,
  `dureemin` VARCHAR(50) NOT NULL,
  `dureemax` VARCHAR(50) NOT NULL,
  `indemnite` DOUBLE NOT NULL DEFAULT '0',
  `remarques` TEXT NOT NULL,
  `estVisible` TINYINT(4) NOT NULL DEFAULT '0',
  `idcontact` INT(10) NOT NULL,
  PRIMARY KEY (`idoffre`),
  INDEX `idcontact_idx` (`idcontact` ASC),
  CONSTRAINT `fk_offredestage_contact_idcontact`
    FOREIGN KEY (`idcontact`)
    REFERENCES `stages`.`contact` (`idcontact`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 317
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`offredalternance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`offredalternance` (
  `idoffre` INT(10) NOT NULL AUTO_INCREMENT,
  `sujet` TEXT NOT NULL,
  `titre` VARCHAR(120) NOT NULL,
  `duree` VARCHAR(50) NOT NULL,
  `indemnite` DOUBLE NOT NULL DEFAULT '0',
  `remarques` TEXT NOT NULL,
  `estVisible` TINYINT(4) NOT NULL DEFAULT '0',
  `idcontact` INT(10) NOT NULL,
  `typedecontrat` BOOLEAN NOT NULL,
  PRIMARY KEY (`idoffre`),
  INDEX `idcontact_idx` (`idcontact` ASC),
  CONSTRAINT `fk_offredalternance_contact_idcontact`
    FOREIGN KEY (`idcontact`)
    REFERENCES `stages`.`contact` (`idcontact`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 317
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`parcours`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`parcours` (
  `idparcours` INT(10) NOT NULL AUTO_INCREMENT,
  `nomparcours` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idparcours`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`profilsouhaite_offredestage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`profilsouhaite_offredestage` (
  `idoffre` INT(10) NOT NULL,
  `idfiliere` INT(10) NOT NULL,
  INDEX `idoffre_idx` (`idoffre` ASC),
  INDEX `idfiliere_idx` (`idfiliere` ASC),
  CONSTRAINT `fk_profilsouhaite_offredestage_idoffre`
    FOREIGN KEY (`idoffre`)
    REFERENCES `stages`.`offredestage` (`idoffre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_profilsouhaite_offredestage_filiere_idfiliere`
    FOREIGN KEY (`idfiliere`)
    REFERENCES `stages`.`filiere` (`idfiliere`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`profilsouhaite_offredalternance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`profilsouhaite_offredalternance` (
  `idoffre` INT(10) NOT NULL,
  `idfiliere` INT(10) NOT NULL,
  INDEX `idoffre_idx` (`idoffre` ASC),
  INDEX `idfiliere_idx` (`idfiliere` ASC),
  CONSTRAINT `fk_profilsouhaite_offredalternance_idoffre`
    FOREIGN KEY (`idoffre`)
    REFERENCES `stages`.`offredalternance` (`idoffre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_profilsouhaite_offredalternance_filiere_idfiliere`
    FOREIGN KEY (`idfiliere`)
    REFERENCES `stages`.`filiere` (`idfiliere`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`promotion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`promotion` (
  `idpromotion` INT(10) NOT NULL AUTO_INCREMENT,
  `anneeuniversitaire` INT(10) NOT NULL DEFAULT '0',
  `idparcours` INT(10) NOT NULL,
  `idfiliere` INT(10) NOT NULL,
  `email_promotion` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`idpromotion`),
  INDEX `idfiliere_idx` (`idfiliere` ASC),
  INDEX `idparcours_idx` (`idparcours` ASC),
  CONSTRAINT `fk_promotion_filiere_idfiliere`
    FOREIGN KEY (`idfiliere`)
    REFERENCES `stages`.`filiere` (`idfiliere`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_promotion_parcours_idparcours`
    FOREIGN KEY (`idparcours`)
    REFERENCES `stages`.`parcours` (`idparcours`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 24
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`relation_competence_offredestage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`relation_competence_offredestage` (
  `idcompetence` INT(10) NOT NULL,
  `idoffre` INT(10) NOT NULL,
  INDEX `idoffre_idx` (`idoffre` ASC),
  INDEX `idcompetence_idx` (`idcompetence` ASC),
  CONSTRAINT `fk_relation_c_os_offredestage_idoffre`
    FOREIGN KEY (`idoffre`)
    REFERENCES `stages`.`offredestage` (`idoffre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_relation_c_os_competence_idcompetence`
    FOREIGN KEY (`idcompetence`)
    REFERENCES `stages`.`competence` (`idcompetence`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`relation_competence_offredalternance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`relation_competence_offredalternance` (
  `idcompetence` INT(10) NOT NULL,
  `idoffre` INT(10) NOT NULL,
  INDEX `idoffre_idx` (`idoffre` ASC),
  INDEX `idcompetence_idx` (`idcompetence` ASC),
  CONSTRAINT `fk_relation_c_oa_offredalternance_idoffre`
    FOREIGN KEY (`idoffre`)
    REFERENCES `stages`.`offredalternance` (`idoffre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_relation_c_oa_competence_idcompetence`
    FOREIGN KEY (`idcompetence`)
    REFERENCES `stages`.`competence` (`idcompetence`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`relation_promotion_datesoutenance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`relation_promotion_datesoutenance` (
  `iddatesoutenance` INT(10) NOT NULL,
  `idpromotion` INT(10) NOT NULL,
  INDEX `iddatesoutenance_idx` (`iddatesoutenance` ASC),
  INDEX `idpromotion_idx` (`idpromotion` ASC),
  CONSTRAINT `fk_relation_p_d_datesoutenance_iddatesoutenance`
    FOREIGN KEY (`iddatesoutenance`)
    REFERENCES `stages`.`datesoutenance` (`iddatesoutenance`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_relation_p_d_promotion_idpromotion`
    FOREIGN KEY (`idpromotion`)
    REFERENCES `stages`.`promotion` (`idpromotion`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`relation_promotion_etudiant_convention`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`relation_promotion_etudiant_convention` (
  `idconvention` INT(10) NULL DEFAULT NULL,
  `idpromotion` INT(10) NOT NULL,
  `idetudiant` INT(10) NOT NULL,
  INDEX `idpromotion_idx` (`idpromotion` ASC),
  INDEX `idetudiant_idx` (`idetudiant` ASC),
  UNIQUE INDEX `idconvention_idx` (`idconvention` ASC),
  CONSTRAINT `fk_relation_p_e_c_promotion_idpromotion`
    FOREIGN KEY (`idpromotion`)
    REFERENCES `stages`.`promotion` (`idpromotion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_relation_p_e_c_etudiant_idetudiant`
    FOREIGN KEY (`idetudiant`)
    REFERENCES `stages`.`etudiant` (`idetudiant`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_relation_p_e_c_convention_idconvention`
    FOREIGN KEY (`idconvention`)
    REFERENCES `stages`.`convention` (`idconvention`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`relation_promotion_etudiant_contrat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`relation_promotion_etudiant_contrat` (
  `idcontrat` INT(10) NULL DEFAULT NULL,
  `idpromotion` INT(10) NOT NULL,
  `idetudiant` INT(10) NOT NULL,
  INDEX `idpromotion_idx` (`idpromotion` ASC),
  INDEX `idetudiant_idx` (`idetudiant` ASC),
  UNIQUE INDEX `idcontrat_idx` (`idcontrat` ASC),
  CONSTRAINT `fk_relation_p_e_ctr_promotion_idpromotion`
    FOREIGN KEY (`idpromotion`)
    REFERENCES `stages`.`promotion` (`idpromotion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_relation_p_e_ctr_etudiant_idetudiant`
    FOREIGN KEY (`idetudiant`)
    REFERENCES `stages`.`etudiant` (`idetudiant`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_relation_p_e_ctr_contrat_idcontrat`
    FOREIGN KEY (`idcontrat`)
    REFERENCES `stages`.`contrat` (`idcontrat`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`sujetdestage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`sujetdestage` (
  `idsujetdestage` INT(10) NOT NULL AUTO_INCREMENT,
  `description` TEXT NOT NULL,
  `valide` TINYINT(4) NOT NULL DEFAULT '0',
  `enattente` TINYINT(4) NOT NULL DEFAULT '0',
  `idetudiant` INT(10) NOT NULL,
  `idpromotion` INT(11) NOT NULL,
  PRIMARY KEY (`idsujetdestage`),
  INDEX `idpromotion_idx` (`idpromotion` ASC),
  INDEX `idetudiant_idx` (`idetudiant` ASC),
  CONSTRAINT `fk_sujetdestage_promotion_idpromotion`
    FOREIGN KEY (`idpromotion`)
    REFERENCES `stages`.`promotion` (`idpromotion`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_sujetdestage_etudiant_idetudiant`
    FOREIGN KEY (`idetudiant`)
    REFERENCES `stages`.`etudiant` (`idetudiant`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 272
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`sujetdalternance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`sujetdalternance` (
  `idsujetdalternance` INT(10) NOT NULL AUTO_INCREMENT,
  `description` TEXT NOT NULL,
  `valide` TINYINT(4) NOT NULL DEFAULT '0',
  `enattente` TINYINT(4) NOT NULL DEFAULT '0',
  `idetudiant` INT(10) NOT NULL,
  `idpromotion` INT(11) NOT NULL,
  PRIMARY KEY (`idsujetdalternance`),
  INDEX `idpromotion_idx` (`idpromotion` ASC),
  INDEX `idetudiant_idx` (`idetudiant` ASC),
  CONSTRAINT `fk_sujetdalternance_promotion_idpromotion`
    FOREIGN KEY (`idpromotion`)
    REFERENCES `stages`.`promotion` (`idpromotion`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_sujetdalternance_etudiant_idetudiant`
    FOREIGN KEY (`idetudiant`)
    REFERENCES `stages`.`etudiant` (`idetudiant`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 272
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`taches`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`taches` (
  `idtache` INT(10) NOT NULL AUTO_INCREMENT,
  `intitule` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `statut` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL DEFAULT 'Pas fait',
  `priorite` MEDIUMINT(9) NOT NULL DEFAULT '0',
  `datelimite` DATE NOT NULL,
  PRIMARY KEY (`idtache`))
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`theme_offredestage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`theme_offredestage` (
  `idparcours` INT(10) NOT NULL,
  `idoffre` INT(10) NOT NULL,
  INDEX `idoffre_idx` (`idoffre` ASC),
  INDEX `idparcours_idx` (`idparcours` ASC),
  CONSTRAINT `fk_theme_offredestage_idoffre`
    FOREIGN KEY (`idoffre`)
    REFERENCES `stages`.`offredestage` (`idoffre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_theme_offredestage_parcours_idparcours`
    FOREIGN KEY (`idparcours`)
    REFERENCES `stages`.`parcours` (`idparcours`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`theme_offredalternance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`theme_offredalternance` (
  `idparcours` INT(10) NOT NULL,
  `idoffre` INT(10) NOT NULL,
  INDEX `idoffre_idx` (`idoffre` ASC),
  INDEX `idparcours_idx` (`idparcours` ASC),
  CONSTRAINT `fk_theme_offredalternance_idoffre`
    FOREIGN KEY (`idoffre`)
    REFERENCES `stages`.`offredalternance` (`idoffre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_theme_offredalternance_parcours_idparcours`
    FOREIGN KEY (`idparcours`)
    REFERENCES `stages`.`parcours` (`idparcours`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`convocation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`convocation` (
  `idconvocation` INT(10) NOT NULL AUTO_INCREMENT,
  `envoi` TINYINT(4) NOT NULL DEFAULT 0,
  `idsoutenance` INT(10) NOT NULL,
  PRIMARY KEY (`idconvocation`),
  UNIQUE INDEX `idsoutenance_idx` (`idsoutenance` ASC),
  CONSTRAINT `fk_convocation_soutenances_idsoutenance`
    FOREIGN KEY (`idsoutenance`)
    REFERENCES `stages`.`soutenances` (`idsoutenance`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`attribution`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`attribution` (
  `idattribution` INT(10) NOT NULL AUTO_INCREMENT,
  `envoi` TINYINT(4) NOT NULL DEFAULT 0,
  `idconvention` INT(10) NOT NULL,
  PRIMARY KEY (`idattribution`),
  UNIQUE INDEX `idconvention_idx` (`idconvention` ASC),
  CONSTRAINT `fk_attribution_convention_idconvention`
    FOREIGN KEY (`idconvention`)
    REFERENCES `stages`.`convention` (`idconvention`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`affectation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`affectation` (
  `idaffectation` INT(10) NOT NULL AUTO_INCREMENT,
  `envoi` TINYINT(4) NOT NULL DEFAULT 0,
  `idcontrat` INT(10) NOT NULL,
  PRIMARY KEY (`idaffectation`),
  UNIQUE INDEX `idcontrat_idx` (`idcontrat` ASC),
  CONSTRAINT `fk_affectation_contrat_idcontrat`
    FOREIGN KEY (`idcontrat`)
    REFERENCES `stages`.`contrat` (`idcontrat`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `stages`.`candidature_alternance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stages`.`candidature_alternance` (
  `idcandidature` INT(10) NOT NULL AUTO_INCREMENT,
  `idetudiant` INT(10) NOT NULL,
  `idoffre` INT(10) NOT NULL,
  `identreprise` INT(10) NOT NULL,
  `statut` VARCHAR(40) NOT NULL DEFAULT "--",
  PRIMARY KEY (`idcandidature`),
  UNIQUE INDEX `idcandidature_idx` (`idcandidature` ASC),
  CONSTRAINT `fk_candidature_alternance_etudiant_idetudiant`
    FOREIGN KEY (`idetudiant`)
    REFERENCES `stages`.`etudiant` (`idetudiant`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_candidature_alternance_offredalternance_idoffre`
    FOREIGN KEY (`idoffre`)
    REFERENCES `stages`.`offredalternance` (`idoffre`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_candidature_alternance_entreprise_identreprise`
    FOREIGN KEY (`identreprise`)
    REFERENCES `stages`.`entreprise` (`identreprise`)
    ON DELETE CASCADE
    ON UPDATE CASCADE )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
