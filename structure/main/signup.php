<?php
use App\recpatchaV3\recaptcha;
use App\app\connect;
use App\accounts\created_account;

if(!empty($_POST['username'])  &&  !empty($_POST['password'])){
    $created_account = new created_account($_POST['username'] , $_POST['password'],connect:: getPDO());
    if($created_account -> is_valid()){
        $captcha = new recaptcha();
        $reponse =  $captcha -> captcha($_POST['reponsecaptcha']);
        // Effectuer une action en fonction du score obtenu.
        if ($reponse['success'] == true && $reponse['score'] > 0.5) {
            $created_account -> creation_account();
            connect::redirection($router,"login");
        }elseif($reponse['success'] === true && $reponse['score'] < 0.5){
            header("Location: https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRdotpbm7MGKkiuVuR9cvQfSujGcJXL_cNug_6rAKvK5svwezmoFdsxZ4iKzd5tUiuNT_4&usqp=CAU");
         }
    }else{
            $errors = $created_account -> getErrors();
    }
}
?>
    <form  method="POST" class="signupForm" name="signupform">
        <h2>Sign Up</h2>
        <ul class="noBullet">
            <li>
                <label for="username"></label>
                <input  type="text" class="inputFields" id="username" name="username" placeholder="Username" value="" autocomplete="off"/>
                <?php if(!empty($errors["username"])): ?>
                    <div class="error"><?= $errors["username"]?></div>
                <?php endif ?>
            </li>
            <li>
                <label for="password"></label>
                <input type="password" class="inputFields" id="password" name="password" placeholder="Password" value="" autocomplete="off" />
                <?php if(!empty($errors["password"])): ?>
                    <div class="error"><?= $errors["password"]?></div>
                <?php endif ?>
            </li>

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
