<?php 
    namespace App\articles;

use PDO;

class grabTutos{
    public PDO $connect;
    public function __construct(PDO $connect)
    {
        $this -> connect = $connect;
    }    
    /**
     * generating_articles
     *
     * @return void recupere tout simplement tout les articles de la base de données
     */
    public function generating_articles():iterable|object
    {
        $requete =  $this -> connect -> query('SELECT * FROM likes');
        return $requete -> fetchAll(); 
    }
    
   
}