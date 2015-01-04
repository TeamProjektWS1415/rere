<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * In dieser Klasse wird das Passwort für den User generiert.
 */
class PasswordFunctions {

    /**
     * Erzeugt ein Zufallspasswort.
     * @return type String
     */
    public function genpassword() {

        // Alphabet für die Passwort-Generierung.
        $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        // Erzeugung des 8 Stellen langen zufalls passworts.
        return substr(str_shuffle($alphabet), 0, 8);
    }

    /**
     * Salt-Funktion nach TYPO3-Standard
     * @param type $password String
     * @return type String
     */
    public function hashPassword($password) {
        $saltedPassword = '';

        // Salt Hash Generierung des Passworts.
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('saltedpasswords') && \TYPO3\CMS\Saltedpasswords\Utility\SaltedPasswordsUtility::isUsageEnabled('FE')) {
            $objSalt = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance(NULL);
            if (is_object($objSalt)) {
                $saltedPassword = $objSalt->getHashedPassword($password);
            }
        }
        return $saltedPassword;
    }

}
?>

