<?php

/**
 * Classe utilitaire liée à la clef d'accès aux parties privées du site
 */

class Clef {

    /**
     * Obtenir la valeur de condensat d'une valeur
     * @param string $clef La valeur dont on cherche le condensat
     * @return string
     */
    public static function calculCondensat($clef) {
	$salt = 'ceci est la valeur par défaut du sel';
	$iterations = 5000;
	$length = 40;
	return hash_pbkdf2('sha256', $clef ,$salt ,$iterations, $length);
    }
}
