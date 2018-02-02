<?php

/**
 * Classe FluxRSS : flux des offres de stage du site
 */

class FluxRSS {

    /**
     * Ouverture du fichier XML contenant le flux RSS
     * @return DOMDocument
     */
    public static function openFluxXML() {
	// Ouverture du fichier
	$file = new DOMDocument();
	$file->load("../../flux/fluxrss.xml");
	// On retourne le fichier
	return $file;
    }

    /**
     * Crétion du fichier de flux initial vide (à exécuter une seule fois)
     * @global string $baseSite
     * @return DOMDocument
     */
    public static function createXML() {
	global $baseSite;

	// Création du fichier en mémoire
	$file = new DOMDocument('1.0', 'UTF-8');
	$file->formatOutput = true;

	// Création du noeud racine
	$root = $file->createElement("rss"); // On crée l'élément racine
	$root->setAttribute("version", "2.0"); // On lui ajoute l'attribut version (2.0)
	$root->setAttribute("xmlns:atom", "http://www.w3.org/2005/Atom"); // On lui ajoute l'attribue xmlns:atom
	$root = $file->appendChild($root); // On insère la racine dans le document

	// Création du noeud channel
	$element_channel = $file->createElement("channel"); // On crée un �élément channel
	$element_channel->setAttribute("xml:id", "news"); // On donne un attribut id à notre channel
	$element_channel = $root->appendChild($element_channel); // On ajoute cet élément à la racine

	// Création du lien atom:link
	$element_atom = $file->createElement("atom:link"); // On crée un élément atom:link
	$element_atom->setAttribute("href", $baseSite . "flux/fluxrss.xml");
	$element_atom->setAttribute("rel", "self");
	$element_atom->setAttribute("type", "application/rss+xml");
	$element_atom = $element_channel->appendChild($element_atom);

	// Création du lien language
	$element_language = $file->createElement("language");
	$element_language = $element_channel->appendChild($element_language);
	$texte_language = $file->createTextNode("fr-FR");
	$texte_language = $element_language->appendChild($texte_language);

	// Création du noeud description
	$element_description = $file->createElement("description"); // On crée un élément description
	$element_description = $element_channel->appendChild($element_description); // On ajoute cet élément au channel
	$texte = "Ce flux RSS donne les nouvelles offres de stage pour les étudiants du Département Informatique de l'Université du Maine";
	$texte_description = $file->createTextNode($texte); // On crée un texte
	$texte_description = $element_description->appendChild($texte_description); // On insère ce texte dans le noeud description

	// Création du noeud link et ajout du texte à l'élément
	$element_link = $file->createElement("link");
	$element_link = $element_channel->appendChild($element_link);
	$texte_link = $file->createTextNode($baseSite);
	$texte_link = $element_link->appendChild($texte_link);

	// Création du noeud title et ajout du texte à l'élément
	$element_title = $file->createElement("title");
	$element_title = $element_channel->appendChild($element_title);
	$texte_title = $file->createTextNode("Offres de stage en informatique");
	$texte_title = $element_title->appendChild($texte_title);

	//On retourne le fichier XML
	return $file;
    }

    /**
     * Ajout d'un élément dans le flux
     * @param DOMDocument $file
     * @param string $title
     * @param string $link
     * @param unix time $timestamp
     * @param string $author
     * @param string $contents
     */
    public static function addOneNews($file, $title, $link, $timestamp, $author, $contents) {
	$file->formatOutput = true;

	// On récupère le channel
	$element_channel = $file->getElementById("news");

	// Création du noeud item
	$element_item = $file->createElement("item");
	$element_item = $element_channel->appendChild($element_item);

	// Création du noeud title et ajout du texte
	$element_title = $file->createElement("title");
	$element_title = $element_item->appendChild($element_title);
	$texte_title = $file->createTextNode($title);
	$texte_title = $element_title->appendChild($texte_title);

	// Création du noeud link et ajout du texte à l'élément
	$element_link = $file->createElement("link");
	$element_link = $element_item->appendChild($element_link);
	$texte_link = $file->createTextNode($link);
	$texte_link = $element_link->appendChild($texte_link);

	// Création du noeud guid et ajout du texte à l'élément
	$element_guid = $file->createElement("guid");
	$element_guid = $element_item->appendChild($element_guid);
	$texte_guid = $file->createTextNode($link);
	$texte_guid = $element_guid->appendChild($texte_guid);

	// Création du noeud pubDate et ajout du texte à l'élément
	$element_date = $file->createElement("pubDate");
	$element_date = $element_item->appendChild($element_date);
	$texte_date = $file->createTextNode(date(DATE_RSS, $timestamp));
	$texte_date = $element_date->appendChild($texte_date);

	// Céation du noeud author et ajout du texte à l'élément
	$element_author = $file->createElement("author");
	$element_author = $element_item->appendChild($element_author);
	$texte_author = $file->createTextNode($author);
	$texte_author = $element_author->appendChild($texte_author);

	// Céation du noeud description et ajout du texte à l'élément
	$element_description = $file->createElement("description");
	$element_descrption = $element_item->appendChild($element_description);
	$texte_description = $file->createTextNode($contents);
	$texte_description = $element_description->appendChild($texte_description);
    }

    /**
     * Sauvegarde du fichier XML contenant le flux
     * @param DOMDocument $file
     */
    public static function saveFluxXML($file) {
	$file->save("../../flux/fluxrss.xml");
    }

    /**
     * Suppression du fichier XML contenant le flux et suppression du contenu de la base
     * @global resource $db Une référence sur la base de donnée ouverte
     * @return boolean
     */
    public static function deleteFlux() {
	global $db;
	if (@unlink("../../flux/fluxrss.xml")) {
	    return $db->query("TRUNCATE TABLE fluxrss");
	}
	return false;
    }

    /**
     * Test si le fichier XML contenant le flux RSS existe déjà
     * @return boolean
     */
    public static function existe() {
	return file_exists("../../flux/fluxrss.xml");
    }

    /**
     * Initialisation du flux (à exécuter une seule fois)
     * @global resource $db Une référence sur la base de donnée ouverte
     */
    public static function initialise() {
	global $db;
	// Création du fichier XML
	$file = FluxRSS::createXML();

	// Ajout des news déjà existantes dans la base
	$query_news = $db->query("SELECT * FROM fluxrss") or die();
	while ($data_news = mysqli_fetch_array($query_news)) {
	    FluxRSS::addOneNews($file, $data_news['title'], $data_news['link'],
		    $data_news['timestamp'], $data_news['author'], $data_news['contents']);
	}

	// Sauvegarde du fichier XML
	FluxRSS::saveFluxXML($file);
    }

    /**
     * Mise à jour du flux
     * @global resource $db Une référence sur la base de donnée ouverte
     * @param string $title
     * @param string $link
     * @param unix time $timestamp
     * @param string $contents
     * @param string $author
     */
    public static function miseAJour($title, $link, $timestamp, $contents, $author) {
	global $db;
	// Ajout de la news dans la base de données
	$db->query("INSERT INTO fluxrss (title, link, timestamp, contents, author)
		    VALUES ('" . $title . "','" . $link . "','" . $timestamp . "','" . $contents . "','" . $author . "')")
		or die();

	// Ouverture du fichier
	$file = FluxRSS::openFluxXML();

	// Ajout de la news dans le fichier
	FluxRSS::addOneNews($file, $title, $link, $timestamp, $author, $contents);

	// Sauvegarde du fichier XML
	FluxRSS::saveFluxXML($file);
    }

}

?>