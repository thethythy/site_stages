<?php

class Utils{

	/** Methodes statiques **/

	public static function VerifierAdresseMail($adresse){
	   $SyntaxeEmail='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
	   if(preg_match($SyntaxeEmail,$adresse))
	      return true;
	   else
	     return false;
	}


	// Fonction qui enl�ve les caract�res accentu�s
	public static function removeaccents($string){
	 return strtr(
	  strtr($string,
	   '������������������������������������������������������������',
	   'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy'),
	  array('�' => 'TH', '�' => 'th', '�' => 'DH', '�' => 'dh', '�' => 'ss',
	   '�' => 'OE', '�' => 'oe', '�' => 'AE', '�' => 'ae', '�' => 'u'));
	}

	// Fonction de recherche d'un �tudiant dans le ldap de l'ic2
	// Arguments : un nom et un pr�nom
	// Retour : l'email (si pas trouv�e chaine vide)
	// DMAJ 21/03/06
	public static function search_ldap($nom, $prenom, $affiche){
		// Mise en forme avant la recherche

		// Remplace les caract�res bizarres par des soulign�s
		$nom = str_replace(" ", "_", $nom);
		$prenom = str_replace(" ", "_", $prenom);
		$nom = str_replace("'", "_", $nom);
		$prenom = str_replace("'", "_", $prenom);

		// Enl�ve les accents
		$nom = Utils::removeaccents($nom);
		$prenom = Utils::removeaccents($prenom);

		// Connection au serveur LDAP
		$ds = ldap_connect("ldapic2.univ-lemans.fr", 389) or die("Could not connect to LDAPIC2 Server");

		if ($r = ldap_bind($ds)) {

			// Recherche dans le LDAP
			$sr = ldap_search($ds,"ou=people,dc=info,dc=univ-lemans,dc=fr","(&(cn=$nom*)(cn=*$prenom))", array("mail","cn"));

			//echo "<br>Recherche de $nom $prenom <br>";

			// Extraction des donn�es
			$info = ldap_get_entries($ds, $sr);

			// Si il y a une r�ponse
			if ($info["count"] >= 1) {
				$mail = $info[0]["mail"][0];
				if ($affiche == true) echo "<br>Adresse institutionnelle trouv� : $mail <br>";
			}
		}

		ldap_close($ds);

		return $mail;
	}

	public static function numToMois($num) {
		switch($num) {
			case 1 : $mois = "janvier"; break;
			case 2 : $mois = "f�vrier"; break;
			case 3 : $mois = "mars"; break;
			case 4 : $mois = "avril"; break;
			case 5 : $mois = "mai"; break;
			case 6 : $mois = "juin"; break;
			case 7 : $mois = "juillet"; break;
			case 8 : $mois = "ao�t"; break;
			case 9 : $mois = "septembre"; break;
			case 10 : $mois = "octobre"; break;
			case 11 : $mois = "novembre"; break;
			case 12 : $mois = "d�cembre"; break;
			default : $mois = "error";
		}
		return $mois;
	}

}

?>