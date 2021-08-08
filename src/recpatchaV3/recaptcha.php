<?php
namespace App\recpatchaV3;
use PDOException;
class recaptcha{
    public const  SECRET_CODE = '6Lez-d4bAAAAANsCK4-OhwizQ3bfbogMU9Wbbhxk';
    public function captcha( $recaptcha_response):?array{


        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => recaptcha::SECRET_CODE, 'response' => $recaptcha_response)));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $capcharespo = curl_exec($ch);
        }catch (PDOException $e){
            echo  "une erreur est survenue chez Google" .  $e -> getMessage();
        }

        curl_close($ch);
        return json_decode($capcharespo, true);

    }
}

