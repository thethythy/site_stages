<?php

class IHM_Menu {

  /**
  * Afficher le menu de la page d'accueil du site
  */
  public static function menuAccueil() {
    ?>
    <div id="sidebar">
      <h1>Accueil</h1>
      <br/>
      <ul class="sidemenu">
        <li><a href="./presentation/" title="Présentation détaillée">Présentation</a></li>
        <br></br>
        <li><a href="./stagiaire/" title="Zone d'accès aux outils pour les étudiants">Stagiaire<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
        <br></br>
        <li><a href="./alternant/" title="Zone d'accès aux outils pour les étudiants">Alternant<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
        <br></br>
        <li><a href="./parrainage/" title="Informations sur les enseignants référents">Enseignants référents<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
        <br></br>
        <li><a href="./entreprise/" title="Partie réservée aux entreprises pour saisir les offres de stage">Déposer une offre</a></li>
        <br></br>
        <li><a href="./soutenances/" title="Planning des soutenances">Soutenances<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
        <br></br>
        <li><a href="./telechargements/" title="Zone de documents téléchargeables">Téléchargement<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
      </ul>
    </div>
    <div id="main">
      <?php
    }

    /**
    * Afficher le menu de la page d'accueil du site
    */
    public static function menuAccueilAccessControl() {
      ?>
      <div id="sidebar">
        <h1>Accueil</h1>
        <br/>
        <ul class="sidemenu">
          <li><a>Présentation</a></li>
          <br></br>
          <li><a>Stagiaire<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
          <br></br>
          <li><a>Alternant<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
          <br></br>
          <li><a>Enseignants référents<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
          <br></br>
          <li><a>Déposer une offre de stage</a></li>
          <br></br>
          <li><a>Soutenances<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
          <br></br>
          <li><a>Téléchargement<img src='/images/cadenas.png' width="10" height="12" align="absbottom"/></a></li>
        </ul>
      </div>
      <div id="main">
        <?php
      }

      /**
      * Afficher le menu de la page présentation
      */
      public static function menuPresentation() {
        ?>
        <div id="sidebar">
          <a href="#1">1. Présentation</a><br/>
          <a href="#11">1.1. Contenu du stage</a><br/>
          <a href="#12">1.2. Planification et durée</a><br/>
          <a href="#13">1.3. Remarques et conseils</a><br/>
          <a href="#2">2. Déroulement du stage</a><br/>
          <a href="#21">2.1. La recherche d'un stage</a><br/>
          <a href="#22">2.2. Le suivi du stagiaire</a><br/>
          <a href="#221">2.2.1. Rôle du référent</a><br/>
          <a href="#222">2.2.2. Choix du référent</a><br/>
          <a href="#23">2.3. Les conventions de stage</a><br/>
          <a href="#24">2.4. Pendant le stage</a><br/>
          <a href="#25">2.5. Le rapport de stage</a><br/>
          <a href="#26">2.6. Résumé de la procédure</a><br/>
          <a href="#3">3. La soutenance</a><br/>
          <a href="#4">4. L'évaluation du stage</a><br/>
          <br/>
        </div>
        <div id="main">
          <?php
        }

        /*
        * Afficher le menu de la page dédiée aux étudiants
        */
        public static function menuStagiaire() {
          ?>
          <div id="sidebar">
            <ul class="sidemenu">
              <li><a>1-Rechercher</a></li>
              <ul class="sidemenu2">
                <li><a href="./listerOffreDeStage.php">Offres de stages</a></li>
                <li><a href="./listerAnciensStages.php">Les anciens stages</a></li>
              </ul>
              <li><a href="./demanderValidationSDS.php">2-Valider le sujet de stage</a></li>
              <br/>
              <li><a href="./depot_doc.php">3-Déposer des documents</a></li>
              <br></br>
              <li>Site externes d'offres:</li>
              <ul class="sidemenu2">
                <li><a href="http://univ-lemans.jobteaser.com/" title="Career Center">Career Center</a></li>
                <li><a href="http://offres.monster.fr" title="monster.fr">monster.fr</a></li>
                <li><a href="http://www.lerucher.com/" title="Le Rucher">Le Rucher</a></li>
                <li><a href="http://www.letudiant.fr" title="L'&Eacute;tudiant">L'&Eacute;tudiant</a></li>
                <li><a href="http://www.stage.fr" title="Stage.fr">Stage.fr</a></li>
                <li><a href="http://www.capcampus.com/" title="Capcampus">Capcampus</a></li>
                <li><a href="http://www.kapstages.com/" title="Kap'stages">Kap'stages</a></li>
                <li><a href="http://www.ofqj.org/" alt="Office Franco Québécois pour la Jeunesse" title="Office Franco Québécois pour la Jeunesse">OFQJ</a></li>
                <li><a href="http://www.europlacement.fr" alt="stage, stages, volontaire, stagiaire, stagiaires" title="stages internationaux, internships, internship, stages et travaille volontaire internationaux" >Europlacement</a></li>
                <li><a href="http://www.iquesta.com/" alt="iquesta.com" title="iquesta.com">iquesta.com</a></li>
                <li><a href="http://remixjobs.com/" alt="remixjobs.com" title="Relix Jobs">Remix Jobs</a></li>
                <li><a href="http://neuvoo.fr/fr" alt="neuvoo.fr" title="neuvoo">Neuvoo</a></li>
              </ul>
            </ul>
          </div>
          <div id="main">
            <?php
          }



