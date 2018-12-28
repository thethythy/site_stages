<?php

// Connexion et sélection de la base
$db = new mysqli('localhost','root','', 'stages');

if ($db->connect_errno) {
    echo "Echec lors de connexion (" . $db->connect_errno . ") " . $db->connect_error;
}

// Indique que la base est codée en UTF-8
$db->set_charset("utf8");

?>
