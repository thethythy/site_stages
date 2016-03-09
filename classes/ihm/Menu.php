<?php
header ('Content-type:text/html; charset=utf-8');
class Menu {

	public static function menuAccueil() {
		?>
			<div id="sidebar">
				<h1>Accueil</h1>
				<br/>
				<ul class="sidemenu">
					<li><a href="./presentation/" title="Pr�sentation d�taill�e">Pr�sentation</a></li>
					<br></br>
					<li><a href="./stagiaire/" title="Zone d'acc�s aux outils pour les �tudiants">Stagiaire</a></li>
					<br></br>
					<li><a href="./parrainage/" title="Informations sur les enseignants r�f�rents">Enseignants r�f�rents</a></li>
					<br></br>
					<li><a href="./entreprise/" title="Partie r�serv�e aux entreprises pour saisir les offres de stage">D�poser une offre de stage</a></li>
					<br></br>
					<li><a href="./soutenances/" title="Planning des soutenances">Soutenances</a></li>
					<br></br>
					<li><a href="./telechargements/" title="Zone de documents t�l�chargeables">T�l�chargement</a></li>
				</ul>
			</div>
		  	<div id="main">
		<?php
	}

	public static function menuPresentation() {
		?>
			<div id="sidebar">
				<li><a href="#1">1. Pr�sentation</a></li>
				<li><a href="#11">1.1. Contenu du stage</a></li>
				<li><a href="#12">1.2. Planification et dur�e</a></li>
				<li><a href="#13">1.3. Remarques et conseils</a></li>
				<li><a href="#2">2. D�roulement du stage</a></li>
				<li><a href="#21">2.1. La recherche d'un stage</a></li>
				<li><a href="#22">2.2. Le suivi du stagiaire</a></li>
				<li><a href="#221">2.2.1. R�le du r�f�rent</a></li>
				<li><a href="#222">2.2.2. Choix du r�f�rent</a></li>
				<li><a href="#23">2.3. Les conventions de stage</a></li>
				<li><a href="#24">2.4. Pendant le stage</a></li>
				<li><a href="#25">2.5. Le rapport de stage</a></li>
				<li><a href="#26">2.6. R�sum� de la proc�dure</a></li>
				<li><a href="#3">3. La soutenance</a></li>
				<li><a href="#4">4. L'�valuation du stage</a></li>
				<br/>
			</div>
		  	<div id="main">
		<?php
	}

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
					<li><a href="./depot_doc.php">3-D�poser des documents</a></li>
					<br></br>
					<li>Site externes d'offres:</li>
					<ul class="sidemenu2">
						<li><a href="http://www.ca-recrute-en.sarthe.com/index.asp" title="ca-recrute-en-sarthe.com">�a recrute en Sarthe</a></li>
						<li><a href="http://offres.monster.fr" title="monster.fr">monster.fr</a></li>
						<li><a href="http://www.lerucher.com/" title="Le Rucher">Le Rucher</a></li>
						<li><a href="http://www.letudiant.fr" title="L'&Eacute;tudiant">L'&Eacute;tudiant</a></li>
						<li><a href="http://www.stage.fr" title="Stage.fr">Stage.fr</a></li>
						<li><a href="http://www.capcampus.com/" title="Capcampus">Capcampus</a></li>
						<li><a href="http://www.kapstages.com/" title="Kap'stages">Kap'stages</a></li>
						<li><a href="http://www.ofqj.org/" alt="Office Franco Qu�b�cois pour la Jeunesse" title="Office Franco Qu�b�cois pour la Jeunesse">OFQJ</a></li>
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

	public static function menuParrainage() {
		?>
			<div id="sidebar">
				<ul class="sidemenu">
					<li><a href="./listerParrainages.php">Charge des r�f�rents</a></li>
					<br></br>
					<li><a href="./bilanParrainages.php">Bilan des r�f�rents</a></li>
					<br></br>
				</ul>
			</div>
		  	<div id="main">
		<?php
   	}

	public static function menuSoutenance() {
	    ?>
		<div id="sidebar">
		    <ul class="sidemenu">
	            <li><a href="./index.php">P�riode des soutenances</a></li>
				<br></br>
		        <li><a href="./planning_salles.php">Planning par salle</a></li>
		        <br></br>
		        <li><a href="./planning_filieres.php">Planning par dipl�me</a></li>
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