          public static function menuAlternant() {
            ?>
            <div id="sidebar">
              <ul class="sidemenu">
                <li><a>1-Rechercher</a></li>
                <ul class="sidemenu2">
                  <li><a href="./listerOffreAlternance.php">Offres de stages</a></li>
                  <li><a href="./listerAnciensContrats.php">Les anciens stages</a></li>
                </ul>
                <li><a href="./demanderValidationSDA.php">2-Valider le sujet de stage</a></li>
                <li><a href="./depot_doc.php">3-Déposer des documents</a></li>
                <li><a href="./suiviCandidatures.php">4-Suivi des candidatures</a></li>
                <br></br>
                <li>Site externes d'offres:</li>
                <ul class="sidemenu2">
                  <li><a href="http://univ-lemans.jobteaser.com/" title="Career Center">Career Center</a></li>
                  <li><a href="http://offres.monster.fr" title="monster.fr">monster.fr</a></li>
                  <li><a href="http://www.lerucher.com/" title="Le Rucher">Le Rucher</a></li>
                  <li><a href="http://www.letudiant.fr" title="L'&Eacute;tudiant">L'&Eacute;tudiant</a></li>
                  <li><a href="http://www.stage.fr" title="Stage.fr">Stage.fr</a></li>
                  <li><a href="http://www.capcampus.com/" title="Capcampus">Capcampus</a></li>
                  <li><a href="http://www.kapstages.com/" title="Kap'stages">Kap'stages</a></li>
                  <li><a href="http://www.ofqj.org/" alt="Office Franco Québécois pour la Jeunesse" title="Office Franco Québécois pour la Jeunesse">OFQJ</a></li>
                  <li><a href="http://www.europlacement.fr" alt="stage, stages, volontaire, stagiaire, stagiaires" title="stages internationaux, internships, internship, stages et travaille volontaire internationaux" >Europlacement</a></li>
                  <li><a href="http://www.iquesta.com/" alt="iquesta.com" title="iquesta.com">iquesta.com</a></li>
                  <li><a href="http://remixjobs.com/" alt="remixjobs.com" title="Relix Jobs">Remix Jobs</a></li>
                  <li><a href="http://neuvoo.fr/fr" alt="neuvoo.fr" title="neuvoo">Neuvoo</a></li>
                </ul>
              </ul>
            </div>
            <div id="main">
              <?php
            }

            /**
            * Afficher le menu de la page dédiée aux enseignants
            */
            public static function menuParrainage() {
              ?>
              <div id="sidebar">
                <ul class="sidemenu">
                  <li><a href="./listerParrainages.php">Charge des référents</a></li>
                  <br></br>
                  <li><a href="./bilanParrainages.php">Bilan des référents</a></li>
                  <br></br>
                </ul>
              </div>
              <div id="main">
                <?php
              }

              /**
              * Afficher le menu de la page dédiée aux soutenances
              */
              public static function menuSoutenance() {
                ?>
                <div id="sidebar">
                  <ul class="sidemenu">
                    <li><a href="./index.php">Période des soutenances</a></li>
                    <br></br>
                    <li><a href="./planning_salles.php">Planning par salle</a></li>
                    <br></br>
                    <li><a href="./planning_filieres.php">Planning par diplôme</a></li>
                    <br></br>
                    <li><a href="./planning_enseignants.php">Planning par enseignant</a></li>
                    <br></br>
                  </ul>
                </div>
                <div id="main">
                  <?php
                }

              }

              ?>
