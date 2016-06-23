<?php

// Connexion et sélection de la base
$db = new mysqli('localhost','','', 'stages');

if ($db->connect_errno) {
    echo "Echec lors de connexion (" . $db->connect_errno . ") " . $db->connect_error;
}

// Indique que la base est codée en UTF-8
mysqli_set_charset($db, "utf8");

?>