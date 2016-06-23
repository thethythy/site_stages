<?php

class GestionDemon {

    /* Lancer le démon */

    public function go() {
	// Lancement si pas déjà lancé
	if (!file_exists('/tmp/RUN_CRON_SITE_STAGE')) {
	    /* Création du service cron */
	    $this->lancerServiceCron('*', '*', '*', '*', '*', '/usr/bin/php -f /Users/lemeunie/git-repository/site_stages/gestion/gestion/demonTache.php > /dev/null 2>&1');

	    /* Création du fichier témoin */
	    fclose(fopen('/tmp/RUN_CRON_SITE_STAGE', 'w'));
	}
    }

    /* Arrêter le démon */

    public function stop() {
	// Rafraîchir au bout de 60 secondes
	if (!headers_sent())
	    header("Refresh:60");

	// Demande un arrêt
	if (file_exists('/tmp/RUN_CRON_SITE_STAGE')) {
	    /* Suppression du fichier témoin */
	    unlink('/tmp/RUN_CRON_SITE_STAGE');
	    /* Arrêt du service cron */
	    $this->arretServiceCron();
	}
    }

    /* Test si le démon est en fonctionnement */

    public function test() {
	$valeur = -1;

	if (file_exists("/tmp/RUN_CRON_SITE_STAGE")) {
	    $today = date("j");
	    $timeLastModified = filemtime("/tmp/RUN_CRON_SITE_STAGE");
	    $unJour = 60 * 60 * 24;
	    if ($today == date("j", $timeLastModified) || $today == date("j", $timeLastModified + $unJour))
		$valeur = 1;
	    else
		$valeur = 0;
	}

	return $valeur;
    }

    /* Création d'une nouvelle crontab */

    private function lancerServiceCron($chpMinute, $chpHeure, $chpJourMois, $chpMois, $chpJourSemaine, $chpCommande) {

	$newCrontab = Array(); /* pour chaque cellule une ligne du nouveau crontab */
	$newCrontab[] = $chpMinute . ' ' . $chpHeure . ' ' . $chpJourMois . ' ' . $chpMois . ' ' . $chpJourSemaine . ' ' . $chpCommande;

	$f = fopen('/tmp/tmpcrontab', 'w'); /* on crée un fichier temporaire */
	fwrite($f, implode(CHR(0x0A), $newCrontab));
	fclose($f);

	exec('crontab /tmp/tmpcrontab'); /* on le soumet comme crontab */
    }

    /* Vider la crontab */

    private function arretServiceCron() {
	exec('crontab -r');
    }

}

?>
