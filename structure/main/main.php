<?php 
use App\app\connect;
use App\articles\grabTutos;
use App\favorites\Favorites;
use App\YouTubeAPI\YouTube;
session_start();
$articles = new grabTutos(connect::getPDO());
$cadre = $articles -> generating_articles();
$_SESSION['id'] = "1";
$ytb  = new YouTube();
$InfosYTB = $ytb -> array_ytb(5);

?>

<?php foreach($cadre as $cadres): ?> 
    <?php 

    $favorites = new Favorites(connect::getPDO(),$_SESSION['id'],$cadres -> id );
        if(isset($_POST['favoris-'.$cadres->id  ])){
            
            $result = $favorites -> is_favorites($cadres -> id);
            if($result === false){
                $favorites -> add_favorites();
                connect::redirection($router,"main");
            }else{
                connect::redirection($router,"main");
            }
            
        }
   ?>
    <p><?= $cadres -> title ?></p>
    <p><?= $cadres -> description ?></p>
    <p><?= $cadres -> links ?></p>
    <form action="" method="post">
 
        <input name="<?= "favoris-".$cadres->id ?>" type="submit">
    </form>
    
<?php endforeach ?>
<?php foreach ($InfosYTB as  $infos):?>

    <iframe width="560" height="315" src="<?= "https://www.youtube.com/embed/" . $infos[0]?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<?php endforeach;?>