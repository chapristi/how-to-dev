<?php
//page du routeur.
require_once  "../../vendor/autoload.php";
$router = new AltoRouter();
$router -> map("GET|POST","/", '../main/main',"main");
$router -> map("GET|POST","/login", '../main/login',"login");
$router -> map("GET|POST","/signup", '../main/signup',"signup");
$router -> map("GET","/logout", '../main/logout',"logout");
$router -> map("GET","/admin", '../main/admin',"admin");



$match = $router -> match();

if (is_array($match)) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } else {
        $params = $match["params"];
        require "../main/{$match["target"]}.php";

    }

}else{
    require_once "../main/404.php";
}