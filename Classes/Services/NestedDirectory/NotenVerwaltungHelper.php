<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * Description of GenChartArray
 *
 * @author Felix
 */
class NotenVerwaltungHelper {

    /**
     * Iteriert über alle Ergebnisse der Abfrage und zählt die Anzahl der Vorkommnisse hoch.
     * @param type $notenliste
     * @return type JsonArray
     */
    public function genArray($notenliste) {

        /**
         * Array für die Anzahl der Note um diese dann im Chart auszugeben
         */
        $resultArray = ['1.0' => 0,
            '1.3' => 0,
            '1.7' => 0,
            '2.0' => 0,
            '2.3' => 0,
            '2.7' => 0,
            '3.0' => 0,
            '3.3' => 0,
            '3.7' => 0,
            '4.0' => 0,
            '5.0' => 0
        ];

        foreach ($notenliste as $object) {
            $wert = $object->getWert();
            if ($wert != 0) {
                $resultArray[$wert] = $resultArray[$wert] + 1;
            }
        }

        // Wandelt das Array in ein Json Array und gibt dieses zurück.
        return json_encode($resultArray);
    }

    /**
     * Berechnet den Durchschnitt der Klausur / Prüfung / etc.
     * @param type $notenliste
     * @return type int
     */
    public function calculateAverage($notenliste) {
        $sum = 0;
        $count = 0;
        foreach ($notenliste as $result) {
            $sum += $result->getWert();
            $count++;
        }

        if ($sum != 0) {
            $erg = $sum / $count;
        } else {
            $erg = 0;
        }

        return $erg;
    }

    /**
     * Funktion zum Prüfen ob für einen Wert bereits eine Note gesetzt wurde
     * @param type $notenliste
     * @return int Anzahl der gesetzten
     */
    public function checkIfWertisSet($notenliste) {
        $count = 0;
        foreach ($notenliste as $result) {
            if ($result->getWert() != 0) {
                $count++;
            }
        }
        return $count;
    }

}
