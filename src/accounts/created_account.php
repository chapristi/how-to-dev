<?php
namespace App\accounts;

use PDOException;
use PDO;
?>
    <?php
class created_account {
    public  $username;
    public  $password;
    public PDO $connect;
    public function __construct(string $username,string $password,PDO $connect)
    {
        $this -> password = $password;
        $this -> username = $username;
        $this  -> connect = $connect;
    }

    /**
     * getErrors
     *
     * @return void recupere les erreurs
     */

    public function getErrors():array
    {
        $erreur = [];
        if (strlen($this -> username)  > 18)   {
            $erreur['username'] =  "can't be bigger than 18 caracters ";
        }
        if (strlen($this -> password)  > 150) {
            $erreur['password'] = "can't be bigger than 150 caracters";
        }

        return $erreur;
    }
    /**
     * is_valid
     *
     * @return bool cette fonction nous permet de verifier que le tableau $erreur est bien vide
     */
    public function is_valid(): bool
    {
        return empty($this->getErrors());
    }
    /**
     * creation_account
     *
     * @param  mixed $request
     * @param  mixed $pdo
     * @return void
     */
    public function creation_account()
    {
        $username = htmlentities($this-> username);
        $password = htmlentities($this -> password);
        try {

            $request = $this -> connect ->prepare('INSERT INTO accounts (username,password,created_at,ip,is_connected,token) VALUES (:username,:password,:created_at,:ip, :is_connected, :token)');
            $request->execute([

                'username' => $username,

                'password' => password_hash($password, PASSWORD_ARGON2I, ["cost" => 12]),

                'created_at' => time(),

                'ip' =>  $_SERVER['REMOTE_ADDR'],

                'is_connected' => 0,

                'token' => uniqid(null,true),
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


}
