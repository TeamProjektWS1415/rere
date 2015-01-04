<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * Description of GenChartArray
 *
 * @author Felix
 */
class NotenVerwaltungHelper {

    /**
     * Array für XYZ NotenSystem.
     * @var type
     */
    protected $schoolMarks = array(
        '1.0' => 0,
        '1.1' => 0,
        '1.2' => 0,
        '1.3' => 0,
        '1.4' => 0,
        '1.5' => 0,
        '1.6' => 0,
        '1.7' => 0,
        '1.8' => 0,
        '1.9' => 0,
        '2.0' => 0,
        '2.1' => 0,
        '2.2' => 0,
        '2.3' => 0,
        '2.4' => 0,
        '2.5' => 0,
        '2.6' => 0,
        '2.7' => 0,
        '2.8' => 0,
        '2.9' => 0,
        '3.0' => 0,
        '3.1' => 0,
        '3.2' => 0,
        '3.3' => 0,
        '3.4' => 0,
        '3.5' => 0,
        '3.6' => 0,
        '3.7' => 0,
        '3.8' => 0,
        '3.9' => 0,
        '4.0' => 0,
        '4.1' => 0,
        '4.2' => 0,
        '4.3' => 0,
        '4.4' => 0,
        '4.5' => 0,
        '4.6' => 0,
        '4.7' => 0,
        '4.8' => 0,
        '4.9' => 0,
        '5.0' => 0,
        '5.1' => 0,
        '5.2' => 0,
        '5.3' => 0,
        '5.4' => 0,
        '5.5' => 0,
        '5.6' => 0,
        '5.7' => 0,
        '5.8' => 0,
        '5.9' => 0,
        '6.0' => 0);

    /**
     * Array für Unbenotete Leistungen.
     * @var type
     */
    protected $unbenotetMarks = array(
        'be' => 0,
        'N' => 0);

    /**
     * Array für das 15 Punkte System
     * @var type
     */
    protected $fifteenMarks = [
        '1' => 0,
        '2' => 0,
        '3' => 0,
        '4' => 0,
        '5' => 0,
        '6' => 0,
        '7' => 0,
        '8' => 0,
        '9' => 0,
        '10' => 0,
        '11' => 0,
        '12' => 0,
        '13' => 0,
        '14' => 0,
        '15' => 0];

    /**
     * Array für die Anzahl der Note um diese dann im Chart auszugeben
     */
    protected $resultArray = ['1.0' => 0,
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

    /**
     * Iteriert über alle Ergebnisse der Abfrage und zählt die Anzahl der Vorkommnisse hoch.
     * @param type $notenliste
     * @param type $typ Benotungstyp
     * @return type JsonArray
     */
    public function genArray($notenliste, $typ) {

        foreach ($notenliste as $object) {
            $wert = $object->getWert();

            if ($typ == "hochschulsystem" && $wert != 0) {
                $this->resultArray[$wert] = $this->resultArray[$wert] + 1;
            }

            if ($typ == "15pktsystem" && $wert != 0) {
                $this->fifteenMarks[$wert] = $this->fifteenMarks[$wert] + 1;
            }

            if ($typ == "schulsystem" && $wert != 0) {
                $this->schoolMarks[$wert] = $this->schoolMarks[$wert] + 1;
            }

            if ($typ == "unbenotet" && $wert != NULL) {
                $this->unbenotetMarks[$wert] = $this->unbenotetMarks[$wert] + 1;
            }
        }

        // Wandelt das Array in ein Json Array und gibt dieses zurück.
        if ($typ == "hochschulsystem") {
            return json_encode($this->resultArray);
        } elseif ($typ == "15pktsystem") {
            return json_encode($this->fifteenMarks);
        } elseif ($typ == "schulsystem") {
            return json_encode($this->schoolMarks);
        } else {
            return json_encode($this->unbenotetMarks);
        }
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
