<?php

class Utils {

    /** Methodes statiques * */
    public static function VerifierAdresseMail($adresse) {
	$SyntaxeEmail = '/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/';
	if (preg_match($SyntaxeEmail, $adresse))
	    return true;
	else
	    return false;
    }

    // Fonction qui enlève les caractères accentués
    public static function removeaccents($string) {
	return strtr(
		strtr($string, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿ',
			       'AAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy'),
		array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss',
	    '' => 'OE', '' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u', ' ' => '_'));
    }

    // Fonction de recherche d'un étudiant dans le ldap de l'ic2
    // Arguments : un nom et un prénom
    // Retour : l'email (si pas trouvée chaine vide)
    // DMAJ 21/03/06
    public static function search_ldap($nom, $prenom, $affiche) {
	// Mise en forme avant la recherche
	// Remplace les caractères bizarres par des soulignés
	$nom = str_replace(" ", "_", $nom);
	$prenom = str_replace(" ", "_", $prenom);
	$nom = str_replace("'", "_", $nom);
	$prenom = str_replace("'", "_", $prenom);

	// Enlève les accents
	$nom = Utils::removeaccents($nom);
	$prenom = Utils::removeaccents($prenom);

	// Connection au serveur LDAP
	$ds = ldap_connect("ldapic2.univ-lemans.fr", 389) or die("Could not connect to LDAPIC2 Server");

	if ($r = ldap_bind($ds)) {

	    // Recherche dans le LDAP
	    $sr = ldap_search($ds, "ou=people,dc=info,dc=univ-lemans,dc=fr", "(&(cn=$nom*)(cn=*$prenom))", array("mail", "cn"));

	    //echo "<br>Recherche de $nom $prenom <br>";
	    // Extraction des données
	    $info = ldap_get_entries($ds, $sr);

	    // Si il y a une réponse
	    if ($info["count"] >= 1) {
		$mail = $info[0]["mail"][0];
		if ($affiche == true)
		    echo "<br>Adresse institutionnelle trouvé : $mail <br>";
	    }
	}

	ldap_close($ds);

	return $mail;
    }

    public static function numToMois($num) {
	switch ($num) {
	    case 1 : $mois = "janvier";
		break;
	    case 2 : $mois = "février";
		break;
	    case 3 : $mois = "mars";
		break;
	    case 4 : $mois = "avril";
		break;
	    case 5 : $mois = "mai";
		break;
	    case 6 : $mois = "juin";
		break;
	    case 7 : $mois = "juillet";
		break;
	    case 8 : $mois = "août";
		break;
	    case 9 : $mois = "septembre";
		break;
	    case 10 : $mois = "octobre";
		break;
	    case 11 : $mois = "novembre";
		break;
	    case 12 : $mois = "décembre";
		break;
	    default : $mois = "error";
	}
	return $mois;
    }

}

?>