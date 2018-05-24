<?php require_once 'Configuration.php';
require_once 'DB/User.php';

class Mail {

    public static function activation(User $user) {
        $newLine = '\r\n';

        $sub = "";
        $text = "";

        $countLn = count(L10NAvail);
        for ($i = 0; $i < $countLn; $i++) {
            $l10n = json_decode(file_get_contents(PUBLIC_FOLDER . 'l10n/' . L10NAvail[$i]["abr"] . '.json'), true)["mail"]["activation"];

            $sub.= $l10n["subject"];
            $text.= sprintf($l10n["text"], $user);

            if ($i + 1 < $countLn) {
                $sub.= '/';
                $text.= "$newLine------------------------------$newLine";
            }
        }

        $text .= "$newLine$newLine\t". Configuration::hostname . BASE_URL. "/signup?id=" . $user->getToken();

        return mail($user->getEMail(), $sub, $text, "FROM: " . Configuration::email);
    }
}