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

    /**
     * Funktion zum vergleichen, ob eine Matrikelnummer in der Liste der Matrikelnummern, die einem Fach zugewiesen wurde bereits hinzugefügt wurde.
     * @param type $matrikelNummer Array mit Matrikelnummern
     * @param type $checkvar Matrikelnummer mit der verglichen werden soll
     * @return int 0 = succes / 1 = fail
     */
    public function checkMatrikelNr($matrikelNummer, $checkvar) {
        foreach ($matrikelNummer as $mat) {
            if ($mat->getMatrikelnr() == $checkvar) {
                return 0;
            }
        }
        return 1;
    }

}
?>

