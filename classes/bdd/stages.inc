<?php

// Connexion à la base
$db = mysql_connect('localhost:8889','','') or die("Impossible de se connecter : " . mysql_error());

// Sélection de la base
mysql_select_db('stages', $db) or die("Impossible de trouver la base : " . mysql_error());;

?>