<?php
namespace App\accounts;
use PDO;
use App\accounts\User;
class Auth{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this -> pdo = $pdo;

    }
    public function user(): ?User
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $id = $_SESSION['auth'] ?? null;
        if($id === null){
            return null;
        }else{
            $query = $this->pdo->prepare('SELECT * FROM accounts WHERE token = :token');
            $query -> execute([
                'token' => $_SESSION['auth'],
            ]);

            $user = $query -> fetchObject(User::class);
            return $user ?: null;
        }
    }
    // les ... sert a lui dire que l'on peut passer une infinitée de parametres
    public function requireRole( string ...$role){
        $user = $this -> user();

        if ($user === null || !in_array($user -> role,$role)){
            return false;
        }
    }

    public function login(string $username,string $password):?user
    {
        //trouve l'utilsateur correspondant dans la bdd
        $query = $this->pdo->prepare('SELECT * FROM accounts WHERE username = :username');
        $query -> execute([
            'username' => $username,
        ]);
         $user = $query -> fetchObject(User::class);

        if ($user === false){
            return  null;
        }
        if(password_verify($password,$user -> password)){
            if(session_status() === PHP_SESSION_NONE){
                session_start();
            }

            $_SESSION['auth']= $user -> token;
            return $user;
        }else{
            return null;
        }
        // et on verifie que le mot de passe soit correct si oui on renvoie User donc ses infos sinon null

    }

}