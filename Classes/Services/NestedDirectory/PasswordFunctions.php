<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * Class to Generate User Passwords.
 */
class PasswordFunctions {

    /**
     * Erzeugt ein Zufallspasswort, welches nach Typ3 Standard gesaltet wird.
     * @return type Salted PW
     */
    public function genpassword() {

        // Alphabet für die Passwort Generierung.
        $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $saltedPassword = '';

        // Erzeugung des 8 Stellen langen zufalls passworts.
        $password = substr(str_shuffle($alphabet), 0, 8);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($pw);
        // Salt Hash generierung des Passworts.
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('saltedpasswords')) {
            if (\TYPO3\CMS\Saltedpasswords\Utility\SaltedPasswordsUtility::isUsageEnabled('FE')) {
                $objSalt = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance(NULL);
                if (is_object($objSalt)) {
                    $saltedPassword = $objSalt->getHashedPassword($password);
                }
            }
        }
        return $saltedPassword;
    }

}
?>

