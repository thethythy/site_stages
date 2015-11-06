<?php

class FluxRSS {

	// Ouverture du fichier XML contenant le flux RSS
	public static function openFluxXML() {
		// Ouverture du fichier
		$file = new DOMDocument();
		$file->load("../../flux/fluxrss.xml");
		// On retourne le fichier
		return $file;
	}

	// Cr�ation du fichier de flux initial vide (� ex�cuter une seule fois)
	public static function createXML() {
		global $baseSite;

		// Cr�ation du fichier en m�moire
		$file = new DOMDocument('1.0', 'UTF-8');
		$file->formatOutput = true;

		// Cr�ation du noeud racine
		$root = $file->createElement("rss"); // On cr�e l'�l�ment racine
		$root->setAttribute("version", "2.0"); // On lui ajoute l'attribut version (2.0)
		$root->setAttribute("xmlns:atom", "http://www.w3.org/2005/Atom"); // On lui ajoute l'attribue xmlns:atom
		$root = $file->appendChild($root); // On ins�re la racine dans le document

		// Cr�ation du noeud channel
		$element_channel = $file->createElement("channel"); // On cr�e un �l�ment channel
		$element_channel->setAttribute("xml:id", "news"); // On donne un attribut id � notre channel
		$element_channel = $root->appendChild($element_channel); // On ajoute cet �l�ment � la racine

		// Cr�ation du lien atom:link
		$element_atom = $file->createElement("atom:link"); // On cr�e un �l�ment atom:link
		$element_atom->setAttribute("href", $baseSite."flux/fluxrss.xml");
		$element_atom->setAttribute("rel", "self");
		$element_atom->setAttribute("type", "application/rss+xml");
		$element_atom = $element_channel->appendChild($element_atom);

		// Cr�ation du lien language
		$element_language = $file->createElement("language");
		$element_language = $element_channel->appendChild($element_language);
		$texte_language = $file->createTextNode("fr-FR");
		$texte_language = $element_language->appendChild($texte_language);

		// Cr�ation du noeud description
		$element_description = $file->createElement("description"); // On cr�e un �l�ment description
		$element_description = $element_channel->appendChild($element_description); // On ajoute cet �l�ment au channel
		$texte = utf8_encode("Ce flux RSS donne les nouvelles offres de stage pour les �tudiants du D�partement Informatique de l'Universit� du Maine");
		$texte_description = $file->createTextNode($texte); // On cr�e un texte
		$texte_description = $element_description->appendChild($texte_description); // On ins�re ce texte dans le noeud description

		// Cr�ation du noeud link et ajout du texte � l'�l�ment
		$element_link = $file->createElement("link");
		$element_link = $element_channel->appendChild($element_link);
		$texte_link = $file->createTextNode($baseSite);
		$texte_link = $element_link->appendChild($texte_link);

		// Cr�ation du noeud title et ajout du texte � l'�l�ment
		$element_title = $file->createElement("title");
		$element_title = $element_channel->appendChild($element_title);
		$texte_title = $file->createTextNode("Offres de stage en informatique");
		$texte_title = $element_title->appendChild($texte_title);

		//On retourne le fichier XML
		return $file;
	}

	// Ajout d'un �l�ment dans le flux
	public static function addOneNews($file, $title, $link, $timestamp, $author, $contents) {
		$file->formatOutput = true;

		// On r�cup�re le channel
		$element_channel = $file->getElementById("news");

		// Cr�ation du noeud item
		$element_item = $file->createElement("item");
		$element_item = $element_channel->appendChild($element_item);

		// Cr�ation du noeud title et ajout du texte � Cr�ation
		$element_title = $file->createElement("title");
		$element_title = $element_item->appendChild($element_title);
		$texte_title = $file->createTextNode(utf8_encode($title));
		$texte_title = $element_title->appendChild($texte_title);

		// Cr�ation du noeud link et ajout du texte � l'�l�ment
		$element_link = $file->createElement("link");
		$element_link = $element_item->appendChild($element_link);
		$texte_link = $file->createTextNode($link);
		$texte_link = $element_link->appendChild($texte_link);

		// Cr�ation du noeud guid et ajout du texte � l'�l�ment
		$element_guid = $file->createElement("guid");
		$element_guid = $element_item->appendChild($element_guid);
		$texte_guid = $file->createTextNode($link);
		$texte_guid = $element_guid->appendChild($texte_guid);

		// Cr�ation du noeud pubDate et ajout du texte � l'�l�ment
		$element_date = $file->createElement("pubDate");
		$element_date = $element_item->appendChild($element_date);
		$texte_date = $file->createTextNode(date(DATE_RSS,$timestamp));
		$texte_date = $element_date->appendChild($texte_date);

		// Cr�ation du noeud author et ajout du texte � l'�l�ment
		$element_author = $file->createElement("author");
		$element_author = $element_item->appendChild($element_author);
		$texte_author = $file->createTextNode($author);
		$texte_author = $element_author->appendChild($texte_author);

		// Cr�ation du noeud description et ajout du texte � l'�l�ment
		$element_description = $file->createElement("description");
		$element_descrption = $element_item->appendChild($element_description);
		$texte_description = $file->createTextNode(utf8_encode($contents));
		$texte_description = $element_description->appendChild($texte_description);
	}

	// Sauvegarde du fichier XML contenant le flux
	public static function saveFluxXML($file) {
		$file->save("../../flux/fluxrss.xml");
	}

	// Suppression du fichier XML contenant le flux et suppression du contenu de la base
	public static function deleteFlux() {
		if (@unlink("../../flux/fluxrss.xml")) {
			return mysql_query("TRUNCATE TABLE fluxrss");
		}
		return false;
	}

	// Test si le fichier XML contenant le flux RSS existe d�j�
	public static function existe() {
		return file_exists("../../flux/fluxrss.xml");
	}

	// Initialisation du flux (� ex�cuter une seule fois)
	public static function initialise() {
		// Cr�ation du fichier XML
		$file = FluxRSS::createXML();

		// Ajout des news d�j� existantes dans la base
		$query_news = mysql_query("SELECT * FROM fluxrss") or die();
		while ($data_news = mysql_fetch_array($query_news)) {
			FluxRSS::addOneNews($file, $data_news['title'], $data_news['link'], $data_news['timestamp'], $data_news['author'], $data_news['contents']);
		}

		// Sauvegarde du fichier XML
		FluxRSS::saveFluxXML($file);
	}

	// Mise � jour du flux
	public static function miseAJour($title, $link, $timestamp, $contents, $author) {
		// Ajout de la news dans la base de donn�es
		mysql_query("INSERT INTO fluxrss (title, link, timestamp, contents, author) VALUES ('" . $title . "','" . $link . "','" . $timestamp . "','" . $contents . "','" . $author . "')") or die();

		// Ouverture du fichier
		$file = FluxRSS::openFluxXML();

		// Ajout de la news dans le fichier
		FluxRSS::addOneNews($file, $title, $link, $timestamp, $author, $contents);

		// Sauvegarde du fichier XML
		FluxRSS::saveFluxXML($file);
	}

}

?>