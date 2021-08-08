<?php
use App\app\connect;
use App\recpatchaV3\recaptcha;
session_start();
$error = false;
$pdo = connect::getAuth();
if(!empty($_POST['username']) && !empty($_POST['password'])) {

    $captcha = new recaptcha();
    $reponse = $captcha->captcha($_POST['reponsecaptcha']);

    if ($reponse['success'] == true && $reponse['score'] > 0.5) {
        $user = $pdo->login($_POST['username'], $_POST['password']);
        if ($user) {
            connect::redirection($router, "main");
            exit();
        }else{
            $error = true;
        }
    } elseif ($reponse['success'] === true && $reponse['score'] < 0.5) {
        header("Location: https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRdotpbm7MGKkiuVuR9cvQfSujGcJXL_cNug_6rAKvK5svwezmoFdsxZ4iKzd5tUiuNT_4&usqp=CAU");

    }
}


?>
<DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
    <h1>se connecter</h1>
    <form action="" method="post">
        <div class="form-group">
            <input type="text" name="username" placeholder="pseudo" >
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="mot de passe" >
        </div>
        <?= $error === true ? "votre mot de passe ou identifiants est incorrecte" : null ?>




            <input type="hidden" name="reponsecaptcha" id="recaptcha">
            <button  type="submit" id="join-btn" name="join"class="g-recaptcha"
                     data-callback='onSubmit'
                     data-action='submit'>Submit</button>
        <script src="https://www.google.com/recaptcha/api.js?render=6Lez-d4bAAAAAMq-EX6xWJe6DpCGci3cDfvVVrmf"></script>
        <script>
            grecaptcha.ready(function () {
                const token = "6Lez-d4bAAAAAMq-EX6xWJe6DpCGci3cDfvVVrmf";
                grecaptcha.execute(token, { action: 'contact' }).then(function (token) {
                    var recaptchaResponse = document.getElementById('recaptcha');
                    recaptchaResponse.value = token;
                });
            });
        </script>
    </form>
    </body>
    </html>