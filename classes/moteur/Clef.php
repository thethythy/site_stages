<?php

class Clef {

    public static function calculCondensat($clef) {
	$salt = 'ceci est la valeur par défaut du sel';
	$iterations = 5000;
	$length = 40;
	return hash_pbkdf2('sha256', $clef ,$salt ,$iterations, $length);
    }
}
