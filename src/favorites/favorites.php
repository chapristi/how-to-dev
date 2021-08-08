<?php 
    namespace App\favorites;

use PDO;
class Favorites{
    public PDO $connect;
    public int $id_user;
    public int $id_article;
    public function __construct(PDO $connect,int $id_user, int $id_article)
    {
        $this -> connect = $connect;
        $this -> id_user =  $id_user;
        $this -> id_article =  $id_article;
    }
    /**
     * add_favorites
     *
     * @return void creer la mise en favories de l'article en 
     */
    public function add_favorites():void
    {
        $request = $this -> connect -> prepare("INSERT INTO favoris (id_article,ip,date,id_user) VALUES (:id_article,:ip,:date,:id_user)");

        date_default_timezone_set('Europe/Paris');

        $request -> execute([
            'id_article'  => $this -> id_article,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'date' => date('Y-m-d  H:i:s'),
            'id_user' => $this -> id_user,

        ]);
    }    
    /**
     * is_favorites
     *
     * @return BOOL  recupere l'id user par rapport a l'id de l'id de l'articles et vois si l'articles a deja
     * était ajouté au favoris si il l'est alors le favoris est suprimé sinon retourne null.
     */
    public function is_favorites($id_article):bool
    {
        $request = $this -> connect -> prepare('SELECT * FROM favoris WHERE id_article = :id_article ');
        $request -> execute([
            'id_article' => $this -> id_article,
        ]);
        $infos = $request -> fetch();
        if(!empty($infos) && "1" === $_SESSION['id']){
            $requestt = $this -> connect -> prepare('DELETE  FROM favoris WHERE id_article = :id_article');
            $requestt -> execute([
                    'id_article' => $id_article ,
            ]);
            return true;
        }else{
            return false;
        }
    }
    
   
}