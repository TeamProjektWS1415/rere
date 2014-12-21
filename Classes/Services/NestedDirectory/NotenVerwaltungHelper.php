<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * Description of GenChartArray
 *
 * @author Felix
 */
class NotenVerwaltungHelper {

    /**
     * Array für die Anzahl der Note um diese dann im Chart auszugeben
     * @var type
     */
    protected $resultArray = array('1.0' => 0,
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
    );

    /**
     * Iteriert über alle Ergebnisse der Abfrage und zählt die Anzahl der Vorkommnisse hoch.
     * @param type $notenliste
     * @return type JsonArray
     */
    public function genArray($notenliste) {
        foreach ($notenliste as $object) {
            $wert = $object->getWert();
            $resultArray[$wert] = $resultArray[$wert] + 1;
        }

        $json = json_encode($resultArray);
        var_dump($json);
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
        return $sum / $count;
    }

    /**
     * Funktion zum Prüfen ob für einen Wert bereits eine Note gesetzt wurde
     * @param type $notenliste
     * @return int Anzahl der gesetzten
     */
    public function checkIfWertisSet($notenliste) {
        $count = 0;
        foreach ($notenliste as $result) {
            if ($result->getWert() != "") {
                $count++;
            }
        }
        return $count;
    }

}
