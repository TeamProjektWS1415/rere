<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * Diese Klasse beinhaltet Mailing-Funktionen.
 *
 * @author Felix
 */
class ReReMailer {

    /**
     * Sendet eine Mail an den erstellen Prüfling, dass für ihn ein Front-End User anegelgt wurde. Dem neuen user werden username + passwort mitgeteilt.
     * @param type $empfaenger String
     * @param type $username String
     * @param type $name String
     * @param type $vorname String
     * @param type $passwort String
     * @return string String
     */
    public function newUserMail($empfaenger, $username, $name, $vorname, $passwort, $absender) {

        // Verschicken der Nachricht
        $message = (new \TYPO3\CMS\Core\Mail\MailMessage())
                ->setFrom(array($absender => 'Result Repository'))
                ->setTo(array($empfaenger => $name))
                ->setSubject("Ihr Result Repository Nutzer.")
                ->setBody('<html><head></head><body><p>Hallo ' . $name . ' ' . $vorname . ', für Sie wurde ein Nutzer für das Result Repository angelegt.</p><br><br> <b>Username:</b> ' . $username . '<br> <b>Passwort:</b> ' . $passwort . '</body></html>', 'text/html');
        $message->send();
        // Rückmeldung im Backend, ob eine E-Mail verschickt wurde oder nicht.
        if ($message->isSent()) {
            return 'Mail erfolgreich versandt';
        } else {
            return 'Die Mail wurde nicht versandt.';
        }
    }

}
