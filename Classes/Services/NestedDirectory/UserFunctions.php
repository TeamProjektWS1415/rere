<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * Diese Klasse beinhaltet Benutzer-Funktionen.
 */
class UserFunctions {

    /**
     * Generiert einen Username bestehend aus den ersten vier Zeichen des Vornamens und den ersten vier Zeichen des Nachnamens.
     * @param type $vorname String
     * @param type $nachname String
     * @return type String
     */
    public function genuserName($vorname, $nachname) {

        $sub1 = substr($nachname, 0, 4);
        $sub2 = substr($vorname, 0, 4);

        return $sub1 . $sub2;
    }

}
?>

