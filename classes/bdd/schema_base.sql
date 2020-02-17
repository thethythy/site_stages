-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 10, 2020 at 04:03 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stages`
--

-- --------------------------------------------------------

--
-- Table structure for table `affectation`
--

CREATE TABLE `affectation` (
  `idaffectation` int(10) NOT NULL,
  `envoi` tinyint(4) NOT NULL DEFAULT '0',
  `idcontrat` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attribution`
--

CREATE TABLE `attribution` (
  `idattribution` int(10) NOT NULL,
  `envoi` tinyint(4) NOT NULL DEFAULT '0',
  `idconvention` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `candidature_alternance`
--

CREATE TABLE `candidature_alternance` (
  `idcandidature` int(10) NOT NULL,
  `idetudiant` int(10) NOT NULL,
  `idoffre` int(10) NOT NULL,
  `identreprise` int(10) NOT NULL,
  `statut` varchar(40) NOT NULL DEFAULT '--'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `competence`
--

CREATE TABLE `competence` (
  `idcompetence` int(10) NOT NULL,
  `nomcompetence` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `idcontact` int(10) NOT NULL,
  `nomcontact` varchar(100) NOT NULL,
  `prenomcontact` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `identreprise` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contrat`
--

CREATE TABLE `contrat` (
  `idcontrat` int(10) NOT NULL,
  `sujetcontrat` mediumtext NOT NULL,
  `typedecontrat` tinyint(1) NOT NULL,
  `duree` int(4) NOT NULL,
  `indemnite` int(4) NOT NULL,
  `asonresume` tinyint(4) NOT NULL DEFAULT '0',
  `note` decimal(4,2) NOT NULL DEFAULT '0.00',
  `idparrain` int(10) NOT NULL,
  `idexaminateur` int(10) NOT NULL,
  `idreferent` int(10) NOT NULL,
  `idetudiant` int(10) NOT NULL,
  `idsoutenance` int(10) DEFAULT NULL,
  `idtheme` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `convention`
--

CREATE TABLE `convention` (
  `idconvention` int(10) NOT NULL,
  `sujetdestage` mediumtext NOT NULL,
  `asonresume` tinyint(4) NOT NULL DEFAULT '0',
  `note` decimal(4,2) NOT NULL DEFAULT '0.00',
  `idparrain` int(10) NOT NULL,
  `idexaminateur` int(10) NOT NULL,
  `idetudiant` int(10) NOT NULL,
  `idsoutenance` int(10) DEFAULT NULL,
  `idcontact` int(10) NOT NULL,
  `idtheme` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `convocation`
--

CREATE TABLE `convocation` (
  `idconvocation` int(10) NOT NULL,
  `envoi` tinyint(4) NOT NULL DEFAULT '0',
  `idsoutenance` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `couleur`
--

CREATE TABLE `couleur` (
  `idcouleur` int(10) NOT NULL,
  `nomcouleur` varchar(100) NOT NULL,
  `codehexa` varchar(6) NOT NULL DEFAULT '000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `datesoutenance`
--

CREATE TABLE `datesoutenance` (
  `iddatesoutenance` int(10) NOT NULL,
  `jour` int(2) NOT NULL DEFAULT '0',
  `mois` int(2) NOT NULL DEFAULT '0',
  `annee` int(4) NOT NULL DEFAULT '0',
  `convocation` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entreprise`
--

CREATE TABLE `entreprise` (
  `identreprise` int(10) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `codepostal` varchar(8) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `email` varchar(256) NOT NULL,
  `idtypeentreprise` int(10) DEFAULT NULL,
  `siret` bigint(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `etudiant`
--

CREATE TABLE `etudiant` (
  `idetudiant` int(10) NOT NULL,
  `nometudiant` varchar(100) NOT NULL,
  `prenometudiant` varchar(100) NOT NULL,
  `email_institutionnel` varchar(200) NOT NULL,
  `email_personnel` varchar(200) DEFAULT NULL,
  `codeetudiant` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `filiere`
--

CREATE TABLE `filiere` (
  `idfiliere` int(10) NOT NULL,
  `nomfiliere` varchar(50) NOT NULL,
  `temps_soutenance` int(3) NOT NULL DEFAULT '20',
  `affDepot` tinyint(1) NOT NULL DEFAULT '1',
  `idfilieresuivante` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fluxrss`
--

CREATE TABLE `fluxrss` (
  `ID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `link` mediumtext NOT NULL,
  `timestamp` int(12) NOT NULL DEFAULT '0',
  `contents` mediumtext NOT NULL,
  `author` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offredalternance`
--

CREATE TABLE `offredalternance` (
  `idoffre` int(10) NOT NULL,
  `sujet` text NOT NULL,
  `titre` varchar(120) NOT NULL,
  `duree` varchar(50) NOT NULL,
  `indemnite` double NOT NULL DEFAULT '0',
  `remarques` text NOT NULL,
  `estVisible` tinyint(4) NOT NULL DEFAULT '0',
  `idcontact` int(10) NOT NULL,
  `typedecontrat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `offredestage`
--

CREATE TABLE `offredestage` (
  `idoffre` int(10) NOT NULL,
  `sujet` mediumtext NOT NULL,
  `titre` varchar(120) NOT NULL,
  `dureemin` varchar(50) NOT NULL,
  `dureemax` varchar(50) NOT NULL,
  `indemnite` double NOT NULL DEFAULT '0',
  `remarques` mediumtext NOT NULL,
  `estVisible` tinyint(4) NOT NULL DEFAULT '0',
  `idcontact` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parcours`
--

CREATE TABLE `parcours` (
  `idparcours` int(10) NOT NULL,
  `nomparcours` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parrain`
--

CREATE TABLE `parrain` (
  `idparrain` int(10) NOT NULL,
  `nomparrain` varchar(100) NOT NULL,
  `prenomparrain` varchar(100) NOT NULL,
  `emailparrain` varchar(200) NOT NULL,
  `idcouleur` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profilsouhaite_offredalternance`
--

CREATE TABLE `profilsouhaite_offredalternance` (
  `idoffre` int(10) NOT NULL,
  `idfiliere` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profilsouhaite_offredestage`
--

CREATE TABLE `profilsouhaite_offredestage` (
  `idoffre` int(10) NOT NULL,
  `idfiliere` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `idpromotion` int(10) NOT NULL,
  `anneeuniversitaire` int(10) NOT NULL DEFAULT '0',
  `idparcours` int(10) NOT NULL,
  `idfiliere` int(10) NOT NULL,
  `email_promotion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relation_competence_offredalternance`
--

CREATE TABLE `relation_competence_offredalternance` (
  `idcompetence` int(10) NOT NULL,
  `idoffre` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relation_competence_offredestage`
--

CREATE TABLE `relation_competence_offredestage` (
  `idcompetence` int(10) NOT NULL,
  `idoffre` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relation_promotion_datesoutenance`
--

CREATE TABLE `relation_promotion_datesoutenance` (
  `iddatesoutenance` int(10) NOT NULL,
  `idpromotion` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relation_promotion_etudiant_contrat`
--

CREATE TABLE `relation_promotion_etudiant_contrat` (
  `idcontrat` int(10) DEFAULT NULL,
  `idpromotion` int(10) NOT NULL,
  `idetudiant` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relation_promotion_etudiant_convention`
--

CREATE TABLE `relation_promotion_etudiant_convention` (
  `idetudiant` int(10) NOT NULL,
  `idconvention` int(10) DEFAULT NULL,
  `idpromotion` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relation_promotion_offredalternance`
--

CREATE TABLE `relation_promotion_offredalternance` (
  `idpromotion` int(10) NOT NULL,
  `idoffre` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Table structure for table `relation_promotion_offredestage`
--

CREATE TABLE `relation_promotion_offredestage` (
  `idpromotion` int(10) NOT NULL,
  `idoffre` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Table structure for table `responsable`
--

CREATE TABLE `responsable` (
  `idresponsable` int(10) NOT NULL,
  `responsabilite` varchar(100) NOT NULL,
  `nomresponsable` varchar(100) NOT NULL,
  `prenomresponsable` varchar(100) NOT NULL,
  `emailresponsable` varchar(100) NOT NULL,
  `titreresponsable` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `salle_soutenance`
--

CREATE TABLE `salle_soutenance` (
  `idsalle` int(10) NOT NULL,
  `nomsalle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `soutenances`
--

CREATE TABLE `soutenances` (
  `idsoutenance` int(10) NOT NULL,
  `heuredebut` int(2) NOT NULL DEFAULT '0',
  `mindebut` int(2) NOT NULL DEFAULT '0',
  `ahuitclos` tinyint(4) NOT NULL DEFAULT '0',
  `iddatesoutenance` int(10) NOT NULL,
  `idsalle` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sujetdalternance`
--

CREATE TABLE `sujetdalternance` (
  `idsujetdalternance` int(10) NOT NULL,
  `description` text NOT NULL,
  `valide` tinyint(4) NOT NULL DEFAULT '0',
  `enattente` tinyint(4) NOT NULL DEFAULT '0',
  `idetudiant` int(10) NOT NULL,
  `idpromotion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sujetdestage`
--

CREATE TABLE `sujetdestage` (
  `idsujetdestage` int(10) NOT NULL,
  `description` mediumtext NOT NULL,
  `valide` tinyint(4) NOT NULL DEFAULT '0',
  `enattente` tinyint(4) NOT NULL DEFAULT '0',
  `idetudiant` int(10) NOT NULL,
  `idpromotion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `taches`
--

CREATE TABLE `taches` (
  `idtache` int(10) NOT NULL,
  `intitule` varchar(100) NOT NULL,
  `statut` varchar(20) NOT NULL DEFAULT 'Pas fait',
  `priorite` mediumint(9) NOT NULL DEFAULT '0',
  `datelimite` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `theme_destage`
--

CREATE TABLE `theme_destage` (
  `idtheme` int(10) NOT NULL,
  `theme` varchar(20) NOT NULL,
  `idcouleur` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `theme_offredalternance`
--

CREATE TABLE `theme_offredalternance` (
  `idparcours` int(10) NOT NULL,
  `idoffre` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `theme_offredestage`
--

CREATE TABLE `theme_offredestage` (
  `idparcours` int(10) NOT NULL,
  `idoffre` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `type_entreprise`
--

CREATE TABLE `type_entreprise` (
  `idtypeentreprise` int(10) NOT NULL,
  `type` varchar(30) NOT NULL,
  `idcouleur` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affectation`
--
ALTER TABLE `affectation`
  ADD PRIMARY KEY (`idaffectation`),
  ADD UNIQUE KEY `idcontrat_idx` (`idcontrat`);

--
-- Indexes for table `attribution`
--
ALTER TABLE `attribution`
  ADD PRIMARY KEY (`idattribution`),
  ADD UNIQUE KEY `idconvention_idx` (`idconvention`) USING BTREE;

--
-- Indexes for table `candidature_alternance`
--
ALTER TABLE `candidature_alternance`
  ADD PRIMARY KEY (`idcandidature`),
  ADD UNIQUE KEY `idcandidature_idx` (`idcandidature`),
  ADD KEY `fk_candidature_alternance_etudiant_idetudiant` (`idetudiant`),
  ADD KEY `fk_candidature_alternance_offredalternance_idoffre` (`idoffre`),
  ADD KEY `fk_candidature_alternance_entreprise_identreprise` (`identreprise`);

--
-- Indexes for table `competence`
--
ALTER TABLE `competence`
  ADD PRIMARY KEY (`idcompetence`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`idcontact`),
  ADD KEY `identreprise_idx` (`identreprise`) USING BTREE;

--
-- Indexes for table `contrat`
--
ALTER TABLE `contrat`
  ADD PRIMARY KEY (`idcontrat`),
  ADD UNIQUE KEY `idsoutenance_idx` (`idsoutenance`),
  ADD KEY `idetudiant_idx` (`idetudiant`),
  ADD KEY `idparrain_idx` (`idparrain`),
  ADD KEY `idreferent_idx` (`idreferent`),
  ADD KEY `idtheme_idx` (`idtheme`),
  ADD KEY `idexaminateur_idx` (`idexaminateur`) USING BTREE;

--
-- Indexes for table `convention`
--
ALTER TABLE `convention`
  ADD PRIMARY KEY (`idconvention`),
  ADD UNIQUE KEY `idsoutenance_idx` (`idsoutenance`) USING BTREE,
  ADD KEY `idparrain_idx` (`idparrain`) USING BTREE,
  ADD KEY `idtheme_idx` (`idtheme`) USING BTREE,
  ADD KEY `idexaminateur_idx` (`idexaminateur`) USING BTREE,
  ADD KEY `idcontact_idx` (`idcontact`) USING BTREE,
  ADD KEY `idetudiant_idx` (`idetudiant`) USING BTREE;

--
-- Indexes for table `convocation`
--
ALTER TABLE `convocation`
  ADD PRIMARY KEY (`idconvocation`),
  ADD UNIQUE KEY `idsoutenance_idx` (`idsoutenance`) USING BTREE;

--
-- Indexes for table `couleur`
--
ALTER TABLE `couleur`
  ADD PRIMARY KEY (`idcouleur`);

--
-- Indexes for table `datesoutenance`
--
ALTER TABLE `datesoutenance`
  ADD PRIMARY KEY (`iddatesoutenance`);

--
-- Indexes for table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`identreprise`),
  ADD KEY `idtypeentreprise_idx` (`idtypeentreprise`);

--
-- Indexes for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`idetudiant`);

--
-- Indexes for table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`idfiliere`),
  ADD KEY `fk_filiere_filire_idfiliere` (`idfilieresuivante`);

--
-- Indexes for table `fluxrss`
--
ALTER TABLE `fluxrss`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `offredalternance`
--
ALTER TABLE `offredalternance`
  ADD PRIMARY KEY (`idoffre`),
  ADD KEY `idcontact_idx` (`idcontact`);

--
-- Indexes for table `offredestage`
--
ALTER TABLE `offredestage`
  ADD PRIMARY KEY (`idoffre`),
  ADD KEY `idcontact_idx` (`idcontact`) USING BTREE;

--
-- Indexes for table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`idparcours`);

--
-- Indexes for table `parrain`
--
ALTER TABLE `parrain`
  ADD PRIMARY KEY (`idparrain`),
  ADD KEY `idcouleur_idx` (`idcouleur`) USING BTREE;

--
-- Indexes for table `profilsouhaite_offredalternance`
--
ALTER TABLE `profilsouhaite_offredalternance`
  ADD PRIMARY KEY (`idoffre`,`idfiliere`),
  ADD KEY `idoffre_idx` (`idoffre`),
  ADD KEY `idfiliere_idx` (`idfiliere`);

--
-- Indexes for table `profilsouhaite_offredestage`
--
ALTER TABLE `profilsouhaite_offredestage`
  ADD PRIMARY KEY (`idoffre`,`idfiliere`),
  ADD KEY `idfiliere_idx` (`idfiliere`) USING BTREE,
  ADD KEY `idoffre_idx` (`idoffre`) USING BTREE;

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`idpromotion`),
  ADD KEY `idfiliere_idx` (`idfiliere`) USING BTREE,
  ADD KEY `idparcours_idx` (`idparcours`) USING BTREE;

--
-- Indexes for table `relation_competence_offredalternance`
--
ALTER TABLE `relation_competence_offredalternance`
  ADD PRIMARY KEY (`idcompetence`,`idoffre`),
  ADD KEY `idoffre_idx` (`idoffre`),
  ADD KEY `idcompetence_idx` (`idcompetence`);

--
-- Indexes for table `relation_competence_offredestage`
--
ALTER TABLE `relation_competence_offredestage`
  ADD KEY `idcompetence_idx` (`idcompetence`) USING BTREE,
  ADD KEY `idoffre_idx` (`idoffre`) USING BTREE;

--
-- Indexes for table `relation_promotion_datesoutenance`
--
ALTER TABLE `relation_promotion_datesoutenance`
  ADD KEY `iddatesoutenance_idx` (`iddatesoutenance`) USING BTREE,
  ADD KEY `idpromotion_idx` (`idpromotion`) USING BTREE;

--
-- Indexes for table `relation_promotion_etudiant_contrat`
--
ALTER TABLE `relation_promotion_etudiant_contrat`
  ADD UNIQUE KEY `idcontrat_idx` (`idcontrat`),
  ADD KEY `idpromotion_idx` (`idpromotion`),
  ADD KEY `idetudiant_idx` (`idetudiant`);

--
-- Indexes for table `relation_promotion_etudiant_convention`
--
ALTER TABLE `relation_promotion_etudiant_convention`
  ADD UNIQUE KEY `idconvention_idx` (`idconvention`),
  ADD KEY `idetudiant_idx` (`idetudiant`) USING BTREE,
  ADD KEY `idpromotion_idx` (`idpromotion`) USING BTREE;

--
-- Indexes for table `relation_promotion_offredalternance`
--
ALTER TABLE `relation_promotion_offredalternance`
  ADD KEY `fk_relation_p_oa_offredalternance_idoffre_idx` (`idoffre`),
  ADD KEY `fk_relation_p_oa_promotion_idpromotion_idx` (`idpromotion`);

--
-- Indexes for table `relation_promotion_offredestage`
--
ALTER TABLE `relation_promotion_offredestage`
  ADD KEY `fk_relation_p_o_offredestage_idoffre_idx` (`idoffre`),
  ADD KEY `fk_relation_p_os_promotion_idpromotion_idx` (`idpromotion`);

--
-- Indexes for table `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`idresponsable`);

--
-- Indexes for table `salle_soutenance`
--
ALTER TABLE `salle_soutenance`
  ADD PRIMARY KEY (`idsalle`);

--
-- Indexes for table `soutenances`
--
ALTER TABLE `soutenances`
  ADD PRIMARY KEY (`idsoutenance`),
  ADD KEY `idsalle_idx` (`idsalle`) USING BTREE,
  ADD KEY `iddatesoutenance_idx` (`iddatesoutenance`) USING BTREE;

--
-- Indexes for table `sujetdalternance`
--
ALTER TABLE `sujetdalternance`
  ADD PRIMARY KEY (`idsujetdalternance`),
  ADD KEY `idpromotion_idx` (`idpromotion`),
  ADD KEY `idetudiant_idx` (`idetudiant`);

--
-- Indexes for table `sujetdestage`
--
ALTER TABLE `sujetdestage`
  ADD PRIMARY KEY (`idsujetdestage`),
  ADD KEY `idetudiant_idx` (`idetudiant`) USING BTREE,
  ADD KEY `idpromotion_idx` (`idpromotion`);

--
-- Indexes for table `taches`
--
ALTER TABLE `taches`
  ADD PRIMARY KEY (`idtache`);

--
-- Indexes for table `theme_destage`
--
ALTER TABLE `theme_destage`
  ADD PRIMARY KEY (`idtheme`),
  ADD KEY `idcouleur_idx` (`idcouleur`) USING BTREE;

--
-- Indexes for table `theme_offredalternance`
--
ALTER TABLE `theme_offredalternance`
  ADD KEY `idoffre_idx` (`idoffre`),
  ADD KEY `idparcours_idx` (`idparcours`);

--
-- Indexes for table `theme_offredestage`
--
ALTER TABLE `theme_offredestage`
  ADD KEY `idoffre_idx` (`idoffre`) USING BTREE,
  ADD KEY `idparcours_idx` (`idparcours`) USING BTREE;

--
-- Indexes for table `type_entreprise`
--
ALTER TABLE `type_entreprise`
  ADD PRIMARY KEY (`idtypeentreprise`),
  ADD KEY `idcouleur_idx` (`idcouleur`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affectation`
--
ALTER TABLE `affectation`
  MODIFY `idaffectation` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attribution`
--
ALTER TABLE `attribution`
  MODIFY `idattribution` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidature_alternance`
--
ALTER TABLE `candidature_alternance`
  MODIFY `idcandidature` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `competence`
--
ALTER TABLE `competence`
  MODIFY `idcompetence` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `idcontact` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `idcontrat` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `convention`
--
ALTER TABLE `convention`
  MODIFY `idconvention` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `convocation`
--
ALTER TABLE `convocation`
  MODIFY `idconvocation` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `couleur`
--
ALTER TABLE `couleur`
  MODIFY `idcouleur` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `datesoutenance`
--
ALTER TABLE `datesoutenance`
  MODIFY `iddatesoutenance` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `identreprise` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `idetudiant` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `idfiliere` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fluxrss`
--
ALTER TABLE `fluxrss`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offredalternance`
--
ALTER TABLE `offredalternance`
  MODIFY `idoffre` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offredestage`
--
ALTER TABLE `offredestage`
  MODIFY `idoffre` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `idparcours` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parrain`
--
ALTER TABLE `parrain`
  MODIFY `idparrain` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `idpromotion` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `responsable`
--
ALTER TABLE `responsable`
  MODIFY `idresponsable` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salle_soutenance`
--
ALTER TABLE `salle_soutenance`
  MODIFY `idsalle` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `soutenances`
--
ALTER TABLE `soutenances`
  MODIFY `idsoutenance` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sujetdalternance`
--
ALTER TABLE `sujetdalternance`
  MODIFY `idsujetdalternance` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sujetdestage`
--
ALTER TABLE `sujetdestage`
  MODIFY `idsujetdestage` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taches`
--
ALTER TABLE `taches`
  MODIFY `idtache` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theme_destage`
--
ALTER TABLE `theme_destage`
  MODIFY `idtheme` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_entreprise`
--
ALTER TABLE `type_entreprise`
  MODIFY `idtypeentreprise` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affectation`
--
ALTER TABLE `affectation`
  ADD CONSTRAINT `fk_affectation_contrat_idcontrat` FOREIGN KEY (`idcontrat`) REFERENCES `contrat` (`idcontrat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attribution`
--
ALTER TABLE `attribution`
  ADD CONSTRAINT `fk_attribution_convention_idconvention` FOREIGN KEY (`idconvention`) REFERENCES `convention` (`idconvention`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `candidature_alternance`
--
ALTER TABLE `candidature_alternance`
  ADD CONSTRAINT `fk_candidature_alternance_entreprise_identreprise` FOREIGN KEY (`identreprise`) REFERENCES `entreprise` (`identreprise`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_candidature_alternance_etudiant_idetudiant` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_candidature_alternance_offredalternance_idoffre` FOREIGN KEY (`idoffre`) REFERENCES `offredalternance` (`idoffre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `fk_contact_entreprise_identreprise` FOREIGN KEY (`identreprise`) REFERENCES `entreprise` (`identreprise`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `contrat`
--
ALTER TABLE `contrat`
  ADD CONSTRAINT `fk_contrat_contact_idreferent` FOREIGN KEY (`idreferent`) REFERENCES `contact` (`idcontact`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contrat_etudiant_idetudiant` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contrat_parrain_idparrain` FOREIGN KEY (`idparrain`) REFERENCES `parrain` (`idparrain`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contrat_parrain_idparrain_2` FOREIGN KEY (`idexaminateur`) REFERENCES `parrain` (`idparrain`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contrat_soutenances_idsoutenance` FOREIGN KEY (`idsoutenance`) REFERENCES `soutenances` (`idsoutenance`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contrat_theme_destage_idtheme` FOREIGN KEY (`idtheme`) REFERENCES `theme_destage` (`idtheme`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `convention`
--
ALTER TABLE `convention`
  ADD CONSTRAINT `fk_convention_contact_idcontact` FOREIGN KEY (`idcontact`) REFERENCES `contact` (`idcontact`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_convention_etudiant_idetudiant` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_convention_parrain_idexaminateur` FOREIGN KEY (`idexaminateur`) REFERENCES `parrain` (`idparrain`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_convention_parrain_idparrain` FOREIGN KEY (`idparrain`) REFERENCES `parrain` (`idparrain`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_convention_soutenances_idsoutenance` FOREIGN KEY (`idsoutenance`) REFERENCES `soutenances` (`idsoutenance`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_convention_theme_destage_idtheme` FOREIGN KEY (`idtheme`) REFERENCES `theme_destage` (`idtheme`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `convocation`
--
ALTER TABLE `convocation`
  ADD CONSTRAINT `fk_convocation_soutenances_idsoutenance` FOREIGN KEY (`idsoutenance`) REFERENCES `soutenances` (`idsoutenance`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `entreprise`
--
ALTER TABLE `entreprise`
  ADD CONSTRAINT `fk_entreprise_type_entreprise_idtypeentreprise` FOREIGN KEY (`idtypeentreprise`) REFERENCES `type_entreprise` (`idtypeentreprise`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `filiere`
--
ALTER TABLE `filiere`
  ADD CONSTRAINT `fk_filiere_filire_idfiliere` FOREIGN KEY (`idfilieresuivante`) REFERENCES `filiere` (`idfiliere`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `offredalternance`
--
ALTER TABLE `offredalternance`
  ADD CONSTRAINT `fk_offredalternance_contact_idcontact` FOREIGN KEY (`idcontact`) REFERENCES `contact` (`idcontact`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `offredestage`
--
ALTER TABLE `offredestage`
  ADD CONSTRAINT `fk_offredestage_contact_idcontact` FOREIGN KEY (`idcontact`) REFERENCES `contact` (`idcontact`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `parrain`
--
ALTER TABLE `parrain`
  ADD CONSTRAINT `fk_parrain_couleur_idcouleur` FOREIGN KEY (`idcouleur`) REFERENCES `couleur` (`idcouleur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `profilsouhaite_offredalternance`
--
ALTER TABLE `profilsouhaite_offredalternance`
  ADD CONSTRAINT `fk_profilsouhaite_offredalternance_filiere_idfiliere` FOREIGN KEY (`idfiliere`) REFERENCES `filiere` (`idfiliere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_profilsouhaite_offredalternance_idoffre` FOREIGN KEY (`idoffre`) REFERENCES `offredalternance` (`idoffre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profilsouhaite_offredestage`
--
ALTER TABLE `profilsouhaite_offredestage`
  ADD CONSTRAINT `fk_profilsouhaite_offredestage_filiere_idfiliere` FOREIGN KEY (`idfiliere`) REFERENCES `filiere` (`idfiliere`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_profilsouhaite_offredestage_idoffre` FOREIGN KEY (`idoffre`) REFERENCES `offredestage` (`idoffre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promotion`
--
ALTER TABLE `promotion`
  ADD CONSTRAINT `fk_promotion_filiere_idfiliere` FOREIGN KEY (`idfiliere`) REFERENCES `filiere` (`idfiliere`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_promotion_parcours_idparcours` FOREIGN KEY (`idparcours`) REFERENCES `parcours` (`idparcours`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `relation_competence_offredalternance`
--
ALTER TABLE `relation_competence_offredalternance`
  ADD CONSTRAINT `fk_relation_c_oa_competence_idcompetence` FOREIGN KEY (`idcompetence`) REFERENCES `competence` (`idcompetence`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relation_c_oa_offredalternance_idoffre` FOREIGN KEY (`idoffre`) REFERENCES `offredalternance` (`idoffre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `relation_competence_offredestage`
--
ALTER TABLE `relation_competence_offredestage`
  ADD CONSTRAINT `fk_relation_c_o_competence_idcompetence` FOREIGN KEY (`idcompetence`) REFERENCES `competence` (`idcompetence`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relation_c_o_offredestage_idoffre` FOREIGN KEY (`idoffre`) REFERENCES `offredestage` (`idoffre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `relation_promotion_datesoutenance`
--
ALTER TABLE `relation_promotion_datesoutenance`
  ADD CONSTRAINT `fk_relation_p_d_datesoutenance_iddatesoutenance` FOREIGN KEY (`iddatesoutenance`) REFERENCES `datesoutenance` (`iddatesoutenance`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relation_p_d_promotion_idpromotion` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `relation_promotion_etudiant_contrat`
--
ALTER TABLE `relation_promotion_etudiant_contrat`
  ADD CONSTRAINT `fk_relation_p_e_ctr_contrat_idcontrat` FOREIGN KEY (`idcontrat`) REFERENCES `contrat` (`idcontrat`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relation_p_e_ctr_etudiant_idetudiant` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relation_p_e_ctr_promotion_idpromotion` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `relation_promotion_etudiant_convention`
--
ALTER TABLE `relation_promotion_etudiant_convention`
  ADD CONSTRAINT `fk_relation_p_e_c_convention_idconvention` FOREIGN KEY (`idconvention`) REFERENCES `convention` (`idconvention`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relation_p_e_c_etudiant_idetudiant` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relation_p_e_c_promotion_idpromotion` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `relation_promotion_offredalternance`
--
ALTER TABLE `relation_promotion_offredalternance`
  ADD CONSTRAINT `fk_relation_p_oa_offredalternance_idoffre` FOREIGN KEY (`idoffre`) REFERENCES `offredalternance` (`idoffre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relation_p_oa_promotion_idpromotion` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `relation_promotion_offredestage`
--
ALTER TABLE `relation_promotion_offredestage`
  ADD CONSTRAINT `fk_relation_p_os_offredestage_idoffre` FOREIGN KEY (`idoffre`) REFERENCES `offredestage` (`idoffre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_relation_p_os_promotion_idpromotion` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soutenances`
--
ALTER TABLE `soutenances`
  ADD CONSTRAINT `fk_soutenances_datesoutenance_iddatesoutenance` FOREIGN KEY (`iddatesoutenance`) REFERENCES `datesoutenance` (`iddatesoutenance`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_soutenances_salle_soutenance_idsalle` FOREIGN KEY (`idsalle`) REFERENCES `salle_soutenance` (`idsalle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sujetdalternance`
--
ALTER TABLE `sujetdalternance`
  ADD CONSTRAINT `fk_sujetdalternance_etudiant_idetudiant` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sujetdalternance_promotion_idpromotion` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sujetdestage`
--
ALTER TABLE `sujetdestage`
  ADD CONSTRAINT `fk_sujetdestage_etudiant_idetudiant` FOREIGN KEY (`idetudiant`) REFERENCES `etudiant` (`idetudiant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sujetdestage_promotion_idpromotion` FOREIGN KEY (`idpromotion`) REFERENCES `promotion` (`idpromotion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `theme_destage`
--
ALTER TABLE `theme_destage`
  ADD CONSTRAINT `fk_theme_destage_couleur_idcouleur` FOREIGN KEY (`idcouleur`) REFERENCES `couleur` (`idcouleur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `theme_offredalternance`
--
ALTER TABLE `theme_offredalternance`
  ADD CONSTRAINT `fk_theme_offredalternance_idoffre` FOREIGN KEY (`idoffre`) REFERENCES `offredalternance` (`idoffre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_theme_offredalternance_parcours_idparcours` FOREIGN KEY (`idparcours`) REFERENCES `parcours` (`idparcours`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `theme_offredestage`
--
ALTER TABLE `theme_offredestage`
  ADD CONSTRAINT `fk_theme_offredestage_idoffre` FOREIGN KEY (`idoffre`) REFERENCES `offredestage` (`idoffre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_theme_offredestage_parcours_idparcours` FOREIGN KEY (`idparcours`) REFERENCES `parcours` (`idparcours`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `type_entreprise`
--
ALTER TABLE `type_entreprise`
  ADD CONSTRAINT `fk_type_entreprise_couleur_idcouleur` FOREIGN KEY (`idcouleur`) REFERENCES `couleur` (`idcouleur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
