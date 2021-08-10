<?php


namespace App;

use Swift_Attachment;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class mail
{
    private const USERNAME = "chapristimailpro@gmail.com";
    private const PASSWORD = "zkcyjrtcdmpsvclw";

    public function setPassword(int $nbChar): string
    {
        $chaine = "mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0!@*$,%-*";
        $pass = '';
        for ($i = 0; $i < $nbChar; $i++) {
            $pass .= $chaine[rand() % strlen($chaine)];
        }
        return $pass;


    }

    public function sendMail(string $user_mail, string $username): bool
    {


        $transport = (new Swift_SmtpTransport("smtp.gmail.com", 465, "ssl"))
            ->setUsername(mail::USERNAME)
            ->setPassword(mail::PASSWORD);

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message())
            ->setCharset('utf-8')
            ->setSubject('vos identifiants sont arrivés');

        $message->setFrom([mail::USERNAME => 'how-to-dev'])
            ->setTo([$user_mail => $username])
            ->setBody("votre mot de passe a été crée {$this -> setPassword(100)}");
           //->attach(Swift_Attachment::fromPath('recaptchaV3.php'));


        $result = $mailer->send($message);
        return $result === 1 ? true : false;

    }
}