<?php

namespace ReRe\Rere\Services\NestedDirectory;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IntervalLogic
 *
 * @author Felix
 */
class IntervallLogic {

    /**
     * Ein Studien Intervall nach vorne
     * @param type $aktuellesIntervall
     * @return string
     */
    public function nextStudiIntervall($aktuellesIntervall) {
        $sem = substr($aktuellesIntervall, 0, 2);
        $jahr = intval(substr($aktuellesIntervall, 2, 4));

        if ($sem == "SS") {
            $sem = "WS";

            $tempjahr = $jahr++;
            $jahr = $tempjahr . "/" . $jahr;
        } else {
            $sem = "SS";
            $jahr++;
        }
        $ret = $sem . $jahr;
        return $ret;
    }

    /**
     * Ein Studienintervall zurück.
     * @param type $aktuellesIntervall
     * @return string
     */
    public function prevStudiIntervall($aktuellesIntervall) {
        $sem = substr($aktuellesIntervall, 0, 2);
        $jahr = intval(substr($aktuellesIntervall, 2, 4));

        if ($sem == "SS") {
            $sem = "WS";

            $tempjahr = $jahr--;
            $jahr = $jahr . "/" . $tempjahr;
        } else {
            $sem = "SS";
            $jahr--;
        }
        $ret = $sem . $jahr;
        return $ret;
    }

    /**
     * Ein Schuljahr intervall weiter.
     * @param type $aktuellesIntervall
     * @return string
     */
    public function nextSchulIntervall($aktuellesIntervall) {
        $jahr = intval(substr($aktuellesIntervall, 9, 11));
        $jahr++;
        $ret = "Schuljahr" . $jahr;
        $jahr++;
        $ret = $ret . "/" . $jahr++;
        return $ret;
    }

    /**
     * Ein Schuljahr intervall zurück.
     * @param type $aktuellesIntervall
     * @return string
     */
    public function prevSchulIntervall($aktuellesIntervall) {
        $jahr = intval(substr($aktuellesIntervall, 9, 11));
        $jahr--;
        $ret = "Schuljahr" . $jahr;
        $jahr++;
        $ret = $ret . "/" . $jahr--;
        return $ret;
    }

}
