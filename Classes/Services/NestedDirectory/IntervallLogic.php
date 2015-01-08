<?php

namespace ReRe\Rere\Services\NestedDirectory;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Diese Klasse enthält die Intervall-Logik. Hierbei wird zwischen Schuljahr und Studienjahr differenziert.
 *
 * @author Felix
 */
class IntervallLogic {

    const SCHULJAHR = "Schuljahr";

    /**
     * Ein Studien-Intervall nach vorne
     * @param type $aktuellesIntervall
     * @return string
     */
    public function nextStudiIntervall($aktuellesIntervall) {
        $sem = substr($aktuellesIntervall, 0, 2);
        $jahr = intval(substr($aktuellesIntervall, 2, 4));

        if ($sem == "SS") {
            $sem = "WS";
            $orig = $jahr;
            $tempjahr = ++$jahr;
            $jahr = $orig . "/" . $tempjahr;
        } else {
            $sem = "SS";
            ++$jahr;
        }
        return $sem . $jahr;
    }

    /**
     * Ein Studien-Intervall zurück.
     * @param type $aktuellesIntervall
     * @return string
     */
    public function prevStudiIntervall($aktuellesIntervall) {
        $sem = substr($aktuellesIntervall, 0, 2);
        $jahr = intval(substr($aktuellesIntervall, 2, 4));

        if ($sem == "SS") {
            $sem = "WS";
            $orig = $jahr;
            $tempjahr = --$jahr;
            $jahr = $tempjahr . "/" . $orig;
        } else {
            $sem = "SS";
        }
        return $sem . $jahr;
    }

    /**
     * Ein Schuljahr-Intervall nach vorne.
     * @param type $aktuellesIntervall
     * @return string
     */
    public function nextSchulIntervall($aktuellesIntervall) {
        $jahr = intval(substr($aktuellesIntervall, 9, 11));
        $orig = ++$jahr;
        $tempjahr = ++$jahr;
        return self::SCHULJAHR . $orig . "/" . $tempjahr;
    }

    /**
     * Ein Schuljahr-Intervall zurück.
     * @param type $aktuellesIntervall
     * @return string
     */
    public function prevSchulIntervall($aktuellesIntervall) {
        $jahr = intval(substr($aktuellesIntervall, 9, 11));
        $orig = $jahr;
        $tempjahr = --$jahr;
        return self::SCHULJAHR . $tempjahr . "/" . $orig;
    }

    /**
     * Handelt das Umschalten zwischen Schuljahr und Studienhalbjahr.
     * @param type $type
     * @return string
     */
    public function genAktuellesIntervall($type) {
        if ($type == "studienhalbjahr") {
            $aktuell = "SS" . substr(date("Y"), 2, 4);
        } else {
            $date = intval(substr(date("Y"), 2, 4));
            $aktuell = self::SCHULJAHR . $date . "/" . ++$date;
        }
        return $aktuell;
    }

}
