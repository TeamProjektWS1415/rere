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
        $ret = $sem . $jahr;
        return $ret;
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
        $ret = $sem . $jahr;
        return $ret;
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
        $ret = "Schuljahr" . $orig . "/" . $tempjahr;
        return $ret;
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
        $ret = "Schuljahr" . $tempjahr . "/" . $orig;
        return $ret;
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
            $aktuell = "Schuljahr" . $date . "/" . ++$date;
        }
        return $aktuell;
    }

}
