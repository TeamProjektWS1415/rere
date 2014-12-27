<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * Benutzer funktionen.
 */
class UserFunctions {

    /**
     * Generiert einen Username. Bestehend aus den ersten 4 Zeichen es vornamens + den ersten 4 zeichen des nachnamens.
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

