<?php

/**
* Classe Utils : une classe utilitaire regroupant des méthodes disparates
* dont certaines sont spécifiques au lieu géographique de déploiement du site
*/

//ini_set('display_errors', 'off');

class Utils {

  /**
  * Fonction pour auto-charger les classes depuis la racine
  * @param string $name
  */
  public static function my_autoloader_from_root($name) {
    if (strpos($name, 'IHM') !== FALSE) {
      include_once("./classes/ihm/$name.php");
    } elseif (strpos($name, 'BDD') !== FALSE) {
      include_once("./classes/bdd/$name.php");
    } else {
      include_once("./classes/moteur/$name.php");
    }
  }

  /**
  * Fonction pour auto-charger les classes depuis le niveau 1
  * @param string $name
  */
  public static function my_autoloader_from_level1($name) {
    if (strpos($name, 'IHM') !== FALSE) {
      include_once("../classes/ihm/$name.php");
    } elseif (strpos($name, 'BDD') !== FALSE) {
      include_once("../classes/bdd/$name.php");
    } else {
      include_once("../classes/moteur/$name.php");
    }
  }

  /**
  * Fonction pour auto-charger les classes depuis le niveau 2
  * @param string $name
  */
  public static function my_autoloader_from_level2($name) {
    if (strpos($name, 'IHM') !== FALSE) {
      include_once("../../classes/ihm/$name.php");
    } elseif (strpos($name, 'BDD') !== FALSE) {
      include_once("../../classes/bdd/$name.php");
    } else {
      include_once("../../classes/moteur/$name.php");
    }
  }

  /**
  * Fonction pour auto-charger les classes depuis le niveau 3
  * @param string $name
  */
  public static function my_autoloader_from_level3($name) {
    if (strpos($name, 'IHM') !== FALSE) {
      include_once("../../../classes/ihm/$name.php");
    } elseif (strpos($name, 'BDD') !== FALSE) {
      include_once("../../../classes/bdd/$name.php");
    } else {
      include_once("../../../classes/moteur/$name.php");
    }
  }

  /**
  * Test si une valeur est une adresse de couriel valide
  * @param string $adresse
  * @return boolean
  */
  public static function VerifierAdresseMail($adresse) {
    $SyntaxeEmail = '/^[\w\.\-]+@[\w.-]+\.[a-zA-Z]{2,6}$/';
    if (preg_match($SyntaxeEmail, $adresse))
    return true;
    else
    return false;
  }

  /**
  * Remplace les caractères accentués par leurs équivalents sans accents
  * ainsi que les espaces par des underscores
  * @param string $string
  * @return string
  */
  public static function removeaccents($string) {
    return strtr($string, array('À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A' ,'Å' => 'A',
    'Ç' => 'C',
    'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
    'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
    'Ñ' => 'N',
    'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
    'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
    'Ý' => 'Y',
    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
    'ç' =>  'c',
    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
    'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
    'ñ' => 'n',
    'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
    'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
    'ý' => 'y', 'ÿ' => 'y',
    'Æ' => 'AE', 'æ' => 'ae',
    'µ' => 'u',
    ' ' => '_'));
  }

  /**
  * Fonction de recherche d'un étudiant dans le ldap de l'ic2
  * @param string $nom
  * @param prénom $prenom
  * @param boolean $affiche Indicteur pour afficher ou pas si la recherche est un succès
  * @return string L'email (si pas trouvée chaine vide)
  */
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

  /**
  * Convertir un numéro de mois en toute lettre
  * @param integer $num
  * @return string
  */
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

  /**
  * Retourne la liste des lieux des stages
  * @return tableau de chaine
  */
  public static function getLieuxStage() {
    return array('Le Mans', 'Sarthe', 'Pays de la Loire', 'France', 'Etranger');
  }

  /**
  * Retourne le lieu selon les informations données
  * @param entier $codepostal
  * @param chaine $ville
  * @param chaine $pays
  * @return string Le lieu du stage
  */
  public static function getLieuDuStage($codepostal, $ville, $pays) {
    $laville = strtolower($ville);
    $lepays = strtolower($pays);
    $ledep = 0;

    if (strlen($codepostal) == 5)
    $ledep = $codepostal[0] . $codepostal[1];

    $deps = array("53", "85", "49", "44");

    if (strstr($laville, "le mans") && ($ledep == "72" || $codepostal == "72000" || $codepostal == "72100") && strstr($lepays, "france")) {
      return 'Le Mans';
    } else if ($ledep == "72" && strstr($lepays, "france") && ($codepostal != "72000" || $codepostal != "72100")) {
      return 'Sarthe';
    } else if (in_array($ledep, $deps) && strstr($lepays, "france")) {
      return 'Pays de la Loire';
    } else if (strstr($lepays, "france")) {
      return 'France';
    } else {
      return 'Etranger';
    }
  }

  /**
  * Crée et écris dans un fichier log.txt le message passé en paramètre
  * @param chaine $string
  */
  public static function printLog($string){
    $log = fopen("log.txt", "a+");
    fwrite($log, "\n".$string);
    fclose($log);
  }

}

?>
