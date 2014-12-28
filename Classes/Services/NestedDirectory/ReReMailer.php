<?php

namespace ReRe\Rere\Services\NestedDirectory;

/**
 * Diese Klasse beinhaltet Mailing funktionen.
 *
 * @author Felix
 */
class ReReMailer {

    public function newUserMail($empfänger, $username, $name, $vorname, $passwort) {

        $body = "Hallo " . $name . " " . $vorname . ", Dein Benutzername lautet: " . $username . " und dein Passwort lautet: " . $passwort;

        $message = (new \TYPO3\CMS\Core\Mail\MailMessage())
                ->setFrom(array('ab@send.er' => 'Result Repository'))
                ->setTo(array($empfänger => $name))
                ->setBody($body);
        $message->send();
    }

}
