<?php 
    namespace App\app;
use App\accounts\Auth;
use  PDO;

class connect{
    public  static  $pdo;  
    public static $redirect;
    public  static  $auth;
    /**
     * getPDO
     *
     * @return PDO get pdo me permet d'appeler la connexion à la bdd si ce n'est pas deja fait
     */
    public  static function getPDO():PDO
    {
        if (!self::$pdo) {
            self::$pdo = new PDO('mysql:dbname=how-to-dev;host=localhost', 'root', '1234', [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 ',
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);
        }
        return self::$pdo;
    }

    public static function redirection($router, $route)
    {
        if (!self::$redirect) {
            self::$redirect =  header("Location: {$router -> generate($route) }");
        }
        return self::$redirect;
    }
    //getAuth me permet de recuperer un utilisateur grace à la classe Auth
    public  static function getAuth():Auth
    {
        if (!self::$auth) {
            self::$auth = new Auth(self::getPDO());
        }
        return self::$auth;
    }



}