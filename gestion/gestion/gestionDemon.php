<?php

class GestionDemon {

    /* Lancer le d�mon */

    public function go() {
	// Lancement si pas d�j� lanc�
	if (!file_exists('/tmp/RUN_CRON_SITE_STAGE')) {
	    /* Cr�ation du service cron */
	    $this->lancerServiceCron('*', '*', '*', '*', '*', '/usr/bin/php -f /Applications/MAMP/htdocs/gestion/gestion/demonTache.php > /dev/null 2>&1');

	    /* Cr�ation du fichier t�moin */
	    fclose(fopen('/tmp/RUN_CRON_SITE_STAGE', 'w'));
	}
    }

    /* Arr�ter le d�mon */

    public function stop() {
	// Rafra�chir au bout de 60 secondes
	if (!headers_sent())
	    header("Refresh:60");

	// Demande un arr�t
	if (file_exists('/tmp/RUN_CRON_SITE_STAGE')) {
	    /* Suppression du fichier t�moin */
	    unlink('/tmp/RUN_CRON_SITE_STAGE');
	    /* Arr�t du service cron */
	    $this->arretServiceCron();
	}
    }

    /* Test si le d�mon est en fonctionnement */

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

    /* Cr�ation d'une nouvelle crontab */

    private function lancerServiceCron($chpMinute, $chpHeure, $chpJourMois, $chpMois, $chpJourSemaine, $chpCommande) {

	$newCrontab = Array(); /* pour chaque cellule une ligne du nouveau crontab */
	$newCrontab[] = $chpMinute . ' ' . $chpHeure . ' ' . $chpJourMois . ' ' . $chpMois . ' ' . $chpJourSemaine . ' ' . $chpCommande;

	$f = fopen('/tmp/tmpcrontab', 'w'); /* on cr�e un fichier temporaire */
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
